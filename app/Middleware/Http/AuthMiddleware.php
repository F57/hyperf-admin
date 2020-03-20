<?php

declare(strict_types=1);

namespace App\Middleware\Http;

use App\Constants\Code;
use App\Exception\AppRequestException;
use App\Model\User;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Hyperf\Utils\Context;
use Hyperf\Di\Annotation\Inject;
use Donjan\Permission\Models\Role;
use Hyperf\HttpServer\Contract\ResponseInterface as HttpResponseInterface;
use Donjan\Permission\Models\Permission;
use Hyperf\Cache\Cache;

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
     * @var User
     */
    private $user;

    /**
     * @Inject()
     * @var Cache
     */
    private $Cache;

    /**
     * @Inject()
     * @var Role
     */
    protected $role;

    /**
     * @Inject()
     * @var HttpResponseInterface
     */
    protected $http;

    /**
     * @Inject()
     * @var Permission
     */
    protected $permission;


    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {

        $id = $this->session->get('id');

        if(!$id){
            return $handler->handle($request);
        }

        $menus = $this->Cache->get('menu:id:'.$id);
        if($menus){
            Context::set('menu', $menus);

            return $handler->handle($request);
        }

        $url = $request->getServerParams()['request_uri'];

        $arr = array_merge(array_filter(explode('/',$url)));

        $uinfo =$this->user->find($id);

        $isPermission = $this->userHasPermission($uinfo,$arr);

        $method = $request->getMethod();

        if(!$isPermission && $method=='GET'){
            return $this->http->redirect('/404');
        }

        if(!$isPermission && $method !='GET'){
            throw new AppRequestException('',Code::DISALLOW);
        }

        $menus = $this->menuList($uinfo,$id,$arr);

        Context::set('menu', $menus);

        return $handler->handle($request);
    }

    /**
     * 获取菜单
     * @param $uinfo
     * @param $id
     * @param $arr
     * @return array
     */
    public function menuList($uinfo,$id,$arr)
    {
        $ifAdmin =in_array('v1',$arr) ?? false;
        $ifLogin = in_array('login',$arr) ?? false;

        if($ifAdmin && $id && $ifLogin==false){

            if($uinfo->id == 1) {

                $menu = $this->permission::getMenuList();

            }else{

                $menu= $uinfo->getMenu();

            }

        }

        $menus = array();
        foreach ($menu as $k=>$v)
        {
            if($v['status']==0){
                $menus[$k]['display_name']=$v['display_name'];
                $menus[$k]['url']=$v['url'];
                $menus[$k]['icon']=$v['icon'];
                if(isset($v->child)){
                    foreach ($v['child'] as $kk=>$vv){
                        $menus[$k]['child'][$kk]['display_name']=$vv['display_name'];
                        $menus[$k]['child'][$kk]['url']=$vv['url'];
                        $menus[$k]['child'][$kk]['icon']=$vv['icon'];
                    }
                }
            }
        }
        $this->Cache->set('menu:id:'.$id,$menus);
        return $menus;
    }

    /**
     * 用户对是否有权限
     * @param $user
     * @param $arr
     * @return bool
     */
    protected function userHasPermission($user,$arr)
    {
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

        $permission = Permission::getPermissions(['name' => $purl])->first();

        $result = $user->checkPermissionTo($permission);

        if($result){
            return true;
        }

        return false;

    }
}
