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
    'handler' => [
        'http' => [
            App\Exception\Handler\AppValidationExceptionHandler::class, //数据验证
            App\Exception\Handler\AppNotFoundExceptionHandler::class,//404
            App\Exception\Handler\AppBadRequestExceptionHandler::class,//0
            App\Exception\Handler\AppCsrfRequestExceptionHandler::class,//419
            App\Exception\Handler\UnauthorizedExceptionHandler::class,//408
            App\Exception\Handler\AppExceptionHandler::class,   //系统自带

        ],
    ],
];
