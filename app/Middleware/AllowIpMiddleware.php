<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Exception\AppNotFoundException;
use App\Helpers\Helper;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Hyperf\Di\Annotation\Inject;

class AllowIpMiddleware implements MiddlewareInterface
{

    /**
     * @Inject()
     * @var Helper
     */
    private $help;


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

        $realIp = $request->getHeaders()['x-real-ip'];
        $ips = env('ALLOW_IP','');
        if($ips ==''){
            return $handler->handle($request);
        }
        $ipArray = explode(',', $ips);
        if(!in_array($realIp,$ipArray)){
            throw new AppNotFoundException('html');
        }
        return $handler->handle($request);
    }
}