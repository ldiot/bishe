<?php
namespace app\index\controller;
use think\View;
use app\index\model\Staff;
class Index extends \think\Controller
{
    public function user(){

        $result=Staff::get(1);
        return $this->view->fetch();
//        return $this->fetch();
    }

    public function index()
    {
//        $user=[];
//        $name=['peter','jack','mike','jim'];
//        for($key=0;$key<10;$key++){
//            $user[]=[
//                'name'=>$name[rand(0,3)],
//                'sex'=>($key%2)?'男':'女',
//                'age'=>rand(15,40),
//                'salary'=>rand(3200,6800),
//                'level'=>rand(1,4),
//                'home'=>rand(1,3),
//            ];
//        }
//        return $this->view->fetch('',['user'=>$user,'age'=>18]);

//        $this->view->engine->layout('mylayout');
//        $this->view->domain='www.pp.cn';
//        $this->view->name='php中文网';

//        $this->view->domain='www.php.cn';
//        $this->view->birthday=strtotime('1988-01-01');
//        return $this->fetch();

//        setcookie('siteName','PHP中文网');
//        return $this->fetch();

//        dump($_SERVER);

//        $user=[
//            'name'=>'朱老师',
//            'age'=>28,
//        ];
//        $book=new \stdClass();
//        $book->name='php设计模式';
//        $book->price=99;
//        $this->assign('domain','jj');
//        $this->assign('user',$user);
//        $this->assign('book',$book);
//        return $this->fetch();

//        return view();

//        return $this->fetch('./tpl/demo.html');

//        return view('index',[
//            'name'=>'zhanglaoshi',
//            'lesson'=>'css',
//        ]);

//        $this->view->name='朱老师';
//        $this->view->lesson='js';
//        return \think\View::instance()->fetch();
//        return view('index',[
//            'domain'=>'php.cn',
//            'siteName'=>'php中文网',
//        ]);

//        $this->assign('siteName','php中文网');
//        $this->assign('domain','www.php.cn');
//        return $this->view->fetch();

////        $view=new View();
//        $view=View::instance();
//        $view->assign('domain','www.php.cn');
//        return $view->fetch();

//        $result=Staff::create([
//            'name'=>'孙二良',
//            'sex'=>0,
//        ]);

//        $result=Staff::update([
//            'name'=>'西门庆',
//        ],['id'=>1016]);
//        if($result){
//            return $result->name;
//        }else{
//            return 'fail';
//        }

//        $staff=Staff::get(1002);
//        $staff->name='张无忌';
//        $staff->salary=600;
//        $staff->hiredate='2010-09-20';
//        $staff->isUpdate(true)->save();
//        dump(Staff::get(1002)->getData());
//        $staff=new Staff;
//        $staff->name='左冷禅';
//        $staff->salary=5000;
//        $staff->hiredate='2014-10-23';
//        if($staff->save()){
//            return 'success';
//        }

//        $staff=Staff::get(1001);
//        return date("Y-m-d",time());
//        return $staff->name.$staff->hiredate;
////        return date('Y-m-d',$staff->hiredate);

//        return $staff->hiredate;

//        $where=function ($query){
//            $query->where('id','>',1002)
//                ->whereOr('salary','>',40000);
//        };
//        $value=Staff::destroy($where);
//        dump($value);

//        $result=Staff::get(['id'=>['>',1003]]);
//        $result->delete();

//        $where=function ($query){
//            $query->field(['name','salary'])
//                ->where('id','>',1007);
//        };
//        $resul=Staff::all($where);
//        foreach ($resul as $value){
//            dump($value->getData());
//    }
//        dump($resul);

//        $staff=new Staff();
//        $where=function ($query){
//            $query->field(['name','salary'])
//                ->where('id','>',1002);
//        };
//        $result=$staff->all($where);
//        foreach ($result as $key=>$value){
//            echo $key.$value->name.$value->salary;
////            dump($value->getData());
//        }
//        dump($result);

//        $id=1011;
//        $data=[
//            'name'=>'韦一笑','salary'=>5600
//        ];
////        $where=['id'=>1011];
//        $where=function ($query) use($id){
//            $query->where('id',$id);
//        };

//        $field=['name'];
//        $result=Staff::update($data,$where,$field);
//        dump($result->getData());

//        $staff=new Staff();
//        $data=[
//            ['id'=>1004,'name'=>'天山童姥', 'salary'=>80],
//            ['id'=>1005,'name'=>'天山童姥1', 'salary'=>80],
//            ['id'=>1006,'name'=>'天山童姥2', 'salary'=>80],
//        ];
//        $where=['id'=>1006];
//        $staff->isUpdate(true)->saveAll($data);
//        dump($staff->getData());

//        $result=Staff::create([
//            'name'=>'林平之','salary'=>300
//        ]);
//        dump($result->getData());

//        $staff=new Staff();
//        $data=[
//            ['name'=>'陈近南','salary'=>40000],
//            ['name'=>'吴三桂','salary'=>60000],
//            ['name'=>'陈圆圆','salary'=>8000],
//        ];
//        $result=$staff->saveAll($data);
//        dump($result);

//        $staff=new Staff();
//        $result=$staff->where('id',1002)->find();
//        dump($result->getData('name'));

    }

    public function demo(){
//        $sql="delete from staff where id=:id";
//        $result=Db::execute($sql,[0]);
//        dump($result);

//        $sql="insert into staff(name,sex) values (:name,:sex)";
//        $result=Db::execute($sql,['name'=>'朱老师','sex'=>1]);

//        $sql="select name,salary,dept from staff where salary>:salary";
//        $result=Db::query($sql,['salary'=>4000]);
//        dump($result);

//        $sql="update staff set salary=salary+1000 where id=:id";
//        $result=Db::execute($sql,['id'=>1002]);
//        dump($result);

//        $config='mysql://root:@localhost:3306/tp5#utf8';
//        $config=[
//            'type'=>'mysql',
//            'hostname'=>'localhost',
//            'username'=>'root',
//            'password'=>'',
//            'database'=>'tp5',
//        ];
//        $link=Db::connect();
//        $result=Db::table('staff')->select();
//        dump($result);
    }
}



