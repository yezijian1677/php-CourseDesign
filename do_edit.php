<?php
/**
 * Created by PhpStorm.
 * User: 16773
 * Date: 2018/12/2
 * Time: 18:21
 */
header("content-type:text/html;charset=utf-8");

//开启session
session_start();
require_once "./lib/util.php";

//如果session中不存在登录信息或者信息为空，则进行登录,执行表单处理
if (!isset($_SESSION["user"])||empty($_SESSION["user"])){
    echo "<script>alert('请登录');window.location.href='login.php';</script>";exit;
}
$user = $_SESSION["user"];

//表单提交，如果不是post方法提交过来的，即可能是url访问过来的就产生报错
if (!empty($_POST["title"])){
    //连接数据库
    $con = mysqlInit();
    mysqli_query($con,"set names utf-8");

    //如果资讯id不存在就跳转
    if ( !$newsId = intval($_POST['id'])){
        echo "<script>alert('参数非法');window.location.href='index.php';</script>";exit;
    }
//    var_dump("This is".$newsId);

    //根据资讯id校验资讯
    $sql = "select * from `news` where `id` = {$newsId}";
    $obj = mysqli_query($con, $sql);
    //如果根据id查询不到资讯，就跳转回index页
    if(!$news = mysqli_fetch_assoc($obj)){
        echo "<script>alert('资讯不存在');window.location.href='index.php';</script>";exit;
    }

    //获取表单的提交
    $title = trim($_POST["title"]);
//    var_dump($title);
    $author = trim($_POST["author"]);
//    var_dump($author);
    $des = trim($_POST["des"]);
//    var_dump($des);
    $content = trim($_POST["content"]);
//    var_dump($content);
    //当前时间
    $now = $_SERVER["REQUEST_TIME"];

    //当用户选择修改图片的时候才上传图片，var_dump查看信息，file的路径不为空就是上传

    $file = $_FILES['file'];
//    var_dump($file['error']);
    if ($file['error'] == 0){

        //检查上传文件是否合法,如果不是合法，弹出提示
        if (!is_uploaded_file($file['tmp_name'])){
            echo "<script>alert('上传文件需要符合规范')</script>";
        }
        //上传目录 这个是物理地址 访问不到
        $uploadPath = "./static/file/";
        //上传访问地址 通过url访问
        $uploadUrl = '/static/file/';
        //获取上传文件的扩展名
        $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
        //随机生成名字防止文件重复而产生覆盖
        $img = mt_rand(0,5000).".".$ext;

        $imgPath = $uploadPath.$img;
        $imgUrl = "http://localhost/trade/".$uploadUrl.$img;

        //如果操作失败
        if (!move_uploaded_file($file['tmp_name'], $imgPath)){
            echo "<script>alert('上传文件失败')</script>";
        }

        //图片路径
        $pic = $imgUrl;
        //如果修改了图片文件，才会有pic路径这个文件，所以要动态设置上sql语句，否则会报错
        $sql = "update `news` set `title`= '{$title}', `author`='{$author}', `pic`='{$pic}', `content_short`='{$des}', `content_detail`='{$content}',
            `update_time`= '{$now}' where `id` = '{$newsId}'";
    } else {
        $sql = "update `news` set `title`= '{$title}', `author`='{$author}',`content_short`='{$des}', `content_detail`='{$content}',
            `update_time`= '{$now}' where `id` = '{$newsId}'";
    }

    $result = mysqli_query($con, $sql);
//    var_dump($result);
    //如果更新成功
    if ($result){
        echo "<script>alert('操作成功');window.location.href='detail.php?id={$newsId}';</script>";exit;
    }
    else{
        echo "<script>alert('操作失败');window.location.href='edit.php?id={$newsId}';</script>";exit;
    }


} else {
    echo "<script>alert('访问非法');window.location.href='index.php';</script>";exit;
}



?>