<?php

declare(strict_types=1);

namespace App\Middleware\Http;

use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Hyperf\DbConnection\Db;
use Hyperf\Contract\ConfigInterface;
use Hyperf\Di\Annotation\Inject;
use App\Service\OperateService;

class UserOperateMiddleware implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @Inject
     * @var ConfigInterface
     */
    public $config;

    /**
     * @Inject()
     * @var \Hyperf\Contract\SessionInterface
     */
    private $session;

    /**
     * @Inject
     * @var OperateService
     */
    public $OperateService;

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $id = $this->session->get('id');

        if(!$id){
            return $handler->handle($request);
        }

        $url = $request->getServerParams()['request_uri'];

        $arr = array_merge(array_filter(explode('/',$url)));

        $count = count($arr);

        if($count < 3 ){
            return false;
        }

        $purl='';

        foreach ($arr as $k=>$v){
            if($k<3){
                $purl .='/'.$v;
            }
        }
        $table = $this->config->get('permission.table_names.permissions');
        $post = $request->getParsedBody();
        if($post['passwd']){
            unset($post['passwd']);
        }
        if($post['password']){
            unset($post['password']);
        }
        if($post['password_confirmation']){
            unset($post['password_confirmation']);
        }

        $where[]=['name','=',$purl];
        $data['name'] = Db::table($table)->where($where)->value('display_name');
        $data['get'] = $request->getQueryParams();
        $data['post'] =$post;
        $data['ip'] = $request->getHeaders()['x-real-ip']['0'];
        $data['id']=$id;

        $this->OperateService->push($data);

        return $handler->handle($request);
    }

}
