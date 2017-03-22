/**
 * Created with JetBrains PhpStorm.
 * User: Герман
 * Date: 30.06.13
 * Time: 3:11
 * To change this template use File | Settings | File Templates.
 */

var Answer = (function(){
    var answerId = 0;

    function Answer(data){
        this.questionId = data.questionId;
        this.id = data.id || 'a' + ++answerId;
        this.text = data.text || '';
    }

    return Answer;
})();

var Question = (function(){
    var questionId = 0;

    function Question(data){
        this.interviewId = data.interviewId;
        this.id = data.id || 'q' + ++questionId;
        this.text = data.text || '';
        this.type = data.type || 'single';
        this.required = parseInt(data.required) || 0;
        this.answers = [];
        if(Array.isArray(data.answers))
            data.answers.forEach(function(answer){
                this.addAnswer(answer);
            }, this);
    }

    Question.prototype.addAnswer = function(answer){
        answer = answer || {};
        answer.questionId = this.id;
        var newAnswer = new Answer(answer);
        this.answers.push(newAnswer);
        return newAnswer;
    };

    Question.prototype.getAnswer = function(answerId){
        var result = this.answers.filter(function(answer){
            return answer.id == answerId
        });
        return result[0];
    };

    return Question;
})();

var Interview = (function(){

    function Interview(data){
        this.setData(data);
    }

    Interview.prototype.refresh = function(){
        var $self = this;
        if(this.id)
            return $.post('/interview/json/', {
                id:this.id
            }, function(data, status){
                $self.setData(data);
            }, 'json');
        else
            return $.when();
    };

    Interview.prototype.setData = function(data){
        this.id = parseInt(data.id) || null;
        this.name = data.name || '';
        this.questions = [];
        if(Array.isArray(data.questions))
            data.questions.forEach(function(question){
                this.addQuestion(question);
            }, this);
    };

    Interview.prototype.addQuestion = function(question){
        question = question || {};
        question.interviewId = this.id;
        var newQuestion = new Question(question);
        this.questions.push(newQuestion);
        return newQuestion;
    };

    Interview.prototype.getQuestion = function(questionId){
        var result = this.questions.filter(function(question){
            return question.id == questionId
        });
        return result[0];
    };

    Interview.prototype.save = function(){
        return $.post('/interview/save/', {
            interview:JSON.stringify(this)
        });
    };

    return Interview;
})();