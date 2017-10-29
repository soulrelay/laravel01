<!doctype html>
<html lang="{{ app()->getLocale() }}" ng-app="shuaihu">
<head>
    <meta charset="utf-8">
    <!-- npm install angular jquery angular-ui-router normalize-css -->
    <!--         百度静态资源公共库 http://cdn.code.baidu.com     稍微慢点 也可以手动下载添加 类似npm做的工作    -->
    <!-- http://apps.bdimg.com/libs/angular.js/1.4.6/angular.js -->
    <!-- Fonts -->


    <title>帅乎</title>
    <link rel="stylesheet" href="node_modules/normalize-css/normalize.css">
    <link rel="stylesheet" href="css/base.css">

    <script src="node_modules/jquery/dist/jquery.js"></script>
    <script src="node_modules/angular/angular.js"></script>
    <script src="node_modules/angular-ui-router/release/angular-ui-router.js"></script>
    <script src="js/base.js"></script>


</head>
<body>
<div class="navbar clearfix">
    <div class="container">
        <div class="fl">
            <div class="navbar-item brand">帅乎</div>
            <div class="navbar-item">
                <input type="text">
            </div>

        </div>
        <div class="fr">
            <a ui-sref="home" class="navbar-item">首页</a>
            <a ui-sref="login" class="navbar-item">登录</a>
            <a ui-sref="signup" class="navbar-item">注册</a>
        </div>
    </div>


</div>


<div class="page">
    <div ui-view></div>

</div>

</body>

<script type="text/ng-template" id="home.tpl">
    <div class="home  container">
        首页
        就看见乐视了dddddddddddddddddddddd的点点滴滴多多多多多多多多多多多多多多多多多多多多多的点点滴滴多多多多多多多多多多多的点点滴滴多多多多多多多多多多多多多多多多多多多多多
    </div>
</script>

<script type="text/ng-template" id="login.tpl">
    <div class="home  container">
        登录
        就看见乐视了dddddddddddddddddddddd的点点滴滴多多多多多多多多多多多多多多多多多多多多多的点点滴滴多多多多多多多多多多多的点点滴滴多多多多多多多多多多多多多多多多多多多多多
    </div>
</script>

<script type="text/ng-template" id="signup.tpl">
    <div class="home  container">
        注册
        就看见乐视了dddddddddddddddddddddd的点点滴滴多多多多多多多多多多多多多多多多多多多多多的点点滴滴多多多多多多多多多多多的点点滴滴多多多多多多多多多多多多多多多多多多多多多
    </div>
</script>
</html>
