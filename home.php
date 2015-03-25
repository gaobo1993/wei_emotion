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
$url = "https://api.weibo.com/oauth2/access_token?client_id=3128512954&client_secret=f4b76f3f0ebf32b31e06748cb10b6327&grant_type=authorization_code&redirect_uri=weiconnect.coding.net/home.php&code=" . $code;
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_POST, 1);
$data = curl_exec($curl);
curl_close($curl);
var_dump($data);


?>
</body>
</html>