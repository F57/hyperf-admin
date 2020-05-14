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

return [
    'http' => [
        \Hyperf\Session\Middleware\SessionMiddleware::class,//session
        \App\Middleware\HeaderMiddleware::class,//设置头信息
        \App\Middleware\CsrfMiddleware::class,//csrf验证
        \App\Middleware\AllowIpMiddleware::class,//后台允许访问的ip
        \App\Middleware\LoginMiddleware::class,//后台登录
        \App\Middleware\AuthMiddleware::class,//后天权限
        \Hyperf\Validation\Middleware\ValidationMiddleware::class,//数据验证
        \App\Middleware\FilterMiddleware::class,//过滤数据

    ],
];
