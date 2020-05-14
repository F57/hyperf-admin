<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Exception\AppNotFoundException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\ResponseInterface as HttpResponseInterface;
use App\Helpers\Helper;

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

    /**
     * @Inject()
     * @var Helper
     */
    private $help;


    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $pathInfo = $this->help->pathInfo();

        if(empty($pathInfo)){
            return $handler->handle($request);
        }

        if(count($pathInfo)<2){
            throw new AppNotFoundException('html');
        }

        if($pathInfo['0'] !='system'){
            return $handler->handle($request);
        }

        $session = $this->session->get('id');
        if($pathInfo['1'] =='login'){

            if(count($pathInfo)>=3 && $pathInfo['2']=='logout'){
                return $handler->handle($request);
            }

            if($session){
                return $this->http->redirect('/system/index');
            }

        }else{

            if(!$session){
                return $this->http->redirect('/system/login');
            }

        }
        return $handler->handle($request);
    }
}