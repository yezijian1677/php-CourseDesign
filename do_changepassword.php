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
if (!empty($_POST['oldpassword'])){

    //加载utils工具
    require_once "./lib/util.php";
    $oldpassword = filter_var($_POST['oldpassword'],FILTER_SANITIZE_STRING);
    $newpassword = filter_var($_POST['newpassword'],FILTER_SANITIZE_STRING);

    //数据库连接
    $con = mysqlInit();
    if (!$con){
        echo mysqli_error();
        exit;
    }
    //修改编码
    mysqli_set_charset($con, "utf-8");
    $server_password = $user['password'];
    if ($server_password == $oldpassword){
        $sql = "update `user` set `password` = '{$newpassword}' where `username` = '{$user['username']}'";
        if (mysqli_query($con, $sql)){
            echo "<script>alert('修改成功');window.location.href='logout.php';</script>";exit;
        }else{
            echo "<script>alert('密码不正确');window.location.href='changepassword.php';</script>";exit;
        }
    }
}