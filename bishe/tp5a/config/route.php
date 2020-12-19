<?php
//think\Route::bind('app\index\controller','namespace');
//think\Route::bind('app\index\controller\Index','class');

//think\Route::bind('index');
//think\Route::bind('index/Demo');
//think\Route::bind('index/Index');

//return[
//    '__alias__'=>[
//        'math'=>['index/demo',['ext'=>'html','except'=>'add,sub',],],
//    ]
//];
//think\Route::alias('math','index/demo',[
//    'ext'=>'html',
////    'allow'=>'add,sub',
//    'except'=>'add,sub',
//]);
//think\Route::alias('php','\app\index\controller\Test');

//think\Route::get('add/:n/:m','index/demo/add');
//think\Route::get('sub/:n/:m','index/demo/sub');
//think\Route::get('mult/:n/:m','index/demo/mult');
//think\Route::get('div/:n/:m','index/demo/div');


//think\Route::group('demo',[
//    ':id'=>'demo1',
//    ':name'=>'demo2',
//    ':isOk'=>'demo3',
//],[
//    'method'=>'get',
//    'prefix'=>'index/user/'
//],[
//    'id'=>'\d{2,4}',
//    'name'=>'[a-zA-Z]+',
//    'isOk'=>'0|1'
//]);

//think\Route::group(['name'=>'demo','method'=>'get','prefix'=>'index/user/'],[
//    ':id'=>['demo1',[],['id'=>'\d{2,4}']],
//    ':name'=>['demo2',[],['name'=>'[a-zA-Z]+']],
//    ':isOk'=>['demo3',[],['isOk'=>'0|1']],
//]);

//think\Route::group(['name'=>'demo','method'=>'get'],[
//    ':id'=>['index/user/demo1',[],['id'=>'\d{2,4}']],
//    ':name'=>['index/user/demo2',[],['name'=>'[a-zA-Z]+']],
//    ':isOk'=>['index/user/demo3',[],['isOk'=>'0|1']],
//]);

//\think\Route::group('demo',function (){
//    think\Route::get(':id','index/user/demo1',[],['id'=>'\d{2,4}']);
//    think\Route::get(':name','index/user/demo2',[],['name'=>'[a-zA-Z]+']);
//    think\Route::get(':isOk','index/user/demo3',[],['isOk'=>'0|1']);
//});

//think\Route::group('demo',[
//    ':id'=>['index/user/demo1',['method'=>'get'],['id'=>'\d{2,4}']],
//    ':name'=>['index/user/demo2',['method'=>'get'],['name'=>'[a-zA-Z]+']],
//    ':isOk'=>['index/user/demo3',['method'=>'get'],['isOk'=>'0|1']],
//]);

//return[
//    '[demo]'=>[
//        ':id'=>['index/user/demo1',['method'=>'get'],['id'=>'\d{2,4}']],
//        ':name'=>['index/user/demo2',['method'=>'get'],['name'=>'[a-zA-Z]+']],
//        ':isOk'=>['index/user/demo3',['method'=>'get'],['isOk'=>'0|1']],
//    ],
//];

//think\Route::pattern([
//    'name'=>'[a-zA-Z]+',
//    'age'=>'\d{2}'
//]);
//think\Route::get('test/:name/:age','index/index/test');
//return [
//    '__pattern__'=>[
//        'name'=>'[a-zA-Z]+',
//        'age'=>'\d{2}'
//    ],
//    'test/:name/:age'=>'index/index/test',
//];

//think\Route::get('demo','index/index/demo',[],[]);
//return[
//    'demo'=>['index/index/demo',['method'=>'get'],[]],
//];

//think\Route::get('demo/:name','@index/index/demo?lesson=thinkphp5');
//think\Route::get('test','\app\Test@test');
//think\Route::get('myfunc/:lesson',function($lesson){
//    return $lesson;
//});

//think\Route::rule('myjump','/dashboard/bishe/tp5/public/demo.php');

//think\Route::rule('demo1','edu/test/demo1');
//think\Route::rule('demo/:lesson','index/index/demo','Get',['ext'=>'shtml'],['lesson'=>'\w{1,10}']);
//return[
//    'demo/:lesson'=>['index/index/demo',['method'=>'get','ext'=>'shtml'],['lesson'=>'\w{1,10}']],
////    'test'=>'index/index/test',
//];