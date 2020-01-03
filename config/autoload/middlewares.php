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
use App\Middleware\HeaderMiddleware;
use Hyperf\Validation\Middleware\ValidationMiddleware;
use Hyperf\Session\Middleware\SessionMiddleware;
use App\Middleware\CsrfMiddleware;


return [
    'http' => [
        HeaderMiddleware::class,
        ValidationMiddleware::class,
        SessionMiddleware::class,
        CsrfMiddleware::class,
    ],
];
