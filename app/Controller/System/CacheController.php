<?php

declare(strict_types=1);

namespace App\Controller\System;

use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;

/**
 * @Controller()
 */
class CacheController extends AbstractController
{
    /**
     * 管理员信息
     * @RequestMapping(path="/system/cache/clear", methods="post")
     */
    public function clear()
    {
       $this->redis->clearAll();
       return $this->helper->success();
    }
}
