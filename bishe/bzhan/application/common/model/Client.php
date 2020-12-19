<?php
/**
 * Created by PhpStorm.
 * User:jiayongwei
 * Date: 2018/2/22
 * Time: 15:26
 */

namespace app\common\model;


class Client extends Base
{

    public $addfield = array(
        array('name'=>'id', 'title'=>'ID', 'type'=>'hidden', 'help'=>'', 'option'=>''),
        'product_id'=>array('name'=>'product_id', 'title'=>'商品ID', 'type'=>'select', 'help'=>'', 'option'=>array()),
        array('name'=>'title', 'title'=>'客户名', 'type'=>'text', 'help'=>'', 'option'=>''),
        array('name'=>'qq', 'title'=>'QQ', 'type'=>'text', 'help'=>'', 'option'=>''),
        array('name'=>'mobile', 'title'=>'手机号', 'type'=>'text', 'help'=>'', 'option'=>''),
        array('name'=>'address', 'title'=>'地址', 'type'=>'text', 'help'=>'', 'option'=>''),
        array('name'=>'remark', 'title'=>'备注', 'type'=>'text', 'help'=>'', 'option'=>''),
        array('name'=>'auth_code', 'title'=>'授权码', 'type'=>'text', 'help'=>'不填写自动生成', 'option'=>''),
        array('name'=>'ips', 'title'=>'授权IP列表', 'type'=>'textarea', 'help'=>'一行一个,不填写则不限制', 'option'=>''),
        array('name'=>'domains', 'title'=>'授权域名', 'type'=>'textarea', 'help'=>'一行一个,例如www.zhiyunzhushou.com', 'option'=>''),
        array('name'=>'startdt', 'title'=>'起始时间', 'type'=>'datetime', 'help'=>'授权起始时间', 'option'=>''),
        array('name'=>'enddt', 'title'=>'结束时间', 'type'=>'datetime', 'help'=>'授权结束时间', 'option'=>''),
       'status'=> array('name'=>'status', 'title'=>'状态', 'type'=>'select', 'help'=>'', 'option'=>array(0=>'不可用',1=>'可用')),
     );
    public $searchbar_noauth = array(
        'product_id'=>array('name'=>'product_id', 'title'=>'产品列表', 'type'=>'select', 'help'=>'', 'option'=>array(0=>'全部')),
    );
    public $searchbar_uplog = array(
        'product_id'=>array('name'=>'product_id', 'title'=>'产品列表', 'type'=>'select', 'help'=>'', 'option'=>array(0=>'全部')),
    );

}