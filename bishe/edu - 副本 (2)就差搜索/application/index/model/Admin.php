<?php
namespace app\index\model;
use phpDocumentor\Reflection\Types\Null_;
use think\Model;
use traits\model\SoftDelete;

class Admin extends Model{
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

    //新增时自动填入的值 这里的字段一定不要出现在编辑或者添加的表单中，否则用户数据是无效的
    protected $insert=[
        'login_time'=>Null,//新增时登陆时间应为NULL，因为刚创建
        'login_count'=>0,//原因同上，
    ];

    //更新自动完成列表
    protected $update=[];
    //是否需要自动写入时间戳，如果为字符串 则表示时间字段类型
    protected $autoWriteTimestamp=true;//自动写入
    //创建时间字段
    protected $createTime='report_time';
    //更新时间字段
    protected $updateTime='update_time';
    //时间字段取出后的默认时间格式
    protected $dateFormat='Y年m月d日';

    //数据表中角色字段：role返回值处理
    public function getRoleAttr($value){
        $role=[
            0=>'管理员',
            1=>'超级管理员'
        ];
        return $role[$value];
    }

    //状态字段：status返回值处理
    public function getStatusAttr($value){
        $status=[
            0=>'已停用',
            1=>'已启用'
        ];
        return $status[$value];
    }

    //密码修改器
    public function setPasswordAttr($value){
        return md5($value);
    }

    public function getLoginTimeAttr($value){
        return date("Y-m-d H:i:s",$value);
    }

}