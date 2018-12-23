<?php
/**
 * Created by PhpStorm.
 * User: 16773
 * Date: 2018/12/21
 * Time: 15:37
 */
header("content-type:text/html;charset=utf-8");

//开启session
session_start();
require_once "./lib/util.php";

//表单处理
if (!empty($_POST["name"])) {
    //连接数据库
    $con = mysqlInit();
    //获取表单的提交
    //过滤标签等字符串
    $name = filter_var($_POST["name"],FILTER_SANITIZE_STRING);
    $email = filter_var($_POST["email"], FILTER_VALIDATE_EMAIL);
    $content = filter_var($_POST["message"], FILTER_SANITIZE_STRING);
   // var_dump($name, $email, $content);

    if (!$email){
        echo "<script>alert('邮箱不合法不符合规范'+'{$email}');</script>";exit;
    }

    $sql = "insert `board`(`name`, `email`,`content`)
     values('{$name}','{$email}','{$content}') ";
    if ($obj = mysqli_query($con, $sql)){
        echo "<script>alert('留言发布成功');window.location.href='index.php';</script>";exit;
    } else {
        echo mysqli_error('');exit;
    }

}

?>