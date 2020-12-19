<?php
/**
 * www.zhiyunzhushou.com
 * User: 304455977@qq.com
 * Date: 2017/11/14  QQ 3044 55 977 智云科技www . zhi yun zhushou.com
 * Time: 15:50
 */

namespace app\admin\controller;

use think\Db;

class Autoinfo extends Base
{

    /*
     *  www. zhiyunzhushou .com
     * */
     public function getUserlist()
    {
        $key = input('term', '');
        $id= input('id', '');
        if($id){
            $uinfo = Db::name('member')->where('uid', $id)->find();
            return $this->formatRow($uinfo['uid'],$uinfo['username']);
        }
        $ulist = Db::name('member')->where('username|mobile','like',"%$key%")->limit(10)->select();
        $result = [];
        foreach ($ulist as $val){
            $result[]=$this->formatRow($val['uid'],$val['username']);
        }
        return $result;
    }
}