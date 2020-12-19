<?php
namespace app\index\controller;
use app\index\model\Student as StudentModel;
use think\Db;
use think\Request;
class Student extends Base{
    //渲染学生信息列表
    public function studentList(){
        //每次输出5行
        $studentList=StudentModel::paginate(5);
        $count=StudentModel::count();
        foreach ($studentList as $value){
            $value->grade=$value->grade->name;
        }
        $this->view->assign('studentList',$studentList);
        $this->view->assign('count',$count);
        return $this->view->fetch('student_list');
    }

    //学生状态变更
    public function setStatus(Request $request){
        $student_id=$request->param('id');
        $result=StudentModel::get($student_id);
        if($result->getData('status')==1){
            StudentModel::update(['status'=>0],['id'=>$student_id]);
        }else{
            StudentModel::update(['status'=>1],['id'=>$student_id]);
        }
    }

    //渲染学生编辑界面
    public function studentEdit(Request $request){
        $student_id=$request->param('id');
        $result=StudentModel::get($student_id);
        $result->grade=$result->grade->name;

        $this->view->assign('title','编辑班级');
        $this->view->assign('keywords','php.cn');
        $this->view->assign('desc','PHP中文网ThinkPHP5开发实战课程');

        $this->view->assign('student_info',$result);
        $this->view->assign('gradeList',\app\index\model\Grade::all());
        return $this->view->fetch('student_edit');
    }

    //更新学生信息
    public function doEdit(Request $request){
        $data=$request->param();
        $condition=['id'=>$data['id']];
        $result=StudentModel::update($data,$condition);
        $status=0;
        $message='更新失败，请检查';
        if($result==true){
            $status=1;
            $message='恭喜，更新成功~~';
        }
        return ['status'=>$status,'message'=>$message];
    }

    //渲染学生添加界面
    public function studentAdd(){
        $this->view->assign('title','添加学生');
        $this->view->assign('keywords','php.cn');
        $this->view->assign('desc','PHP中文网ThinkPHP5开发实战课程');
        $this->view->assign('gradeList',\app\index\model\Grade::all());
        return $this->view->fetch('student_add');
    }

    //添加学生到表中
    public function doAdd(Request $request){
//        $data=$request->param();
        $data=$request->except('grade');

        $result=StudentModel::create($data);
        $status=0;
        $message='添加失败，请检查';
        if(true==$result){
            $status=1;
            $message='恭喜，添加成功~~';
        }
        return ['status'=>$status,'message'=>$message];
    }

    //软删除操作
    public function deleteStudent(Request $request){
        $teacher_id=$request->param('id');
        StudentModel::update(['is_delete'=>1],['id'=>$teacher_id]);
        StudentModel::destroy($teacher_id);
    }

    //恢复删除操作
    public function unDelete(){
        $sql = ' update student set delete_time = NULL where is_delete=1' ;//delete_time是数据库中自定义的删除标识字段。
        Db::execute($sql);
    }
}