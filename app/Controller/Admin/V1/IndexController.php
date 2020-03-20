<?php

declare(strict_types=1);

namespace App\Controller\Admin\V1;

use App\Controller\Admin\BaseController;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;

/**
 * @Controller()
 */
class IndexController extends BaseController
{

    /**
     * @RequestMapping(path="/v1/index/index", methods="get")
     */
    public function index()
    {
        return $this->render->render('admin.index.index',$this->helper->getData());
    }

}