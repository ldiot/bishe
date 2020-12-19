<?php
namespace app\index\controller;
use app\index\controller\Base;
use think\console\command\make\Model;
use think\Exception;
use think\Request;
use app\index\model\Resident as ResidentModel;
use think\Session;
use think\Db;
class Resident extends Base
{
    public function test(){
        $data=[
            'name'=>"李姣姣",
            'sex'=>'女',
            'age'=>'22',
            'tel'=>'13658274122',
            'idcard_number'=>'2345678909876437653',
            'job'=>'法发发',
            'address'=>'啊啊啊啊',
            'remark'=>'广泛的但是'
        ];
        ResidentModel::create($data);
    }

    public function search(Request $request){
        $id=$request->param('id');
        $name=$request->param('name');
        if($id!=""&&$name!=""){
            $condition['id']=['=',$id];
            $condition['name']=['=',$name];
            $list=ResidentModel::where($condition);
        }elseif($id!=""){
            $list=ResidentModel::where('id','=',$id);
        }else{
            $list=ResidentModel::where('name','=',$name);
        }
        $list=$list->paginate(1,false,[
            'type'=>'BootstrapDetailed'
        ]);
        $this->view->count=count($list);
        $this->view->assign('title','查询结果');
        $this->view->assign('list',$list);
        //渲染管理员列表模板
        return $this->fetch('resident_list');
    }

    public function residentList(){
        $this->view->assign('title','住户列表');

        $this->view->count=ResidentModel::count();
        $list=ResidentModel::paginate(1,false,[
            'type'=>'BootstrapDetailed'
        ]);
        $this->view->assign('list',$list);
        //渲染管理员列表模板
        return $this->fetch('resident_list');
    }


    //渲染编辑管理员界面
    public function residentEdit(Request $request){
        $user_id=$request->param('id');
        $result=ResidentModel::get($user_id);
        $this->view->assign('title','编辑住户信息');
        $this->view->assign('user_info',$result->getData());
        return $this->view->fetch('resident_edit');
    }

    //更新数据操作
    public function editResident(Request $request){
        $param=$request->param();
        //去掉表单中为空的数据，即没有修改的内容
        foreach ($param as $key=>$value){
            if(!empty($value)||$value==0){
                $data[$key]=$value;
            }
        }

        $condition=['id'=>$data['id']];
        $result=ResidentModel::update($data,$condition)?true:false;
        if($result===true){
            return ['status'=>1,'message'=>'更新成功'];
        }else{
            return ['status'=>0,'message'=>'更新失败，请检查'];
        }
    }

    public function deleteResident(Request $request){
        $user_id=$request->param('id');
        ResidentModel::update(['is_delete'=>1],['id'=>$user_id]);
        ResidentModel::destroy($user_id);
    }

    public function unDelete(){
        //['delete_time'=>null]是将其设为null,['is_delete'=>1]条件是1
//        ResidentModel::update(['delete_time'=>NULL],['is_delete'=>1]);//无用
        //tp5恢复软删除目前已知的只有一种方法，写原生sql语句。
        $sql = ' update resident set delete_time = NULL where is_delete=1' ;//delete_time是数据库中自定义的删除标识字段。
        Db::execute($sql);
    }

    public function residentAdd(){
        $this->view->assign('title','添加住户');
        return $this->fetch('resident_add');
    }

    //添加操作
    public function addResident(Request $request){
        $data=$request->param();
        $status=1;
        $message='添加成功';
        $rule=[
            'name|姓名'=>"require",
            'sex|性别'=>"require",
            'age|年龄'=>"require",
            'tel|电话'=>"require",
            'idcard_number|身份证号'=>"require",
        ];

        $result=$this->validate($data,$rule);
        if($result=='true'){
            $user=ResidentModel::create($request->param());
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