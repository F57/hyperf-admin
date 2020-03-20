<?php

declare(strict_types=1);

namespace App\Controller\Admin\V1;

use App\Controller\Admin\BaseController;
use App\Exception\AppRequestException;
use App\Model\User;
use Hyperf\HttpMessage\Cookie\Cookie;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use App\Request\Admin\LoginRequest;
use Hyperf\Di\Annotation\Inject;
use Psr\EventDispatcher\EventDispatcherInterface;
use App\Event\LoginRegistered;

/**
 * @Controller()
 */
class LoginController extends BaseController
{

    /**
     * @Inject
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @RequestMapping(path="/v1/login", methods="get")
     */
    public function index()
    {
        return $this->render->render('admin.login.index',$this->helper->getData());
    }

    /**
     * 获取验证码
     * @RequestMapping(path="/v1/login/captchas", methods="get")
     */
    public function captcha()
    {
        $config = $this->config->get('captcha');
        $length = $config['length'];
        $width = $config['width'];
        $height = $config['height'];
        $phraseBuilder = new PhraseBuilder($length);
        $builder = new CaptchaBuilder(null, $phraseBuilder);
        $builder->build($width, $height);
        $phrase =strtoupper($builder->getPhrase());
        $captchaId = uniqid();
        $output = $builder->get();
        $this->cache->set($captchaId, $phrase, 300);
        $cookie = new Cookie('captcha', $captchaId);
        return $this->response
            ->withCookie($cookie)
            ->withAddedHeader('content-type', 'image/jpeg')
            ->withBody(new SwooleStream($output));
    }

    /**
     * 登录
     * @RequestMapping(path="/v1/login", methods="post")
     */
    public function login(LoginRequest $request,User $user)
    {

        $email = $request->input('email');
        $passwd = $request->input('passwd');
        $captcha = strtoupper($request->input('captcha'));
        $this->captchaCheck($request,$captcha);

        $userInfo = $this->userCheck($email,$passwd,$user,$this->request);

        $this->session->set('id',$userInfo['id']);
        return $this->helper->success();
    }

    /**
     * 验证码校验
     * @param $request
     * @param $captcha
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    protected function captchaCheck($request,$captcha)
    {
        $cooks = $request->getCookieParams();
        if(!array_key_exists('captcha',$cooks)){
            throw new AppRequestException('验证码错误',$this->code::ERROR);
        }

        $cacheCaptcha = $this->cache->get($cooks['captcha']);
        if(!$cacheCaptcha){
            throw new AppRequestException('验证码超时',$this->code::ERROR);
        }

        if($cacheCaptcha != $captcha){
            throw new AppRequestException('验证码错误',$this->code::ERROR);
        }

        $this->cache->delete($cooks['captcha']);

        return true;

    }

    /**
     * 用户验证
     * @param $email
     * @param $passwd
     * @param $user
     * @param $request
     * @return mixed
     */
    protected function userCheck($email,$passwd,$user,$request)
    {

        $where[]=['email','=',$email];

        $userInfo = $user->oneInfo($where);

        if (!$userInfo) {
            throw new AppRequestException('用户不存在',$this->code::ERROR);
        }

        $userInfo = $userInfo->toArray();

        if(!password_verify($passwd, $userInfo['passwd'])){
            throw new AppRequestException('用户名或者密码错误',$this->code::ERROR);
        }

        if ($userInfo['access']==1) {
            throw new AppRequestException('用户已禁用',$this->code::ERROR);
        }

        $data['ip'] = $request->getHeaders()['x-real-ip']['0'];
        $data['id'] = $userInfo['id'];
        $this->eventDispatcher->dispatch(new LoginRegistered($data));
        return $userInfo;
    }

    /**
     * 退出
     * @RequestMapping(path="/v1/login/logout", methods="post")
     */
    public function logout()
    {
        $this->session->forget('id');
        return $this->helper->success();
    }
}