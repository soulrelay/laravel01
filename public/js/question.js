;(function () {
    'use strict';
    angular.module('question', [])
        .service('QuestionService', [
            '$state',
            '$http',
            function ($state, $http) {
                var me = this;
                me.new_question = {};
                me.data = {};
                me.go_add_question = function () {
                    $state.go('question.add');
                }

                me.add = function () {
                    if (!me.new_question.title)
                        return;
                    $http.post('api/question/add', me.new_question)
                        .then(function (r) {
                            if (r.data.status) {
                                me.new_question = {};
                                $state.go('home');
                            }
                        }, function (e) {

                        })

                }

                me.read = function (params) {
                    return $http.post('api/question/read', params)
                        .then(function (r) {
                            if (r.data.status) {
                                if(params.id){
                                    me.data[params.id] = me.current_question = r.data.data;
                                }else {
                                    me.data = angular.merge({}, me.data, r.data.data);
                                }
                                return r.data.data;
                            }
                            return false;

                        })
                }

            }
        ])
        .controller('QuestionController', [
            '$scope',
            'QuestionService',
            function ($scope, QuestionService) {
                $scope.Question = QuestionService;
            }
        ])
        .controller('QuestionAddController', [
            '$scope',
            'QuestionService',
            function ($scope, QuestionService) {
                //$scope.Question = QuestionService;
            }
        ])

        .controller('QuestionDetailController', [
            '$scope',
            'QuestionService',
            '$stateParams',
            function ($scope, QuestionService, $stateParams) {
                //$scope.Question = QuestionService;
                QuestionService.read($stateParams);
            }
        ])

})();