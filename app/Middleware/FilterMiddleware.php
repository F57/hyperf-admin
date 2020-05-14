<?php

declare(strict_types=1);

namespace App\Middleware;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Hyperf\Utils\Context;

/**
 * 过滤参数
 * Class FilterMiddleware
 * @package App\Middleware
 */
class FilterMiddleware implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {

        $queryParam = $this->paramFilter($request->getQueryParams());
        $request = $request->withQueryParams($queryParam);

        $postParam = $this->paramFilter($request->getParsedBody());
        $request = $request->withParsedBody($postParam);

        Context::set(ServerRequestInterface::class, $request);

        return $handler->handle($request);
    }

    public function paramFilter($data){
        foreach ($data as $key=>$value){
            if(!is_array($value))
            {
                $data[$key]=htmlentities(trim($value));
            }else{
                $data[$key]=$this->paramFilter($value);
            }

        }
        return $data;
    }
}