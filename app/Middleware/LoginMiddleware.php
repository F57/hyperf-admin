<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Exception\AppNotFoundException;
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
     * @var \App\Helpers\Helper
     */
    private $helper;


    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $pathInfo = $this->helper->pathInfo();

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