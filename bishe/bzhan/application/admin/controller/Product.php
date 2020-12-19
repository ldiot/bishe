<?php
/**
 * Created by PhpStorm.
 * User:jiayongwei
 * Date: 2018/2/22
 * Time: 9:25
 */

namespace app\admin\controller;
use think\Db;

class Product extends Base
{
    public function index()
    {
         $list = Db::name('product')->order("id desc")->paginate(15);
         $data = array(
             'list'=>$list,
             'page'=>$list->render()
         );

         $this->assign($data);
         $this->setMeta('产品列表');
         return $this->fetch();
    }
    public function add()
    {
        $id = input('id', 0);
        $prd = model('product');
        $data = input('param.');
        if (IS_POST) {
            if(!$data['title']) return $this->error('请填写产品名');
            if(!$id)$data['create_time'] = time();
            $prd->autosave('product',$data);
            return $this->success("保存成功！", '','parent_reload');
        } else {
            $info=[];
            if($id>0) $info = $prd->where('id', $id)->find();
            $data             = array(
                'info'    => $info,
                'keyList' => $prd->addfield,
            );
            $this->assign($data);
            $this->setMeta("添加/编辑产品");
            return $this->fetch('public/popedit');
        }

    }
    public function editable($name = null, $value = null, $pk = null) {
        if ($name && ($value != null || $value != '') && $pk) {
            Db::name('product')->where(array('id' => $pk))->setField($name, $value);
        }
    }
    public function delete($id=0)
    {
        Db::name('product')->where('id', $id)->delete();
        return $this->success('删除成功');
    }
    /*
     * 版本列表
     * */
    public function verlist()
    {
        $title = input('title', '');
        $where = [];
        if($title){
            $where['p.title'] =['like', "%$title%"];
        }
        $mod = model('product');
        $searchbar = $mod->searchbar_ver;
        $list = Db::name('product_version')->alias('pv')
            ->join("product p","pv.product_id=p.id",'left')
            ->where($where)->field("pv.*,p.title")->order('pv.up_sort desc')->paginate(15);
        $data = array(
            'list'=>$list,
            'page'=>$list->render(),
            'searchbar'=>$searchbar
        );

        $this->setMeta('产品版本列表');
        $this->assign($data);
        return $this->fetch();
    }
    public function addver()
    {
        $id = input('id', 0);
        $prd = model('product');
        $data = input('param.');
        if (IS_POST) {
            if(!$data['vernum'] || !$data['upzipname'])return $this->error('请填写版本号和更新包路径');
            if(!$id)$data['create_time'] = time();
             $prd->autosave('product_version',$data);
            return $this->success("保存成功！", '','parent_reload');
        } else {
            $info=[];
            if($id>0) $info = Db::name('product_version')->where('id', $id)->find();
            $keylist = $prd->verfield;
            $prdlist = Db::name('product')->order("id desc")->select();
            foreach ($prdlist as $val){
                $keylist['product_id']['option'][$val['id']] = $val['title'];
            }

            $data             = array(
                'info'    => $info,
                'keyList' => $keylist
            );
            $this->assign($data);
            $this->setMeta("添加/编辑产品版本");
            return $this->fetch('public/popedit');
        }

    }
    public function editvable($name = null, $value = null, $pk = null) {
        if ($name && ($value != null || $value != '') && $pk) {
            Db::name('product_version')->where(array('id' => $pk))->setField($name, $value);
        }
    }
    public function deletever($id)
    {
       Db::name('product_version')->where('id', $id)->delete();
       return $this->success('删除成功');
    }

}