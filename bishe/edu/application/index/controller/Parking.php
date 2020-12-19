<?php
namespace app\index\controller;
use app\index\controller\Base;
use think\console\command\make\Model;
use think\Exception;
use think\Request;
use app\index\model\Parking as ParkingModel;
use think\Session;
use think\Db;
class Parking extends Base
{
    public function test(){
//        $data=[
//            'name'=>'兴业',
//            'type'=>'0',
//            'floor_num'=>'4',
//            'unit_num'=>'4',
//            'house_num'=>'3',
//            'store_num'=>'3',
//            'floor_height'=>'3.21',
//            'construction_area'=>'251.15',
//            'usage_area'=>'130.44',
//            'start_time'=>'2020-04-15',
//            'finish_time'=>'2020-04-23',
//            'service_life'=>'300',
//            'remark'=>'aaaaa',
//        ];
//        ParkingModel::create($data);

//        $data=[
//            'name'=>"李姣姣",
//            'sex'=>'女',
//            'age'=>'22',
//            'tel'=>'13658274122',
//            'idcard_number'=>'2345678909876437653',
//            'job'=>'法发发',
//            'address'=>'啊啊啊啊',
//            'remark'=>'广泛的但是'
//        ];
//        ParkingModel::create($data);
    }

    public function search(Request $request){
        $this->isLogin();//判断用户是否登录

        $id=$request->param('id');
        $parking_lot=$request->param('parking_lot');
        $status=$request->param('status');
        if($status==1){
            $condition['status']=['=','1'];
        }elseif($status==0){
            $condition['status']=['=','0'];
        }

        if($id!=""&&$parking_lot!=""){
            $condition['id']=['=',$id];
            $condition['parking_lot']=['=',$parking_lot];
            $list=ParkingModel::where($condition);
        }elseif($id!=""){
            $condition['id']=['=',$id];
            $list=ParkingModel::where($condition);
        }else{
            $condition['parking_lot']=['=',$parking_lot];
            $list=ParkingModel::where($condition);
        }
        $list=$list->paginate(20,false,[
            'type'=>'BootstrapDetailed'
        ]);
        $this->view->count=count($list);
        $this->view->assign('title','查询结果');
        $this->view->assign('list',$list);
        //渲染管理员列表模板
        if($status==1){
            $this->view->assign('status',1);
        }elseif($status==0){
            $this->view->assign('status',0);
        }
        return $this->fetch('parking_list');
    }

    public function issell(){
        $this->isLogin();//判断用户是否登录

        $this->view->assign('title','已租出停车位列表');

        $list=ParkingModel::where('status','=','1')->paginate(20,false,[
            'type'=>'BootstrapDetailed'
        ]);

        $this->view->count=count($list);

        $this->view->assign('list',$list);
        $this->view->assign('status',1);
        //渲染管理员列表模板
        return $this->fetch('parking_list');
    }

    public function unsell(){
        $this->isLogin();//判断用户是否登录

        $this->view->assign('title','未租出停车位列表');

        $list=ParkingModel::where('status','=','0')->paginate(20,false,[
            'type'=>'BootstrapDetailed'
        ]);
        $this->view->count=count($list);

        $this->view->assign('list',$list);
        $this->view->assign('status',0);
        //渲染管理员列表模板
        return $this->fetch('parking_list');
    }

    //渲染编辑管理员界面
    public function parkingEdit(Request $request){
        $this->isLogin();//判断用户是否登录

        $user_id=$request->param('id');
        $result=ParkingModel::get($user_id);
        $this->view->assign('title','编辑停车位信息');
        $this->view->assign('user_info',$result->getData());
        return $this->view->fetch('parking_edit');
    }

    //更新数据操作
    public function editParking(Request $request){
        $this->isLogin();//判断用户是否登录

        $param=$request->param();
        //去掉表单中为空的数据，即没有修改的内容
        foreach ($param as $key=>$value){
            if(!empty($value)||$value==0){
                $data[$key]=$value;
            }
        }

        $condition=['id'=>$data['id']];
        $result=ParkingModel::update($data,$condition)?true:false;
        if($result===true){
            return ['status'=>1,'message'=>'更新成功'];
        }else{
            return ['status'=>0,'message'=>'更新失败，请检查'];
        }
    }

    public function deleteParking(Request $request){
        $this->isLogin();//判断用户是否登录

        $user_id=$request->param('id');
        ParkingModel::update(['is_delete'=>1],['id'=>$user_id]);
        ParkingModel::destroy($user_id);
    }

    public function unDelete(){
        $this->isLogin();//判断用户是否登录

        //['delete_time'=>null]是将其设为null,['is_delete'=>1]条件是1
//        ParkingModel::update(['delete_time'=>NULL],['is_delete'=>1]);//无用
        //tp5恢复软删除目前已知的只有一种方法，写原生sql语句。
        $sql = ' update parking set delete_time = NULL where is_delete=1' ;//delete_time是数据库中自定义的删除标识字段。
        Db::execute($sql);
    }

    public function ParkingAdd(){
        $this->isLogin();//判断用户是否登录

        $this->view->assign('title','添加停车位');
        return $this->fetch('parking_add');
    }

    //添加操作
    public function addParking(Request $request){
        $this->isLogin();//判断用户是否登录

        $data=$request->param();
        $status=1;
        $message='添加成功';
        $rule=[
            'type|类型'=>"require",
            'parking_lot|停车场'=>"require",
        ];

        $result=$this->validate($data,$rule);
        if($result=='true'){
            $user=ParkingModel::create($request->param());
            if($user===null){
                $status=0;
                $message='添加失败~~';
            }
        }else{
            $message=$result;
        }
        return ['status'=>$status,'message'=>$message];
    }
}