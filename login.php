<?php
/**
 * Created by PhpStorm.
 * User: 16773
 * Date: 2018/12/1
 * Time: 14:24
 */
header("content-type:text/html;charset=utf-8");

//开启session
session_start();


//如果session中已经存在登录信息且不为空，则不再进行登录,不执行表单处理
if (isset($_SESSION["user"])&&!empty($_SESSION["user"])){
    header("location:index.php");
    exit;
}

//验证是不是post提交,表单处理
if (!empty($_POST["username"])){
    include_once "./lib/util.php";

    //对用户名密码进行过滤空格
    $username = filter_var($_POST['username'],FILTER_SANITIZE_STRING);
    $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);

    if (!$username){
        echo "<script>alert('用户名不符合规范'+'{$username}');window.location.href='register.php';</script>";exit;
    }

    if (!$password){
        echo "<script>alert('密码不符合规范'+'{$password}');window.location.href='register.php';</script>";exit;
    }

    $con = mysqlInit();
    mysqli_query($con, "set names utf-8");
    if (!$con){
        echo mysqli_error();
        exit;
    }

    //根据用户名查询用户
    $sql = "select * from `user` where `username` = '{$username}'";

    $obj = mysqli_query($con, $sql);
    $result = mysqli_fetch_assoc($obj);

    if (is_array($result) && !empty($result)){

//        如果有用户再判断密码
        //var_dump($result);die;
        if ($password === $result['password']){
//            储存session信息 字段user
            $_SESSION['user'] = $result;
//            登录成功定向到首页
            header("Location:index.php");
        } else {
//            header("location:login.php");
//            echo "<script>alert('密码错误，请再次输入')</script>";exit;
            echo "<script>alert('密码错误');window.location.href='login.php';</script>";

        }
    } else {
        echo "<script>alert('用户名不存在');window.location.href='login.php';</script>";
    }


}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>用户登录</title>
    <link type="text/css" rel="stylesheet" href="./static/css/common.css">
    <link type="text/css" rel="stylesheet" href="./static/css/add.css">
    <link rel="stylesheet" type="text/css" href="./static/css/login.css">
    <link type="text/css" rel="stylesheet" href="./static/css/slide.css">
</head>
<body>
<nav class="header">
    <div class="title" onclick="window.open('login.php')">
        中美贸易战
    </div>
    <div class="auth fr">
        <ul>
            <li><a href="index.php">首页</a></li>
            <li><a href="login.php">登录</a></li>
            <li><a href="register.php">注册</a></li>
        </ul>
    </div>
</nav>

<section class="content">
    <div class="center">
        <div class="center-login">
            <div class="login-banner">
                <img src="./static/image/CUF.jpg" style="width: 600px;height: 536px;">
            </div>
            <div class="user-login">
                <div class="user-box">
                    <div class="user-title">
                        <p>用户登录</p>
                    </div>
                    <form class="login-table" name="login" id="login-form" action="login.php" method="post">
                        <div class="login-left">
                            <label class="username">用户名</label>
                            <input type="text" class="yhmiput" name="username" placeholder="请输入用户名" id="username">
                        </div>
                        <div class="login-right">
                            <label class="passwd">密码</label>
                            <input type="password" class="yhmiput" name="password" placeholder="请输入密码" id="password">
                        </div>
                        <div class="login-btn">
                            <button type="submit">登录</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <aside id="volet_clos">
        <div id="volet">
            <summary>
                中美综合国力
                <details>
                    中美综合国力差距的本质还是发达国家与发展中国家的差距,我国综合国力许多指标远远落后于美国，但在很多领域也进步迅速，令美国倍感压力。但必须清醒地认识到中美综合国力之间仍然存在巨大差距，有些差距中短期内是难以超越的。
                </details>
            </summary>
            <progress value="23" max="100" style="height: 15px; width: 200px;"></progress>23%
            <p>美国人口是我国的四分之一</p>
            <progress value="14.3" max="100" style="height: 15px; width: 200px;"></progress>14.3%
            <p>我国人均耕地仅为美国的14.3%</p>
            <progress value="6.6" max="100" style="height: 15px; width: 200px;"></progress>6.6%
            <p>我国人均收入仅为美国的6.6%</p>
            <progress value="47" max="100" style="height: 15px; width: 200px;"></progress>23%
            <p> 人均住房：美国是我国的2.2倍</p>
            <progress value="28" max="100" style="height: 15px; width: 200px;"></progress>23%
            <p>恩格尔系数：我国是美国的3.5倍</p>

            <p class="counter_1">中美状况:</p>
            <p class="counter_2">GDP总量：我国是美国的63%</p>
            <p class="counter_2"> GDP增速：我国是美国的3倍</p>

            <p class="counter_1">中美近况:</p>
            <p class="counter_2">孟晚舟在加拿大被捕</p>
            <p class="counter_2">中兴受挫</p>

            <p class="counter_1">中美远望:</p>
            <p class="counter_2">出发点是“和合”</p>
            <p class="counter_2">长远、发展的眼光审视两国关系</p>

            <a href="#volet" class="ouvrir" aria-hidden="true">更多资讯</a>
            <a href="#volet_clos" class="fermer" aria-hidden="true">隐藏资讯</a>
        </div>
    </aside>

</section>
<footer class="footer">
    <p><span>中美贸易战</span>2018年中美贸易争端</p>
</footer>

</body>
<script src="./static/js/jquery-3.3.1.min.js"></script>
<script>
    $(function () {
        $('#login-form').submit(function () {
            var username = $('#username').val(),
                password = $('#password').val();
            if (username == '' || username.length <= 0) {
                alert("用户名不能为空");
                $('#username').focus();
                return false;
            }

            if (password == '' || password.length <= 0) {
                alert("密码不能为空");
                $('#password').focus();
                return false;
            }


            return true;
        })

    })
</script>
</html>