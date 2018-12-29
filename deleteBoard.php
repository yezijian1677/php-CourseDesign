<?php
/**
 * Created by PhpStorm.
 * User: 16773
 * Date: 2018/12/29
 * Time: 10:49
 */
header("content-type:text/html;charset=utf-8");
session_start();
require_once "./lib/util.php";

//如果session中不存在登录信息或者信息为空，则进行登录,拒绝执行表单处理
if (!isset($_SESSION["user"])||empty($_SESSION["user"])||$_SESSION['user']['status']==1){
    echo "<script>alert('请登录');window.location.href='login.php';</script>";exit;
}
$user = $_SESSION["user"];

$commentId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']): "";

if (!$commentId){
    echo "<script>alert('参数非法');window.location.href='index.php';</script>";exit;
}

$con = mysqlInit();
mysqli_set_charset($con, "utf-8");

$sql = "select `id` from `board` where `id` = '{$commentId}'";
$obj = mysqli_query($con, $sql);

if(!$comment = mysqli_fetch_assoc($obj)){
    echo "<script>alert('id不存在');window.location.href='index.php';</script>";exit;
}

$sql = "delete from `board` where `id` = '{$commentId}'";
if ($result = mysqli_query($con, $sql)){
    echo "<script>alert('删除成功');window.location.href='index.php';</script>";exit;
} else {
    echo "<script>alert('删除失败');window.location.href='index.php';</script>";exit;
}
?>
