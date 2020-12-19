<?php
/**
 * QQ 3044 55 977 智云科技
 * User:jiayongwei  www.zhiyunzhushou.com
 * Date: 2017/11/23
 * Time: 9:22
 */

namespace app\admin\controller;
use app\common\controller\Base as CommonBase;
use think\Db;

class Base extends CommonBase
{
    public $logininfo = [];
    public $loginuid = 0;
    public $menu_topids = [];//所有父菜单id
    public function _initialize()
    {
        parent::_initialize();
        $this->setMenu();

        $this->logininfo = session("user_auth");
        if($this->logininfo){
            $this->loginuid = $this->logininfo['uid'];
        }
        //检查权限
        $nocheck = ['admin/index/login', 'admin/index/logout', 'admin/index/verify'];

        if (!$this->loginuid && !in_array($this->url, $nocheck)) {
           return  $this->redirect('admin/index/login');
        }
        if($this->loginuid>0){
            $supergroup = config('super_admingroup');
            $usergroup = $this->getUserGroup($this->loginuid);
            if(in_array($supergroup, $usergroup)){ //超级管理员
                return;
            }
            if(!$this->checkRule($this->url)){
                return   $this->error('您没有权限操作!');
            }
        }
     }
    private function setMenu()
    {
        //顶部菜单
        $top_menu = $this->getSubList(0);
        $sub_menu = [];
        //查出此菜单id

        $cinfo = Db::name('menu')->where("url",$this->url)->where("pid",">",0)->find();
        if(!$cinfo){
            $cinfo = Db::name('menu')->where("url",$this->url)->where("pid","=",0)->find();
        }
        $this->menu_topids[] = $cinfo['id'];
        if($cinfo){
            $topmenuid = $this->getTopMenuId($cinfo['id']);
            $sub_menu = $this->getSubList($topmenuid);
          }
         foreach ($top_menu as &$val){
            $val['select'] = $this->getMenuStatus($val['id']);
         }
        $sub_gmenu = [];

        foreach ($sub_menu as &$val) {
            $val['select'] = $this->getMenuStatus($val['id']);
            $sub_gmenu[$val['group']][] = $val;
        }
        unset($sub_menu);
//var_dump($top_menu,$sub_gmenu);exit;
        $this->assign('top_menu', $top_menu);
        $this->assign('sub_menu', $sub_gmenu);
    }
    /*
     * 菜单id,当前url对应的菜单id
     * */
    private function getMenuStatus($id)
    {
        if(in_array($id,$this->menu_topids)){
            return 1;
        }
        return 0;

    }
    //获得菜单的顶级菜单id
    private function getTopMenuId($id)
    {
        $minfo = $this->getMenuInfo($id);
        if($minfo && $minfo['pid']>0){
            $this->menu_topids[] = $minfo['pid'];
           return   $this->getTopMenuId($minfo['pid']);
        }
         return $minfo['id'];
    }
    private function getMenuInfo($id)
    {
        $minfo=[];
        if(!$id)return $minfo;
         $minfo = Db::name('menu')->where('id',$id)->find();

         return $minfo;
    }

    private function getSubList($pid)
    {
        $result = [];
        $menuarr  = Db::name('menu')->where('hide',0)->where("pid", $pid)->order("sort asc")->select();
        foreach ($menuarr as $val){
             $result[$val['id']] = $val;
        }
        return $result;
    }



    final protected function checkRule($url) {
        static $Auth = null;
        if (!$Auth) {
            $Auth = new \com\Auth();
        }
        if (!$Auth->check($url, session('user_auth.uid'), 1, 'url')) {
            return false;
        }
        return true;
    }
    public function getUserGroup($uid)
    {
        $groupids = [];
        $list = Db::name('auth_group_access')->where('uid', $uid)->select();
        foreach ($list as $val){
            $groupids[] = $val['group_id'];
        }
        return $groupids;
    }

}