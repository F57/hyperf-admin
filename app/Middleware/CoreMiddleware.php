<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Exception\AppNotFoundException;
use App\Helpers\Code;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Utils\Contracts\Arrayable;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CoreMiddleware extends \Hyperf\HttpServer\CoreMiddleware
{
    /**
     * Handle the response when cannot found any routes.
     *
     * @return array|Arrayable|mixed|ResponseInterface|string
     */
    protected function handleNotFound(ServerRequestInterface $request)
    {
        $method = $request->getMethod();
        if($method !='GET'){
            throw new AppNotFoundException('API不存在',Code::NOT_FOUND);
        }
        throw new AppNotFoundException('html');
    }

    /**
     * Handle the response when the routes found but doesn't match any available methods.
     *
     * @return array|Arrayable|mixed|ResponseInterface|string
     */
    protected function handleMethodNotAllowed(array $methods, ServerRequestInterface $request)
    {
        $method = $request->getMethod();
        if($method !='GET'){
            throw new AppNotFoundException('请求错误',Code::ERROR);
        }
        throw new AppNotFoundException('html');
    }
}