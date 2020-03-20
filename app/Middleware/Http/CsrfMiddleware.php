<?php

declare(strict_types=1);

namespace App\Middleware\Http;

use App\Constants\Code;
use Hyperf\Cache\Cache;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Hyperf\Di\Annotation\Inject;
use App\Exception\AppRequestException;

class CsrfMiddleware implements MiddlewareInterface
{
    /**
     * @Inject
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @Inject
     * @var Cache
     */
    protected $cache;

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {


        if('post'=== strtolower($request->getMethod())){

            $csrf = $request->getHeaderLine('X-CSRF-TOKEN');

            if(!$csrf || $csrf =='' ){
                $csrf = $request->getParsedBody()['_token'];
            }

            if(!$csrf){
                throw new AppRequestException('',Code::CSRF_NOT_FOUND);
            }

            $isExists = $this->cache->get($csrf);

            if(!$isExists){
                throw new AppRequestException('',Code::CSRF_NOT_FOUND);
            }

            $url = $request->getServerParams()['request_uri'];
            $exp = array_filter(explode('/',$url));
            $ifLogin = in_array('login',$exp) ?? false;

            if(!$ifLogin){
                $this->cache->delete($csrf);
            }


        }
        return $handler->handle($request);
    }
}