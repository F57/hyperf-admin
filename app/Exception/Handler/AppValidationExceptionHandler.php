<?php

declare(strict_types = 1);

namespace App\Exception\Handler;

use Hyperf\Di\Annotation\Inject;
use Psr\Http\Message\ResponseInterface;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Throwable;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\Validation\ValidationException;
use App\Helper\Helper;
use App\Constants\Code;

class AppValidationExceptionHandler extends ExceptionHandler {

    /**
     * @Inject
     * @var Helper
     */
    protected $helper;

    public function handle(Throwable $throwable, ResponseInterface $response) {

        $this->stopPropagation();

        $message = $throwable->validator->errors()->first();

        $result = $this->helper->error(Code::VALIDATA_ERROR, $message);

        return $response->withStatus(200)
            ->withAddedHeader('content-type', 'application/json')
            ->withBody(new SwooleStream($this->helper->jsonEncode($result)));
    }

    public function isValid(Throwable $throwable): bool {
        return $throwable instanceof ValidationException;
    }
}