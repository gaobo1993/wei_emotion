<!DOCTYPE html>
<html>
<head>
    <meta property="wb:webmaster" content="3df8a9a1aa580df4" />
    <meta charset="UTF-8">
    <title>WeiConnet</title>
</head>
<body>
It works!
<br/>

<?php
$code = $_GET['code'];
echo $code;

$url = "https://api.weibo.com/oauth2/access_token?client_id=3128512954&client_secret=f4b76f3f0ebf32b31e06748cb10b6327&grant_type=authorization_code&redirect_uri=weiconnect.coding.io/home.php&code=" . $code;
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$json = curl_exec($curl);
curl_close($curl);
$obj = json_decode($json);
var_dump($obj);
$token = $obj->access_token;
$uid = $obj->uid;
//get user information
$url = "https://api.weibo.com/2/users/show.json?access_token=" . $token."&uid=" . $uid;
echo "<hr/>";
echo $url;
echo "<hr/>";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$json = curl_exec($curl);
curl_close($curl);
?>

<table border="1px">
<tr><th>property</th><th>value</th></tr>
<?php
$array = json_decode($json, true);
foreach ($array as $x=>$x_value) {
    echo "<tr><td>".$x."</td><td>".$x_value."</td></tr>";
}
?>
</table>

</body>
</html>