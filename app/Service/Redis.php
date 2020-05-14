<?php

declare(strict_types=1);

namespace App\Service;

use Hyperf\Utils\ApplicationContext;

class Redis
{
    protected $redis;

    public function __construct()
    {
        $container = ApplicationContext::getContainer();
        $this->redis = $container->get(\Redis::class);

    }

    public function del($key)
    {
        $this->redis->del($key);
        return true;
    }

    public function has($key)
    {
        $result = $this->redis->EXISTS($key);
        if($result==1){
            return true;
        }
        return false;
    }
    /**
     * 写入缓存
     * @param string $key 键名
     * @param string $value 键值
     * @param int $exprie 过期时间 0:永不过期
     * @return bool
     */
    public function set($key, $value, $exprie = 0)
    {
        if ($exprie == 0) {
            $set = $this->redis->set($key, $value);
        } else {
            $set = $this->redis->setex($key, $exprie, $value);
        }
        return $set;
    }

    /**
     * 读取缓存
     * @param string $key 键值
     * @return mixed
     */
    public function get($key)
    {
        $fun = is_array($key) ? 'Mget' : 'get';
        return $this->redis->{$fun}($key);
    }

    /**
     *  不存在会先创建,存在则覆盖
     * @param string $name hash名称
     * @param string $filed 字段
     * @param string $value 值
     * @return 1|0 成功返回1,覆盖返回0
     */
    public function hSet($name,$filed,$value)
    {
        $result = $this->redis->hSet($name, $filed, $value);
        if($result==0 || $result==1){
            return true;
        }
        return false;

    }

    /**
     *  不存在会先创建,存在则覆盖
     * @param string $name hash名称
     * @param array $data 字段和值
     * @return bool
     */
    public function hMSet($name,array $data)
    {
        return $this->redis->hMset($name,$data);
    }

    /**
     * 获取hash中指定字段的值
     * @param string $name
     * @param string $file
     * @return string
     */
    public function hGet($name,$file)
    {
        return $this->redis->hGet($name, $file);
    }

    /**
     * 获取hash中多个字段的值
     * @param string $name
     * @param array $filed
     * @return array
     */
    public function hMget($name,array $filed)
    {
        return $this->redis->hMget($name, $filed);
    }

    /**
     * 获取hash中所有的字段和值
     * @param $name
     * @return array
     */
    public function hGetAll($name)
    {
        return $this->redis->hGetAll($name);
    }

    public function clearAll()
    {
        return $this->redis->FLUSHALL();
    }

}