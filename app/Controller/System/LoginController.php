<?php

declare(strict_types=1);

namespace App\Controller\System;

use App\Helpers\Code;
use App\Model\Admin;
use App\Request\System\LoginRequest;
use Hyperf\HttpMessage\Cookie\Cookie;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\View\RenderInterface;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use Hyperf\HttpServer\Annotation\RequestMapping;
use App\Exception\AppErrorRequestException;

/**
 * @Controller()
 */
class LoginController extends AbstractController
{
    /**
     * @RequestMapping(path="/system/login", methods="get")
     */
    public function index(RenderInterface $render)
    {
        return $render->render('system.login.index',$this->other->initData());
    }

    /**
     * @RequestMapping(path="/system/login/captchas", methods="get")
     * Notes:验证码
     * User: 你猜呢
     * Date: 2019/12/17
     * Time: 13:53
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function captchas()
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
        $this->redis->set($captchaId, $phrase, 300);

        $cookie = new Cookie('captcha', $captchaId);
        return $this->response
            ->withCookie($cookie)
            ->withAddedHeader('content-type', 'image/jpeg')
            ->withBody(new SwooleStream($output));
    }

    /**
     * @RequestMapping(path="/system/login", methods="post")
     * @param LoginRequest $request
     */
    public function login(LoginRequest $request,Admin $admin)
    {
        $email = $request->input('email');
        $passwd = $request->input('passwd');
        $captcha = strtoupper($request->input('captcha'));
        $this->captchaCheck($request,$captcha);
        $user = $this->userCheck($email,$passwd,$admin,$request);
        $this->session->set('id',$user['id']);
        return $this->helper->success();
    }

    /**
     * Notes:验证码验证
     * User: 你猜呢
     * Date: 2019/12/18
     * Time: 16:56
     * @param $request
     * @param $captcha
     */
    protected function captchaCheck($request,$captcha)
    {

        $cooks = $request->getCookieParams();
        if(!array_key_exists('captcha',$cooks)){
            throw new AppErrorRequestException("验证码错误",Code::ERROR);
        }
        $cacheCaptcha = $this->redis->get($cooks['captcha']);

        if(!$cacheCaptcha){
            throw new AppErrorRequestException("验证码超时",Code::ERROR);
        }

        if($cacheCaptcha != $captcha){
            throw new AppErrorRequestException("验证码错误",Code::ERROR);
        }

        $this->redis->del($cooks['captcha']);
    }

    /**
     * 用户验证
     * @param $email
     * @param $passwd
     * @param $obj
     * @param $request
     * @return mixed
     */
    protected function userCheck($email,$passwd,$obj,$request)
    {
        $where[]=['email','=',$email];
        $user = $obj->oneInfo($where);

        if (!$user) {
            throw new AppErrorRequestException("用户不存在",Code::ERROR);
        }
        $user = $user->toArray();

        if(!password_verify($passwd, $user['passwd'])){
            throw new AppErrorRequestException("用户名或者密码错误",Code::ERROR);
        }

        if ($user['access']==1) {
            throw new AppErrorRequestException("用户已禁用",Code::ERROR);
        }

        $data['ip']=$request->getHeaders()['x-real-ip']['0'];
        $obj->updateOne($where,$data);

        return $user;
    }

    /**
     * @RequestMapping(path="/system/login/logout", methods="post")
     */
    public function logout()
    {
        $this->session->forget('id');
        return $this->helper->success();
    }
}
