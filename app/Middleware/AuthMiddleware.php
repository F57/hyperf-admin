<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Model\Admin;
use Donjan\Permission\Exceptions\UnauthorizedException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Hyperf\Utils\Context;
use Hyperf\Di\Annotation\Inject;
use App\Service\Redis;
use Donjan\Permission\Models\Role;
use App\Helpers\Code;
use Hyperf\HttpServer\Contract\ResponseInterface as HttpResponseInterface;
use Donjan\Permission\Models\Permission;

class AuthMiddleware implements MiddlewareInterface
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
     * @var Admin
     */
    private $admin;

    /**
     * @Inject()
     * @var Redis
     */
    private $redis;

    protected $role;

    protected $HttpResponseInterface;

    protected $permission;

    public function __construct(ContainerInterface $container,Admin $admin,Redis $redis,Role $role,HttpResponseInterface $HttpResponseInterface,Permission $permission)
    {
        $this->container = $container;
        $this->admin = $admin;
        $this->Redis = $redis;
        $this->role = $role;
        $this->HttpResponseInterface = $HttpResponseInterface;
        $this->permission = $permission;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {

		$url = $request->getServerParams()['path_info'];
		$purl = ltrim($url,"/");
        $loginArr=array(
			'system/login',
			'system/captchas',
			'system/login/logout',
		);
		if(in_array($purl,$loginArr)){
			return $handler->handle($request);
		}

		$id = $this->session->get('id');
		if($id){

		}
        $uinfo = $this->redis->hGetAll('admin:user:id:'.$id);
        if(empty($uinfo)){
            $where[]=['id','=',$id];
            $uinfo =$this->admin->oneInfo($where);
            if($uinfo){
            	$uinfo = $uinfo->toArray();
			}else{
            	$uinfo=array();
			}
            $this->redis->hMSet('admin:user:id:'.$id,$uinfo);
        }
        Context::set('uinfo', $uinfo);
        if($id !=1)
        {
            //菜单以及权限
            $user = $this->admin->find($id);

            $whiteBlock=array(
                'system',
                'system/',
                'system/index',
            );
            if(!in_array($purl,$whiteBlock)){

                $result = $user->can($purl);
                $method = $request->getMethod();
                if(!$result && $method=='GET'){
                    return $this->HttpResponseInterface->redirect('/408');
                }
                if(!$result && $method !='GET'){
                    throw new UnauthorizedException('没有权限',Code::DISALLOW);
                }
            }
            $menu = $user->getMenu();
        }else{

            $menu = $this->permission::getMenuList();
        }

        $menus = array();
        foreach ($menu as $k=>$v)
        {
            $menus[$k]['display_name']=$v['display_name'];
            $menus[$k]['url']=$v['url'];
            $menus[$k]['icon']=$v['icon'];
            $menus[$k]['status']=$v['status'];
            if(isset($v->child)){
                foreach ($v['child'] as $kk=>$vv){
                    $menus[$k]['child'][$kk]['display_name']=$vv['display_name'];
                    $menus[$k]['child'][$kk]['url']=$vv['url'];
                    $menus[$k]['child'][$kk]['icon']=$vv['icon'];
                    $menus[$k]['child'][$kk]['status']=$vv['status'];
                }
            }
        }
        Context::set('menu', $menus);
        return $handler->handle($request);
    }
}
