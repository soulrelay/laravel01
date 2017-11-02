<div ng-controller="QuestionDetailController" class="container question-detail">
    <div class="card">
        <h1>[: Question.current_question.title :]</h1>
        <div class="desc">[: Question.current_question.desc :]</div>
        <div>
            <span class="gray">
                回答数: [: Question.current_question.answers_with_user_info.length :]
            </span>
        </div>
        <div class="hr"></div>
        <div class="feed item clearfix">
            <div ng-if="!Question.current_answer_id || Question.current_answer_id ==item.id"
                 ng-repeat="item in Question.current_question.answers_with_user_info">
                <div class="vote">
                    <div ng-click="Question.vote({id:item.id, vote:1})" class="up">赞[: item.upvote_count :]</div>
                    <div ng-click="Question.vote({id:item.id, vote:2})" class="down">踩[: item.down_count :]</div>
                </div>
                <div class="feed-item-content">
                    <div>
                    <span ui-sref="user({id:item.user.id})">
                        [: item.user.username :]
                    </span>
                    </div>
                    <div>
                        [: item.content :]
                        <div ng-if="item.question_id" class="gray">
                    <span ui-sref="question.detail({id: Question.current_question.id, answer_id: item.id})"> [: item.updated_at :]
                    </span>
                        </div>
                    </div>
                </div>
                <div class="hr"></div>
            </div>
        </div>
    </div>
</div>