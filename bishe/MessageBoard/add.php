<?php
include ("conn.php");
$user=$_POST['user'];
$title=$_POST['title'];
$content=$_POST['content'];
if($_SERVER["REQUEST_METHOD"]=="POST"){
    $sql="insert into message(id,user,title,content,lastdate)values ('','$user','$title','$content',now())";
    $conn->exec($sql);
    echo "<script>alert('提交成功！返回首页。');location.href='add.html';</script>";
}