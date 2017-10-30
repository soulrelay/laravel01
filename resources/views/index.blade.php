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
    </div>
</script>

<script type="text/ng-template" id="login.tpl">
    <div ng-controller="LoginController" class="login  container">
        <div class="card">
            <h1>登录</h1>
            <form name="login_form" ng-submit="User.login()">
                <div class="input-group">
                    <label>用户名</label>
                    <input name="username"
                           type="text"
                           ng-model="User.login_data.username"
                           required>
                </div>
                <div class="input-group">
                    <label>密码</label>
                    <input name="password"
                           type="password"
                           ng-model="User.login_data.password"
                           required>
                </div>
                <div ng-if="User.login_failed" class="input-error-set">
                    用户名或密码有误
                </div>
                <div class="input-group">
                    <button type="submit" ng-disabled="login_form.username.$error.required ||
                    login_form.password.$error.required" class="primary">
                        登录
                    </button>
                </div>
            </form>
        </div>
    </div>
</script>

<script type="text/ng-template" id="signup.tpl">
    <div ng-controller="SignupController" class="signup  container">
        <div class="card">
            <h1>注册</h1>
            {{--[: User.signup_data :]--}}
            <form name="signup_form" ng-submit="User.signup()">
                <div class="input-group">
                    <label>用户名：</label>
                    <input name="username"
                           type="text"
                           ng-minlength="4"
                           ng-maxlength="16"
                           ng-model="User.signup_data.username"
                           ng-model-options="{debounce: 500}"
                           required
                    >
                    <div ng-if="signup_form.username.$touched" class="input-error-set">
                        <div ng-if="signup_form.username.$error.required">
                            用户名为必填项
                        </div>
                        <div ng-if="signup_form.username.$error.maxlength ||
                        signup_form.username.$error.minlength"
                        >用户名长度需在4至24之间
                        </div>
                        <div ng-if="User.signup_username_exists">
                            用户名已存在
                        </div>
                    </div>

                </div>
                <div class="input-group">
                    <label>密码：</label>
                    <input name="password"
                           type="password"
                           ng-minlength="6"
                           ng-maxlength="255"
                           ng-model="User.signup_data.password"
                           {{--ng-model-options="{updateOn: 'blur'}"--}}
                           required
                    >
                    <div ng-if="signup_form.password.$touched" class="input-error-set">
                        <div ng-if="signup_form.password.$error.required">
                            密码为必填项
                        </div>
                        <div ng-if="signup_form.password.$error.maxlength ||
                        signup_form.password.$error.minlength"
                        >密码长度需在6至255之间
                        </div>
                    </div>
                </div>

                <button type="submit"
                        ng-disabled="signup_form.$invalid" class="primary"
                >注册
                </button>

            </form>
        </div>
    </div>
</script>

<script type="text/ng-template" id="question.add.tpl">
    <div ng-controller="QuestionAddController" class="question-add  container">
        <div class="card">
            <form name="question_add_form" ng-submit="Question.add()">
                <div class="input-group">
                    <label>问题标题</label>
                    <input type="text"
                           name="title"
                           ng-minlength="5"
                           ng-maxlength="255"
                           ng-model="Question.new_question.title"
                           required>
                </div>
                <div class="input-group">
                    <label>问题描述</label>
                    <textarea type="text"
                              name="desc"
                              ng-model="Question.new_question.desc"
                    >
                    </textarea>
                </div>
                <div class="input-group">
                    <button type="submit"
                            ng-disabled="question_add_form.$invalid"
                            class="primary"
                    >提交</button>
                </div>
            </form>

        </div>
    </div>
</script>
</html>
