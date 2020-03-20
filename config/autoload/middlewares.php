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
use Hyperf\Validation\Middleware\ValidationMiddleware;
use Hyperf\Session\Middleware\SessionMiddleware;
use App\Middleware\FilterMiddleware;
use App\Middleware\Http\CsrfMiddleware;
use App\Middleware\Http\LoginMiddleware;
use App\Middleware\Http\AuthMiddleware;
use App\Middleware\Http\UserOperateMiddleware;

return [
    'http' => [
        SessionMiddleware::class,//session
        LoginMiddleware::class,//后台login
        AuthMiddleware::class,//后台auth
        CsrfMiddleware::class,//csrf
        FilterMiddleware::class,//过滤参数
        ValidationMiddleware::class,//验证器
        UserOperateMiddleware::class,//后台用户操作记录
    ],
];
