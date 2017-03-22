<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Герман
 * Date: 28.06.13
 * Time: 23:41
 * To change this template use File | Settings | File Templates.
 */

final class Logger{
    private static $log_file = 'log/dev.log';

    public static function log($data){
        if(!is_string($data)){
            ob_start();
            var_dump($data);
            $data = ob_get_clean();
        } else
            $data .= '
';
        $trace = debug_backtrace();
        $trace = $trace[0];
        $data  = '['.date("Y-m-d H:i:s").'] '.$trace['file'].':'.$trace['line'].' | '.$data;
        file_put_contents(self::$log_file, $data, FILE_APPEND);
    }

//    public static function stack(){
//        $trace = debug_backtrace();
//        $data = '';
//        foreach($trace as $t)
//            $data .= $t
//    }
}