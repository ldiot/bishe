<?php
namespace app\index\controller;
use app\index\model\Teacher as TeacherModel;
use think\Db;
use think\Request;

class Teacher extends Base{
    //教师列表
    public function teacherList(){
        $teacher=TeacherModel::all();
        $count=TeacherModel::count();
        $teacherList=array();
        foreach ($teacher as $value){
            $data=[
                'id'=>$value->id,
                'name'=>$value->name,
                'degree'=>$value->degree,
                'school'=>$value->school,
                'mobile'=>$value->mobile,
                'hiredate'=>$value->hiredate,
                'status'=>$value->status,
                //用关联方法grade属性方法访问grade表中数据
                'grade'=>isset($value->grade->name)?$value->grade->name:'<span style="color: red">未分配</span>'
            ];
            $teacherList[]=$data;
        }
        $this->view->assign('teacherList',$teacherList);
        $this->view->assign('count',$count);

        //设置当前页面的seo模板变量
        $this->view->assign('title','编辑班级');
        $this->view->assign('keywords','php.cn');
        $this->view->assign('desc','PHP中文网ThinkPHP5开发实战课程');

        return $this->view->fetch('teacher_list');
    }

    //教师状态变更
    public function setStatus(Request $request){
        $teacher_id=$request->param('id');
        $result=TeacherModel::get($teacher_id);
        if($result->getData('status')==1){
            TeacherModel::update(['status'=>0],['id'=>$teacher_id]);
        }else{
            TeacherModel::update(['status'=>0],['id'=>$teacher_id]);
        }
    }

    //渲染教师编辑界面
    public function teacherEdit(Request $request){
        $teacher_id=$request->param('id');
        $result=TeacherModel::get($teacher_id);
        $this->view->assign('title','编辑教师信息');
        $this->view->assign('keywords','php.cn');
        $this->view->assign('desc','PHP中文网ThinkPHP5开发实战课程');

        $this->view->assign('teacher_info',$result);
        $this->view->assign('gradeList',\app\index\model\Grade::all());

        return $this->view->fetch('teacher_edit');
    }

    //教师更新
    public function doEdit(Request $request){
        $data=$request->param();
        $condition=['id'=>$data['id']];
        $result=TeacherModel::update($data,$condition);
        $status=0;
        $message='更新失败，请检查';
        if($result==true){
            $status=1;
            $message='恭喜，更新成功~~';
        }
        return ['status'=>$status,'message'=>$message];
    }

    //渲染教师添加界面
    public function teacherAdd(){
        $this->view->assign('title','添加班级');
        $this->view->assign('keywords','php.cn');
        $this->view->assign('desc','PHP中文网ThinkPHP5开发实战课程');
        $this->view->assign('gradeList',\app\index\model\Grade::all());
        return $this->view->fetch('teacher_add');
    }

    //添加教师
    public function doAdd(Request $request){
        $data=$request->param();

        $result=TeacherModel::create($data);
        $status=0;
        $message='添加失败，请检查';
        if(true==$result){
            $status=1;
            $message='恭喜，添加成功~~';
        }
        return ['status'=>$status,'message'=>$message];
    }

    //软删除操作
    public function deleteTeacher(Request $request){
        $teacher_id=$request->param('id');
        TeacherModel::update(['is_delete'=>1],['id'=>$teacher_id]);
        TeacherModel::destroy($teacher_id);
    }

    //恢复删除操作
    public function unDelete(){
        $sql = ' update teacher set delete_time = NULL where is_delete=1' ;//delete_time是数据库中自定义的删除标识字段。
        Db::execute($sql);
    }



}