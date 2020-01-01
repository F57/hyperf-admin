<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\BaseController;
use App\Model\Admin;
use App\Request\Admin\LoginRequest;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\HttpMessage\Cookie\Cookie;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;
use App\Exception\AppNotFoundException;
use App\Exception\AppBadRequestException;

class LoginController extends BaseController
{

    public function index()
    {
        return $this->render->render('admin.login.index');
    }

    /**
     * Notes:验证码
     * User: 你猜呢
     * Date: 2019/12/17
     * Time: 13:53
     * @return mixed
     * @throws \Psr\SimpleCache\InvalidArgumentException
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
        $phrase = $builder->getPhrase();
        $captchaId = uniqid();
        $output = $builder->get();
        $this->redis->set($captchaId, $phrase, 300);
        $cookie = new Cookie('captcha', $captchaId);
        return $this->response
            ->withCookie($cookie)
            ->withAddedHeader('content-type', 'image/jpeg')
            ->withBody(new SwooleStream($output));
    }

    public function login(LoginRequest $request,Admin $admin)
    {

        $email = $request->input('email');
        $passwd = $request->input('passwd');
        $captcha = $request->input('captcha');

        $user = $this->userCheck($email,$passwd,$admin,$this->request);
        $this->session->set('id',$user['id']);
        $this->captchaCheck($request,$captcha);
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
            throw new AppBadRequestException("验证码错误");
        }
        $cacheCaptcha = $this->redis->get($cooks['captcha']);
        if(!$cacheCaptcha){
            throw new AppBadRequestException("验证码超时");
        }

        if($cacheCaptcha != $captcha){
            throw new AppBadRequestException("验证码错误");
        }
    }

    /**
     * Notes:用户验证
     * User: 你猜呢
     * Date: 2019/12/18
     * Time: 17:02
     * @param $email
     * @param $passwd
     * @param $admin
     * @param $request
     * @return mixed
     */
    protected function userCheck($email,$passwd,$admin,$request)
    {

        $where[]=['email','=',$email];

        $user = $admin->oneInfo($where)->toArray();


        if (!$user) {
            throw new AppNotFoundException("用户不存在");
        }

        if(!password_verify($passwd, $user['passwd'])){
            throw new AppBadRequestException("用户名或者密码错误");
        }

        if ($user['access']==1) {
            throw new AppBadRequestException("用户已禁用");
        }

        $data['ip']=$request->getHeaders()['x-real-ip']['0'];
        $admin->updateOne($where,$data);

        return $user;
    }

    public function logout()
	{
		$this->session->forget('id');
		return $this->helper->success();
	}
}
