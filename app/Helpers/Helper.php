<?php

declare(strict_types = 1);

namespace App\Helpers;

use App\Exception\AppNotFoundException;
use App\Service\Redis;
use Hyperf\Contract\SessionInterface;
use Psr\Http\Message\ServerRequestInterface;
use Hyperf\Utils\ApplicationContext;
use Hyperf\Di\Annotation\Inject;

Class Helper {

    /**
     * @Inject
     * @var Redis
     */
    public $redis;

    /**
     * @Inject
     * @var SessionInterface
     */
    protected $session;


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


}
