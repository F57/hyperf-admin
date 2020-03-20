<?php

declare(strict_types=1);

namespace App\Controller\Admin\V1;

use App\Controller\Admin\BaseController;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;

/**
 * @Controller()
 */
class SetController extends BaseController
{

    /**
     * @RequestMapping(path="/v1/set/index", methods="get")
     */
    public function index()
    {

    }

}