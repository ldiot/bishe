<?php
namespace app\index\model;

use think\Model;
use traits\model\SoftDelete;

class Student extends Model{
    use SoftDelete;
    protected $dateFormat='Y/m/d';
    protected $deleteTime='delete_time';
    protected $autoWriteTimestamp=true;
    protected $createTime='create_time';
    protected $updateTime='update_time';
    protected $type=[
        'start_time'=>'timestamp',
    ];

    public function getSexAttr($value){
        $sex=[
            0=>'女',
            1=>'男'
        ];
        return $sex[$value];
    }

    //定义grade表与学生表student的一对多关联
    public function grade(){
        return $this->belongsTo('grade');
    }
}