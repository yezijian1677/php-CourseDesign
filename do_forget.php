<?php
/**
 * Created by PhpStorm.
 * User: 16773
 * Date: 2018/12/28
 * Time: 17:20
 */
header("content-type:text/html;charset=utf-8");


//表单都不为空数据才会提交过来
if (!empty($_POST['username'])){

    //加载utils工具
    require_once "./lib/util.php";
    $username = filter_var($_POST['username'],FILTER_SANITIZE_STRING);
    $seed = filter_var((int)$_POST['seed'],FILTER_VALIDATE_INT);
    $newpassword = filter_var($_POST['newpassword'],FILTER_SANITIZE_STRING);

    //数据库连接
    $con = mysqlInit();
    if (!$con){
        echo mysqli_error();
        exit;
    }
    //修改编码
    mysqli_set_charset($con, "utf-8");
    $sql =  "select `seed` from `user` where `username` = '{$username}'";
    $obj = mysqli_query($con, $sql);
    $result = mysqli_fetch_assoc($obj);
//    var_dump($result);
    if ((int)$result['seed'] == $seed){
        $sql = "update `user` set `password` = '{$newpassword}' where `username` = '{$username}'";
        if (mysqli_query($con, $sql)){
            echo "<script>alert('修改成功');window.location.href='logout.php';</script>";exit;
        }else{
            echo "<script>alert('随机码验证错误');window.location.href='forgetPassword.php';</script>";exit;
        }
    }
}