<?php
/**
 * Created by PhpStorm.
 * User: 16773
 * Date: 2018/12/28
 * Time: 17:20
 */
header("content-type:text/html;charset=utf-8");

//开启session
session_start();
require_once "./lib/util.php";
if (!isset($_SESSION["user"])||empty($_SESSION["user"])){
    echo "<script>alert('请登录');window.location.href='login.php';</script>";exit;
}
$user = $_SESSION["user"];

//表单都不为空数据才会提交过来
if (!empty($_POST['userdesc'])){

    //加载utils工具
    require_once "./lib/util.php";
    $userdesc = filter_var($_POST['userdesc'],FILTER_SANITIZE_STRING);

    //数据库连接
    $con = mysqlInit();
    if (!$con){
        echo mysqli_error();
        exit;
    }
    //修改编码
    mysqli_set_charset($con, "utf-8");
    $sql = "update `user` set `desc` = '{$userdesc}' where `username` = '{$user['username']}' ";

    $obj = mysqli_query($con, $sql);
    if ($obj){
        echo "<script>alert('备注修改成功');window.location.href='index.php';</script>";
        exit;
    }
}