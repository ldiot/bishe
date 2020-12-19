<?php
namespace app\index\controller;
use app\index\controller\Base;
use think\console\command\make\Model;
use think\Exception;
use think\Request;
use app\index\model\Admin as AdminModel;
use think\Session;
use think\Db;
class Admin extends Base
{
    //登陆界面
    public function login(){
        $this->alreadLogin();//防止重复登陆
        return $this->view->fetch();
    }

    //验证登录 $this->validate($data,$rule,$msq)
    public function checkLogin(Request $request){
        //初始返回参数
        $status=0;//请求失败
        $result='';
//        $data=$request->param();
        $data=$request->except('verify');
        //创建验证规则
        $rule=[
            'username|用户名'=>'require',//用户名必填
            'password|密码'=>'require',//密码必填
//            'verify|验证码'=>'require|captcha',//用户名必填
//            'verify|验证码'=>'require',//用户名必填
        ];

        //自定义验证失败的提示信息
        $msg=[
            'username'=>['require'=>'用户名不能为空，请检查'],
            'password'=>['require'=>'密码不能为空，请检查'],
//            'verify'=>[
//                'require'=>'验证码不能为空，请检查',
//                'captcha'=>'验证码错误'
//                ],
        ];

        //进行验证
        //$result 只会返回两种值：ture->表示验证通过，如果返回字符串，则是用户自定义的错误提示
        $result=$this->validate($data,$rule,$msg);
//        return $result;
        //如果验证通过则执行
        if($result=='true'){
            //构造查询条件
            $map=[
                'username'=>$data['username'],
                'password'=>md5($data['password'])
            ];
            //查询用户信息
//            return $result;
            $user=AdminModel::get($map);
//            return $result;
            if($user=='null'){
                $result='没有找到该用户';

            }else{
                $status=1;
                $result='验证通过，点击[确定]进入';
                //设置用户登录信息用：session
                Session::set('user_id',$user->id);//用户id
                Session::set('user_info',$user->getData());//获取用户所有信息

                $user->setInc('login_count');
            }
        }
//        return '11111'.$result;
        return ['status'=>$status,'message'=>$result,'data'=>$data];
    }

    //退出登录
    public function logout(){
        //注销session
        //destroy方法会将所有用户的session信息全部注销，而delete方法只删除当前用户的session信息
        Session::delete('user_id');
        Session::delete('user_info');
        $this->success('注销登录，正在返回','admin/login');
    }

    public function adminList(){
        $this->view->assign('title','管理员列表');

        $this->view->count=AdminModel::count();
        //判断当前是不是admin用户
        //先通过session获取到用户登陆名
        $userName=Session::get('user_info.username');
        if($userName=='admin'){
            $list=AdminModel::all();//admin用户可以查看所有记录，数据要经过模型获取器处理
        }else{
            //为了共用列表模板，使用了all(),其实这里用get()符合逻辑，但有时也要变通
            //非admin只能看自己信息，数据要经过模型获取器处理
            $list=AdminModel::all(['name'=>$userName]);
        }

        $this->view->assign('list',$list);
        //渲染管理员列表模板
        return $this->fetch('admin_list');
    }

    //管理员状态变更
    public function setStatus(Request $request){
        $user_id=$request->param('id');
        $result=AdminModel::get($user_id);
        if($result->getData('status')==1){
            AdminModel::update(['status'=>0],['id'=>$user_id]);
        }else{
            AdminModel::update(['status'=>1],['id'=>$user_id]);
        }
    }

    //渲染编辑管理员界面
    public function adminEdit(Request $request){
        $user_id=$request->param('id');
        $result=AdminModel::get($user_id);
        $this->view->assign('title','编辑管理员信息');
        $this->view->assign('user_info',$result->getData());
        return $this->view->fetch('admin_edit');
    }

    //更新数据操作
    public function editUser(Request $request){
//        return $request->param('status');
        //获取表单返回的数据
        $param=$request->param();
        //去掉表单中为空的数据，即没有修改的内容
        foreach ($param as $key=>$value){
            if(!empty($value)||$value==0){
                $data[$key]=$value;
            }
        }

        $condition=['id'=>$data['id']];
        $result=AdminModel::update($data,$condition)?true:false;
        //如果是admin用户，更新当前session中用户信息user_info中的角色role，供页面调用
        if(Session::get('user_info.username'=='admin')){
            Session::set('user_info.role',$data['role']);
        }
        if($result===true){
            return ['status'=>1,'message'=>'更新成功'];
        }else{
            return ['status'=>0,'message'=>'更新失败，请检查'];
        }
    }

    public function deleteUser(Request $request){
        $user_id=$request->param('id');
        AdminModel::update(['is_delete'=>1],['id'=>$user_id]);
        AdminModel::destroy($user_id);
    }

    public function unDelete(){
        //['delete_time'=>null]是将其设为null,['is_delete'=>1]条件是1
//        AdminModel::update(['delete_time'=>NULL],['is_delete'=>1]);//无用
        //tp5恢复软删除目前已知的只有一种方法，写原生sql语句。
        $sql = ' update admin set delete_time = NULL where is_delete=1' ;//delete_time是数据库中自定义的删除标识字段。
        Db::execute($sql);
    }

    public function adminAdd(){
        $this->view->assign('title','添加管理员');
        return $this->fetch('admin_add');
    }

    //检测用户名是否可用
    public function checkUserName(Request $request){
        $userName=trim($request->param('username'));
        $status=1;
        $message='用户名可用';
        if(AdminModel::get(['username'=>$userName])){
            //如果在表中查询到该用户名
            $status=0;
            $message='用户名重复，请重新输入~~';
        }
        return ['status'=>$status,'message'=>$message];
    }

    //检测用户邮箱是否可用
//    public function checkUserEmail(Request $request){
//        $userEmail=trim($request->param('email'));
//        $status=1;
//        $message='邮箱可用';
//        if(AdminModel::get(['email'=>$userEmail])){
//            $status=0;
//            $message='邮箱重复，请重新输入~~';
//        }
//        return ['status'=>$status,'message'=>$message];
//    }

    //添加操作
    public function addUser(Request $request){
        $data=$request->param();
        $status=1;
        $message='添加成功';
        $rule=[
            'username|用户名'=>"require|min:3|max:10",
            'password|密码'=>"require|min:3|max:10",
        ];

        $result=$this->validate($data,$rule);
        if($result=='true'){
            $user=AdminModel::create($request->param());
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