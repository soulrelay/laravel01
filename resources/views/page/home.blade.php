<div ng-controller="HomeController" class="home card container">
    <h1>最新动态</h1>
    <div class="hr"></div>
    <div class="item-set">
        <div ng-repeat="item in Timeline.data track by $index" class="feed item clearfix">
            <div ng-if="item.question_id" class="vote">
                <div ng-click="Timeline.vote({id:item.id, vote:1})" class="up">赞[: item.upvote_count :]</div>
                <div ng-click="Timeline.vote({id:item.id, vote:2})" class="down">踩[: item.down_count :]</div>
            </div>
            <div class="feed-item-content">
                <div ng-if="item.question_id" class="content-act">[: item.user.username :]添加了回答</div>
                <div ng-if="!item.question_id" class="content-act">[: item.user.username :]添加了提问</div>
                <div ng-if="item.question_id" ui-sref="question.detail({id:item.question.id})" class="title">[:
                    item.question.title:]
                </div>
                <div ui-sref="question.detail({id:item.id})" class="title">[: item.title :]</div>
                <div class="content-owner">[: item.user.username :]
                    <span class="desc">[: item.user.intro:]</span>
                </div>
                <div ng-if="!item.question_id" class="content-main">[: item.desc :]</div>
                <div ng-if="item.question_id" class="content-main">[: item.content :]</div>
                <div ng-if="item.question_id" class="gray">
                    <span ui-sref="question.detail({id: item.question_id, answer_id: item.id})"> [: item.updated_at :]
                    </span>
                </div>
                <div ng-if="!item.question_id" class="gray">
                    <span ui-sref="question.detail({id: item.id})"> [: item.updated_at :] </span>
                </div>
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