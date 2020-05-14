<?php

namespace App\Model\ModelTrait;

trait ModelTrait
{

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

    public function getListByPage($where=[],$num=10)
    {
        return $this->where($where)->paginate($num);
    }

}