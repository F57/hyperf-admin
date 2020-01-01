<?php

declare(strict_types=1);

namespace App\Engine;

use Hyperf\di\Annotation\Inject;
use Hyperf\View\Engine\EngineInterface;
use duncan3dc\Laravel\BladeInstance;
use Hyperf\Contract\ConfigInterface;
use Hyperf\HttpServer\Contract\RequestInterface;
use App\Helpers\Helper;

class View implements EngineInterface
{

    /**
     * @var array
     */
    protected $config;

    /**
     * @var Helper
     */
    protected $helper;

    public function __construct(ConfigInterface $config,Helper $helper)
    {
        $this->config = $config->get('view.config', []);
        $this->helper = $helper;
    }

    public function render($template, $data=array(),$config=array()): string
    {
        $uinfo = \Hyperf\Utils\Context::get('uinfo');
        $menu = \Hyperf\Utils\Context::get('menu');
        $data['menu']=$menu;
        $data['uinfo']=$uinfo;
        $data['csrf']=$this->helper->getCsrf();

        $blade = new BladeInstance($this->config['view_path'],$this->config['cache_path']);
        return $blade->render($template, $data);
    }
}