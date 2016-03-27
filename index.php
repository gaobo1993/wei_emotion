<!DOCTYPE html>
<html xmlns:wb="http://open.weibo.com/wb">
<head>
    <meta property="wb:webmaster" content="3df8a9a1aa580df4" />
    <meta charset="UTF-8">
    <title>WeiConnet</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css"/>
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="http://tjs.sjs.sinajs.cn/open/api/js/wb.js?appkey=1128990285" type="text/javascript" charset="utf-8"></script>
</head>
<body style="background:url('img/index.jpg')">

<div class="panel panel-info" id="log-window">
    <div class="panel-heading">
    <h2>欢迎！</h2>
    </div>
    <div class="panel-body">
        这是一个可以获取你的微博信息并提取关键词的小网站<hr/>
        <div class="middle">
        <wb:login-button type="3,2" onlogin="login">登录按钮</wb:login-button>
        </div>
    </div>
<!--     <div class="panel-footer">
        <div class="pull-right">
            Author: 石伟男
        </div>
        <div class="clearfix"></div>
    </div> -->
</div>

<script>
function login(o) {
    window.location.href = "https://api.weibo.com/oauth2/authorize?client_id=1128990285&response_type=code&redirect_uri=weiconnect.codingapp.com/home.php";
}
</script>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>