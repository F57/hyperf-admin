<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Exception\AppNotFoundException;
use App\Helpers\Code;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Service\Other;
use Hyperf\Di\Annotation\Inject;

class CsrfMiddleware implements MiddlewareInterface
{

    /**
     * @Inject
     * @var Other
     */
    protected $other;

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $method = $request->getMethod();

        if($method !='GET'){

            $csrf = $request->getHeader('x-csrf-token')[0] ?? '';

            if($csrf==''){
				$csrf = $request->getParsedBody()['x-csrf-token'] ?? '';
			}

            if($csrf==''){
                throw new AppNotFoundException('验证错误',Code::VALIDATE_ERROR);
            }

            $result = $this->other->verifyCsrf($csrf);

            if(!$result){
                throw new AppNotFoundException('验证错误',Code::VALIDATE_ERROR);
            }

        }

        return $handler->handle($request);
    }
}