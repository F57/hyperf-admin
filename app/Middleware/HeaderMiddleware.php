<?php
declare(strict_types=1);

namespace App\Middleware;

use Hyperf\Utils\Context;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

use Hyperf\Contract\ConfigInterface;
use Hyperf\Di\Annotation\Inject;

class HeaderMiddleware implements MiddlewareInterface
{

    /**
     * @Inject
     * @var ConfigInterface
     */
    protected $config;

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {

        $response = Context::get(ResponseInterface::class);

        $response = $response->withHeader('Content-Type', 'text/html; charset=utf-8');


        Context::set(ResponseInterface::class, $response);

        return $handler->handle($request);
    }
}
