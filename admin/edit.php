<?php
/**
 * Created by PhpStorm.
 * User: 16773
 * Date: 2018/12/29
 * Time: 16:16
 */

header("content-type:text/html;charset=utf-8");
require_once "../lib/util.php";

$user = null;

$userId = isset($_GET['id']) && is_numeric($_GET['id']) ? intval($_GET['id']): "";

if (!$userId){
    echo "<script>alert('参数非法');window.location.href='index.php';</script>";exit;
}
$con = mysqlInit();
mysqli_set_charset($con, "utf-8");

$sql = "select * from `user` where `id` = '{$userId}'";
$obj = mysqli_query($con, $sql);
$user = mysqli_fetch_assoc($obj);
//var_dump($user);
if(!$user){
    echo "<script>alert('用户不存在');window.location.href='index.php';</script>";exit;
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>用户信息</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/add.css">
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php">
                用户详细信息
            </a>
        </div>
    </div>
</nav>
<div class="container">
    <div class="jumbotron">
        <h1>Welcome, Super_admin!</h1>
        <p>请小心的修改用户信息，要是修改错误就不好了。。。</p>
    </div>
    <div class="page-header">
        <h3><small>编辑</small></h3>
    </div>
    <form class="form-horizontal" action="do_edit.php" method="post">
<!--        //隐氏提交id-->
        <input type="hidden" name="id" id="id" value="<?php echo $user['id'] ?>">
        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">用户名 ：</label>
            <div class="col-sm-8">
                <input name="username" class="form-control" id="username" value="<?php echo $user['username'] ?>" disabled="disabled">
            </div>
        </div>
        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">用户权限 ：</label>
            <div class="col-sm-8">
                <input name="status" class="form-control" id="status" value="<?php echo $user['status'] ?>">
            </div>
        </div>
        <div class="form-group">
            <label for="name" class="col-sm-2 control-label">用户随机码 ：</label>
            <div class="col-sm-8">
                <input name="seed" class="form-control" id="seed" value="<?php echo $user['seed'] ?>" disabled="disabled">
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-primary">保存</button>&nbsp;&nbsp;&nbsp;
            </div>
        </div>
    </form>
</div>
<footer class="text-center" >
    中美贸易战20162612叶子剑
</footer>
</body>
</html>

