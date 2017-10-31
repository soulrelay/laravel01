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
    <script src="js/user.js"></script>
    <script src="js/question.js"></script>
    <script src="js/common.js"></script>



</head>
<body>
<div class="navbar clearfix">
    <div class="container">
        <div class="fl">
            <div ui-sref="home" class="navbar-item brand">帅乎</div>
            <form ng-submit="Question.go_add_question()" id="quick_ask" ng-controller="QuestionAddController">
                <div class="navbar-item">
                    <input ng-model="Question.new_question.title" type="text">
                </div>
                <div class="navbar-item">
                    <button type="submit">提问</button>
                </div>
            </form>
        </div>
        <div class="fr">
            <a ui-sref="home" class="navbar-item">首页</a>
            @if(is_logined_in())
                <a class="navbar-item">{{session('username')}}</a>
                <a href="{{url('api/user/logout')}}" class="navbar-item">登出</a>

            @else
                <a ui-sref="login" class="navbar-item">登录</a>
                <a ui-sref="signup" class="navbar-item">注册</a>
            @endif
        </div>
    </div>


</div>


<div class="page">
    <div ui-view></div>

</div>

</body>

</html>
