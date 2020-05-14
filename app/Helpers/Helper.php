<?php

declare(strict_types = 1);

namespace App\Helpers;

use App\Exception\AppNotFoundException;
use App\Helpers\Code;
use App\Service\Redis;
use Hyperf\Contract\SessionInterface;
use Psr\Http\Message\ServerRequestInterface;
use Hyperf\Utils\ApplicationContext;
use Hyperf\Utils\Context;

Class Helper {

    public $redis;


    public function __construct(Redis $redis,SessionInterface $session)
    {
        $this->redis=$redis;
        $this->session=$session;
    }

    //返回成功
    public function success($data=[]) {
        return $this->result(Code::SUCCESS, Code::getMessage(Code::SUCCESS), $data);
    }

    //返回错误
    public function error($code = 422, $message = '', $data = []) {
        if (empty($message)) {
            return $this->result($code, Code::getMessage($code), $data);
        } else {
            return $this->result($code, $message, $data);
        }
    }

    protected function result($code, $message, $data) {
        return ['code' => $code, 'message' => $message, 'data' => $data];
    }

    public function mdResult($code,$success,$message,$url) {
        return ['code' => $code,'success'=>$success,'message' => $message, 'url' =>$url];
    }

    public function jsonEncode($data) {
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 生成随机字符串
     * @param number $length
     * @param string $chars
     * @return string
     */
    public function generateString($length=128)
    {
        $chars = openssl_random_pseudo_bytes($length);
        return $chars;
    }

    /**
     * 容器实例
     */
    public function container()
    {
        return ApplicationContext::getContainer();
    }

    /**
     * 请求信息
     * @return mixed|ServerRequestInterface
     */
    public function pathInfo()
    {
        $pathInfo=$this->container()->get(ServerRequestInterface::class)->getServerParams()['path_info'];
        $arr = array_values(array_filter(explode('/',$pathInfo)));
        return $arr;
    }

    /**
     * 获取csrf
     * @return string
     */
    public function getCsrf()
    {

        $cookie=$this->container()->get(ServerRequestInterface::class)->getCookieParams()['csrf'] ?? Context::get('cookie');

        if(!$cookie){
            throw new AppNotFoundException('html');
        }

        $csrf = md5($cookie.time());
        $this->redis->set($csrf,1,7200);
        return $csrf;
    }

    /**
     * 验证csrf
     * @param $csrf
     * @return mixed
     */
    public function verifyCsrf($csrf)
    {
        $cookie=$this->container()->get(ServerRequestInterface::class)->getCookieParams()['csrf'];
        if(!$cookie){
            throw new AppNotFoundException('html');
        }

        $param = $this->redis->get($csrf);
        if($param){
            return true;
        }
        return false;
    }

    /**
     * 初始化数据
     * @param array $arr
     * @return array
     */
    public function initData($arr=[])
    {
        $id = $this->session->get('id');
        $data=array();
        if($id){
            if(!empty($arr)){
                foreach ($arr as $k=>$v){
                    $data[$k]=$v;
                }
            }
            $user = Context::get('user');
            if($user['photo']==''){
                $user['photo']=env('APP_USER_IMG', '');
            }
            if($user['name']==''){
                $user['name']=env('APP_USER_NAME', '默认名字');
            }
            $data['users'] =$user;
            $data['menus'] = Context::get('menu');
            $data['btns'] = Context::get('btn');
        }
        $data['app_manager_name']=env('APP_MANAGER_NAME', '后台管理系统');
        $data['app_manager_logo']=env('APP_MANAGER_LOGO', '');
        $data['csrf']=$this->getCsrf();
        return $data;
    }
}
