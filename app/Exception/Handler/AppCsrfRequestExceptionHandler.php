<?php

declare(strict_types = 1);

namespace App\Exception\Handler;

use Hyperf\Di\Annotation\Inject;
use Psr\Http\Message\ResponseInterface;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Throwable;
use App\Helpers\Helper;
use App\Helpers\Code;
use Hyperf\ExceptionHandler\ExceptionHandler;
use App\Exception\AppCsrfRequestException;

class AppCsrfRequestExceptionHandler extends ExceptionHandler {

    /**
     * @Inject
     * @var Helper
     */
    protected $helper;

    public function handle(Throwable $throwable, ResponseInterface $response) {

        $this->stopPropagation();

        $message = $throwable->getMessage();

        $result = $this->helper->error(Code::CSRF_NOT_FOUND, $message);

        return $response->withStatus(Code::SUCCESS)
            ->withAddedHeader('content-type', 'application/json')
            ->withBody(new SwooleStream($this->helper->jsonEncode($result)));
    }

    public function isValid(Throwable $throwable): bool {
        return $throwable instanceof AppCsrfRequestException;
    }
}