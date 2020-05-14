<?php

declare(strict_types=1);

namespace App\Controller\System;

use App\Exception\AppErrorRequestException;
use App\Helpers\Code;
use App\Request\System\MenuRequest;
use Donjan\Permission\Models\Permission;
use Hyperf\Utils\ApplicationContext;
use Donjan\Permission\PermissionRegistrar;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\HttpServer\Annotation\Controller;

/**
 * @Controller()
 */
class MenuController extends AbstractController
{
    /**
     * @RequestMapping(path="/system/menu/index", methods="get")
     */
	public function index(Permission $permission)
	{
		$list = $permission::getMenuList();
		return $this->render->render('system.menu.index',$this->helper->initData(['list'=>$list]));
	}

    /**
     * @RequestMapping(path="/system/menu/store", methods="post")
     */
	public function store(MenuRequest $request,Permission $permission)
	{
		$data['parent_id']=$request->input('parent_id');
		$data['name']=$request->input('name');
		$data['display_name']=$request->input('display_name');
		$data['url']=$request->input('url');
		$data['icon']=$request->input('icon');
		$data['guard_name']=$request->input('guard_name');
		$data['sort']=$request->input('sort');
		$data['status']=$request->input('status');

		$result = $permission->create($data);

		if($result){

			return $this->helper->success();
		}

		throw new AppErrorRequestException('操作失败',Code::OPERATION_FAILED);
	}

    /**
     * @RequestMapping(path="/system/menu/update", methods="post")
     */
	public function update(MenuRequest $request,Permission $permission)
	{
		$data['parent_id']=$request->input('parent_id');
		$data['name']=$request->input('name');
		$data['display_name']=$request->input('display_name');
		$data['url']=$request->input('url');
		$data['icon']=$request->input('icon');
		$data['guard_name']=$request->input('guard_name');
		$data['sort']=$request->input('sort');
		$data['status']=$request->input('status');
		$result = $permission->where('id',$request->input('id'))->update($data);

		if($result){
			ApplicationContext::getContainer()->get(PermissionRegistrar::class)->forgetCachedPermissions();
			return $this->helper->success();
		}

		throw new AppErrorRequestException('操作失败',Code::OPERATION_FAILED);
	}

    /**
     * @RequestMapping(path="/system/menu/del", methods="post")
     */
	public function del(Permission $permission)
	{
		$id = $this->request->input('id');
		if(!is_numeric($id)){
			throw new AppErrorRequestException('操作失败',Code::OPERATION_FAILED);
		}

		$result = $permission->where('id',$id)->delete();

		if($result){
			ApplicationContext::getContainer()->get(PermissionRegistrar::class)->forgetCachedPermissions();
			return $this->helper->success();
		}

		throw new AppErrorRequestException('操作失败',Code::OPERATION_FAILED);
	}
}