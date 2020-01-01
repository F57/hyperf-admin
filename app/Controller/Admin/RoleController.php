<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\BaseController;
use App\Exception\AppBadRequestException;
use App\Request\Admin\RoleRequest;
use Donjan\Permission\Models\Role;
use Donjan\Permission\Models\Permission;
use Hyperf\Utils\ApplicationContext;
use Donjan\Permission\PermissionRegistrar;
use Hyperf\DbConnection\Db;

class RoleController extends BaseController
{
    public function index(Role $role)
    {
        $list = $role::all();
        return $this->render->render('admin.role.index',compact('list'));
    }

    public function store(RoleRequest $request,Role $role)
    {
        $data['name']=$request->input('name');
        $data['description']=$request->input('description');
        $data['guard_name']=$request->input('guard_name');
        $result = $role->create($data);

        if($result){

            return $this->helper->success();
        }

        throw new AppBadRequestException('操作失败',Code::OPERATE_ERROR);
    }

	public function update(RoleRequest $request,Role $role)
	{
		$data['name']=$request->input('name');
		$data['description']=$request->input('description');
		$data['guard_name']=$request->input('guard_name');

		$result = $role->where('id',$request->input('id'))->update($data);

		if($result){
			return $this->helper->success();
		}

		throw new AppBadRequestException('操作失败',Code::OPERATE_ERROR);
	}

	public function del(Role $role)
	{
		$id = $this->request->input('id');
		if(!is_numeric($id)){
			throw new AppBadRequestException('操作失败',Code::OPERATE_ERROR);
		}

		$result = $role->where('id',$id)->delete();

		if($result){
			return $this->helper->success();
		}

		throw new AppBadRequestException('操作失败',Code::OPERATE_ERROR);
	}

	public function authorize(Permission $permission,Role $role)
	{
	    $id = $this->request->input('id',0);
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

		return $this->render->render('admin.role.authorize',compact('menuList','roleInfo','permissions','id'));
	}

	public function auth(int $id,Role $role)
    {
        $arr = $this->request->all();
        if(!is_array($arr)){
            throw new AppBadRequestException('参数错误!');
        }
        if(!isset($arr['ids']) || !is_array($arr['ids'])){
            throw new AppBadRequestException('参数错误!');
        }
        foreach ($arr['ids'] as $v){
            if(!is_numeric($v) || $v<1){
                throw new AppBadRequestException('参数错误!');
            }
        }

        $role = $role->where('id',$id)->first();
        $result = $role->permissions()->sync($arr['ids']);
        if($result){
            ApplicationContext::getContainer()->get(PermissionRegistrar::class)->forgetCachedPermissions();
            return $this->helper->success();
        }

        throw new AppBadRequestException('操作失败',Code::OPERATE_ERROR);
    }
}
