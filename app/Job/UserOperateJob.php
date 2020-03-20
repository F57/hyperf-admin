<?php

declare(strict_types=1);

namespace App\Job;

use Hyperf\AsyncQueue\Job;
use App\Model\UserOperateLog;

/**
 * 记录后台用户的每个操作
 * Class UserOperateJob
 * @package App\Job
 */
class UserOperateJob extends Job
{
    public $params;

    public function __construct($params)
    {
        $this->params = $params;
    }

    public function handle()
    {
        $data = $this->params;

        $arr=array(
            'name'=>$data['name'],
            'get'=>$data['get'],
            'post'=>$data['post'],
        );

        $UserOperateLog = new UserOperateLog();

        $UserOperateLog->uid = $data['id'];
        $UserOperateLog->ip = $data['ip'];
        $UserOperateLog->param = json_encode($arr,JSON_UNESCAPED_UNICODE);
        $UserOperateLog->save();
    }
}
