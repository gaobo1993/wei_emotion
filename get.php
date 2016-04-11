<?php
require 'tool.php';
@header("Content-Type:text/html;charset=utf-8");
$uid = $_GET['uid'];
$key = $_GET['keywords'];
$mysqli mysqli("10.9.1.188", "qL8LQMhtBDyQgd0b", "JSfUTPlC0R3DthnG", "cf_afa98478_964a_43f8_a1c5_8193bff83c4e");
if (mysqli_connect_error()) {
    die('Connect Error('.mysqli_connect_errno() .')'.mysqli_connect_error());
}
//show posts
$query = "select post from posts where uid=".$uid;
$num = 0;
$post_row = array();
$result = $mysqli->query($query);
if ($result->num_rows>0) {
    while ($row = $result->fetch_row()) {
        array_push($post_row, $row[0]);
    }
}
if ($key == '1') {
    $query = "select keywords from users where uid=".$uid;
    $result = $mysqli->query($query);
    if ($result->num_rows>0) {
        $keywords_row = $result->fetch_array();
        $keywords = $keywords_row[0];
    }
    $ret = array("posts"=>$post_row, "keywords"=>$keywords);
} else {
    $ret = array("posts"=>$post_row);
}
if (count($post_row) > 0)
    echo JSON($ret);
$mysqli->close();
?>