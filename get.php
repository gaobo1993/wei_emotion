<?php
require 'tool.php';
@header("Content-Type:text/html;charset=utf-8");
$uid = $_GET['uid'];
$key = $_GET['keywords'];
$mysqli = new mysqli("10.9.1.188", "LW70AGqB1OOFgzAO", "HJmN4DfBEnQ0ajEH", "cf_e61290b4_5735_47e5_891e_d13c3a00d3e3");
if (mysqli_connect_error()) {
    die('Connect Error('.mysqli_connect_errno() .')'.mysqli_connect_error());
}
//show posts
$query = "select num from users where id = ".$uid;
$num = 0;
$result = $mysqli->query($query);
if ($result->num_rows==1) {
    $row = $result->fetch_array();
    $num = $row[0];
}

$query = "select ";
for ($i=0; $i<$num-1; $i ++) {
    $query .= ("post".$i.",");
}
$query .= (" post".($num-1));
$query .= " from users where id=".$uid;
$result = $mysqli->query($query);
if ($result->num_rows>0) {
    $post_row = $result->fetch_array(MYSQLI_NUM);
}
var_dump($key);
if ($key == '1') {
    $query = "select keywords from users where id=".$uid;
    $reslut = $mysqli->query($query);
    if ($result->num_rows==1) {
        $keywords_row = $result->fetch_array();
        var_dump($keywords_row);
        $keywords = $keywords_row[0];
    }
    $ret = array("posts"=>$post_row, "keywords"=>$keywords);
    echo "<hr/>";
    echo $ret;
    echo "<hr/>";
} else {
    $ret = array("posts"=>$post_row);
}
echo JSON($ret);
$mysqli->close();
?>