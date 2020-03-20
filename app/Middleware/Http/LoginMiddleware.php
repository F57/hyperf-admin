<?php

declare(strict_types=1);

namespace App\Middleware\Http;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\ResponseInterface as HttpResponseInterface;

class LoginMiddleware implements MiddlewareInterface
{
    /**
     * @Inject()
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @Inject()
     * @var \Hyperf\Contract\SessionInterface
     */
    private $session;

    /**
     * @Inject()
     * @var HttpResponseInterface
     */
    private $http;


    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {

        $url = $request->getServerParams()['request_uri'];
        $exp = array_filter(explode('/',$url));
        $ifAdmin =in_array('v1',$exp) ?? false;
        $ifLogin = in_array('login',$exp) ?? false;
        $iflogout = in_array('logout',$exp) ?? false;
        $session = $this->session->get('id');

        if($ifAdmin && $ifLogin)
        {
            if($session && !$iflogout){
                return $this->http->redirect('/v1/index/index');
            }
        }

        if($ifAdmin && !$ifLogin){
            if(!$session){
                return $this->http->redirect('/v1/login');
            }
        }

        return $handler->handle($request);
    }
}