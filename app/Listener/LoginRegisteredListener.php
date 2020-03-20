<?php
namespace App\Listener;

use App\Event\LoginRegistered;
use Hyperf\Event\Annotation\Listener;
use Hyperf\Event\Contract\ListenerInterface;
use App\Model\User;
use Hyperf\Di\Annotation\Inject;
use App\Model\UserLoginLog;

/**
 * @Listener
 */
class LoginRegisteredListener implements ListenerInterface
{
    /**
     * @Inject
     * @var User
     */
    protected $user;

    /**
     * @Inject
     * @var UserLoginLog
     */
    protected $loginLog;

    public function listen(): array
    {
        return [
            LoginRegistered::class,
        ];
    }

    /**
     * @param LoginRegistered $event
     */
    public function process(object $event)
    {
        //修改用户登录ip,记录登录日志
        $where[]=['id','=',$event->arr['id']];
        $data['ip']=$event->arr['ip'];
        $this->user->updateOne($where,$data);

        $log['uid']=$event->arr['id'];
        $log['ip']=$event->arr['ip'];
        $this->loginLog->add($log);
    }


}