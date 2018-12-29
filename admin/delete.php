<?php
/**
 * Created by PhpStorm.
 * User: 16773
 * Date: 2018/12/29
 * Time: 10:49
 */
header("content-type:text/html;charset=utf-8");
require_once "../lib/util.php";

$userId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']): "";

if (!$userId){
    echo "<script>alert('参数非法');window.location.href='index.php';</script>";exit;
}

$con = mysqlInit();
mysqli_set_charset($con, "utf-8");

$sql = "select `id` from `user` where `id` = '{$userId}'";
$obj = mysqli_query($con, $sql);

if(!$user = mysqli_fetch_assoc($obj)){
    echo "<script>alert('id不存在');window.location.href='index.php';</script>";exit;
}

$sql = "delete from `user` where `id` = '{$userId}'";
if ($result = mysqli_query($con, $sql)){
    echo "<script>alert('删除成功');window.location.href='index.php';</script>";exit;
} else {
    echo "<script>alert('删除失败');window.location.href='index.php';</script>";exit;
}
?>
