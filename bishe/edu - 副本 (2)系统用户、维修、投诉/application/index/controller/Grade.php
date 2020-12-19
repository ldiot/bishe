<?php
namespace app\index\controller;
use app\index\model\Grade as GradeModel;
use app\index\model\Teacher;
use think\Db;
use think\Request;

class Grade extends Base{
    //班级列表
    public function gradeList(){
        //获取所有班级表数据
        $grade=GradeModel::all();

        //获取记录数量
        $count=GradeModel::count();

        $gradeList=array();
        //遍历grade表
        foreach ($grade as $value){
            $data=[
                'id'=>$value->id,
                'name'=>$value->name,
                'length'=>$value->length,
                'price'=>$value->price,
                'status'=>$value->status,
                'create_time'=>$value->create_time,
                //用关联方法teacher属性方式访问teacher表中数据
                'teacher'=>isset($value->teacher->name)?$value->teacher->name:'<span style="color:red;">未分配</span>',
            ];
            //每次关联查询结果，保存到数组$gradeList中
            $gradeList[]=$data;
        }

        $this->view->assign('gradeList',$gradeList);
        $this->view->assign('count',$count);

        return $this->view->fetch('grade_list');

    }

    //班级状态变更
    public function setStatus(Request $request){
        $grade_id=$request->param('id');
        $result=GradeModel::get($grade_id);
        if($result->getData('status')==1){
            GradeModel::update(['status'=>0],['id'=>$grade_id]);
        }else{
            GradeModel::update(['status'=>1],['id'=>$grade_id]);
        }
    }

    //渲染班级编辑界面
    public function gradeEdit(Request $request){
        $grade_id=$request->param('id');
        $result=GradeModel::get($grade_id);
        $result->teacher=isset($result->teacher->name)?$result->teacher->name:'未分配';
//        dump($result);
        $this->view->assign('title','编辑班级');
        $this->view->assign('keywords','php.cn');
        $this->view->assign('desc','PHP中文网ThinkPHP5开发实战课程');
        $this->view->assign('grade_info',$result);
        return $this->view->fetch('grade_edit');
    }

    //班级更新
    public function doEdit(Request $request){
        $data=$request->except('teacher');
        //$data=$reques->param();如果全部获取，提交会提示缺少字段teacher

        $condition=['id'=>$data['id']];
        $result=GradeModel::update($data,$condition);
        $status=0;
        $message='更新失败，请检查';
        if(true==$result){
            $status=1;
            $message='恭喜更新成功~~';
        }
        return ['status'=>$status,'message'=>$message];
    }

    //渲染班级添加界面
    public function gradeAdd(){
        $this->view->assign('title','编辑班级');
        $this->view->assign('keywords','php.cn');
        $this->view->assign('desc','PHP中文网ThinkPHP5开发实战课程');
        return $this->view->fetch('grade_add');
    }

    //添加班级
    public function doAdd(Request $request){
        $data=$request->param();
        //静态方法get/all,update,create,destory
        $result=GradeModel::create($data);
        $status=0;
        $message='添加失败，请检查';
//        return $result;
        if(null!==$result){
            $status=1;
            $message='恭喜，添加成功~~';
        }
        //自动转为json格式，这是在config.php中配置的
        return ['status'=>$status,'message'=>$message];
    }

    //软删除操作
    public function deleteGrade(Request $request){
        $user_id=$request->param('id');
        GradeModel::update(['is_delete'=>1],['id'=>$user_id]);
        //这个destory方法不是GradeModel中的方法，而是软删除中的方法，GradeModel中也有destory，
        //但而是软删除中的destory方法优先级更高，所以GradeModel中也有destory被覆盖了
        GradeModel::destroy($user_id);
    }

    //恢复删除操作
    public function unDelete(){
        $sql = ' update grade set delete_time = NULL where is_delete=1' ;//delete_time是数据库中自定义的删除标识字段。
        Db::execute($sql);

//        GradeModel::update(['delete_time'=>NULL],['is_delete'=>1]);
    }
}