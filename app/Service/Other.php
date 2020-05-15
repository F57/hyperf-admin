<?php

declare(strict_types=1);

namespace App\Service;

use Hyperf\Utils\Context;
use Psr\Http\Message\ServerRequestInterface;
use App\Helpers\Helper;
use App\Exception\AppNotFoundException;
use App\Service\Redis;
use Hyperf\Contract\SessionInterface;
use Hyperf\Di\Annotation\Inject;

class Other
{
    /**
     * @Inject
     * @var Helper
     */
    private $help;

    /**
     * @Inject
     * @var Redis
     */
    private $redis;

    /**
     * @Inject
     * @var SessionInterface
     */
    private $session;

    /**
     * 获取csrf
     * @return string
     */
    public function getCsrf()
    {

        $cookie=$this->help->container()->get(ServerRequestInterface::class)->getCookieParams()['csrf'] ?? Context::get('cookie');

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
        $cookie=$this->help->container()->get(ServerRequestInterface::class)->getCookieParams()['csrf'];
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