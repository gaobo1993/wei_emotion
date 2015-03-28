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

<div class="panel">
<div class="panel-heading middle">
    提供API如下
</div>
<div class="panel-body">
    <table class="table table-hover">
        <tr>
            <th>URL</th>
            <th>说明</th>
        </tr>
        <tr>
            <td><a href="http://weiconnect.coding.io/users">weiconnect.coding.io/users</a></td>
            <td>返回所有登录过的用户的uid和用户名</td>
        </tr>
        <tr>
            <td><a href="http://weiconnect.coding.io/<uid>">weiconnect.coding.io/&lt;uid&gt;</a></td>
            <td>返回uid为&lt;uid&gt;的用户的最近微博（不超过100条）</td>
        </tr>
        <tr>
            <td><a href="http://weiconnect.coding.io/<uid>?keywords=1">weiconnect.coding.io/&lt;uid&gt;?keywords=1</a></td>
            <td>返回uid为&lt;uid&gt;的用户的最近微博（不超过100条）及对应的关键词信息</td>
        </tr>
    </table>
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