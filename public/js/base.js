;(function () {
    'use strict';

    angular.module('shuaihu', [
        'ui.router',
        'user',
        'common',
        'question'
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
                    templateUrl: 'tpl/page/home'
                })
                .state('login', {
                    url: '/login',
                    templateUrl: 'tpl/page/login'

                })
                .state('signup', {
                    url: '/signup',
                    templateUrl: 'tpl/page/signup'

                })
                .state('question', {
                    abstract: true,
                    url: '/question',
                    // templateUrl: 'signup.tpl'
                    template: '<div ui-view=""></div>'

                })
                .state('question.add', {
                    url: '/add',
                    templateUrl: 'tpl/page/question_add'

                })

        }])


})();