;(function () {
    'use strict';

    angular.module('shuaihu', [
        'ui.router',
    ])
        .config(['$interpolateProvider', '$stateProvider', '$urlRouterProvider', function ($interpolateProvider,
                                                                                           $stateProvider,
                                                                                           $urlRouterProvider) {
            $interpolateProvider.startSymbol('[:');
            $interpolateProvider.endSymbol(':]');

            $urlRouterProvider.otherwise('/home');

            $stateProvider
                .state('home', {
                    url: '/home',
                    templateUrl: 'home.tpl'
                })
                .state('login', {
                    url: '/login',
                    templateUrl: 'login.tpl'

                })
                .state('signup', {
                    url: '/signup',
                    templateUrl: 'signup.tpl'

                })

        }])

        .service('UserService', [function () {
            var me = this;
            me.signup_data = {};
            me.signup = function () {

            }
        }])

        .controller('SignupController', ['$scope', 'UserService', function ($scope, UserService) {
            $scope.User = UserService;
        }])


    /**/
})();