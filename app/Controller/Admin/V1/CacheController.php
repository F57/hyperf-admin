<?php

declare(strict_types=1);

namespace App\Controller\Admin\V1;

use App\Controller\Admin\BaseController;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\Utils\ApplicationContext;

/**
 * @Controller()
 */
class CacheController extends BaseController
{
    protected $redis;

    public function __construct()
    {
        $container = ApplicationContext::getContainer();
        $this->redis = $container->get(\Redis::class);
    }

    /**
     * @RequestMapping(path="/v1/cache/clear", methods="post")
     */
    public function clear()
    {
        $this->redis->FLUSHALL();
        return $this->helper->success();
    }
}
