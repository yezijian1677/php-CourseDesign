<?php
/**
 * Created by PhpStorm.
 * User: 16773
 * Date: 2018/12/21
 * Time: 19:15
 */
header("content-type:text/html;charset=utf-8");
require_once "./lib/util.php";
$con = mysqlInit();
//表示从数据中取出news，按照id递减的顺序，以及浏览次数递减的顺序排列
$sql = "select * from `board`";

$obj = mysqli_query($con, $sql);
mysqli_query($con, "set names utf-8 ");
while ($result = mysqli_fetch_assoc($obj)){
    $comment[] = $result;
}
//var_dump($comment);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>首页</title>
    <link rel="stylesheet" type="text/css" href="./static/css/common.css" />
    <link rel="stylesheet" type="text/css" href="./static/css/slide.css" />
    <link rel="stylesheet" type="text/css" href="./static/css/board_detail.css" />
</head>
<style>

</style>
<body>
<section>
<section class="comments">

    <?php if (sizeof($comment)!=0): ?>
        <?php foreach ($comment as $c):?>
            <div class="comment-wrap">
                <div class="photo">
                    <div class="avatar" style="background-image: url('./static/image/avatar.jpg')"></div>
                </div>
                <div class="comment-block">
                    <p class="comment-text"><?php echo $c["content"] ?></p>
                    <div class="bottom-comment">
                        <ul class="comment-actions">
                            <li class="complain">超级</li>
                            <li class="reply">聪明</li>
                        </ul>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    <?php else: ?>
        <div class="comment-wrap">
            <div class="photo">
                <div class="avatar" style="background-image: url('./static/image/avatar.jpg')"></div>
            </div>
            <div class="comment-block">
                <p class="comment-text">超级帅气的我没有发现留言，孩子，快去添加留言吧</p>
                <div class="bottom-comment">
                    <ul class="comment-actions">
                        <li class="complain">超级</li>
                        <li class="reply">聪明</li>
                    </ul>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <input class="back" type="button" value="返回" onclick="window.location.href='index.php'">

</section>

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

    <a class="goTop"><img src="./static/image/timg.jpg"/></a>

</section>

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
