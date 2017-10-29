;(function () {
    'use strict';

    angular.module('shuaihu', [
        'ui.router',
    ])
        .config(function ($interpolateProvider,
                          $stateProvider,
                          $urlRouterProvider) {
            $interpolateProvider.startSymbol('[:');
            $interpolateProvider.endSymbol(':]');

            $urlRouterProvider.otherwise('/home');

            $stateProvider
                .state('home',{
                    url:'/home',
                    templateUrl: 'home.tpl'
                })
                .state('login',{
                    url:'/login',
                    templateUrl: 'login.tpl'

                })
                .state('signup',{
                    url:'/signup',
                    templateUrl: 'signup.tpl'

                })

        })



        .controller('TestController', function ($scope) {
            $scope.name = 'Test';
        })
        .controller('ParentController',function ($scope) {
            $scope.name = 'Parent';
        })

    /**/
})();