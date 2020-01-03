<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\BaseController;

class IndexController extends BaseController
{


    public function index()
    {
        return $this->render->render('admin.index.index');
    }

}
