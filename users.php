<?php
echo "here all users";
$mysqli = new mysqli("10.9.1.188", "LW70AGqB1OOFgzAO", "HJmN4DfBEnQ0ajEH", "cf_e61290b4_5735_47e5_891e_d13c3a00d3e3");
if (mysqli_connect_error()) {
    die('Connect Error('.mysqli_connect_errno() .')'.mysqli_connect_error());
}
//show all users
$query = "select * from users";
if ($stmt = $mysqli->prepare($query)) {
    $stmt->execute();
    $stmt->bind_result($id, $screen_name);
    while ($stmt->fetch()) {
        printf("%d %s\n", $id, $screen_name);
    }
    $stmt->close();
} else {
echo "fail to lookup table".$mysqli->errno.":".$mysqli->error;
}

$mysqli->close();
?>