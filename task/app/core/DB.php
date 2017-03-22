<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Герман
 * Date: 28.06.13
 * Time: 18:43
 * To change this template use File | Settings | File Templates.
 */

class DB{
    /**
     * @var $instance PDO
     */
    protected static $instance = NULL;

    /**
     * @return PDO|Bool
     */
    public static function getInstance(){
        if(!self::$instance){
            $config_filename = Registry::get('db_config');
            if(is_file($config_filename))
                $cfg = parse_ini_file($config_filename, TRUE);
            else
                return FALSE;

            self::$instance = new PDO("{$cfg['db']['driver']}:host={$cfg['db']['host']};dbname={$cfg['db']['name']}",
                $cfg['db']['username'], $cfg['db']['password']);
            self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            foreach($cfg['db_options'] as $k => $v){
                self::$instance->query("set $k = '$v'");
            }
        }
        return self::$instance;
    }

    private function __construct(){
    }

    private function __clone(){
    }

    private function __wakeup(){
    }
}