<?php

declare(strict_types=1);

namespace App\Controller\Admin\V1;

use App\Controller\Admin\BaseController;
use App\Exception\AppRequestException;
use App\Request\Admin\RoleRequest;
use Donjan\Permission\Models\Permission;
use Hyperf\DbConnection\Db;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Donjan\Permission\PermissionRegistrar;
use Hyperf\Utils\ApplicationContext;
use Donjan\Permission\Models\Role;

/**
 * 角色
 * @Controller()
 */
class RoleController extends BaseController
{

    /**
     * @RequestMapping(path="/v1/role/index", methods="get")
     */
    public function index(Role $role)
    {

        $list = $role::all();

        return $this->render->render('admin.role.index',$this->helper->getData($list));
    }

    /**
     * @RequestMapping(path="/v1/role/store", methods="post")
     */
    public function store(RoleRequest $request,Role $role)
    {
        $data['name']=$request->input('name');
        $data['description']=$request->input('description');
        $data['guard_name']=$request->input('guard_name');
        $result = $role->create($data);

        if($result){

            return $this->helper->success();
        }
        throw new AppRequestException('',$this->code::ERROR);
    }

    /**
     * @RequestMapping(path="/v1/role/update", methods="post")
     */
    public function update(RoleRequest $request,Role $role)
    {
        $data['name']=$request->input('name');
        $data['description']=$request->input('description');
        $data['guard_name']=$request->input('guard_name');
        $id = $request->input('id');

        if(!is_numeric($id)){
            throw new AppRequestException('',$this->code::VALIDATA_ERROR);
        }
        $result = $role->where('id',$id)->update($data);

        if($result){
            return $this->helper->success();
        }

        throw new AppRequestException('',$this->code::ERROR);
    }

    /**
     * @RequestMapping(path="/v1/role/del", methods="post")
     */
    public function del(Role $role)
    {
        $id = $this->request->input('id');

        if(!is_numeric($id)){
            throw new AppRequestException('',$this->code::VALIDATA_ERROR);
        }

        $result = $role->where('id',$id)->delete();

        if($result){
            return $this->helper->success();
        }

        throw new AppRequestException('',$this->code::ERROR);
    }

    /**
     * @RequestMapping(path="/v1/role/authorize/{id}", methods="get")
     */
    public function authorize(int $id,Permission $permission,Role $role)
    {

        if(!is_numeric($id) || $id==0){
            throw new AppBadRequestException('参数错误!');
        }

        $roleHasPermission = Db::table('role_has_permissions')
            ->where('role_id',$id)
            ->get();

        $permissions = array();
        foreach ($roleHasPermission as $v){
            $permissions[]=$v->permission_id;
        }

        $roleInfo = $role->where('id',$id)->first();
        $menuList = $permission::getMenuList();
        $list['menuList']= $menuList;
        $list['roleInfo']= $roleInfo;
        $list['permissions']= $permissions;
        $list['id']= $id;

        return $this->render->render('admin.role.authorize',$this->helper->getData($list));
    }

    /**
     * @RequestMapping(path="/v1/role/auth/{id}", methods="post")
     */
    public function auth(int $id,Role $role)
    {
        $arr = $this->request->all();
        if(!is_array($arr)){
            throw new AppRequestException('',$this->code::VALIDATA_ERROR);
        }

        if(!isset($arr['ids']) || !is_array($arr['ids'])){
            throw new AppRequestException('',$this->code::VALIDATA_ERROR);
        }

        foreach ($arr['ids'] as $v){
            if(!is_numeric($v) || $v<1){
                throw new AppRequestException('',$this->code::VALIDATA_ERROR);
            }
        }

        $role = $role->where('id',$id)->first();
        $result = $role->permissions()->sync($arr['ids']);
        if($result){
            ApplicationContext::getContainer()->get(PermissionRegistrar::class)->forgetCachedPermissions();
            return $this->helper->success();
        }

        throw new AppRequestException('',$this->code::ERROR);
    }
}