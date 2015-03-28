<?php
@header("Content-Type:text/html;charset=utf-8");
require 'tool.php';
$mysqli = new mysqli("10.9.1.188", "LW70AGqB1OOFgzAO", "HJmN4DfBEnQ0ajEH", "cf_e61290b4_5735_47e5_891e_d13c3a00d3e3");
if (mysqli_connect_error()) {
    die('Connect Error('.mysqli_connect_errno() .')'.mysqli_connect_error());
}
//show all users
$query = "select uid, screen_name from users";
if ($stmt = $mysqli->prepare($query)) {
    $stmt->execute();
    $stmt->bind_result($id, $screen_name);
    while ($stmt->fetch()) {
        $return[$id] = $screen_name;
    }
    $stmt->close();
} else {
    $return['result']='error';
    $return[$mysqli->errno] = $mysqli->error;
}
$mysqli->close();
echo JSON($return);
?>