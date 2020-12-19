<?php
namespace app\index\controller;
class Index
{
    public function index()
    {
        return 'index';
    }

    public function demo1($lesson){
        return $lesson;
    }
    public function demo2(){
        return $lesson;
    }

    public function test($name,$age){
        return $name.$age;
    }
}
