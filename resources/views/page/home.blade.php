<div ng-controller="HomeController" class="home card container">
    <h1>最新动态</h1>
    <div class="hr"></div>
    <div class="item-set">
        <div ng-repeat="item in Timeline.data" class="item">
            <div class="vote"></div>
            <div class="feed-item-content">
                <div ng-if="item.question_id" class="content-act">[: item.user.username :]添加了回答</div>
                <div ng-if="!item.question_id" class="content-act">[: item.user.username :]添加了提问</div>
                <div class="title">[: item.title :]</div>
                <div class="content-owner">[: item.user.username :]
                    <span class="desc">[: item.user.intro:]</span>
                </div>
                <div ng-if="!item.question_id" class="content-main">[: item.desc :]</div>
                <div ng-if="item.question_id" class="content-main">[: item.content :]</div>
                <div class="action-set">
                    <div class="comment">评论</div>
                </div>
                <div class="comment-block">
                    <div class="hr"></div>
                    <div class="comment-item-set">
                        <div class="rect"></div>
                        <div class="comment-item clearfix">
                            <div class="user">
                                孙尚香
                            </div>
                            <div class="comment-content">
                                抢券链接：图书文娱超级品类日 - 京东图书专题活动-京东30号0点当当抢图书券300-100 抢券链接：图书文娱超级品类日 -
                                京东图书专题活动-京东30号0点当当抢图书券300-100，
                            </div>
                        </div>
                        <div class="comment-item clearfix">
                            <div class="user">
                                孙尚香
                            </div>
                            <div class="comment-content">
                                抢券链接：图书文娱超级品类日 - 京东图书专题活动-京东30号0点当当抢图书券300-100 抢券链接：图书文娱超级品类日 -
                                京东图书专题活动-京东30号0点当当抢图书券300-100，
                            </div>
                        </div>
                        <div class="comment-item clearfix">
                            <div class="user">
                                孙尚香
                            </div>
                            <div class="comment-content">
                                抢券链接：图书文娱超级品类日 - 京东图书专题活动-京东30号0点当当抢图书券300-100 抢券链接：图书文娱超级品类日 -
                                京东图书专题活动-京东30号0点当当抢图书券300-100，
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="hr"></div>
        </div>
        <div ng-if="Timeline.pending" class="tac">加载中...</div>
        <div ng-if="Timeline.no_more_data" class="tac">没有更多数据啦</div>
    </div>


</div>