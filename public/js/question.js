;(function () {
    'use strict';
    angular.module('question', [])
        .service('QuestionService', [
            '$state',
            '$http',
            'AnswerService',
            function ($state, $http, AnswerService) {
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
                                if (params.id) {
                                    me.data[params.id] = me.current_question = r.data.data;
                                    me.its_answers = me.current_question.answers_with_user_info;
                                    me.its_answers = AnswerService.count_vote(me.its_answers);
                                } else {
                                    me.data = angular.merge({}, me.data, r.data.data);
                                }
                                return r.data.data;
                            }
                            return false;

                        })
                }

                me.vote = function (conf) {
                    AnswerService.vote(conf).then(
                        function (r) {
                            //如果投票成功 会更新AnswerService中的数据
                            if (r) {
                                me.update_answer(conf.id);
                            }
                        }
                    )
                }
                
                me.update_answer = function (answer_id) {
                    $http.post('api/answer/read',{id: answer_id
                    }).then(function (r) {
                        if(r.data.status){
                            for(var i = 0; i<me.its_answers.length;i++){
                                var answer = me.its_answers[i];
                                if(answer.id == answer_id){
                                    me.its_answers[i] = r.data.data;
                                    AnswerService.data[answer_id] = r.data.data;
                                }
                            }
                        }
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
                if($stateParams.answer_id){
                    QuestionService.current_answer_id = $stateParams.answer_id;
                }else{
                    QuestionService.current_answer_id = null;
                }
            }
        ])

})();