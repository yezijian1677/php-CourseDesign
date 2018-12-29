<?php
/**
 * Created by PhpStorm.
 * User: 16773
 * Date: 2018/12/29
 * Time: 17:11
 */
header("content-type:text/html;charset=utf-8");
require_once "../lib/util.php";

//表单处理
if (!empty($_POST["id"])) {
    //连接数据库
    $con = mysqlInit();

    $id = filter_var($_POST["id"], FILTER_VALIDATE_INT);
    $status = filter_var($_POST["status"], FILTER_VALIDATE_INT);
    var_dump($id, $status);

    if (!$id&&!$status){
        echo "<script>alert('输入不合法不符合规范');</script>";exit;
    }

    $sql = "update `user` set `status` = '{$status}' where `id` = '{$id}' ";
    if ($obj = mysqli_query($con, $sql)){
        echo "<script>alert('用户修改成功');window.location.href='index.php';</script>";exit;
    } else {
        echo mysqli_error();exit;
    }
}
?>