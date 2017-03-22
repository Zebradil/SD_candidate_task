<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Герман
 * Date: 28.06.13
 * Time: 22:11
 * To change this template use File | Settings | File Templates.
 */

define('DS', DIRECTORY_SEPARATOR);

add_include_paths(array('core', 'controllers', 'models', 'views'), __DIR__);
spl_autoload_extensions('.php');
spl_autoload_register();

Registry::set('db_config', __DIR__.DS.'database.ini');
Registry::set('default_controller', 'interview');
Registry::set('default_action', 'index');
Registry::set('app_dir',__DIR__.DS);
Registry::set('template_view', 'layout');

Route::start();

function add_include_paths($paths, $root = ''){
    foreach($paths as $path){
        if(is_array($path))
            $path = implode(DS, $path);
        $path = $root.DS.$path.DS;
        set_include_path(get_include_path().PATH_SEPARATOR.$path);
    }
}