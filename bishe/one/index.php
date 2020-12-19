<?php
session_start();
$username=$_SESSION['username'];
$password=$_SESSION['password'];
if($username==null||$password==null){
    $username=$_COOKIE['username'];
    $password=$_COOKIE['password'];
    if($username==null||$password==null) {
        header("Location:login.php");
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title></title>
</head>
<body>
welcome,<?php echo $username.",".$password;?>
</body>
</html>

