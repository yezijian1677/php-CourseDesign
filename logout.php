<?php
/**
 * Created by PhpStorm.
 * User: 16773
 * Date: 2018/12/3
 * Time: 17:42
 */


/**
 * 退出功能
 */
header("content-type:text/html;charset=utf-8");
//开启session
session_start();
unset($_SESSION["user"]);
echo "<script>alert('退出成功');window.location.href='login.php';</script>";exit;


?>