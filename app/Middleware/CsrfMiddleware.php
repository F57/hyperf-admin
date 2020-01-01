<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Exception\AppBadRequestException;
use App\Exception\AppCsrfRequestException;
use App\Helpers\Code;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Helpers\Helper;

class CsrfMiddleware implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;
    /**
     * @var Helper
     */
    protected $helper;

    public function __construct(ContainerInterface $container,Helper $helper)
    {
        $this->container = $container;
        $this->helper = $helper;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $method = $request->getMethod();
        if($method !='GET'){
            $csrf = $request->getHeader('x-csrf-token')[0] ?? '';
            if($csrf==''){
				$csrf = $request->getParsedBody()['x-csrf-token'] ?? '';
			}
            if($csrf==''){
                throw new AppCsrfRequestException();
            }
            $result = $this->helper->verifyCsrf($csrf);

            if(!$result){
                throw new AppBadRequestException('请求超时',Code::TIMEOUT_ERROR);
            }

        }

        return $handler->handle($request);
    }
}