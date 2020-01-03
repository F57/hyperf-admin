<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\BaseController;
use App\Model\Set;
use Hyperf\DbConnection\Db;
use App\Exception\AppBadRequestException;
use App\Helpers\Code;

class SetController extends BaseController
{

    public function upload(Set $set)
    {
    	$list = $set::all();
    	return $this->render->render('admin.set.upload',compact('list'));
    }

    public function update()
	{
		$param  = $this->request->all();
		Db::beginTransaction();
		try{
			foreach ($param as $k=>$v){
				$data=array();
				$where=array();
				$data['value']=$v;
				$where[]=['key','=',$k];
				Db::table('sets')->where($where)->update($data);
			}
			Db::commit();
			return $this->helper->success();
		} catch(\Throwable $ex){
			Db::rollBack();
			throw new AppBadRequestException('操作失败',Code::OPERATE_ERROR);
		}
	}
}
