<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Герман
 * Date: 28.06.13
 * Time: 22:15
 * To change this template use File | Settings | File Templates.
 */

class Route{
    static function start(){
        $controller_name = Registry::get('default_controller');
        $action_name     = Registry::get('default_action');

        $routes = explode('/', $_SERVER['REQUEST_URI']);

        if(!empty($routes[1]))
            $controller_name = $routes[1];

        if(!empty($routes[2]))
            $action_name = $routes[2];

        Registry::set('model_name', $controller_name);
        Registry::set('action_name', $action_name);
        Registry::set('view', $controller_name.'/'.$action_name);

        $controller_name = ucfirst($controller_name).'Controller';

        $controller_path = "app/controllers/".$controller_name.'.php';
        if(!file_exists($controller_path))
            Route::ErrorPage404();

        $controller = new $controller_name;
        $action     = $action_name.'Action';

        $params = array_merge($_GET, $_POST);

        if(method_exists($controller, $action))
            $controller->$action($params);
        else
            Route::ErrorPage404();
    }

    function ErrorPage404(){
        $host = 'http://'.$_SERVER['HTTP_HOST'].'/';
        header('HTTP/1.1 404 Not Found');
        header("Status: 404 Not Found");
        header('Location:'.$host.'forbidden');
    }
}