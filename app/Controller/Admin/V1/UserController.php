<?php

declare(strict_types=1);

namespace App\Controller\Admin\V1;

use App\Controller\Admin\BaseController;
use App\Exception\AppRequestException;
use App\Request\Admin\PwdRequest;
use App\Request\Admin\UserInfoRequest;
use Hyperf\DbConnection\Db;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;
use Donjan\Permission\Models\Role;
use App\Model\User;
use App\Request\Admin\UserRequest;

/**
 * 管理员
 * @Controller()
 */
class UserController extends BaseController
{

    /**
     * @RequestMapping(path="/v1/user/index", methods="get")
     */
    public function index(User $user,Role $role)
    {

        $list = $user->getListByPage();

        $roles = $role::all()->toArray();

        return $this->render->render('admin.user.index',$this->helper->getData(compact('list','roles')));
    }

    /**
     * @RequestMapping(path="/v1/user/store", methods="post")
     */
    public function store(UserRequest $request,User $user)
    {
        $data['name'] = $request->input('name');
        $data['email'] = $request->input('email');
        $data['passwd'] = password_hash($request->input('passwd'), PASSWORD_DEFAULT);
        $data['role'] = $request->input('role');
        $data['access'] = $request->input('access');

        Db::beginTransaction();
        try{

            $user->add($data);
            $user =$user->orderBy('id','desc')->first();
            $user->roles()->sync([$data['role']]);

            Db::commit();
            return $this->helper->success();
        } catch(\Throwable $ex){
            Db::rollBack();
            throw new AppRequestException('',$this->code::ERROR);
        }
    }

    /**
     * @RequestMapping(path="/v1/user/update", methods="post")
     */
    public function update(UserRequest $request,User $user)
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
            $user->updateOne($where,$data);

            Db::commit();
            return $this->helper->success();

        } catch(\Throwable $ex){
            Db::rollBack();
            throw new AppRequestException('',$this->code::ERROR);
        }
    }

    /**
     * @RequestMapping(path="/v1/user/del", methods="post")
     */
    public function del(User $user)
    {
        $id = $this->request->input('id');
        if(!is_numeric($id)){
            throw new AppRequestException('',$this->code::VALIDATA_ERROR);
        }
        $where[]=['id','=',$id];
        $result = $user->del($where);

        if($result){
            return $this->helper->success();
        }

        throw new AppRequestException('',$this->code::ERROR);
    }

    /**
     * 修改密码
     * @RequestMapping(path="/v1/user/pwd", methods="post")
     */
    public function pwd(PwdRequest $request,User $user)
    {
        $password = $request->input('password');

        $id = $this->session->get('id');

        $where[]=['id','=',$id];
        $data['passwd']= password_hash($password, PASSWORD_DEFAULT);;

        $result = $user->updateOne($where,$data);
        if($result){
            return $this->helper->success();
        }

        throw new AppRequestException('',$this->code::ERROR);

    }

    /**
     * 修改密码
     * @RequestMapping(path="/v1/user/profile", methods="get")
     */
    public function profile(User $user)
    {
        return $this->render->render('admin.user.profile',$this->helper->getData());
    }

    /**
     * 修改密码
     * @RequestMapping(path="/v1/user/info", methods="post")
     */
    public function info(UserInfoRequest $request,User $user)
    {
        $username = $request->input('name');
        $email = $request->input('email');
        $img = $request->input('img');

        $id = $this->session->get('id');

        $where[]=['id','=',$id];
        $data['name']= $username;
        $data['email']= $email;
        $data['photo']= $img;
        $result = $user->updateOne($where,$data);
        if($result){
            return $this->helper->success();
        }

        throw new AppRequestException('',$this->code::ERROR);
    }
}