<?php
/**
 * Created by PhpStorm.
 * User: 16773
 * Date: 2018/12/1
 * Time: 11:02
 */

header("content-type:text/html;charset=utf-8");
//开启session
session_start();
require_once "./lib/util.php";
$con = mysqlInit();
mysqli_set_charset($con, "utf-8");

$stars = null;
//如果session中不存在登录信息或者信息为空，登录状态为false，否则为true,并且返回session里的数据
if (!isset($_SESSION["user"])||empty($_SESSION["user"])){
    $login = false;
} else {
    $login = true;
    $user = $_SESSION['user'];
    $nickname_user = '用户';
    $nickname_admin = '管理员';
    $status_name = $user['status'] > 0 ? $nickname_user:$nickname_admin;

    //查询收藏列表
    unset($sql, $obj, $result);
    $sql = "select * from `star` where `username` = '{$user['username']}'";
    $obj = mysqli_query($con, $sql);
    while ($result = mysqli_fetch_assoc($obj)){
        $stars[] = $result;
//        var_dump($stars);
    }

}
unset($sql, $obj, $result);
//表示从数据中取出news，按照id递减的顺序，以及浏览次数递减的顺序排列
$sql = "select `id`, `title`, `content_short`, `pic` from `news` order by `id` desc, `view` desc";

$obj = mysqli_query($con, $sql);

while ($result = mysqli_fetch_assoc($obj)){
    $news[] = $result;
}
//var_dump($news);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>首页</title>
    <link rel="stylesheet" type="text/css" href="./static/css/common.css" />
    <link rel="stylesheet" type="text/css" href="./static/css/index.css" />
    <link rel="stylesheet" type="text/css" href="./static/css/slide.css" />
    <link rel="stylesheet" type="text/css" href="./static/css/slide-right.css" />
    <link rel="stylesheet" type="text/css" href="./static/css/slide-right-down.css" />
    <link rel="stylesheet" type="text/css" href="./static/css/board.css" />
</head>
<body>
<nav class="header">
    <a name="top"></a>
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
    <!--  首页的banner  -->
    <div class="banner">
        <img class="banner-img" id="turn_img" src="./static/image/1.jpg" alt="图片描述">
        <!--        页面banner的信息-->
        <div class="section1_meta">
            <p class="_title">中美贸易战</p>
            <p class="_subTitle">China与US之间的一场贸易争端</p>
            <?php if ($login == false): ?>
            <div class="_subBtn" onclick="window.open('login.php')">
                登录了解更多
            </div>
            <?php endif; ?>
        </div>
    </div>

    <video controls  width="358px">
        <source src="./static/video/1.mp4" type="video/webm">
    </video>

    <video controls  width="358px" style="margin-left: 58px;">
        <source src="./static/video/2.mp4" type="video/webm">
    </video>

    <video controls  width="358px" style="float: right;">
        <source src="./static/video/3.mp4" type="video/webm">
    </video>

    <div class="img-content">
        <ul>
            <?php if (sizeof($news)!=0): ?>
                <?php foreach ($news as $n):?>
                    <li>
                        <img class="" src="<?php echo $n["pic"] ?>" alt="<?php echo $n["title"] ?>">
                        <div class="info">
                            <a href="detail.php?id=<?php echo $n["id"] ?>">
                                <h3 class="img_title"><?php echo $n["title"] ?></h3>
                            </a>
                            <p>
                                <?php echo $n["content_short"] ?>
                            </p>
                            <?php if ($login == true && $user['status'] == 0): ?>
                            <div class="btn">
                                <a href="edit.php?id=<?php echo $n["id"] ?>" class="edit">编辑</a>
                                <a href="delete.php?id=<?php echo $n["id"] ?>" class="del">删除</a>
                            </div>
                            <?php else: ?>
                            <div class="btn">
                                <a href="detail.php?id=<?php echo $n["id"] ?>" class="star">查看详情</a>
                            </div>
                            <?php endif;?>
                        </div>
                    </li>
                <?php endforeach;?>
            <?php endif; ?>
        </ul>
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

    <?php if ($login == true):?>
    <aside id="volet_clos2" style="text-align: center;">
        <div id="volet2">
            <div class="login_tips">Profile<a href="userInfo.php" style="margin-left: 150px; color: white; font-size: 12px;">个人资料</a></div>
            <div class="user_info">
                <div class="user_avatar"><img src="./static/image/useravatar.jpg" style="height: 78px;width: 78px; border-radius: 50%;border: 3px solid #00C78C;"></div>
                <p class="user_name"><?php echo $user['username']?></p>
                <article class="user_desc" id="user_desc" onclick="edit()">
                    <?php echo $user['desc']?>
                </article>
            </div>
            <div class="user_func">
                <a href="changepassword.php" class="update">修改密码</a>
                <a href="#volet3" class="star">我的关注</a>
            </div>
            <a href="#volet2" class="ouvrir" aria-hidden="true">个人信息</a>
            <a href="#volet_clos2" class="fermer" aria-hidden="true">隐藏信息</a>
        </div>

    </aside>
    <?php endif;?>
<!--关注窗口-->
    <?php if ($login == true):?>
        <aside id="volet_clos3" style="text-align: center;">
            <div id="volet3">
                <div class="login_tips">My Star</div>
                <?php if (sizeof($stars)==0): ?>
                    <p style="margin-top: 30px;height: 25px;color: darkblue; font-size: 15px;font-weight: bold;">您还没有收藏喔</p>
                <?php else: ?>
                    <?php foreach ($stars as $s):?>
                        <div class="star_title star_1"><a href="detail.php?id=<?php echo $s['newsId'] ?>"><?php echo $s["title"] ?></a></div>
                    <?php endforeach;?>
                <?php endif; ?>


                <a href="#volet3" class="ouvrir" aria-hidden="true">我的关注</a>
                <a href="#volet_clos3" class="fermer" aria-hidden="true">隐藏关注</a>
            </div>

        </aside>
    <?php endif;?>

    <section class="board">
        <form name="board-form" id="board-form" action="board.php" method="post" class="white-pink">
            <h1>你的想法
                <span>说出你想说的.</span>
            </h1>
            <label>
                <span>你的名字 :</span>
                <input id="name" type="text" name="name" placeholder="输入名字" />
            </label>
            <label>
                <span>邮箱 :</span>
                <input id="email" type="email" name="email" placeholder="邮箱地址" />
            </label>

            <label>
                <span>想说的话 :</span>
                <textarea id="message" name="message" placeholder="想说啥啊你"></textarea>
            </label>
            <label>
                <span> 性别 :</span><select name="selection">
                    <option value="1">男</option>
                    <option value="2">女</option>
                </select>
            </label>
            <label>
                <span>&nbsp;</span>
                <input type="submit" class="button" value="发送" />
            </label>
        </form>
    </section>

</section>

<a class="goTop"><img src="./static/image/timg.jpg"/></a>

<section>


</section>

<footer class="footer">

    <p><span>中美贸易战</span>2018年中美贸易争端</p>

</footer>
</body>
<script src="./static/js/jquery-3.3.1.min.js"></script>
<script>
    function edit(){
        document.getElementById("user_desc").setAttribute("contentEditable", "true");
    }
    $(function () {
       $(".del").on("click", function () {
         if (confirm("确认删除改资讯吗？")){
             //确认后再用url跳转
             window.location = $(this).attr("href");
         }
         return false;
       });


       //置顶图标的显示与隐藏
       $(window).scroll(function () {
           //获取已经滚动的高度
           var windowScrollTop = $(window).scrollTop();
           var tool = $(".goTop");
           //如果滚动大于100px则显示出回到顶部，否则不显示
           if (windowScrollTop > 100){
               tool.fadeIn();
           } else {
               tool.fadeOut();
           }
       });

       $(".goTop").click(function () {
           //点击回到顶部，动画效果
           $("html, body").animate({scrollTop:0},1000);
       });

    });


    //导航栏图片的切换
    window.onload = changeImg();

    function changeImg(){
        var path_prev = "./static/image/";
        var path_suffix = ".jpg";
        var index = 1;
        var size = 3;
        var timer = setInterval(function(){
            index++;
            if(index > size){
                index = 1;
            }
            var path = path_prev+index+path_suffix;//拼装的图片路径
            document.getElementById("turn_img").setAttribute("src", path);
        },4500);

    }

    //对下面留言板的获取
    $(function () {
        $('#board-form').submit(function () {
            var name = $('#name').val(),
                email = $('#email').val(),
                content = $('#message').val();

            if (name.length <= 0 || name.length > 30) {
                alert("名字不符合规范");
                $('#name').focus();
                return false;
            }

            if (email.length <= 0 || email.length > 30) {
                alert("邮箱不符合规范");
                $('#email').focus();
                return false;
            }

            if (content.length <= 0) {
                alert("请输入评论");
                $('#message').focus();
                return false;
            }
            return true;

        })
    })
</script>
</html>

