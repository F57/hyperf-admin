<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\BaseController;
use App\Exception\AppBadRequestException;
use App\Helpers\Code;
use App\Model\Admin;
use App\Request\Admin\AdminInfoRequest;
use App\Request\Admin\AdminRequest;
use App\Request\Admin\PwdRequest;
use Donjan\Permission\Models\Role;
use Hyperf\DbConnection\Db;

class AdminController extends BaseController
{
    public function index(Admin $admin,Role $role)
    {
        $list = $admin->getListByPage();
        $roles = $role::all()->toArray();
        return $this->render->render('admin.admin.index',compact('list','roles'));
    }

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
            throw new AppBadRequestException('操作失败',Code::OPERATE_ERROR);
        }

    }

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
            throw new AppBadRequestException('操作失败',Code::OPERATE_ERROR);
        }
    }

    public function del(Admin $admin)
    {
        $id = $this->request->input('id');
        if(!is_numeric($id)){
            throw new AppBadRequestException('操作失败',Code::OPERATE_ERROR);
        }
        $where[]=['id','=',$id];
        $result = $admin->del($where);

        if($result){
            return $this->helper->success();
        }

        throw new AppBadRequestException('操作失败',Code::OPERATE_ERROR);
    }

    public function profile(Admin $admin)
    {
        $id = $this->session->get('id');
        $list = $this->redis->hGetAll('admin:user:id:'.$id);

        if(empty($list)){
            $where[]=['id','=',$id];
            $list =$admin->oneInfo($where)->toArray();
        }

        return $this->render->render('admin.admin.profile',compact('list'));

    }

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

        throw new AppBadRequestException('操作失败',Code::OPERATE_ERROR);
    }

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

		throw new AppBadRequestException('操作失败',Code::OPERATE_ERROR);

	}
}
