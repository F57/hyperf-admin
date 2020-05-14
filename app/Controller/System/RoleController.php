<?php

declare(strict_types=1);

namespace App\Controller\System;


use App\Exception\AppErrorRequestException;
use App\Helpers\Code;
use App\Request\System\RoleRequest;
use Donjan\Permission\Models\Role;
use Donjan\Permission\Models\Permission;
use Hyperf\Utils\ApplicationContext;
use Donjan\Permission\PermissionRegistrar;
use Hyperf\DbConnection\Db;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Annotation\Controller;

/**
 * @Controller()
 */
class RoleController extends AbstractController
{
    /**
     * @RequestMapping(path="/system/role/index", methods="get")
     */
    public function index(Role $role)
    {
        $list = $role::all();
        return $this->render->render('system.role.index',$this->helper->initData(['list'=>$list]));
    }

    /**
     * @RequestMapping(path="/system/role/store", methods="post")
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

        throw new AppErrorRequestException('操作失败',Code::OPERATION_FAILED);
    }

    /**
     * @RequestMapping(path="/system/role/update", methods="post")
     */
	public function update(RoleRequest $request,Role $role)
	{
		$data['name']=$request->input('name');
		$data['description']=$request->input('description');
		$data['guard_name']=$request->input('guard_name');

		$result = $role->where('id',$request->input('id'))->update($data);

		if($result){
			return $this->helper->success();
		}

        throw new AppErrorRequestException('操作失败',Code::OPERATION_FAILED);
	}

    /**
     * @RequestMapping(path="/system/role/del", methods="post")
     */
	public function del(Role $role)
	{
		$id = $this->request->input('id');
		if(!is_numeric($id)){
            throw new AppErrorRequestException('操作失败',Code::OPERATION_FAILED);
		}

		$result = $role->where('id',$id)->delete();

		if($result){
			return $this->helper->success();
		}

        throw new AppErrorRequestException('操作失败',Code::OPERATION_FAILED);
	}

    /**
     * @RequestMapping(path="/system/role/authorize", methods="get")
     */
	public function authorize(Permission $permission,Role $role)
	{
	    $id = $this->request->input('id',0);
        if(!is_numeric($id) || $id==0){
            throw new AppErrorRequestException('操作失败',Code::OPERATION_FAILED);
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
		return $this->render->render('system.role.authorize',$this->helper->initData(['menuList'=>$menuList,'roleInfo'=>$roleInfo,'permissions'=>$permissions,'id'=>$id]));
	}

    /**
     * @RequestMapping(path="/system/role/auth", methods="post")
     */
	public function auth(Role $role)
    {
        $id = $this->request->input('id');
        $arr = $this->request->all();
        if(!is_array($arr)){
            throw new AppErrorRequestException('操作失败',Code::OPERATION_FAILED);
        }
        if(!isset($arr['ids']) || !is_array($arr['ids'])){
            throw new AppErrorRequestException('操作失败',Code::OPERATION_FAILED);
        }
        foreach ($arr['ids'] as $v){
            if(!is_numeric($v) || $v<1){
                throw new AppErrorRequestException('操作失败',Code::OPERATION_FAILED);
            }
        }

        $role = $role->where('id',$id)->first();
        $result = $role->permissions()->sync($arr['ids']);
        if($result){
            ApplicationContext::getContainer()->get(PermissionRegistrar::class)->forgetCachedPermissions();
            return $this->helper->success();
        }

        throw new AppErrorRequestException('操作失败',Code::OPERATION_FAILED);
    }
}
