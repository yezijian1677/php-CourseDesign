<?php
/**
 * Created by PhpStorm.
 * User: 16773
 * Date: 2018/12/1
 * Time: 15:37
 */
header("content-type:text/html;charset=utf-8");

//开启session
session_start();
require_once "./lib/util.php";

//如果session中不存在登录信息或者信息为空，则进行登录,执行表单处理
if (!isset($_SESSION["user"])||empty($_SESSION["user"])){
    echo "<script>alert('请登录');window.location.href='login.php';</script>";exit;
}

$user = $_SESSION['user'];

//因为此页是编辑页面，大部分都和发布页面相同，但是需要带上新闻的id,通过url传参可以直接用get方式获取
//获取newsId, 判断集合里是否有id且是不是一个数字，是的话返回id数字，否则返回空
$newsId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']): "";

//如果为空
if (!$newsId){
    echo "<script>alert('参数非法');window.location.href='index.php';</script>";exit;
}

//根据商品信息查询商品信息
$con = mysqlInit();
mysqli_query($con, "set names utf-8");
$sql = "select * from `news` where `id` = {$newsId}";
$obj = mysqli_query($con, $sql);
//如果根据id查询不到资讯，就跳转回index页
if(!$news = mysqli_fetch_assoc($obj)){
    echo "<script>alert('资讯不存在');window.location.href='index.php';</script>";exit;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>编辑资讯</title>
    <link type="text/css" rel="stylesheet" href="./static/css/common.css">
    <link type="text/css" rel="stylesheet" href="./static/css/add.css">
    <link type="text/css" rel="stylesheet" href="./static/css/slide.css">
</head>
<body>
<nav class="header">
    <div class="title" onclick="window.open('login.php')">
        中美贸易战
    </div>
    <div class="auth">
        <ul>
            <li><span>管理员: <?php echo $user['username']?></span></li>
            <li><a href="#">退出</a></li>
        </ul>
    </div>
</nav>

<section class="content">
    <div class="addwrap">
        <div class="addl fl">
            <header>发布资讯</header>
            <form name="release-form" id="release-form" action="do_edit.php" method="post"
                  enctype="multipart/form-data">
<!--                隐藏的发送资讯的id，用于提交资讯信息-->
                <input type="hidden" name="id" value="<?php echo $news["id"] ?>">
                <div class="additem">
                    <label id="for-title">新闻标题</label><input type="text" value="<?php echo $news["title"] ?>" name="title" id="title" placeholder="请输入资讯标题">
                </div>
                <div class="additem">
                    <label id="for-author">原文作者</label><input type="text" value="<?php echo $news["author"] ?>" name="author" id="author" placeholder="请输入原文作者">
                </div>
                <div class="additem">
                    <!-- 使用accept html5属性 声明仅接受png gif jpeg格式的文件                -->
                    <label id="for-file">选择图片</label><input type="file" accept="image/png,image/gif,image/jpeg,image/jpg" id="file" name="file">
                </div>
                <div class="additem textwrap">
                    <label class="ptop" id="for-des">资讯简介</label>
                    <textarea class="des" id="des" name="des" placeholder="请输入资讯简介"><?php echo $news["content_short"] ?></textarea>
                </div>
                <div class="additem textwrap">
                    <label class="ptop" id="for-content">资讯详情</label>
                    <div id="container">
                        <textarea class="detail" id="content" name="content"><?php echo $news["content_detail"] ?></textarea>
                    </div>

                </div>
                <div style="margin-top: 20px">
                    <button type="submit">发布</button>
                    <button type="button" onclick="window.location.href='index.php'">取消编辑</button>
                </div>

            </form>
        </div>
        <div class="addr fr">
            <img src="./static/image/CUF.jpg" style="height: 732px; width: 400px">
        </div>
    </div>

    <div id="volet_clos">
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
    </div>

</section>
<div class="footer">
    <p><span>中美贸易战</span>2018年中美贸易争端</p>
</div>
</body>
<script src="./static/js/jquery-3.3.1.min.js"></script>
<script>
    $(function () {
        $('#release-form').submit(function () {
            var title = $('#title').val(),
                author = $('#author').val(),
                file = $('#file').val(),
                des = $('#des').val(),
                content = $('#content').val();

            if (title.length <= 0 || title.length > 30) {
                alert("标题不符合规范");
                $('#title').focus();
                return false;
            }

            if (author.length <= 0 || author.length > 30) {
                alert("原文作者不符合规范");
                $('#author').focus();
                return false;
            }
            //
            // if (file == '' || file.length <= 0) {
            //     alert("请选择图片");
            //     $('#file').focus();
            //     return false;
            //
            // }

            if (des.length <= 0 || des.length >= 100) {
                alert("简介过长");
                $('#des').focus();
                return false;
            }

            if (content.length <= 0) {
                alert("请输入资讯详情");
                $('#content').focus();
                return false;
            }
            return true;

        })
    })
</script>
</html>

