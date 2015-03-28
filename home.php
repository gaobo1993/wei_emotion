<!DOCTYPE html>
<html xmlns:wb="http://open.weibo.com/wb">
<head>
    <meta property="wb:webmaster" content="3df8a9a1aa580df4" />
    <meta charset="UTF-8">
    <title>WeiConnet</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css"/>
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="http://tjs.sjs.sinajs.cn/open/api/js/wb.js?appkey=3128512954" type="text/javascript" charset="utf-8"></script>
</head>
<body style="background-color:#ebf5fa">
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header"  id="nav-head">
      <a class="navbar-brand" href="http://weiconnect.coding.io">WeiConnect</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav"  id="navs">
        <li class="active"><a href="http://weiconnect.coding.io">首页<span class="sr-only">(current)</span></a></li>
        <li><a href="http://weiconnect.coding.io/apis.php">API</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
        <li><wb:login-button type="3,2" onlogout="logout">登录按钮</wb:login-button>            </li>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>


<?php
require 'tool.php';
//get token and uid
$code = $_GET['code'];
$url = "https://api.weibo.com/oauth2/access_token?client_id=3128512954&client_secret=f4b76f3f0ebf32b31e06748cb10b6327&grant_type=authorization_code&redirect_uri=weiconnect.coding.io/home.php&code=" . $code;
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$json = curl_exec($curl);
curl_close($curl);
$obj = json_decode($json);
$token = $obj->access_token;
$uid = $obj->uid;
//get user information
$url = "https://api.weibo.com/2/users/show.json?access_token=" . $token."&uid=" . $uid;
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$json = curl_exec($curl);
curl_close($curl);
$user_array = json_decode($json, true);
// connect mysql database
$mysqli = new mysqli("10.9.1.188", "LW70AGqB1OOFgzAO", "HJmN4DfBEnQ0ajEH", "cf_e61290b4_5735_47e5_891e_d13c3a00d3e3");
if (mysqli_connect_error()) {
    die('Connect Error('.mysqli_connect_errno() .')'.mysqli_connect_error());
}
//create table
$query = "show tables like 'users'";
if ($result = $mysqli->query($query)) {
    if ($result->num_rows==0) {
        $create = "create table users(id bigint not null primary key, screen_name varchar(20),num int";
        for ($i =0; $i<100; $i ++) {
            $create .= (",post".$i." text");
        }
        $create .= ",keywords text) default charset=utf8";
        if (!$mysqli->query($create))
            echo "create error".$mysqli->error;
    }
} else {echo "query table error".$mysqli->error;}
//insert user info
$screen_name = $user_array['screen_name'];
$id = $user_array['id'];
$query = "insert into users(id, screen_name) values (?,?)";
if ($stmt = $mysqli->prepare($query)) {
    $stmt->bind_param("is", $id, $screen_name);
    $stmt->execute();
    $stmt->close();
} else {
echo "fail to insert into table".$mysqli->errno.":".$mysqli->error;
}
//get user posts and update the database
$query = "update users t ";
$query .= "set ";

$url = "https://api.weibo.com/2/statuses/user_timeline.json?access_token=".$token.
       "&uid=".$uid."&count=100&trim_user=1";
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
$json = curl_exec($curl);
curl_close($curl);
$obj = json_decode($json);
for ($i=0; $i<count($obj->statuses);$i ++) {
    $p = $obj->statuses[$i];
    $content = $p->text;
    if ($re = $p->retweeted_status) {
        $content .= $re->text;
    }
    $posts[$i] = $content;
    $query .= (" post".$i."=");
    $query .= ("'".$content."',");
    $all .= $content;
}
$query .= ("num = ".count($obj->statuses));
$query .= " where t.id =";
$query .= $uid;
if (!$mysqli->query($query)) {
    echo "update table error".$mysqli->errno.":".$mysqli->error;
}
$keywords = getkeywords(str_replace('/', '', $all));
$query = "update users t set keywords=? where t.id=".$uid;
if ($stmt = $mysqli->prepare($query)) {
    $stmt->bind_param("s", $keywords);
    $stmt->execute();
    $stmt->close();
} else {
    echo "fail to update keywords into table".$mysqli->errno.":".$mysqli->error;
}


$mysqli->close();

?>
<br/>
Welcome!<br/>

<h6>关键词<span class="label label-info">伯乐</span></h6>

<?php
echo '<img src="'.$user_array['profile_image_url'].'"alt="'.$screen_name.'">';
echo $screen_name;
echo "<br/>关键词：";
echo $keywords;
$keywords_array = split('，',$keywords);
echo $keywords_array;
?>


<hr/>
<ul class="list-group">
<?php
for ($i=0; $i<count($posts); $i++) {
    echo '<li class="list-group-item">'.$posts[$i].'</li>';
}
?>
</ul>

<script>
function logout() {
    window.location.href="http://weiconnect.coding.io";
}
</script>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>