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
      <ul class="nav navbar-nav navbar-right well-sm">
        <li><wb:login-button type="3,2" onlogout="logout">登录按钮</wb:login-button>            </li>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>


<?php
require 'tool.php';
require 'emoji.php';
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
        $create = "create table users(uid bigint not null primary key, screen_name varchar(50),keywords longtext) default charset=utf8";
        if (!$mysqli->query($create))
            echo "create users error".$mysqli->error;
    }
} else {echo "query users table error".$mysqli->error;}
$query = "show tables like 'posts'";
if ($result = $mysqli->query($query)) {
    if ($result->num_rows==0) {
        $create = "create table posts(uid bigint not null, post longtext) default charset=utf8";
        if (!$mysqli->query($create))
            echo "create posts error".$mysqli->error;
    }
} else {echo "query posts table error".$mysqli->error;}

//insert user info
$screen_name = $user_array['screen_name'];
$id = $user_array['id'];

//delete weibo posts if exists
$query="delete from posts where uid=".$uid;
if (!$mysqli->query($query)) {
    echo "delete posts failed".$mysqli->errno.":".$mysqli->error;
}

//get weibo text
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
    str_replace("'","''",$content);
    $content = emoji_unified_to_html($content);
    $query = "insert into posts(uid, post) values(?,?)";
    if ($stmt = $mysqli->prepare($query)) {
        $stmt->bind_param("is", $id, $content);
        $stmt->execute();
        $stmt->close();
    } else { echo "fail to insert into posts".$mysqli->errno.":".$mysqli->error;}
    $all .= $content;
}
$process = str_replace('/', ' ', $all);
$process = preg_replace('[a-zA-Z]', ' ', $process);
$keywords = getkeywords($process);
$query = "insert into users(uid, screen_name, keywords) values (?,?,?)";
if ($stmt = $mysqli->prepare($query)) {
    $stmt->bind_param("iss", $id, $screen_name, $keywords);
    $stmt->execute();
    $stmt->close();
} else {
echo "fail to insert into table".$mysqli->errno.":".$mysqli->error;
}

$mysqli->close();

?>
<br/>

<h5><b>关键词</b>

<?php
$keywords_array = split(',',$keywords);
for ($i=0; $i<count($keywords_array); $i++) {
    if (count($keywords_array[$i])>0) {
        echo '<span class="label label-info">'.$keywords_array[$i].'</span>&nbsp;';
    }
}

?>
<h5/>

<hr/>
<div class="panel">
<div class="panel-heading middle">
    <h3>近期微博内容</h3>
</div>
<div class="panel-body">
<ul class="list-group">
<?php
for ($i=0; $i<count($posts); $i++) {
    echo '<li class="list-group-item">'.$posts[$i].'</li>';
}
?>
</ul>
</div>
</div>

<script>
function logout() {
    window.location.href="http://weiconnect.coding.io";
}
</script>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>