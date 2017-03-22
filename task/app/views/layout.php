<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Герман
 * Date: 28.06.13
 * Time: 22:56
 * To change this template use File | Settings | File Templates.
 */
/**
 * @var $content_view string
 * @var $scripts      array|null
 */
switch($_SERVER['REQUEST_URI']){
    case '/':
    case '/interview/index':
        $l1 = TRUE;
        break;
    case '/interview/list':
        $l2 = TRUE;
        break;
    case '/interview/edit':
        $l3 = TRUE;
        break;
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Опросник</title>
    <link rel="stylesheet" href="/css/bootstrap.css"/>
    <link rel="stylesheet" href="/css/style.css"/>
</head>
<body>
<div class="main-wrapper">
    <div class="navbar">
        <div class="navbar-inner">
            <a class="brand" href="/">Опросник</a>
            <ul class="nav">
                <li class="<?= (isset($l1) ? 'active' : '') ?>"><a href="/">Пройти</a></li>
                <li class="<?= (isset($l2) ? 'active' : '') ?>"><a href="/interview/list">Список</a></li>
                <li class="<?= (isset($l3) ? 'active' : '') ?>"><a href="/interview/edit">Новый</a></li>
            </ul>
        </div>
    </div>
    <div class="sub-wrapper well">
        <?php include "app/views/$content_view.php"; ?>
    </div>
</div>
<script type="text/javascript" src="/js/jquery-2.0.2.min.js"></script>
<script type="text/javascript" src="/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/js/base.js"></script>
<?
if(is_array($scripts))
    foreach($scripts as $script){
        ?>
        <script type="text/javascript" src="/js/<?= $script ?>.js"></script><?
    }?>
</body>
</html>