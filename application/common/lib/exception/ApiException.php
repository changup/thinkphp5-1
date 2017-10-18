<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/23
 * Time: 13:59
 */
    namespace app\common\lib\exception;

    use think\Exception;

    class ApiException extends Exception{

        public $message='';
        public $httpCode=500;
        public $code=0;

        /**
         * ApiException constructor.
         * @param string $message   信息提示
         * @param int $httpCode     http状态码
         * @param int $code         请求状态码
         */
        public function __construct($message='',$httpCode=0,$code=0){
            $this->message=$message;
            $this->httpCode=$httpCode;
            $this->code=$code;
        }
    }