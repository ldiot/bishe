<?php
/**
 * www. zhiyunzhuoshou .com
 * User:jiayongwei
 * Date: 2018/2/26
 * Time: 9:09
 */

namespace app\logic;
use think\Db;

class Auth
{
     /*
      * 升级
      * */
    public function upgrade($domain, $client_id, $cur_version)
    {
        //检查授权
       $cltinfo = $this->check($domain, $client_id, $cur_version);
        //查询下一个版本包
        $where['product_id'] = $cltinfo['product_id'];
        $where['vernum'] = $cur_version;
       $cur_verinfo = Db::name('product_version')->where($where)->find();
       //升级日志
        $inarr = array(
            'product_id'=>$cltinfo['product_id'],
            'client_id'=>$client_id,
            'domain'=>$domain,
            'source_version'=>$cur_version,

            'create_time'=>time(),
        );
        $remark = '';
       if(!$cur_verinfo){
           $remark = '升级失败！当前版本号未找到';
           throw new \Exception($remark,3001);
       }
       //找到下一个版本号
        $next_verinfo = Db::name('product_version')
            ->where('product_id', $cltinfo['product_id'])
            ->where('up_sort','>',$cur_verinfo['up_sort'])
            ->order("up_sort asc")->find();
        $inarr['to_version'] = $next_verinfo['vernum'];
        if(!$next_verinfo){
            $remark = '已是最新版本';
            throw new \Exception($remark, 3002);
        }
        if(!$remark)  $remark = '升级成功';
        $inarr['remark'] = $remark;
        //写入升级日志
        Db::name('product_client_uplog')->insertGetId($inarr);


        return $next_verinfo;
    }


    /*
     * 授权检查
     * $domain
     * */
   public function check($domain, $client_id, $cur_version)
   {
        $ip = get_client_ip();//获得请求ip
       if(!$domain || !$client_id ||!$cur_version){
           throw new \Exception('非法请求',1001);
       }
        $noauth = array(
           'product_id'=>0,
           'create_time'=>time(),
           'ip'=>$ip,
           'domain'=>$domain
       );
       $remark = '';
       $cltinfo = Db::name('product_client')
           ->where('id', $client_id)
           ->where('status',1)->find();
       $now = time();
       if(!$cltinfo){
           $remark = '盗版：客户端不存在';
            throw new \Exception($remark,1002);
       }
       $noauth['product_id'] = $cltinfo['product_id'];
       if($now<$cltinfo['startdt'] || $now>$cltinfo['enddt']){
           $remark = '盗版：授权已过期！';

            throw new \Exception($remark,1003);
        }
        //检查域名和ip
       if($cltinfo['ips']){
           $iplist = explode("\r\n",$cltinfo['ips']);
           foreach ($iplist as $key=>$value){
               $iplist[$key] = trim($value);
           }
           if(!in_array($ip,$iplist)){
               $remark = '盗版:IP未授权！';
               throw new \Exception($remark, 2001);
           }
       }
       if($cltinfo['domains']){
           $domainlist = explode("\r\n",$cltinfo['domains']);
           foreach ($domainlist as $key=>$value){
               $domainlist[$key] = trim($value);
           }
           if(!in_array($domain,$domainlist)){
               $remark = '盗版：域名未授权';
               throw new \Exception($remark,2002);
           }
       }
       $noauth['remark'] = $remark;
       if($remark){ // 发现盗版
          $ishave = Db::name('product_client_noauth')->where('domain',$domain)->find();
          if(!$ishave){
              Db::name('product_client_noauth')->insertGetId($noauth);
          }

       }
       //更新最新版本信息到数据库
       Db::name('product_client')->where('id',$client_id)->setField('cur_version',$cur_version);
       return $cltinfo;
   }
    /*
  * 用授权的authcode来验证client_id是否被改
  * */
    public  function checkSign($client_id, $timestamp, $sign)
    {
        if(!$client_id || !$timestamp || !$sign){
            throw new \Exception('盗版：非法请求',1001);
        }

        $cltinfo = Db::name('product_client')
            ->where('id', $client_id)
            ->where('status',1)->find();
        if(!$cltinfo){
            throw new \Exception('盗版：客户端不存在',1002);
        }
        $realsign = md5($client_id.",".$timestamp.",".$cltinfo['auth_code']);
        if($sign != $realsign){
            throw new \Exception('盗版：签名错误',5001);
        }

        return true;
    }
}