<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/23
 * Time: 17:22
 */
    namespace app\common\lib;

    class Time{
        /**生成13位的时间戳
         * @return int
         */
        public static function get13TimeStamp(){
            list($t1,$t2)=explode(' ',microtime());
            return $t2.ceil($t1*1000);
        }
    }