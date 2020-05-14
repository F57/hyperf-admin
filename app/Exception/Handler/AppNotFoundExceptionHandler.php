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
use App\Exception\AppNotFoundException;
use Hyperf\Config\Annotation\Value;

class AppNotFoundExceptionHandler extends ExceptionHandler {

    /**
     * @Inject
     * @var Helper
     */
    protected $helper;

    /**
     * @Inject
     * @var \Hyperf\Filesystem\FilesystemFactory
     */
    protected $filesystem;

    /**
     * @Value("view.config.view_path")
     */
    private $configValue;

    public function handle(Throwable $throwable, ResponseInterface $response) {

        $this->stopPropagation();

        $message = $throwable->getMessage();
        $code = $throwable->getCode();

        if($message !='html'){
            $result = $this->helper->error($code, $message);
            return $response->withStatus(Code::SUCCESS)
                ->withAddedHeader('content-type', 'application/json')
                ->withBody(new SwooleStream($this->helper->jsonEncode($result)));
        }else{

            $local = $this->filesystem->get('html');

            $html =$local->read('view/error/404.html');

            return $response->withStatus(404)
                ->withAddedHeader('content-type', 'application/text')
                ->withBody(new SwooleStream($html));
        }

    }

    public function isValid(Throwable $throwable): bool {
        return $throwable instanceof AppNotFoundException;
    }
}