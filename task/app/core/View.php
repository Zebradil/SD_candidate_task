<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Герман
 * Date: 28.06.13
 * Time: 22:44
 * To change this template use File | Settings | File Templates.
 */

class View{
    public function generate($data = array(), $params = array()){
        extract($params, EXTR_SKIP);
        if(!isset($content_view))
            $content_view = Registry::get('view');
        if(!isset($template_view))
            $template_view = Registry::get('template_view');
        extract($data, EXTR_SKIP);
        $_script_folder = Registry::get('app_dir').'..'.DS.'js'.DS; //TODO move into Registry
        $_view_script   = Registry::get('model_name').'-'.Registry::get('action_name');
        if(empty($scripts))
            $scripts = array();
        if(file_exists($_script_folder.$_view_script.'.js'))
            $scripts[] = $_view_script;
        if($template_view)
            include "app/views/$template_view.php";
        else
            include "app/views/$content_view.php";
    }

    public function status($status){
        http_response_code($status);
    }
}