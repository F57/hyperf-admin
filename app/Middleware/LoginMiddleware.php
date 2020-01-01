<?php

declare(strict_types=1);

namespace App\Middleware;

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


    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {

        $session = $this->session->get('id');

        $url = $request->getServerParams();
        $array=array('/system/login','/system/captchas');

        if(in_array($url['request_uri'],$array)){
            if($session){
                return $this->http->redirect('/system');
            }
        }else{
            if(!$session){
                return $this->http->redirect('/system/login');
            }
        }

        return $handler->handle($request);
    }
}