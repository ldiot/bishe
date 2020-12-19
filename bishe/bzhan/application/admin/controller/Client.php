<?php
/**
 * zhiyunzhu shou .com 扣扣 3044 55977
 * User:jiayongwei
 * Date: 2018/2/22
 * Time: 13:38
 */

namespace app\admin\controller;
use think\Db;

class Client extends Base
{

    public function index()
    {
        $title = input('title','');
        $qq = input('qq', '');
        $mobile = input('mobile', '');
        $where = [];
        if($title){
            $where['pc.title'] = ['like', "%$title%"];
        }
        if($qq){
            $where['pc.qq'] = $qq;
        }
        if($mobile){
            $where['pc.mobile'] = $mobile;
        }

        $list = Db::name('product_client')->alias("pc")->join("product p","pc.product_id=p.id")
        ->where($where)->field("pc.*")
            ->order("id desc")->paginate(15);
        $data = array(
            'list'=>$list,
            'page'=>$list->render()
        );

        $this->setMeta('授权列表');
        $this->assign($data);
        return $this->fetch();
     }
     /*
      * /**
 * zhiyunzhu shou .com 扣扣 30 44 55977
 * User:jiayongwei
      * */
     public function add()
     {
         $id = input('id', 0);
          $data = input('param.');
           $cltmod = model('Client');
         if (IS_POST) {
             if(!$id)$data['create_time'] = time();
             if(!$data['auth_code']){//自动生成授权码
                 $data['auth_code'] = rand_string(10);
             }
             $data['startdt'] = strtotime($data['startdt']);
             $data['enddt'] = strtotime($data['enddt']);
              $cltmod->autosave('product_client',$data);
             return $this->success("保存成功！", '','parent_reload');
         } else {
             $info=[];
             if($id>0) {
                 $info = Db::name('product_client')->where('id', $id)->find();
             }else{
                 $info['startdt'] = time();
                 $info['enddt'] = strtotime("+30days");
             }
             $keylist = $cltmod->addfield;
             $prdlist = Db::name('product')->order("id desc")->select();
             foreach ($prdlist as $val){
                 $keylist['product_id']['option'][$val['id']] = $val['title'];
             }
             $data             = array(
                 'info'    => $info,
                 'keyList' => $keylist
             );
             $this->assign($data);
             $this->setMeta("添加/编辑授权");
             return $this->fetch('public/popedit');
         }
     }

     public function delete($id)
    {
        Db::name('product_client')->where('id', $id)->delete();
        return $this->success('删除成功');
    }
    /*
     * 盗版列表
      * */
    public function noauthlist()
    {
         $product_id = input('product_id', 0);
         $where = [];
         if($product_id>0){
             $where['pca.product_id'] = $product_id;
         }
         $cltmod = model("Client");

         $list = Db::name('product_client_noauth')->alias('pca')
             ->join("product p","pca.product_id=p.id",'left')
             ->field("pca.*,p.title as product_title")
             ->where($where)->order("pca.id desc")->paginate(15);
         $searchbar = $cltmod->searchbar_noauth;
        $prdlist = Db::name('product')->order("id desc")->select();
        foreach ($prdlist as $val){
            $searchbar['product_id']['option'][$val['id']] = $val['title'];
        }
         $data = array(
             'list'=>$list,
             'page'=>$list->render(),
             'searchbar'=>$searchbar
         );

         $this->setMeta('盗版列表');
         $this->assign($data);
         return $this->fetch();
    }
    public function delnoauth($id)
    {
        Db::name('product_client_noauth')->where('id', $id)->delete();
        return $this->success('删除成功');
    }
    /*
     * 升级日志
     * */
    public function uplog()
    {
        $product_id = input('product_id', 0);
        $where = [];
        if($product_id>0){
           $where['product_id'] = $product_id;
        }
        $cltmod = model("Client");
        $list = Db::name('product_client_uplog')->where($where)->order("create_time desc")->paginate(15);
        $searchbar = $cltmod->searchbar_uplog;
        $prdlist = Db::name('product')->order("id desc")->select();
        foreach ($prdlist as $val){
            $searchbar['product_id']['option'][$val['id']] = $val['title'];
        }
        $data = array(
            'list'=>$list,
            'page'=>$list->render(),
            'searchbar'=>$searchbar
        );
        $this->setMeta('升级日志');
        $this->assign($data);
        return $this->fetch();
    }
    public function code()
    {
        $this->setMeta('集成代码包');
        return $this->fetch();
    }



}