;(function () {
    'use strict';
    angular.module('common', [])
        .service('TimelineService', [
            '$http', function ($http) {
                var me = this;
                me.data = [];
                me.current_page = 1;
                me.get = function (conf) {
                    if (me.pending) return;
                    me.pending = true;
                    conf = conf || {page: me.current_page}
                    $http.post('api/timeline', conf)
                        .then(function (r) {
                            if (r.data.status) {
                                if (r.data.data.length) {
                                    me.data = me.data.concat(r.data.data);
                                    me.current_page++;
                                } else {
                                    me.no_more_data = true;
                                }

                            } else {
                                console.error('network error');
                            }
                        }, function () {
                            console.error('network error');
                        })
                        .finally(function () {
                            me.pending = false;
                        })
                }
            }
        ])

        .controller('HomeController', [
            '$scope',
            'TimelineService',
            function ($scope, TimelineService) {
                var $win;
                $scope.Timeline = TimelineService;
                TimelineService.get();

                $win = $(window);
                $win.on('scroll', function () {
                    // console.log('$win.scrollTop',$win.scrollTop());
                    //console.log('($(document).height() - $win.height())',($(document).height() - $win.height()));

                    if ($win.scrollTop() - ($(document).height() - $win.height()) > -30) {
                        if (TimelineService.no_more_data) return;
                        TimelineService.get();
                    }
                })
            }
        ])

})();