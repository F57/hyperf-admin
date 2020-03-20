<?php

declare(strict_types=1);

namespace App\Controller;

use App\Controller\Admin\BaseController;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;

/**
 * @Controller()
 */
class ErrorController extends BaseController
{

    /**
     * @RequestMapping(path="/v1/error/404", methods="get")
     */
    public function index()
    {
        echo '1111';
    }

}