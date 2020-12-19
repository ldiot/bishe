<?php
/**
 * Created by PhpStorm.
 * User:jiayongwei
 * Date: 2017/11/29
 * Time: 14:34
 */

namespace app\index\controller;
use think\Db;
use app\logic\Tool;

class Index extends Base
{
    public function ljj(){
        echo THINK_VERSION;
    }
     public function index()
    {

        return $this->fetch();
    }
   public function clientcheck()
   {
       $domain = input('domain', '','trim');
       $mobile = input('mobile','','trim');
       $auth_code = input('auth_code', '','trim');
       if(!$domain || !$mobile ||!$auth_code){
           return $this->error('请填写完整信息');
       }

       $cltinfo = Db::name('product_client')->where('auth_code', $auth_code)->find();
       if(!$cltinfo){
           return $this->error('授权信息不正确!'.$auth_code);
       }
       $domains = explode("\r\n",$cltinfo['domains']);

       if($cltinfo['mobile']!=$mobile || !in_array($domain, $domains)){
           return $this->error('授权信息不正确');
       }
       $result = array(
           'startdt'=>date("Y-m-d H:i:s", $cltinfo['startdt']),
           'enddt'=>date("Y-m-d H:i:s", $cltinfo['enddt']),
       );
       //跳转授权信息详情页
       return  $this->success('效验成功','',$result);

    }
    public function getHelp()
    {
        //header("Content-type: text/html; charset=utf-8");
       $html = file_get_contents(ROOT_PATH.'help.html');
 
        $jscode = Tool::html2js($html);
        return $jscode;
    }




}