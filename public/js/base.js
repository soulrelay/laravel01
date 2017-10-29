;(function () {
    'use strict';

    angular.module('shuaihu', [])
        .config(function ($interpolateProvider) {
            $interpolateProvider.startSymbol('[:');
            $interpolateProvider.endSymbol(':]');
        })
        .controller('TestController', function ($scope) {
            $scope.name = 'Test';
        })
        .controller('ParentController',function ($scope) {
            $scope.name = 'Parent';
        })

    /**/
})();