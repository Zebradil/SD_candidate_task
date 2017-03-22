<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Герман
 * Date: 28.06.13
 * Time: 23:11
 * To change this template use File | Settings | File Templates.
 */

final class Registry implements ArrayAccess{
    /**
     * @var Registry
     */
    private static $instance = NULL;

    private static $vars = array();

    /**
     *  return Registry
     */
    public static function get_instance(){
        if(!isset(self::$instance))
            self::$instance = new Registry();
    }

    public static function set($key, $var){
        if(isset(self::$vars[$key]) == TRUE)
            throw new Exception('Unable to set var `'.$key.'`. Already set.');
        self::$vars[$key] = $var;
        return TRUE;
    }


    public static function get($key){
        if(isset(self::$vars[$key]) == FALSE)
            return NULL;
        return self::$vars[$key];
    }


    public static function remove($key){
        unset(self::$vars[$key]);
    }

    public function offsetExists($offset){
        return isset(self::$vars[$offset]);
    }


    public function offsetGet($offset){
        return self::get($offset);
    }


    public function offsetSet($offset, $value){
        self::set($offset, $value);
    }


    public function offsetUnset($offset){
        unset(self::$vars[$offset]);
    }

    private function __construct(){
    }

    private function __clone(){
    }

    private function __wakeup(){
    }
}