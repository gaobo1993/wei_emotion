<?php
@header("Content-Type:text/html;charset=utf-8");
require 'tool.php';
$mysqli mysqli("10.9.1.188", "qL8LQMhtBDyQgd0b", "JSfUTPlC0R3DthnG", "cf_afa98478_964a_43f8_a1c5_8193bff83c4e");
if (mysqli_connect_error()) {
    die('Connect Error('.mysqli_connect_errno() .')'.mysqli_connect_error());
}
//show all users
$query = "select uid, screen_name from users";
echo "Show users";
$return = array();
if ($stmt = $mysqli->prepare($query)) {
    $stmt->execute();
    $stmt->bind_result($id, $screen_name);
    while ($stmt->fetch()) {
        $person['uid'] = $id;
        $person['screen_name'] = $screen_name;
        array_push($return, $person);
    }
    $stmt->close();
} else {
    $return['result']='error';
    $return[$mysqli->errno] = $mysqli->error;
}
$mysqli->close();
// echo $return;
echo JSON($return);
?>