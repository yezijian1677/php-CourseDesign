<?php
/**
 * Created by PhpStorm.
 * User: 16773
 * Date: 2018/12/28
 * Time: 11:17
 */

header("content-type:text/html;charset=utf-8");
session_start();
$login = false;
if (!isset($_SESSION["user"])||empty($_SESSION["user"])){
    echo "<script>alert('请登录');window.location.href='login.php';</script>";exit;
}else{
    $login = true;
    $user = $_SESSION['user'];
    $nickname_user = '用户';
    $nickname_admin = '管理员';
    $status_name = $user['status'] > 0 ? $nickname_user:$nickname_admin;
}



?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>修改密码</title>
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
    <div class="auth">
        <ul>
            <?php if ($login == false):?>
                <li><a href="login.php">登录</a></li>
                <li><a href="register.php">注册</a></li>
                <li><a href="board_detail.php">评论区</a></li>
            <?php else: ?>
                <li><span><?php echo $status_name?> : <?php echo $user['username']?></span></li>
                <!--                //如果是管理员才有发布功能-->
                <?php if ($user['status']==0):?>
                    <li><a href="release.php">发布</a></li>
                <?php endif;?>
                <li><a href="board_detail.php">评论区</a></li>
                <li><a href="logout.php">退出</a></li>
            <?php endif;?>
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
                        <p>个人信息</p>
                    </div>
                    <form class="login-table" name="user-form" id="user-form" action="do_changepassword.php" method="post">
                        <div class="login-left">
                            <label class="username">用户名</label>
                            <input value="<?php echo $user['username']?>" disabled="disabled" required="required" type="text" class="yhmiput" name="username" placeholder="请输入用户名" id="username">
                        </div>
                        <div class="login-right">
                            <label class="passwd">密码</label>
                            <input required="required" type="password" class="yhmiput" name="oldpassword" placeholder="请输入原始密码" id="oldpassword">
                        </div>
                        <div class="login-right">
                            <label class="passwd">新密</label>
                            <input required="required" type="password" class="yhmiput" name="newpassword" placeholder="请输入新密码"
                                   id="newrepassword">
                        </div>

                        <div class="login-btn">
                            <button type="submit">保存</button>
                            <button type="button" onclick="window.location.href='index.php'">取消修改</button>
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
        $('#user-form').submit(function () {
            var oldpassword = $('#oldpassword').val(),
                newpassword = $('#newrepassword').val();
            if (oldpassword == '' || username.length <= 0) {
                alert("原始密码不能为空");
                $('#oldpassword').focus();
                return false;
            }

            if (newpassword == '' || password.length <= 0) {
                alert("新密码不能为空");
                $('#newrepassword').focus();
                return false;
            }
            return true;
        })

    })
</script>
</html>




