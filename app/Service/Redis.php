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
        return $this->redis->exists($key);
    }
    /**
     * 写入缓存
     * @param string $key 键名
     * @param string $value 键值
     * @param int $expire 过期时间 0:永不过期
     * @return bool
     */
    public function set($key, $value, $expire = 0)
    {
        $value = (is_object($value) || is_array($value)) ? json_encode($value) : $value;

        if (is_int($expire) && $expire) {
            $result = $this->redis->setex($key, $expire, $value);
        } else {
            $result = $this->redis->set($key, $value);
        }

        return $result;
    }

    /**
     * 读取缓存
     * @param string $key 键值
     * @return mixed
     */
    public function get($key)
    {
        $value = $this->redis->get($key);

        $jsonData = json_decode($value, true);

        return (null === $jsonData) ? $value : $jsonData;
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
        $this->redis->hSet($name, $filed, $value);
        return true;
    }

    /**
     *  不存在会先创建,存在则覆盖
     * @param string $name hash名称
     * @param array $data 字段和值
     * @return bool
     */
    public function hMSet($name,array $data)
    {
        $this->redis->hMset($name,$data);
        return true;
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