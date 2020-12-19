<?php
namespace com;
use think\Log;
/**
 * 智云科技www.zhiyunzhushou.com
 * User:jiayongwei
 * Date: 2018/2/26
 * Time: 11:53
 */


/*
 * 智云客户端功能类
 * */
class ZYClient
{
    public $authdomain = ''; //授权中心域名，例如www.zhiyunzhushou.com
    public $authcode = ''; //授权码
    public $client_id = '';//分配的客户端id
    public $zipdir = '';//下载包缓存目录 需要可写 绝对路径  例如 /down/upzip/
    public $nowversion = '';//当前版本号
    public function __construct($authdomain,$client_id, $authcode,$version,$zipdir)
    {
        $this->setConfig($authdomain,$client_id, $authcode,$version, $zipdir);
    }

    public function setConfig($authdomain,$client_id, $authcode,$version,  $zipdir)
    {
        $this->authdomain = 'http://'.$authdomain."/api/server/";
        $this->client_id = $client_id;
        $this->authcode = $authcode;
        $this->nowversion = $version;
        $this->zipdir = $zipdir;


    }
    public function setVersion($version)
    {
        $this->nowversion = $version;
    }

    /*
       * 获得版本信息
       * $product_id 在智云后台产品列表中的产品id
       * */
    public function getNewVersion()
    {
        $url = $this->authdomain.'getNewVersion';
        $result = $this->http_request($url);
        return $result;
    }
    /*
     * 下载下一个版本的更新包
     * */
    public function downUpgradePackage()
    {
        $url = $this->authdomain.'upgrade';
        $result = $this->http_request($url);
         //下载更新包
        if($result['errno']==1000){ //成功
           $result['data']['upzipname'] = $zippath =$this->downFile($result['data']['upzipname'],$this->zipdir);
           if(!$zippath){
               $result = array(
                       'errno'=>9001,
                        'errmsg'=>'下载包失败，请重试',
                        'data'=>array()
               );
               return $result;
           }
         }
        return $result;
    }

    /*
     * 授权检查
     * */
    public function checkAuth()
    {
        $url = $this->authdomain."checkauth";
        $result = $this->http_request($url);
        if($result['errno']==1000){
            return true;
        }
        return false;
    }


    public function http_request( $url, $post = array(), $timeout = 15 ){
        $post['d'] = $_SERVER['HTTP_HOST'];
        $post['c'] = $this->client_id;
        $post['cv'] = $this->nowversion;
        $post['timestamp'] = time();
        $post['sign'] = $this->getSign($post);
        if( empty( $url ) ){
            $result = array(
                'errno'=>9999,
                'errmsg'=>'错误!授权服务器地址为空！',
                'data'=>array()
            );
            return $result;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);

        if($post){
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
         }
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        $result = curl_exec($ch);
        Log::write('服务端返回数据：'.$url);
        Log::write($result);
        $errno =curl_errno($ch);
        $errmsg = '';
        if($errno){
            $errmsg = curl_error($ch);
        }
        curl_close($ch);
        if($errno){
            $result = array(
                'errno'=>9998,
                'errmsg'=>$errmsg,
                'data'=>[]
            );
            $result = json_encode($result);
        }
        return json_decode($result,true);
    }
    public function downFile($weburl, $savedir,$focuswrite =false) {
        if (trim($weburl) == '') {
            return false;
        }
        $lastchar = substr($savedir,-1);
        if($lastchar !='/'){
            $savedir .= '/';
        }

        if(!file_exists($savedir)){
            mkdir($savedir, 0777, true);
        }
        $fname = basename($weburl);
        $savepath = $savedir.$fname;
        if(!$focuswrite && file_exists($savepath)){ //若文件存在不需要强制重下
            return $savepath;
        }
        // curl下载文件
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $weburl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $data = curl_exec($ch);
        curl_close($ch);

        // 保存文件到制定路径
        file_put_contents($savepath, $data);
        return $savepath;

    }
    private function getSign($data)
    {
         $signparam = array(
             $data['c'],
             $data['timestamp'],
             $this->authcode
         );
         $sign = md5(implode(',',$signparam));
         return $sign;
     }
}