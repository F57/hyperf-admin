<?php

declare(strict_types = 1);

namespace App\Exception\Handler;

use App\Exception\AppRequestException;
use Hyperf\Di\Annotation\Inject;
use Psr\Http\Message\ResponseInterface;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Throwable;
use Hyperf\ExceptionHandler\ExceptionHandler;
use App\Helper\Helper;
use App\Constants\Code;

class AppRequestExceptionHadnler extends ExceptionHandler {

    /**
     * @Inject
     * @var Helper
     */
    protected $helper;

    public function handle(Throwable $throwable, ResponseInterface $response) {

        $this->stopPropagation();

        $code = $throwable->getCode();
        $message = $throwable->getMessage();
        $result = $this->helper->error($code,$message);

        return $response->withStatus(Code::SUCCESS)
            ->withAddedHeader('content-type', 'application/json')
            ->withBody(new SwooleStream($this->helper->jsonEncode($result)));
    }

    public function isValid(Throwable $throwable): bool {
        return $throwable instanceof AppRequestException;
    }
}