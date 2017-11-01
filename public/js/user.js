;(function () {
    'use strict';
    angular.module('user', [
        'answer'
    ])
        .service('UserService', [
            '$state',
            '$http',
            function ($state, $http) {
                var me = this;
                me.signup_data = {};
                me.login_data = {};
                me.read = function (param) {
                    return $http.post('api/user/read', param)
                        .then(function (r) {
                            if (r.data.status) {
                                if (param.id == 'self') {
                                    me.self_data = r.data.data;
                                } else {
                                    me.data[param.id] = r.data.data;
                                }
                            }
                        })
                }
                me.signup = function () {
                    $http.post('api/user/signup', me.signup_data)
                        .then(function (r) {
                            if (r.data.status) {
                                me.signup_data = {};
                                $state.go('login');
                            }
                        }, function (e) {
                            console.log(e);
                        })
                }

                me.login = function () {
                    $http.post('api/user/login', me.login_data)
                        .then(function (r) {
                            console.log(r.data);
                            if (r.data.status) {
                                // $state.go('home');
                                location.href = '';//刷新所有页面
                            } else {
                                me.login_failed = true;
                            }
                        }, function (e) {

                        })
                }


                me.username_exists = function () {
                    $http.post('api/user/exist', {
                        username: me.signup_data.username
                    }).then(function (r) {
                        if (r.data.status && r.data.data.count) {
                            me.signup_username_exists = true;
                        } else {
                            me.signup_username_exists = false;
                        }
                    }, function (e) {
                        console.log('e', e);
                    })
                }
            }])

        .controller('SignupController', [
            '$scope',
            'UserService',
            function ($scope, UserService) {
                $scope.User = UserService;
                $scope.$watch(function () {
                    return UserService.signup_data;
                }, function (n, o) {
                    if (n.username != o.username) {
                        UserService.username_exists();
                    }
                }, true)
            }])

        .controller('LoginController', [
            '$scope',
            'UserService',
            function ($scope, UserService) {
                $scope.User = UserService;

            }])

        .controller('UserController', [
            '$scope',
            '$stateParams',
            'AnswerService',
            'QuestionService',
            'UserService',
            function ($scope, $stateParams, AnswerService, QuestionService, UserService) {
                $scope.User = UserService;
                console.log('$stateParams', $stateParams);
                UserService.read($stateParams);
                AnswerService.read({user_id: $stateParams.id}).then(
                    function (r) {
                        if (r) {
                            UserService.his_answers = r;
                        }
                    }
                )

                QuestionService.read({user_id: $stateParams.id}).then(
                    function (r) {
                        if (r) {
                            UserService.his_questions = r;
                        }
                    }
                )
            }])
})();