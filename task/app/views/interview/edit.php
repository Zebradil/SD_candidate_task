<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Герман
 * Date: 29.06.13
 * Time: 18:03
 * To change this template use File | Settings | File Templates.
 */

/** @var $id int */
$is_new = !isset($id);
?><h3><?= ($is_new ? 'Создание опроса' : 'Редактирование опроса') ?></h3>
<form class="form-horizontal" action="/interview/save" method="post">
    <input type="hidden" name="id" value="<?= $id ?>"/>

    <div class="control-group">
        <label class="control-label" for="interview-name">Название опроса:</label>

        <div class="controls">
            <input type="text" id="interview-name" name="name">
        </div>
    </div>
    <fieldset id="questions">
        <legend>Вопросы</legend>
    </fieldset>
    <div class="form-actions">
        <div class="btn btn-success" onclick="addQuestion()"><i class="icon-plus icon-white"></i>Добавить вопрос
        </div>
    </div>
    <div class="form-actions">
        <div onclick="save()" class="btn btn-primary">Сохранить</div>
    </div>
</form>