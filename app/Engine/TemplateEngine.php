<?php

declare(strict_types=1);

namespace App\Engine;

use Hyperf\Contract\ConfigInterface;
use Hyperf\View\Engine\EngineInterface;
use duncan3dc\Laravel\BladeInstance;

class TemplateEngine implements EngineInterface
{

    /**
     * @var array
     */
    protected $array;

    public function __construct(ConfigInterface $config)
    {
        $this->array = $config->get('view.config', []);
    }

    public function render($template, $data=[], $config=[]): string
    {
        $blade = new BladeInstance($this->array['view_path'],$this->array['cache_path']);
        return $blade->render($template, $data);
    }
}