/**
 * Created with JetBrains PhpStorm.
 * User: Герман
 * Date: 29.06.13
 * Time: 20:48
 * To change this template use File | Settings | File Templates.
 */

var addQuestion,
    addAnswer,
    save;

(function(){
    var form,
        interview;

    addQuestion = function(){
        interview.addQuestion().render();
    };

    addAnswer = function(questionId){
        interview.getQuestion(questionId)
            .addAnswer()
            .render();
    };

    save = function(){
        interview.update();
        if(interview.validate())
            interview.save()
                .done(function(){
                    alert('Опрос сохранён');
                })
                .fail(function(){
                    alert('Опрос сохранить не удалось');
                });
        else
            alert('Некорректные значения');
    };

    Answer.prototype.render = function(){
        $('#answers-' + this.questionId).append(this.getHtml());
    };

    Answer.prototype.getHtml = function(){
        var aid = this.id;
        return '<div class="control-group answer" id="answer-' + aid + '">' +
            '<input type="hidden" name="answer-id" value="' + aid + '"/>' +
            '<label class="control-label" for="answer-text-' + aid + '">Текст ответа:</label>' +
            '<div class="controls"><input type="text" id="answer-text-' + aid + '"' +
            'name="answer-text" value="' + this.text + '">' +
            '</div></div>';
    };

    Question.prototype.render = function(){
        $('#questions').append(this.getHtml());
        this.answers.forEach(function(answer){
            answer.render();
        });
    };

    Question.prototype.getHtml = function(){
        var qid = this.id,
            single = this.type == 'single' ? 'selected="selected"' : '',
            multiple = this.type == 'multiple' ? 'selected="selected"' : '',
            required = this.required == 1 ? 'checked="checked"' : '';
        return '<fieldset id="question-' + qid + '" class="question">' +
            '<input type="hidden" name="question-id" value="' + qid + '">' +
            '<legend></legend><div class="control-group">' +
            '<label class="control-label" for="question-text-' + qid + '">Текст вопроса:</label>' +
            '<div class="controls"><input type="text" id="question-text-' + qid + '"' +
            'name="question-text" value="' + this.text + '">' +
            '</div></div><div class="control-group">' +
            '<label class="control-label" for="question-type-' + qid + '">Количество вариантов</label>' +
            '<div class="controls"><select name="question-type" id="question-type-' + qid + '">' +
            '<option value="single" ' + single + '>один</option>' +
            '<option value="multiple" ' + multiple + '>несколько</option>' +
            '</select></div></div><div class="control-group"><label class="control-label"' +
            'for="question-required-' + qid + '">Обязательный</label><div class="controls">' +
            '<input type="checkbox" ' + required + ' name="question-required" ' +
            'id="question-required-' + qid + '"/></div></div>' +
            '<div id="answers-' + qid + '"><h6>Ответы:</h6></div><div class="controls">' +
            '<div class="btn btn-success" onclick="addAnswer(\'' + qid + '\')">' +
            '<i class="icon-plus icon-white"></i>Добавить вариант ответа</div></div></fieldset>';
    };

    Interview.prototype.render = function(){
        form.id.value = this.id;
        form.name.value = this.name;
        this.questions.forEach(function(question){
            question.render();
        });
    };

    Interview.prototype.update = function(){
        this.name = form.name.value;
        var _self = this;
        $(form).find('.question').each(function(i, questionEl){
            var $question = $(questionEl),
                question = _self.getQuestion($question.find('[name=question-id]').val());
            question.text = $question.find('[name=question-text]').val();
            question.type = $question.find('[name=question-type]').val();
            question.required = $question.find('[name=question-required]').is(':checked');
            $question.find('.answer').each(function(i, answerEl){
                var $answer = $(answerEl),
                    answer = question.getAnswer($answer.find('[name=answer-id]').val());
                answer.text = $answer.find('[name=answer-text]').val();
            });
        });
    };

    Interview.prototype.validate = function(){
        switch(false){
            case this.name.length > 0:
            case this.questions.length > 0:
            case checkAnswers(this.questions):
            case checkQuestions(this.questions):
                return false;
        }

        return true;

        function checkAnswers(questions){
            return questions.every(function(question){
                return question.answers.length > 1;
            });
        }

        function checkQuestions(questions){
            return questions.some(function(question){
                return question.required;
            });
        }
    };

    $(function(){
        form = $('form')[0];
        interview = new Interview({id:form.id.value});
        interview.refresh().then(function(){
            interview.render();
        });
        window.aaa = interview;//DEBUG
    });
})();