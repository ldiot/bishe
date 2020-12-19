<?php
namespace app\index\controller;
use app\index\controller\Base;
use think\console\command\make\Model;
use think\Exception;
use think\Request;
use app\index\model\Building as BuildingModel;
use think\Session;
use think\Db;
class Building extends Base
{
    public function test(){
        $data=[
            'name'=>'兴业',
            'type'=>'0',
            'floor_num'=>'4',
            'unit_num'=>'4',
            'house_num'=>'3',
            'store_num'=>'3',
            'floor_height'=>'3.21',
            'construction_area'=>'251.15',
            'usage_area'=>'130.44',
            'start_time'=>'2020-04-15',
            'finish_time'=>'2020-04-23',
            'service_life'=>'300',
            'remark'=>'aaaaa',
        ];
        BuildingModel::create($data);

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
        BuildingModel::create($data);
    }
    public function search(Request $request){
        $this->isLogin();//判断用户是否登录
        $id=$request->param('id');
        $name=$request->param('name');
        if($id!=""&&$name!=""){
            $condition['id']=['=',$id];
            $condition['name']=['=',$name];
            $list=BuildingModel::where($condition);
        }elseif($id!=""){
            $condition['id']=['=',$id];
            $list=BuildingModel::where($condition);
        }else{
            $condition['name']=['=',$name];
            $list=BuildingModel::where($condition);
        }
        $list=$list->paginate(20,false,[
            'type'=>'BootstrapDetailed'
        ]);
        $this->view->count=count($list);
        $this->view->assign('title','查询结果');
        $this->view->assign('list',$list);
        //渲染管理员列表模板
        return $this->fetch('building_list');
    }

    public function buildingList(){
        $this->isLogin();//判断用户是否登录
        $this->view->assign('title','楼盘列表');

        $this->view->count=BuildingModel::count();
        $list=BuildingModel::paginate(20,false,[
            'type'=>'BootstrapDetailed'
        ]);
        $this->view->assign('list',$list);
        //渲染管理员列表模板
        return $this->fetch('building_list');
    }


    //渲染编辑管理员界面
    public function buildingEdit(Request $request){
        $this->isLogin();//判断用户是否登录

        $user_id=$request->param('id');
        $result=BuildingModel::get($user_id);
        $this->view->assign('title','编辑楼盘信息');
        $this->view->assign('user_info',$result->getData());
        return $this->view->fetch('building_edit');
    }

    //更新数据操作
    public function editBuilding(Request $request){
        $this->isLogin();//判断用户是否登录

        $param=$request->param();
        //去掉表单中为空的数据，即没有修改的内容
        foreach ($param as $key=>$value){
            if(!empty($value)||$value==0){
                $data[$key]=$value;
            }
        }

        $condition=['id'=>$data['id']];
        $result=BuildingModel::update($data,$condition)?true:false;
        if($result===true){
            return ['status'=>1,'message'=>'更新成功'];
        }else{
            return ['status'=>0,'message'=>'更新失败，请检查'];
        }
    }

    public function deleteBuilding(Request $request){
        $this->isLogin();//判断用户是否登录

        $user_id=$request->param('id');
        BuildingModel::update(['is_delete'=>1],['id'=>$user_id]);
        BuildingModel::destroy($user_id);
    }

    public function unDelete(){
        $this->isLogin();//判断用户是否登录

        //['delete_time'=>null]是将其设为null,['is_delete'=>1]条件是1
//        BuildingModel::update(['delete_time'=>NULL],['is_delete'=>1]);//无用
        //tp5恢复软删除目前已知的只有一种方法，写原生sql语句。
        $sql = ' update building set delete_time = NULL where is_delete=1' ;//delete_time是数据库中自定义的删除标识字段。
        Db::execute($sql);
    }

    public function buildingAdd(){
        $this->isLogin();//判断用户是否登录

        $this->view->assign('title','添加楼盘');
        return $this->fetch('building_add');
    }

    //添加操作
    public function addBuilding(Request $request){
        $this->isLogin();//判断用户是否登录

        $data=$request->param();
        $status=1;
        $message='添加成功';
        $rule=[
            'name|楼盘名称'=>"require",
            'type|楼盘类型'=>"require",
            'floor_num|层数'=>"require",
            'unit_num|单元数'=>"require",
            'house_num|住宅数'=>"require",
            'store_num|门面数'=>"require",
            'floor_height|层高'=>"require",
            'construction_area|建筑面积'=>"require",
            'usage_area|使用面积'=>"require",
            'start_time|开工日期'=>"require",
            'finish_time|竣工日期'=>"require",
            'service_life|设计使用年限'=>"require",
        ];

        $result=$this->validate($data,$rule);
        if($result=='true'){
            $user=BuildingModel::create($request->param());
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