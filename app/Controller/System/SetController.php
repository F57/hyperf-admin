<?php

declare(strict_types=1);

namespace App\Controller\System;

use App\Exception\AppErrorRequestException;
use App\Model\Set;
use Hyperf\DbConnection\Db;
use App\Helpers\Code;
use Hyperf\HttpServer\Annotation\Controller;
use Hyperf\HttpServer\Annotation\RequestMapping;

/**
 * @Controller()
 */
class SetController extends AbstractController
{

    /**
     * @RequestMapping(path="/system/set/upload", methods="get")
     */
    public function upload(Set $set)
    {
    	$list = $set::all()->toArray();
    	return $this->render->render('system.set.upload',$this->other->initData(['list'=>$list]));
    }

    /**
     * @RequestMapping(path="/system/set/update", methods="post")
     */
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
			throw new AppErrorRequestException('请求错误',Code::ERROR);
		}
	}

    /**
     * @RequestMapping(path="/system/set/website", methods="get")
     */
    public function website(Set $set)
    {
        $list = $set::all()->toArray();
        return $this->render->render('system.set.website',$this->other->initData(['list'=>$list]));
    }
}
