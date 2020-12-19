<?php
namespace app\index\controller;
use app\index\controller\Base;
use think\console\command\make\Model;
use think\Exception;
use think\Request;
use app\index\model\Repair as RepairModel;
use think\Session;
use think\Db;
class Repair extends Base
{
    public function test(){
        echo strtotime("2020-04-21T22:57");
//        strtotime('');
//        $data=[
//            "house_id"=>"123456",
//            "content"=>"抽油烟机坏了",
//            "place"=>"花园",
//            "report_name"=>"李月",
//            "report_tel"=>"12345678965",
//            "status"=>"2",
//            "repairman_name"=>"小李",
//            "repairman_tel"=>"3456567",
//            "finish_time"=>"2020-04-21T22:57",
//            "remark"=>"哈哈哈"
//        ];
//        RepairModel::create($data);
    }
    public function search(Request $request){
    $house_id=$request->param('house_id');
    $report_name=$request->param('report_name');
    $status=$request->param('status');
    if($status==2){
        $condition['status']=['=','2'];
    }elseif($status==1){
        $condition['status']=['<','2'];
    }
    if($house_id!=""&&$report_name!=""){
        $condition['house_id']=['=',$house_id];
        $condition['report_name']=['=',$report_name];
        $list=RepairModel::where($condition);
    }elseif($house_id!=""){
        $condition['house_id']=['=',$house_id];
        $list=RepairModel::where($condition);
    }else{
        $condition['report_name']=['=',$report_name];
        $list=RepairModel::where($condition);
    }
    $list=$list->paginate(1,false,[
        'type'=>'BootstrapDetailed'
    ]);
    $this->view->count=count($list);
    $this->view->assign('title','查询结果');
    $this->view->assign('list',$list);
    $this->view->assign('status',1);
    //渲染管理员列表模板
     if($status==2){
         return $this->fetch('repair_deal');
     }elseif($status==1){
         return $this->fetch('repair_undeal');
    }
}

    public function repairAdd(){
        $this->view->assign('title','添加维修');
        return $this->fetch('repair_add');
    }
    public function addRepair(Request $request){
        $data=$request->param();
        $status=1;
        $message='添加成功';

        $rule=[
            'house_id|房屋编号'=>"require",
            'content|报修内容'=>"require",
            'place|报修地点'=>"require",
            'report_name|报修人姓名'=>"require",
            'report_tel|报修人电话'=>"require",
            'status|维修状态'=>"require",
        ];

        $result=$this->validate($data,$rule);
        if($result=='true'){
            $data1=[];
            foreach ($data as $key=>$value){
                if($value!=""){
                    $data1[$key]=$value;
                }
            }
            $user=RepairModel::create($data1);
            if($user===null){
                $status=0;
                $message='添加失败~~';
            }
        }else{
            $message=$result;
        }
        return ['status'=>$status,'message'=>$message];
    }
    public function unDeal(){
        $this->view->assign('title','未完成列表');
        $list=RepairModel::where('status','<','2')->paginate(1,false,[
            'type'=>'BootstrapDetailed'
        ]);//admin用户可以查看所有记录，数据要经过模型获取器处理
        $this->view->count=count($list);
        $this->view->assign('list',$list);
        return $this->fetch('repair_undeal');
    }
    public function repairEdit(Request $request){
        $user_id=$request->param('id');
        $result=RepairModel::get($user_id);
        $this->view->assign('title','编辑维修信息');
        $this->view->assign('user_info',$result->getData());
        return $this->view->fetch('repair_edit');
    }
    public function editRepair(Request $request){
        $param=$request->param();
        //去掉表单中为空的数据，即没有修改的内容
        foreach ($param as $key=>$value){
            if(!empty($value)||$value==0){
                $data[$key]=$value;
            }
        }

        $condition=['id'=>$data['id']];
        $result=RepairModel::update($data,$condition)?true:false;
        if($result===true){
            return ['status'=>1,'message'=>'更新成功'];
        }else{
            return ['status'=>0,'message'=>'更新失败，请检查'];
        }
    }
    public function deleteRepair(Request $request){
        $user_id=$request->param('id');
        RepairModel::update(['is_delete'=>1],['id'=>$user_id]);
        RepairModel::destroy($user_id);
    }

    public function Deal(){
        $this->view->assign('title','已完成列表');
        $list=RepairModel::where('status','=','2')->paginate(1,false,[
            'type'=>'BootstrapDetailed'
        ]);//admin用户可以查看所有记录，数据要经过模型获取器处理
        $this->view->count=count($list);
        $this->view->assign('list',$list);
        return $this->fetch('repair_deal');
    }

    public function unDelete(){
        //['delete_time'=>null]是将其设为null,['is_delete'=>1]条件是1
//        AdminModel::update(['delete_time'=>NULL],['is_delete'=>1]);//无用
        //tp5恢复软删除目前已知的只有一种方法，写原生sql语句。
        $sql = ' update repair set delete_time = NULL where is_delete=1' ;//delete_time是数据库中自定义的删除标识字段。
        Db::execute($sql);
    }
}