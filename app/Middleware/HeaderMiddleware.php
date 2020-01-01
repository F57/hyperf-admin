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

class HeaderMiddleware implements MiddlewareInterface
{

    /**
     * @Inject
     * @var ConfigInterface
     */
    protected $config;

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {

//        $b = $request->getParsedBody();
//        array(2) {
//        ["aa"]=>
//  string(2) "bb"
//        ["cc"]=>
//  array(2) {
//            [0]=>
//    string(2) "dd"
//            [1]=>
//    string(2) "aa"
//  }
//}

//        var_dump($b);
//        $k = $request->getQueryParams();
//        array(1) {
//        ["aa"]=>
//  string(4) "fsdf"
//}


        $response = Context::get(ResponseInterface::class);

        $response = $response->withHeader('Content-Type', 'text/html; charset=utf-8');


        Context::set(ResponseInterface::class, $response);

        return $handler->handle($request);
    }
}