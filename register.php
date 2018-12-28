<?php
/**
 * Created by PhpStorm.
 * User: 16773
 * Date: 2018/12/1
 * Time: 11:17
 */

header("content-type:text/html;charset=utf-8");
//表单都不为空数据才会提交过来
if (!empty($_POST['username'])){

    //加载utils工具
    require_once "./lib/util.php";
    //对用户名密码进行过滤空格
    //FILTER_SANITIZE_EMAIL 过滤器删除字符串中所有非法的 e-mail 字符。
    //该过滤器允许所有的字符、数字以及 $-_.+!*'{}|^~[]`#%/?@&=。
    $username = filter_var($_POST['username'],FILTER_SANITIZE_EMAIL);
    $password = filter_var($_POST['password'],FILTER_SANITIZE_STRING);
    $repassword = filter_var($_POST['repassword'],FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'],FILTER_VALIDATE_EMAIL);

    if (!$username){
        echo "<script>alert('用户名不符合规范'+'{$username}');window.location.href='register.php';</script>";exit;
    }

    if (!$password){
        echo "<script>alert('密码不符合规范'+'{$password}');window.location.href='register.php';</script>";exit;
    }
    if (!$repassword){
        echo "<script>alert('密码不符合规范'+'{$password}');window.location.href='register.php';</script>";exit;
    }
    if ($password !== $repassword) {
        echo "<script>alert('二次密码不一致'+'{$password}');window.location.href='register.php';</script>";exit;
    }
    if (!$email){
        echo "<script>alert('邮箱不符合规范'+'{$password}');window.location.href='register.php';</script>";exit;
    }

    //数据库连接
    $con = mysqlInit();
    if (!$con){
        echo mysqli_error();
        exit;
    }
    //修改编码
    mysqli_set_charset($con, "utf-8");

    //插入用户之前判断用户是否在user表中存在
    $sql = "select count(`id`) as total from `user` where `username` = '{$username}'";
    $obj = mysqli_query($con, $sql);
    $result = mysqli_fetch_assoc($obj);
    //var_dump($result);die;
    //判断用户名存在
    if (isset($result['total'])&&$result['total']>0){
        echo '用户名已存在';exit;
    }

    //释放变量之前的变量,插入注册信息
    unset($obj, $result, $sql);
    $sql = "insert `user` (`username`,`password`,`create_time`, `status`) values ('{$username}','{$password}', '{$_SERVER['REQUEST_TIME']}',1) ";

    $obj = mysqli_query($con, $sql);
    if ($obj){
        echo "<script>alert('注册成功'+'{$username}');window.location.href='login.php';</script>";
        exit;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>用户注册</title>
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
                        <p>用户注册</p>
                    </div>
                    <form class="login-table" name="register" id="register-form" action="register.php" method="post">
                        <div class="login-left">
                            <label class="username">用户名</label>
                            <input required="required" type="text" class="yhmiput" name="username" placeholder="请输入用户名" id="username">
                        </div>
                        <div class="login-right">
                            <label class="passwd">密码</label>
                            <input required="required" type="password" class="yhmiput" name="password" placeholder="请输入密码" id="password">
                        </div>
                        <div class="login-right">
                            <label class="passwd">确认</label>
                            <input required="required" type="password" class="yhmiput" name="repassword" placeholder="请再次输入密码"
                                   id="repassword">
                        </div>
                        <div class="login-right">
                            <label class="passwd">邮箱</label>
                            <input required="required" type="email" class="yhmiput" name="email" placeholder="请输入邮箱" id="email">
                        </div>
                        <div class="login-btn">
                            <button type="submit">注册</button>
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
        $('#register-form').submit(function () {
            var username = $('#username').val(),
                password = $('#password').val(),
                repassword = $('#repassword').val();
                email = $('#email').val();
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

            if (repassword == '' || repassword.length <= 0 || (password != repassword)) {
                alert("二次密码不正确");
                $('#repassword').focus();
                return false;
            }

            if (email == '' || email.length <= 0) {
                alert("用户名不能为空");
                $('#username').focus();
                return false;
            }


            return true;
        })

    })
</script>
</html>




