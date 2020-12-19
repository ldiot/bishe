<?php
/**
 * Created by PhpStorm.
 * User:jiayongwei
 * Date: 2018/2/25
 * Time: 16:01
 */

namespace app\api\controller;
use think\Db;
use app\logic\Auth;


class Server extends Base
{
    private $client_id = ''; //客户端id
    private $domain = ''; //客户端域名
    private $cur_version = '';//客户端当前版本
    private $timestamp = '';//当前时间
    private $sign = '';//签名
    private  $cltinfo = array();
    public $authlogic;

    public function _initialize()
    {
        parent::_initialize();
        $this->domain = input('d', '');//域名，传递过来的是md5的防止篡改
        $this->client_id = input('c', 0);//客户端id
        $this->cur_version = input('cv',''); //客户端当前版本号
        $this->timestamp = input('timestamp', 0);
        $this->sign = input('sign', '');
        $this->authlogic = new Auth();
        try{
            $this->authlogic->checkSign($this->client_id, $this->timestamp, $this->sign);
            //检查域名和ip是否授权
            $this->cltinfo = $this->authlogic->check($this->domain, $this->client_id, $this->cur_version);
        }catch (\Exception $e){
            $msg = $this->formatResult($e->getCode(),$e->getMessage());
            exit($msg);
        }

    }

    /*
     *
     * */
    public function index()
    {
        return 'working...';
    }
    /*
     * 获得版本
     * */
    public function getNewVersion()
    {
         try{

            $prdvinfo = Db::name('product_version')
                 ->where('product_id', $this->cltinfo['product_id'])
                 ->where('status',1)->field("vernum,upcontent")->order("up_sort desc")->find();
            if(!$prdvinfo){
                throw new \Exception('产品不存在', $prdvinfo);
            }
         }catch (\Exception $e){
            return $this->formatResult($e->getCode(),$e->getMessage());
        }

        $result = array(
            'version'=>$prdvinfo['vernum'],
            'upcontent'=>$prdvinfo['upcontent']
        );
        return $this->formatResult(1000,'',$result);

    }
    /*
     * 升级操作
     * */
    public function upgrade()
    {
        try{
             $nextverinfo = $this->authlogic->upgrade($this->domain,$this->client_id,$this->cur_version);

        }catch (\Exception $e){
            return $this->formatResult($e->getCode(),$e->getMessage());
        }

        return $this->formatResult(1000,'',$nextverinfo);
    }

    /*
     * 授权检查
     * */
    public function checkauth()
    {
        $auth = new Auth();
        try{
             $cltinfo = $auth->check($this->domain,$this->client_id,$this->cur_version);
        }catch (\Exception $e){
            return $this->formatResult($e->getCode(),$e->getMessage());
        }
        return $this->formatResult(1000,'',[]);
      }

    private function formatResult($errno=1000,$errmsg='',$data=[])
    {
        $result = array(
            'errno'=>$errno,
            'errmsg'=>$errmsg,
            'data'=>$data
        );
        return json_encode($result);
    }

}