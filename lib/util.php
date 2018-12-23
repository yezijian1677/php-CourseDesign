<?php
/**
 * Created by PhpStorm.
 * User: 16773
 * Date: 2018/12/1
 * Time: 13:32
 */

/**
 * @return bool|mysqli
 *
 * 访问数据库
 */
function mysqlInit(){
    //对数据库进行操作
    $con = mysqli_connect("localhost","root","admin", "trade");
    if (!$con){
        return false;
    }

    return $con;
}