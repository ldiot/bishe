<?php
namespace app\index\controller;
use app\index\controller\Base;
use think\console\command\make\Model;
use think\Exception;
use think\Request;
use app\index\model\House as HouseModel;
use think\Session;
use think\Db;
class House extends Base
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
//        HouseModel::create($data);

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
//        HouseModel::create($data);
    }
    public function issell(){
        $this->view->assign('title','已售出房屋列表');

        $list=HouseModel::where('status','=','1')->paginate(1,false,[
            'type'=>'BootstrapDetailed'
        ]);

        $this->view->count=count($list);

        $this->view->assign('list',$list);
        $this->view->assign('status',1);
        //渲染管理员列表模板
        return $this->fetch('house_list');
    }

    public function unsell(){
        $this->view->assign('title','未售出房屋列表');

        $list=HouseModel::where('status','=','0')->paginate(1,false,[
            'type'=>'BootstrapDetailed'
        ]);
        $this->view->count=count($list);

        $this->view->assign('list',$list);
        $this->view->assign('status',0);
        //渲染管理员列表模板
        return $this->fetch('house_list');
    }

    //渲染编辑管理员界面
    public function houseEdit(Request $request){
        $user_id=$request->param('id');
        $result=HouseModel::get($user_id);
        $this->view->assign('title','编辑房屋信息');
        $this->view->assign('user_info',$result->getData());
        return $this->view->fetch('house_edit');
    }

    //更新数据操作
    public function editHouse(Request $request){
        $param=$request->param();
        //去掉表单中为空的数据，即没有修改的内容
        foreach ($param as $key=>$value){
            if(!empty($value)||$value==0){
                $data[$key]=$value;
            }
        }

        $condition=['id'=>$data['id']];
        $result=HouseModel::update($data,$condition)?true:false;
        if($result===true){
            return ['status'=>1,'message'=>'更新成功'];
        }else{
            return ['status'=>0,'message'=>'更新失败，请检查'];
        }
    }

    public function deleteHouse(Request $request){
        $user_id=$request->param('id');
        HouseModel::update(['is_delete'=>1],['id'=>$user_id]);
        HouseModel::destroy($user_id);
    }

    public function unDelete(){
        //['delete_time'=>null]是将其设为null,['is_delete'=>1]条件是1
//        HouseModel::update(['delete_time'=>NULL],['is_delete'=>1]);//无用
        //tp5恢复软删除目前已知的只有一种方法，写原生sql语句。
        $sql = ' update house set delete_time = NULL where is_delete=1' ;//delete_time是数据库中自定义的删除标识字段。
        Db::execute($sql);
    }

    public function houseAdd(){
        $this->view->assign('title','添加房屋');
        return $this->fetch('house_add');
    }

    //添加操作
    public function addHouse(Request $request){
        $data=$request->param();
        $status=1;
        $message='添加成功';
        $rule=[
            'building_id|楼盘编号'=>"require",
            'place|房屋位置'=>"require",
            'unit|单元号'=>"require",
            'doorplate|门牌号'=>"require",
            'area|面积'=>"require",
        ];

        $result=$this->validate($data,$rule);
        if($result=='true'){
            $user=HouseModel::create($request->param());
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