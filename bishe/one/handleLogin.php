<?php
session_start();
$name=$passw='';
if($_COOKIE['username']!=null&&$_COOKIE['password']!=null){
    $name=$_COOKIE['username'];
    $passw=$_COOKIE['password'];
    echo $name.$passw;
}elseif($_SERVER["REQUEST_METHOD"]=="POST") {
    $name = $_POST["username"];
    $passw = $_POST["password"];
}
try {
    $servername="localhost";
    $dbname="test";
    $conn=new PDO("mysql:host=$servername;dbname=$dbname","root","666666");
    $conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    $res=$conn->query("select * from user where username='$name' and password='$passw'");
    if($res->rowCount()){
        $_SESSION['username']=$name;
        $_SESSION['password']=$passw;
        setcookie('username',$name,time()+60*60*24*30);
        setcookie('password',$passw,time()+60*60*24*30);
        header("Location:index.php");
    }else{
        header("Location:login.php");
    }
//        if(!empty($res))//错误
//        if(count($res)>0)//错误
}catch (PDOException $e){
    echo $e->getMessage();
}
$conn=null;