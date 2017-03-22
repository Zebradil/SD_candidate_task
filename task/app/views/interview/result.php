<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Герман
 * Date: 01.07.13
 * Time: 0:24
 * To change this template use File | Settings | File Templates.
 */

/**
 * @var $results array
 * @var $interview Interview
 */

$questions = $results['questions'];
$total = $results['results'];
$i = 0;
?>
<h3>Результаты опроса «<?= $interview->getName() ?>»</h3>
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