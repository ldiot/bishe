<?php
namespace app\index\controller;
class Demo{
    public function add($n,$m){
        return $n+$m;
    }
    public function sub($n,$m){
        return $n-$m;
    }
    public function mult($n,$m){
        return $n*$m;
    }
    public function div($n,$m){
        return round(($n/$m),2);
    }
}