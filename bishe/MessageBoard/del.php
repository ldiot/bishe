<?php
include 'conn.php';
$id=$_GET['id'];
$query="delete form message where id=$id";
$conn->query($query);
$url="list.php";
echo "<script>";
echo "window.location.href=$url";
echo "</script>>";