/**
 * Created with JetBrains PhpStorm.
 * User: Герман
 * Date: 30.06.13
 * Time: 21:25
 * To change this template use File | Settings | File Templates.
 */

var validate;

(function(){
    var form;

    validate = function(e){
        var result = true;
        form.find('.question.required').each(function(i){
            result = result && $(this).find('.answer').is(':checked');
        });
        if(!result){
            e.preventDefault();
            alert('Вопросы, отмеченные "*" - обязательные');
        }
    };

    $(function(){
        form = $('form');
    });
})();