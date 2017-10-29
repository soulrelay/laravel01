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
帅乎
<div ng-controller="ParentController">

    <div ng-controller="TestController">
        name1是[: name :]
    </div>

    <div>
        name2是[: name :]
    </div>

</div>

<div class="navbar">导航栏</div>
<a href="" ui-sref="home">首页</a>
<a href="" ui-sref="login">登录</a>

<div>
    <div ui-view></div>

</div>

</body>

<script type="text/ng-template" id="home.tpl">
    <div>
        <h1>首页</h1>
        sssssssssssssssssssssss
    </div>
</script>

<script type="text/ng-template" id="login.tpl">
    <div>
        <h1>登录</h1>
        sssssssssssssssssssssss
    </div>
</script>
</html>
