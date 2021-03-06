<!DOCTYPE html>
<html xmlns:wb="http://open.weibo.com/wb">
<head>
    <meta property="wb:webmaster" content="ff1f5631b53ae071" />
    <meta charset="UTF-8">
    <title>WeiConnet</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" type="text/css"/>
    <link rel="stylesheet" href="css/font-awesome.min.css" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script src="http://tjs.sjs.sinajs.cn/open/api/js/wb.js?appkey=4067847149" type="text/javascript" charset="utf-8"></script>
</head>
<body style="background-color:#ebf5fa">
<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header"  id="nav-head">
      <a class="navbar-brand" href="http://weiemotion-84dd1.coding.io">WeiConnect</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav"  id="navs">
        <li class="active"><a href="http://weiemotion-84dd1.coding.io">首页<span class="sr-only">(current)</span></a></li>
        <li><a href="http://weiemotion-84dd1.coding.io/apis.php">API</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right well-sm">
        <li><wb:login-button type="3,2" onlogout="logout">登录按钮</wb:login-button>            </li>
        </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<div class="panel">
<div class="panel-heading middle">
    <h3>提供API如下</h3>
</div>
<div class="panel-body">
    <table class="table table-hover">
        <tr>
            <th>URL</th>
            <th>说明</th>
        </tr>
        <tr>
            <td><a href="http://weiemotion-84dd1.coding.io/users">weiemotion-84dd1.coding.io/users</a></td>
            <td>返回所有登录过的用户的uid和用户名</td>
        </tr>
        <tr>
            <td><a href="http://weiemotion-84dd1.coding.io/posts/<uid>">weiemotion-84dd1.coding.io/posts/&lt;uid&gt;</a></td>
            <td>返回uid为&lt;uid&gt;的用户的最近微博（不超过100条）</td>
        </tr>
        <tr>
            <td><a href="http://weiemotion-84dd1.coding.io/emotion/<uid>">weiemotion-84dd1.coding.io/emotion/&lt;uid&gt;</a></td>
            <td>返回uid为&lt;uid&gt;的用户的最近表情信息信息</td>
        </tr>
    </table>
</div>
</div>

<script>
function logout() {
    window.location.href="http://weiemotion-84dd1.coding.io";
}
</script>
<script src="js/jquery-1.11.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>
</html>