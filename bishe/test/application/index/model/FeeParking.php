<?php
namespace app\index\model;
use phpDocumentor\Reflection\Types\Null_;
use think\Model;
use traits\model\SoftDelete;

class FeeParking extends Model{
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
    //是否需要自动写入时间戳，如果为字符串 则表示时间字段类型
    protected $autoWriteTimestamp=true;//自动写入
    //创建时间字段
    protected $createTime='create_time';
    //更新时间字段
    protected $updateTime='update_time';
    //时间字段取出后的默认时间格式
    protected $dateFormat='Y/m/d';


    //状态字段：status返回值处理
    public function getStatusAttr($value){
        $status=[
            0=>'未收取',
            1=>'已收取'
        ];
        return $status[$value];
    }

    public function setStartTimeAttr($value){
        return strtotime($value);
    }

    public function getStartTimeAttr($value){
        return date("Y-m-d",$value);
    }

    public function setPayTimeAttr($value){
        return strtotime($value);
    }

    public function getPayTimeAttr($value){
        return date("Y-m-d",$value);
    }

    public function parking(){
        return $this->belongsTo('Parking');
    }
    public function getTypeAttr($value){
        $type=[
            '1'=>'地上停车位',
            '0'=>'地下停车位'
        ];
        return $type[$value];
    }
}