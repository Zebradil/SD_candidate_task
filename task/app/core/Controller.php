<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Герман
 * Date: 28.06.13
 * Time: 22:47
 * To change this template use File | Settings | File Templates.
 */

class Controller{
    public $model;
    public $view;

    function __construct(){
        $this->view = new View();
    }

    function indexAction(){
        $this->view->generate();
    }
}