<?php
namespace app\index\model;
use phpDocumentor\Reflection\Types\Null_;
use think\Model;
use traits\model\SoftDelete;

class House extends Model{
    //导入软删除方法集
    use SoftDelete;
    //设置软删除字段
    //只有该字段为NULL，该字段才会显示出来
    protected $deleteTime='delete_time';

    //保存自动完成列表 这里的字段一定不要出现在编辑或者添加的表单中，否则用户数据是无效的
    protected $auto=[
        'delete_time'=>Null,
        'is_delete'=>1,//1：允许删除，0：禁止删除
    ];


    //更新自动完成列表
    protected $update=[];
//    //是否需要自动写入时间戳，如果为字符串 则表示时间字段类型
//    protected $autoWriteTimestamp=true;//自动写入
//    //创建时间字段
//    protected $createTime='create_time';
//    //更新时间字段
//    protected $updateTime='update_time';
    //时间字段取出后的默认时间格式
    protected $dateFormat='Y/m/d';
//    public function getTypeAttr($value){
//        $type=[
//            '1'=>'地上停车位',
//            '0'=>'地下停车位'
//        ];
//        return $type[$value];
//    }
    public function getCheckInTimeAttr($value){
        return date("Y-m-d H:i:s",$value);
    }
    public function setCheckInTimeAttr($value){
        return strtotime($value);
    }
    public function resident(){
        return $this->belongsTo('Resident');
    }
}