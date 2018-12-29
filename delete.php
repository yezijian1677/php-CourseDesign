<?php
/**
 * Created by PhpStorm.
 * User: 16773
 * Date: 2018/12/2
 * Time: 10:49
 */
header("content-type:text/html;charset=utf-8");

//开启session
session_start();
require_once "./lib/util.php";

//如果session中不存在登录信息或者信息为空，则进行登录,拒绝执行表单处理
if (!isset($_SESSION["user"])||empty($_SESSION["user"])){
    echo "<script>alert('请登录');window.location.href='login.php';</script>";exit;
}
$user = $_SESSION["user"];
//从url获取newsId
$newsId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']): "";

//如果资讯id不存在就跳转
if (!$newsId){
    echo "<script>alert('参数非法');window.location.href='index.php';</script>";exit;
}
//连接数据库
$con = mysqlInit();
mysqli_set_charset($con, "utf-8");

//根据资讯id校验id
$sql = "select `id` from `news` where `id` = '{$newsId}'";
$obj = mysqli_query($con, $sql);
//如果根据id查询不到资讯，就跳转回index页
if(!$news = mysqli_fetch_assoc($obj)){
    echo "<script>alert('id不存在');window.location.href='index.php';</script>";exit;
}

$sql = "delete from `news` where `id` = '{$newsId}'";
if ($result = mysqli_query($con, $sql)){
    echo "<script>alert('删除成功');window.location.href='index.php';</script>";exit;
} else {
    echo "<script>alert('删除失败');window.location.href='index.php';</script>";exit;
}
?>