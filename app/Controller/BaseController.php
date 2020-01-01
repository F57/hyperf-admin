<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Controller;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\Container\ContainerInterface;
use App\Engine\View;
use App\Service\Redis;
use Hyperf\Contract\ConfigInterface;
use App\Helpers\Helper;
use Hyperf\Contract\SessionInterface;

class BaseController
{
    /**
     * @Inject
     * @var ContainerInterface
     */
    public $container;

    /**
     * @Inject
     * @var RequestInterface
     */
    public $request;

    /**
     * @Inject
     * @var ResponseInterface
     */
    public $response;

    /**
     * @Inject
     * @var View
     */
    public $render;

    /**
     * @Inject
     * @var Redis
     */
    public $redis;

    /**
     * @Inject
     * @var ConfigInterface
     */
    public $config;

    /**
     * @Inject
     * @var SessionInterface
     */
    public $session;

    /**
     * @Inject
     * @var Helper
     */
    public $helper;

    public function __construct(ContainerInterface $container,RequestInterface $request,View $render,Redis $redis,ConfigInterface $config,SessionInterface $session,Helper $helper)
    {
        $this->container = $container;
        $this->request = $request;
        $this->render = $render;
        $this->redis = $redis;
        $this->config = $config;
        $this->session = $session;
        $this->helper = $helper;
    }

}
