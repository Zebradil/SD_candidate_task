<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Герман
 * Date: 29.06.13
 * Time: 18:03
 * To change this template use File | Settings | File Templates.
 */
/** @var $interview Interview */
if(empty($interview))
    $res = NULL;
else
    $res = $interview->asJson();
echo json_encode($res);