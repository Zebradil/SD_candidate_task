<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Герман
 * Date: 01.07.13
 * Time: 1:29
 * To change this template use File | Settings | File Templates.
 */

/**
 * @var $results   array
 * @var $interview Interview
 */

$questions = $results['questions'];
$conditions = $results['conditions'];
$total = $results['results'];
$i = 0;
?>
<div class="well filter">
    <form class="form-horizontal" method="post"><?
        foreach($questions as $qid => $question){
            ?>
            <fieldset class="question">
                <legend><?= $question['text'] ?></legend><?
                $answers = $question['answers'];
                foreach($answers as $aid => $answer){
                    if(is_array($conditions[$qid]) && in_array($aid, $conditions[$qid]))
                        $checked = 'checked="checked"';
                    else
                        $checked = '';
                    ?>
                    <label class="checkbox">
                        <input
                            class="answer"
                            type="checkbox"
                            name="conditions[<?= $qid ?>][]"
                            value="<?= $aid ?>"
                            <?= $checked ?>>
                        <?= $answer['text'] ?>
                    </label>
                <? } ?>
            </fieldset>
        <? } ?>
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Посмотреть результаты</button>
        </div>
    </form>
</div>

<h3>Результаты опроса «<?= $interview->getName() ?>»</h3>
<h5>Выборка по пользователям:</h5>
<? if(is_array($conditions))
    foreach($conditions as $q => $answers){
        $qText = $questions[$q]['text'];
        $aText = [];
        foreach($answers as $aid)
            $aText[] = $questions[$q]['answers'][$aid]['text'];
        $aText = implode(' ИЛИ ', $aText);
        ?>
        <p>
            <?= $qText ?>
            <strong><?= $aText ?></strong>.
        </p>
    <?
    } ?>
<h3></h3>
<table class="table">
    <? foreach($questions as $question){ ?>
        <tr>
            <th colspan="3"><?= ++$i.'. '.$question['text'] ?></th>
        </tr>
        <? foreach($question['answers'] as $answer){ ?>
            <tr>
                <td><?= $answer['text'] ?></td>
                <td>
                    <div class="progress progress-success">
                        <div class="bar" style="width: <?= $answer['count'] / $total * 100 ?>%"></div>
                    </div>
                </td>
                <td><span><?= $answer['count'].' из '.$total ?></span></td>
            </tr>
        <?
        }
    } ?>
</table>