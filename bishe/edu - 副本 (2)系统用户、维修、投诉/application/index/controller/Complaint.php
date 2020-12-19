<?php
namespace app\index\controller;
use app\index\controller\Base;
use think\console\command\make\Model;
use think\Exception;
use think\Request;
use app\index\model\Complaint as ComplaintModel;
use think\Session;
use think\Db;
class Complaint extends Base
{

    public function addComplaint(Request $request){
        $data=$request->param();
        $status=1;
        $message='添加成功';

        $rule=[
            'content|投诉内容'=>"require",
            'report_time|投诉日期'=>"require",
            'report_name|投诉人姓名'=>"require",
            'report_tel|投诉人电话'=>"require",
            'status|处理状态'=>"require",
            'house_id|房屋编号'=>"require",
        ];

        $result=$this->validate($data,$rule);
        if($result=='true'){
            $data1=[];
            foreach ($data as $key=>$value){
                if($value!=""){
                    $data1[$key]=$value;
                }
            }
            $user=ComplaintModel::create($data1);
            if($user===null){
                $status=0;
                $message='添加失败~~';
            }
        }else{
            $message=$result;
        }
        return ['status'=>$status,'message'=>$message];
    }

    public function complaintAdd(){
        $this->view->assign('title','添加投诉');
        return $this->fetch('complaint_add');
    }

    public function unDeal(){
        $this->view->assign('title','未解决列表');
        $where=function ($query){
            $query->find()->where('status','<','2');
        };
        $list=ComplaintModel::all($where);//admin用户可以查看所有记录，数据要经过模型获取器处理
        $this->view->count=count($list);
        $this->view->assign('list',$list);
        return $this->fetch('complaint_undeal');
    }
    public function complaintEdit(Request $request){
        $user_id=$request->param('id');
        $result=ComplaintModel::get($user_id);
        $this->view->assign('title','编辑投诉信息');
        $this->view->assign('user_info',$result->getData());
        return $this->view->fetch('complaint_edit');
    }
    public function editComplaint(Request $request){
        $param=$request->param();
        //去掉表单中为空的数据，即没有修改的内容
        foreach ($param as $key=>$value){
            if(!empty($value)||$value==0){
                $data[$key]=$value;
            }
        }

        $condition=['id'=>$data['id']];
        $result=ComplaintModel::update($data,$condition)?true:false;
        if($result===true){
            return ['status'=>1,'message'=>'更新成功'];
        }else{
            return ['status'=>0,'message'=>'更新失败，请检查'];
        }
    }
    public function deleteComplaint(Request $request){
        $user_id=$request->param('id');
        ComplaintModel::update(['is_delete'=>1],['id'=>$user_id]);
        ComplaintModel::destroy($user_id);
    }

    public function test(){
        $this->view->assign('title','已解决列表');
        $list=ComplaintModel::all(['status'=>'2']);//admin用户可以查看所有记录，数据要经过模型获取器处理
        $this->view->count=count($list);
        $this->view->assign('list',$list);
        return $this->fetch('complaint_deal');
    }
    public function Deal(){
        $this->view->assign('title','已解决列表');
        $list=ComplaintModel::all(['status'=>'2']);//admin用户可以查看所有记录，数据要经过模型获取器处理
        $this->view->count=count($list);
        $this->view->assign('list',$list);
        return $this->fetch('complaint_deal');
    }

    public function unDelete(){
        //['delete_time'=>null]是将其设为null,['is_delete'=>1]条件是1
//        AdminModel::update(['delete_time'=>NULL],['is_delete'=>1]);//无用
        //tp5恢复软删除目前已知的只有一种方法，写原生sql语句。
        $sql = ' update complaint set delete_time = NULL where is_delete=1' ;//delete_time是数据库中自定义的删除标识字段。
        Db::execute($sql);
    }
}