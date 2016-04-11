<?php
@header("Content-Type:text/html;charset=utf-8");
require 'tool.php';
$uid = $_GET['uid'];
$mysqli  = new mysqli("10.9.1.188", "qL8LQMhtBDyQgd0b", "JSfUTPlC0R3DthnG", "cf_afa98478_964a_43f8_a1c5_8193bff83c4e");
if (mysqli_connect_error()) {
    die('Connect Error('.mysqli_connect_errno() .')'.mysqli_connect_error());
}
//show all users
$query = "select emotions from users where uid=".$uid;
$emotion_row = array();
$result = $mysqli->query($query);
if($result->num_rows > 0){
    while ($row = $result->fetch_row()) {
        array_push($emotion_row, $row[0]);
    }
}
$return = array("emotions" => $emotion_row);
$mysqli->close();
echo JSON($return);
?>