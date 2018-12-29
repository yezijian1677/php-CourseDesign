<?php
/**
 * Created by PhpStorm.
 * User: 16773
 * Date: 2018/12/29
 * Time: 15:35
 */

header("content-type:text/html;charset=utf-8");
require_once "../lib/util.php";
$con = mysqlInit();
mysqli_set_charset($con, "utf-8");
$users = null;
$sql = "select * from `user` order by `create_time`";

$obj = mysqli_query($con, $sql);

while ($result = mysqli_fetch_assoc($obj)){
    $users[] = $result;
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>用户列表</title>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>

<body>
<header>
    <nav>中美贸易战注册用户管理系统</nav>
</header>
<section class="banner">
    <div class="container">
        <div>
            <h1>Controller</h1>
            <p>用户列表</p>
        </div>
    </div>
</section>
<section class="main">
    <div class="container">
        <table class="table table-striped">
            <thead>
            <tr>
                <th>id</th>
                <th>姓名</th>
                <th>用户权限</th>
                <th>用户随机码</th>
            </tr>
            </thead>
            <tbody>
            <?php if (sizeof($users)==0): ?>
                <tr>无用户</tr>
            <?php else: ?>
                <?php foreach ($users as $u):?>
                    <tr>
                        <td><?php echo $u['id'] ?></td>
                        <td><?php echo $u['username'] ?></td>
                        <td><?php echo $u['status'] ?></td>
                        <td><?php echo $u['seed'] ?></td>
                        <td>

                            <a href="edit.php?id=<?php echo $u['id'] ?>" >修改</a>&nbsp;&nbsp;
                            <a href="delete.php?id=<?php echo $u['id'] ?>" >删除</a>

                        </td>
                    </tr>
                <?php endforeach;?>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<footer>
    中美贸易战20162612叶子剑
</footer>
</body>
</html>
