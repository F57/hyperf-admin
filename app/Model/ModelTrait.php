<?php

namespace App\Model;

use App\Service\PaginatorService;
use Hyperf\Di\Annotation\Inject;

trait ModelTrait
{
    /**
     * @Inject()
     *
     * @var PaginatorService
     */
    protected $paginatorService;

    public function add($data)
    {
        $date = date('Y-m-d H:i:s',time());
        $data['created_at']=$date;
        $data['updated_at']=$date;
        $result = $this->insert($data);
        return $result;
    }

    public function oneInfo($where)
    {
        return $this->where($where)->first();
    }

    public function updateOne($where,$data)
    {
        $info = $this->oneInfo($where);
        foreach ($data as $k=>$v)
        {
            $info->$k = $v;
        }
        return $info->save();
    }

    public function del($where)
	{
		return  $this->oneInfo($where)->delete();
	}

    public function getListByPage($where=[],$num=10,$orderby=array('id','desc'))
    {

       $list = $this->where($where)
            ->orderBy($orderby['0'], $orderby['1'])
            ->paginate($num)
            ->toArray();
        $count = $this->where($where)->count();
        $result = $this->paginatorService->getPaginator(array('list'=>$list,'count'=>$count,'num'=>$num));
        $data['p']=$result;
        $data['d']=$list['data'];
        return $data;
    }
}