;(function () {
    'use strict';

    window.his = {
        id: parseInt($('html').attr('user-id'))
    }

    angular.module('shuaihu', [
        'ui.router',
        'user',
        'common',
        'question',
        'answer'
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
                    template: '<div ui-view=""></div>',
                    controller: 'QuestionController'

                })
                .state('question.detail', {
                    url: '/detail/:id?answer_id',
                    templateUrl: 'tpl/page/question_detail'

                })
                .state('question.add', {
                    url: '/add',
                    templateUrl: 'tpl/page/question_add'

                })
                .state('user', {
                    url: '/user/:id',
                    templateUrl: 'tpl/page/user'

                })

        }])


})();