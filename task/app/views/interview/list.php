<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Герман
 * Date: 30.06.13
 * Time: 19:07
 * To change this template use File | Settings | File Templates.
 */
/** @var $interviews Interview[] */

$active = NULL;
/** @var $closed Interview[] */
$closed = [];
/** @var $drafts Interview[] */
$drafts = [];

foreach($interviews as $i)
    switch(TRUE){
        case $i->isClosed():
            $closed[] = $i;
            break;
        case $i->isDraft():
            $drafts[] = $i;
            break;
        case $i->isActive():
            $active = $i;
            break;
    }

/**
 * @param $i Interview
 *
 * @return string
 */
function getActiveBtns($i){
    $id = $i->getId();
    ob_start();
    ?>
    <div class="btn-group">
        <a class="btn" href="/interview/adminresult/?id=<?= $id ?>">Результаты</a>
        <a class="btn" href="/interview/close/?id=<?= $id ?>">Закрыть</a>
        <a class="btn btn-danger" href="/interview/delete/?id=<?= $id ?>">Удалить</a>
    </div>
    <?
    return ob_get_clean();
}

/**
 * @param $i Interview
 *
 * @return string
 */
function getDraftBtns($i){
    $id = $i->getId();
    ob_start();
    ?>
    <div class="btn-group">
        <a class="btn" href="/interview/edit/?id=<?= $id ?>">Редактировать</a>
        <a class="btn" href="/interview/activate/?id=<?= $id ?>">Активировать</a>
        <a class="btn btn-danger" href="/interview/delete/?id=<?= $id ?>">Удалить</a>
    </div>
    <?
    return ob_get_clean();
}

/**
 * @param $i Interview
 *
 * @return string
 */
function getClosedBtns($i){
    $id = $i->getId();
    ob_start();
    ?>
    <div class="btn-group">
        <a class="btn" href="/interview/adminresult/?id=<?= $id ?>">Результаты</a>
        <a class="btn" href="/interview/activate/?id=<?= $id ?>">Активировать</a>
        <a class="btn btn-danger" href="/interview/delete/?id=<?= $id ?>">Удалить</a>
    </div>
    <?
    return ob_get_clean();
}


?>
<h3>Список опросов</h3>
<h5>Всего опросов: <?= count($interviews) ?></h5>
<table id="list" class="table">
    <? if(isset($active)){ ?>
        <tr>
            <th>Активный опрос</th>
            <th></th>
        </tr>
        <tr>
            <td><?= $active->getName() ?></td>
            <td><?= getActiveBtns($active) ?></td>
        </tr>
    <?
    }
    if(count($drafts)){
        ?>
        <tr>
            <th>Черновики</th>
            <th></th>
        </tr>
        <? foreach($drafts as $d){ ?>
            <tr>
                <td><?= $d->getName() ?></td>
                <td><?= getDraftBtns($d) ?></td>
            </tr>
        <?
        }
    }
    if(count($closed)){
        ?>
        <tr>
            <th>Закрытые опросы</th>
            <th></th>
        </tr>
        <? foreach($closed as $c){ ?>
            <tr>
                <td><?= $c->getName() ?></td>
                <td><?= getClosedBtns($c) ?></td>
            </tr>
        <?
        }
    } ?>
</table>

