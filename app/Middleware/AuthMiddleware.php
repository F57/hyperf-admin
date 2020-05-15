<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Exception\AppAuthenticationFailureException;
use App\Exception\AppErrorRequestException;
use App\Exception\AppNotFoundException;
use App\Model\Admin;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Hyperf\Utils\Context;
use Hyperf\Di\Annotation\Inject;
use App\Service\Redis;
use Donjan\Permission\Models\Role;
use Donjan\Permission\Models\Permission;
use App\Helpers\Helper;

class AuthMiddleware implements MiddlewareInterface
{
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
     * @var Helper
     */
    private $helper;

    /**
     * @Inject()
     * @var Redis
     */
    private $redis;

    /**
     * @Inject()
     * @var Role
     */
    protected $role;

    /**
     * @Inject()
     * @var Permission
     */
    protected $permission;

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

        if($pathInfo['1'] =='login'){
            return $handler->handle($request);
        }

        $id = $this->session->get('id');

        $user = $this->redis->hGetAll('admin:user:id:'.$id);
        if(empty($user)){
            $where[]=['id','=',$id];
            $user =$this->admin->oneInfo($where);
            if($user){
                $user = $user->toArray();
            }else{
                $user=array();
            }
            $this->redis->hMSet('admin:user:id:'.$id,$user);
        }
        Context::set('user', $user);

        if($id !=1)
        {
            //菜单以及权限
            $user = $this->admin->find($id);
            $purl = $request->getServerParams()['path_info'];

            $permission = Permission::getPermissions(['name' => trim($purl,'/')])->first();
            $result = $user->can($permission);

            #$result = $user->checkPermissionTo($permission);

                $method = $request->getMethod();

                if(!$result && $method=='GET'){
                    throw  new AppErrorRequestException('html');
                }

                if(!$result && $method !='GET'){
                    throw new AppAuthenticationFailureException('api');
                }

                $menu = $user->getMenu();

        }else{

            $menu = $this->permission::getMenuList();

        }


        $menus = array();
        $btn = array();
        foreach ($menu as $k=>$v)
        {
            $menus[$k]['display_name']=$v['display_name'];
            $menus[$k]['url']=$v['url'];
            $menus[$k]['icon']=$v['icon'];
            $menus[$k]['status']=$v['status'];
            $btn[]=$v['url'];
            if(isset($v->child)){
                foreach ($v['child'] as $kk=>$vv){
                    $menus[$k]['child'][$kk]['display_name']=$vv['display_name'];
                    $menus[$k]['child'][$kk]['url']=$vv['url'];
                    $menus[$k]['child'][$kk]['icon']=$vv['icon'];
                    $menus[$k]['child'][$kk]['status']=$vv['status'];
                    $btn[]=$vv['url'];
                    if(isset($vv->child)){
                        foreach ($vv['child'] as $kkk=>$vvv){
                            $btn[]=$vvv['url'];
                        }
                    }
                }
            }
        }
        Context::set('menu', $menus);
        Context::set('btn', $btn);
        return $handler->handle($request);
    }
}
