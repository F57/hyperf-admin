<?php

declare(strict_types = 1);

namespace App\Helper;

use Hyperf\Cache\Cache;
use Hyperf\Di\Annotation\Inject;
use App\Constants\Code;
use Hyperf\Utils\Context;
use Hyperf\Contract\SessionInterface;
use App\Model\User;

class Helper
{
    /**
     * @Inject
     * @var Cache
     */
    protected $cache;

    /**
     * @Inject
     * @var SessionInterface
     */
    public $session;

    /**
     * @Inject
     * @var User
     */
    protected $user;

    /**
     * 发送到模板的所有数据
     * @param $info
     * @return array
     */
    public function getData($info=[])
    {
        $csrf = $this->getCsrf();
        $menus = Context::get('menu');
        $user = $this->getUser();
        return compact('csrf','info','menus','user');
    }

    /**
     * 生成csrf
     * @return string
     * @throws \Psr\SimpleCache\InvalidArgumentException
     */
    public function getCsrf()
    {
        $csrf = bin2hex(openssl_random_pseudo_bytes(32));
        $this->cache->set($csrf,time(),3600);
        return $csrf;
    }

    /**
     * 返回错误
     * @param $code
     * @param string $message
     * @param array $data
     * @return array
     */
    public function error($code, $message = '', $data = []) {
        if (empty($message)) {
            return $this->result($code, Code::getMessage($code), $data);
        } else {
            return $this->result($code, $message, $data);
        }
    }

    /**
     * 成功返回
     * @param array $data
     * @return array
     */
    public function success($data=[]) {
        return $this->result(Code::SUCCESS, Code::getMessage(Code::SUCCESS), $data);
    }

    /**
     * 数据组成
     * @param $code
     * @param $message
     * @param $data
     * @return array
     */
    protected function result($code, $message, $data) {
        return ['code' => $code, 'message' => $message, 'data' => $data];
    }

    /**
     * json
     * @param $data
     * @return false|string
     */
    public function jsonEncode($data) {
        return json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * 获取用户信息
     * @return array
     */
    protected function getUser()
    {
        $id = $this->session->get('id');
        $uinfo =$this->user->find($id);
        $arr=array();
        if($uinfo){
            $arr=array(
                'id'=>$uinfo->id,
                'name'=>$uinfo->name,
                'email'=>$uinfo->email,
                'photo'=>$uinfo->photo
            );
        }

        return $arr;
    }
}