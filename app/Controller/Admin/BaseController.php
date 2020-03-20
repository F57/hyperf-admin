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

namespace App\Controller\Admin;

use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Psr\Container\ContainerInterface;
use Hyperf\View\RenderInterface;
use App\Helper\Helper;
use App\Constants\Code;
use Hyperf\Contract\SessionInterface;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Cache\Cache;

abstract class BaseController
{
    /**
     * @Inject
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @Inject
     * @var RequestInterface
     */
    protected $request;

    /**
     * @Inject
     * @var ResponseInterface
     */
    protected $response;

    /**
     * @Inject
     * @var RenderInterface
     */
    public $render;

    /**
     * @Inject
     * @var Helper
     */
    public $helper;

    /**
     * @Inject
     * @var Code
     */
    public $code;

    /**
     * @Inject
     * @var SessionInterface
     */
    public $session;

    /**
     * @Inject
     * @var ConfigInterface
     */
    public $config;

    /**
     * @Inject
     * @var Cache
     */
    public $cache;
}
