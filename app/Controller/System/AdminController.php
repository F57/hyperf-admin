<?php

declare(strict_types=1);

namespace App\Controller\System;

use App\Exception\AppErrorRequestException;
use App\Helpers\Code;
use App\Model\Admin;
use App\Request\System\AdminInfoRequest;
use App\Request\System\AdminRequest;
use App\Request\System\PwdRequest;
use Donjan\Permission\Models\Role;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Hyperf\View\RenderInterface;
use Hyperf\DbConnection\Db;

/**
 * @Controller()
 */
class AdminController extends AbstractController
{
    /**
     * @RequestMapping(path="/system/admin/index", methods="get")
     */
    public function index(Admin $admin,Role $role)
    {
        $list = $this->page->getHtml($admin->getListByPage()->toArray());
        $roles = $role::all()->toArray();
        return $this->render->render('system.admin.index',$this->helper->initData(['list'=>$list,'roles'=>$roles]));

    }

    /**
     * @RequestMapping(path="/system/admin/store", methods="post")
     */
    public function store(AdminRequest $request,Admin $admin)
    {
        $data['name'] = $request->input('name');
        $data['email'] = $request->input('email');
        $data['passwd'] = password_hash($request->input('passwd'), PASSWORD_DEFAULT);
        $data['role'] = $request->input('role');
        $data['access'] = $request->input('access');

        Db::beginTransaction();
        try{

            $admin->add($data);
            $user =$admin->orderBy('id','desc')->first();
            $user->roles()->sync([$data['role']]);

            Db::commit();
            return $this->helper->success();
        } catch(\Throwable $ex){
            Db::rollBack();
            throw new AppErrorRequestException('操作失败',Code::OPERATION_FAILED);
        }

    }

    /**
     * @RequestMapping(path="/system/admin/update", methods="post")
     */
    public function update(AdminRequest $request,Admin $admin)
    {
        $data['name'] = $request->input('name');
        $data['email'] = $request->input('email');
        $data['role'] = $request->input('role');
        $data['access'] = $request->input('access');
        $passwd = $request->input('passwd');
        if($passwd !='false'){
            $data['passwd'] = password_hash($passwd, PASSWORD_DEFAULT);
        }
        $id = $this->request->input('id');
        $where[]=['id','=',$id];

        Db::beginTransaction();

        try{

            $model['role_id']=$data['role'];
            Db::table('model_has_roles')->where('model_id',$id)->update($model);
            $admin->updateOne($where,$data);

            Db::commit();
            return $this->helper->success();

        } catch(\Throwable $ex){
            Db::rollBack();
            throw new AppErrorRequestException('操作失败',Code::OPERATION_FAILED);
        }
    }

    /**
     * @RequestMapping(path="/system/admin/del", methods="post")
     */
    public function del(Admin $admin)
    {
        $id = $this->request->input('id');
        if(!is_numeric($id)){
            throw new AppErrorRequestException('操作失败',Code::OPERATION_FAILED);
        }
        $where[]=['id','=',$id];
        $result = $admin->del($where);

        if($result){
            return $this->helper->success();
        }

        throw new AppErrorRequestException('操作失败',Code::OPERATION_FAILED);
    }

    /**
     * 管理员信息
     * @RequestMapping(path="/system/admin/profile", methods="get")
     */
    public function profile(RenderInterface $render)
    {
        return $render->render('system.admin.profile',$this->helper->initData());
    }

    /**
     * 修改管理员信息
     * @RequestMapping(path="/system/admin/info", methods="post")
     */
    public function info(AdminInfoRequest $request,Admin $admin)
    {
        $username = $request->input('name');
        $email = $request->input('email');
        $img = $request->input('img');

        $id = $this->session->get('id');

        $where[]=['id','=',$id];
        $data['name']= $username;
        $data['email']= $email;
        $data['photo']= $img;

        $result = $admin->updateOne($where,$data);

        if($result){

            $this->redis->del('admin:user:id:'.$id);

            return $this->helper->success();
        }

        throw new AppErrorRequestException('操作失败',Code::OPERATION_FAILED);
    }

    /**
     * 修改管理员信息
     * @RequestMapping(path="/system/admin/pwd", methods="post")
     */
    public function pwd(PwdRequest $request,Admin $admin)
	{
		$password = $request->input('password');

		$id = $this->session->get('id');

		$where[]=['id','=',$id];
		$data['passwd']= password_hash($password, PASSWORD_DEFAULT);;

		$result = $admin->updateOne($where,$data);
		if($result){
			$this->redis->del('admin:user:id:'.$id);

			return $this->helper->success();
		}

        throw new AppErrorRequestException('操作失败',Code::OPERATION_FAILED);

	}
}
