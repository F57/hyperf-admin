<?php

declare(strict_types=1);

namespace App\Controller\Admin\V1;

use App\Controller\Admin\BaseController;
use App\Exception\AppRequestException;
use App\Request\Admin\MenuRequest;
use Donjan\Permission\Models\Permission;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Donjan\Permission\PermissionRegistrar;
use Hyperf\Utils\ApplicationContext;

/**
 * 菜单权限
 * @Controller()
 */
class MenuController extends BaseController
{

    /**
     * @RequestMapping(path="/v1/menu/index", methods="get")
     */
    public function index(Permission $permission)
    {
        $list = $permission::getMenuList();
        return $this->render->render('admin.menu.index',$this->helper->getData($list));
    }

    /**
     * @RequestMapping(path="/v1/menu/store", methods="post")
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

        throw new AppRequestException('',$this->code::ERROR);
    }

    /**
     * @RequestMapping(path="/v1/menu/update", methods="post")
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

        throw new AppRequestException('',$this->code::ERROR);
    }

    /**
     * @RequestMapping(path="/v1/menu/del", methods="post")
     */
    public function del(Permission $permission)
    {
        $id = $this->request->input('id');

        if(!is_numeric($id)){
            throw new AppRequestException('',$this->code::VALIDATA_ERROR);
        }

        $result = $permission->where('id',$id)->delete();

        if($result){
            ApplicationContext::getContainer()->get(PermissionRegistrar::class)->forgetCachedPermissions();
            return $this->helper->success();
        }

        throw new AppRequestException('',$this->code::ERROR);
    }
}