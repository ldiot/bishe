<?php

namespace app\index\model;

use think\Model;

class Staff extends Model
{
    // 保存自动完成列表
    protected $auto = [

    ];
    // 新增自动完成列表
    protected $insert = [
        'dept',
//        'sex'=>1,
        'hiredate'=>'2017-01-01'];
    // 更新自动完成列表
    protected $update = [
        'dept'=>'培训部'
    ];
    protected  $type=[
        'hiredate'=>'timestamp'
    ];

    // 是否需要自动写入时间戳 如果设置为字符串 则表示时间字段的类型
    protected $autoWriteTimestamp=true;
    // 创建时间字段
    protected $createTime = 'create_time';
    // 更新时间字段
    protected $updateTime = 'update_time';

    protected function setDeptAttr($dept,$data){
        if($data['sex']==1){
            return $this->dept='开发部';
        }else{
            return $this->dept='客服部';
        }
    }

//    protected $type=[
//        'name'=>'serialize',
//        'salary'=>'double',
//        'hiredate'=>'timestamp:Y/m/d'
//    ];

//    protected function setHireDateAttr($hiredate){
//        return strtotime($hiredate);
//    }
//
//    protected function getHireDateAttr($hiredate){
//        return date("Y-m-d",time());
////        return date('Y-m-d',$hiredate);
//    }
}
