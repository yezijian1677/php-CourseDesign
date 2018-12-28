<?php
/**
 * Created by PhpStorm.
 * User: 16773
 * Date: 2018/12/3
 * Time: 18:32
 */
header("content-type:text/html;charset=utf-8");
//开启session
session_start();
include_once "./lib/util.php";

//定义是否被收藏
$hadStar = false;
$con = mysqlInit();


//获取newsId, 判断集合里是否有id且是不是一个数字，是的话返回id数字，否则返回空
$newsId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']): "";
if (!$newsId){
    echo "<script>alert('参数非法');window.location.href='index.php';</script>";exit;
}

//如果session中不存在登录信息或者信息为空，登录状态为false，否则为true,并且返回session里的数据
if (!isset($_SESSION["user"])||empty($_SESSION["user"])){
    $login = false;
} else {
    $login = true;
    $user = $_SESSION['user'];


//查询用户是否收藏
    unset($sql, $obj);
    $sql = "select * from `star` where `username`= '{$user['username']}' and `newsId` = '{$newsId}'";
    $obj = mysqli_query($con, $sql);
    $num = mysqli_fetch_array($obj);
//查询到有数据那么就被收藏了
    if ($num){
        $hadStar = true;
    }
}



mysqli_set_charset($con, "utf-8");
//根据商品信息查询商品信息
$sql = "select * from `news` where `id` = {$newsId}";
$obj = mysqli_query($con, $sql);
//如果根据id查询不到资讯，就跳转回index页
if(!$news = mysqli_fetch_assoc($obj)){
    echo "<script>alert('资讯不存在');window.location.href='index.php';</script>";exit;
}
//根据id获取发布人
unset($sql, $obj);
$sql = "select username from user where id =".$news['user_id'];
$obj = mysqli_query($con, $sql);
$username = mysqli_fetch_assoc($obj);
//更新浏览次数
unset($sql, $obj);
$sql = "update `news` set `view`=`view`+1 where `id` =".$newsId;
mysqli_query($con, $sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>资讯详情</title>
    <link rel="stylesheet" type="text/css" href="./static/css/common.css" />
    <link rel="stylesheet" type="text/css" href="./static/css/detail.css" />
    <link rel="stylesheet" type="text/css" href="./static/css/slide.css" />
</head>
<body class="bgf8">
<nav class="header">
    <div class="title" onclick="window.open('login.php')">
        中美贸易战
    </div>
    <div class="auth">
        <ul>
            <?php if ($login == false):?>
                <li><a href="login.php">登录</a></li>
                <li><a href="register.php">注册</a></li>
            <?php else: ?>
                <li><span><?php echo $user['username']?></span></li>
                <li><a href="release.php">发布</a></li>
                <li><a href="logout.php">退出</a></li>
            <?php endif;?>
        </ul>
    </div>
</nav>
<section class="content">

    <div class="section" style="margin-top:20px;">
        <div class="width1200">
            <div class="fl"><img src="<?php echo $news['pic'] ?>" width="720px" height="432px"/></div>
            <div class="fl sec_intru_bg">
                <dl>
                    <dt><?php echo $news['title'] ?></dt>
                    <dd>
                        <p>发布人：<span><?php echo $username["username"] ?></span></p>
                        <p>作者：<span><?php echo $news["author"] ?></span></p>
                        <p>发布时间：<span><?php echo  date("Y年m月d日",$news['create_time']) ?></span></p>
                        <p>修改时间：<span><?php echo  date("Y年m月d日",$news['update_time']) ?></span></p>
                        <p>浏览次数：<span><?php echo $news['view'] ?></span></p>
                    </dd>
                </dl>
                <ul>
<!--                    收藏与取消收藏-->
                    <?php if ($hadStar==false):?>
                    <li class="btn"><a href="star.php?id=<?php echo $newsId ?>" class="btn btn-sm-pink" style="margin-left:8px;">收藏</a></li>
                    <?php else: ?>
                    <li class="btn"><a href="unstar.php?id=<?php echo $newsId ?>" class="btn btn-sm-pink" style="margin-left:8px;">取关</a></li>
                    <?php endif;?>

                    <li class="btn"><a href="index.php" class="btn btn-sm-white" style="margin-left:8px;">返回首页</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="secion_words">
        <div class="width1200">
            <div class="secion_wordsCon">
                <p><?php echo $news['content_detail'] ?></p>
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

<a class="goTop" id="goTop"><img src="./static/image/timg.jpg"/></a>

<footer class="footer">
    <p><span>中美贸易战</span>2018年中美贸易争端</p>
</footer>
</body>

<script src="./static/js/jquery-3.3.1.min.js"></script>
<script>

    $(function () {
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

</script>
</html>


