<?php
namespace app\index\controller;
use app\index\model\Parking as ParkingModel;
use app\index\model\Resident as ResidentModel;
use think\Console;
use think\Controller;
use think\Request;
use think\Session;

class Base extends Controller
{
    protected  function _initialize()
    {
        parent::_initialize(); // 继承父类初始化操作
        define('USER_ID',Session::get('user_id'));
    }
    //判断用户是否登录，放在后台的入口：index/index/
    protected function isLogin(){
//        if(!defined('USER_ID')){//defined
        if(USER_ID==''){//defined
        $this->error('用户未登录，无权访问',url('user/login'));
        }
    }

    //防止用户重复登录 user/login
    protected function alreadLogin(){
//        if(defined('USER_ID')){//defined
        if(USER_ID!=null){//defined
            $this->error('用户已经登录，请勿重复登录',url('index/index'));
        }
    }


}