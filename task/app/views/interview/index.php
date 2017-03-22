<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Герман
 * Date: 28.06.13
 * Time: 23:29
 * To change this template use File | Settings | File Templates.
 */

/** @var $active_interview Interview */
if(empty($active_interview)){
    ?>
    <h3>Нет доступного опроса</h3>
<? } else{ ?>
    <form class="form-horizontal" method="post" action="/interview/finish">
        <h3><?= $active_interview->getName() ?></h3>
        <input type="hidden" name="id" value="<?= $active_interview->getId() ?>"/><?
        $questions = $active_interview->getQuestions();
        foreach($questions as $question){
            $required = $question->getRequired() == '1';
            $answers  = $question->getAnswers();
            $single   = $question->getType() == 'single';
            $q_type   = $single ? 'radio' : 'checkbox'; ?>
            <fieldset class="question <?= $question->getType().($required ? ' required' : '') ?>">
                <legend><?= $question->getText().($required ? '*' : '') ?></legend><?
                foreach($answers as $answer){
                    ?>
                    <label class="<?= $q_type ?>">
                        <input
                            class="answer"
                            type="<?= $q_type ?>"
                            id="answer-<?= $answer->getId() ?>"
                            name="questions[<?= $question->getId().']'.($single ? '' : '[]') ?>"
                            value="<?= $answer->getId() ?>">
                        <?= $answer->getText() ?>
                    </label>
                <? } ?>
            </fieldset>
        <? } ?>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary" onclick="validate(event)">Сохранить результаты</button>
        </div>
    </form>
<? }