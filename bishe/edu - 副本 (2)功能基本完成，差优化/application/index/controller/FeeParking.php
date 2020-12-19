<?php
namespace app\index\controller;
use app\index\controller\Base;
use app\index\model\Resident as ResidentModel;
use Cassandra\Date;
use MongoDB\BSON\Type;
use think\console\command\make\Model;
use think\Exception;
use think\Request;
use app\index\model\FeeParking as FeeParkingModel;
use app\index\model\Parking as ParkingModel;
use think\Session;
use think\Db;
class FeeParking extends Base
{
    public function test(){
        echo time();
        echo "<br>";
        echo date("Y-m-d");
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
//        FeeParkingModel::create($data);

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
//        FeeParkingModel::create($data);
    }
    public function search(Request $request){
        $parking_id=$request->param('parking_id');
        $status=$request->param('status');
        if($status==1){
            $condition['status']=['=','1'];
        }elseif($status==0){
            $condition['status']=['=','0'];
        }

        $condition['parking_id']=['=',$parking_id];
        $list=FeeParkingModel::where($condition)->paginate(1,false,[
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
        return $this->fetch('fee_parking_list');
    }

    public function isdo(){
        $this->view->assign('title','已收取费用');

        $list=FeeParkingModel::where('status','=','1')->paginate(1,false,[
            'type'=>'BootstrapDetailed'
        ]);

        $this->view->count=count($list);

        $this->view->assign('list',$list);
        $this->view->assign('status',1);
        //渲染管理员列表模板
        return $this->fetch('fee_parking_list');
    }

    public function undo(){
        $this->view->assign('title','未收取费用');

        $list=FeeParkingModel::where('status','=','0')->paginate(1,false,[
            'type'=>'BootstrapDetailed'
        ]);
        $this->view->count=count($list);

        $this->view->assign('list',$list);
        $this->view->assign('status',0);
        //渲染管理员列表模板
        return $this->fetch('fee_parking_list');
    }

    //渲染编辑管理员界面
    public function feeparkingEdit(Request $request){
        $user_id=$request->param('id');
        $result=FeeParkingModel::get($user_id);
        $this->view->assign('title','编辑停车费信息');
        $this->view->assign('user_info',$result->getData());
        return $this->view->fetch('fee_parking_edit');
    }

    //更新数据操作
    public function editFeeparking(Request $request){
        $param=$request->param();
        //去掉表单中为空的数据，即没有修改的内容
        foreach ($param as $key=>$value){
            if(!empty($value)||$value==0){
                $data[$key]=$value;
            }
        }

        $condition=['id'=>$data['id']];
        $result=FeeParkingModel::update($data,$condition)?true:false;
        if($result===true){
            return ['status'=>1,'message'=>'更新成功'];
        }else{
            return ['status'=>0,'message'=>'更新失败，请检查'];
        }
    }

    public function deleteFeeparking(Request $request){
        $user_id=$request->param('id');
        FeeParkingModel::update(['is_delete'=>1],['id'=>$user_id]);
        FeeParkingModel::destroy($user_id);
    }

    public function unDelete(){
        //['delete_time'=>null]是将其设为null,['is_delete'=>1]条件是1
//        FeeParkingModel::update(['delete_time'=>NULL],['is_delete'=>1]);//无用
        //tp5恢复软删除目前已知的只有一种方法，写原生sql语句。
        $sql = ' update fee_parking set delete_time = NULL where is_delete=1' ;//delete_time是数据库中自定义的删除标识字段。
        Db::execute($sql);
    }



    public function feeparkingAdd(){
        $this->view->assign('title','新增停车费信息');
        return $this->fetch('fee_parking_add');
    }

    //添加操作
    public function addFeeparking(Request $request){
        $onpay=$request->param('onpay');
        $downpay=$request->param('downpay');
        $parking=ParkingModel::where('status',1)->column('type','id');
        $data=[
            'type'=>'停车费',
            'name'=>'停车费',
            'status'=>0,
            'start_time'=>date("Y-m-d"),
        ];
        foreach ($parking as $key=>$value){
            $data['parking_id']=$key;
            if($value==1){
                $data['money']=$onpay;
                FeeParkingModel::create($data);
            }elseif($value==0){
                $data['money']=$downpay;
                FeeParkingModel::create($data);
            }
        }
        $status=1;
        $message='添加成功';
        return ['status'=>$status,'message'=>$message];
    }
    public function des(Request $request){
        $parking_id=$request->param('id');
        $data=ParkingModel::get($parking_id);
        $resident_id=$data->getData('resident_id');
        $data=ResidentModel::get($resident_id);
        $resident=$data->getData();
        $house=$data->house;
        $parking=$data->parking;

        $this->view->assign('title','业主详情页');
        $this->view->assign('parking',$parking);
        $this->view->assign('resident',$resident);
        $this->view->assign('house',$house);
        return $this->fetch('fee_parking_des');
    }
}