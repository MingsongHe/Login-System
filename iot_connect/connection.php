<?php 
$dbServername = "localhost";
$dbUsername = "数据库用户名";          //数据库用户名, 一般是 root
$dbPassword = "password";
$dbName = "emscom_wp800";           //数据库名

$connect = new mysqli($dbServername, $dbUsername, $dbPassword, $dbName);
/*
// Check connection
if ($mysqli -> connect_error) {
  echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
  exit();
}*/
?>