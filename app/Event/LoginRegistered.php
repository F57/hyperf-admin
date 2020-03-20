<?php
namespace App\Event;

/**
 * 定义log事件
 * Class LogRegistered
 * @package App\Event
 */
class LoginRegistered
{
    public $arr;

    public function __construct($arr)
    {
        $this->arr = $arr;
    }
}