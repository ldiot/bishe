<?php
/**
 * Created by PhpStorm.
 * User:jiayongwei
 * Date: 2018/2/22
 * Time: 9:41
 */

namespace app\common\model;


class Product extends Base
{
    public $addfield = array(
        array('name'=>'id', 'title'=>'ID', 'type'=>'hidden', 'help'=>'', 'option'=>''),
        array('name'=>'title', 'title'=>'标题', 'type'=>'text', 'help'=>'', 'option'=>''),
        array('name'=>'description', 'title'=>'描述', 'type'=>'textarea', 'help'=>'', 'option'=>''),
     );
    //id,product_id,vernum(版本号),upzipname(包路径名),upcontent(对外提示的更新内容),up_sort(更新排序),status

    public $verfield = array(
        array('name'=>'id', 'title'=>'ID', 'type'=>'hidden', 'help'=>'', 'option'=>''),
        'product_id'=>array('name'=>'product_id','title'=>'产品','type'=>'select','help'=>'产品名称','option'=>array()),
        array('name'=>'vernum', 'title'=>'版本号', 'type'=>'text', 'help'=>'例如v1.2.3', 'option'=>''),
        array('name'=>'upzipname', 'title'=>'压缩包路径', 'type'=>'text', 'help'=>'带域名的全路径，可为其他网址例如http://xx.com/x/1.2.zip)',
            'option'=>''),
        array('name'=>'upcontent', 'title'=>'更新说明', 'type'=>'textarea', 'help'=>'将会显示在客户端', 'option'=>''),
        array('name'=>'up_sort', 'title'=>'升级顺序', 'type'=>'text', 'help'=>'客户端会根据此数值从小到大更新压缩包，务必认真填写!', 'option'=>''),
        array('name'=>'status', 'title'=>'状态', 'type'=>'select', 'help'=>'是否开启更新', 'option'=>array(0=>'关闭',1=>'开启')),
    );
    public $searchbar_ver = array(
        array('name'=>'title', 'title'=>'产品名', 'type'=>'text', 'help'=>'', 'option'=>''),
    );

}