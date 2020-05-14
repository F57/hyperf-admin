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
use App\Helpers\Helper;
use Hyperf\HttpMessage\Cookie\Cookie;

class HeaderMiddleware implements MiddlewareInterface
{

    /**
     * @Inject
     * @var ConfigInterface
     */
    protected $config;

    /**
     * @Inject
     * @var Helper
     */
    protected $helper;


    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {

        $response = Context::get(ResponseInterface::class);

        $response = $response->withHeader('Content-Type', 'text/html; charset=utf-8');
        $cookie = $request->getCookieParams()['csrf'] ?? '';

        if($cookie==''){
            $cookie = new Cookie('csrf', $this->helper->generateString());
            Context::set('cookie',$cookie);
            $response = $response->withCookie($cookie);
        }

        Context::set(ResponseInterface::class, $response);

        return $handler->handle($request);
    }
}
