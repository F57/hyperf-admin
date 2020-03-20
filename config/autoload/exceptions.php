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

use App\Exception\Handler\AppExceptionHandler;
use Hyperf\Validation\ValidationExceptionHandler;
use App\Exception\Handler\AppValidationExceptionHandler;
use App\Exception\Handler\AppRequestExceptionHadnler;

return [
    'handler' => [
        'http' => [
            AppExceptionHandler::class,//默认
            AppValidationExceptionHandler::class,//验证
            AppRequestExceptionHadnler::class,//请求错误

        ],
    ],
];
