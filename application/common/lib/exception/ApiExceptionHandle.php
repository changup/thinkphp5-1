<?php
    namespace app\common\lib\exception;

    use think\exception\Handle;

    class ApiExceptionHandle extends Handle{
        public $httpCode=500;   //http状态码

        /**重写render方法
         * @param \Exception $e 异常类对象
         * @return \think\response\Json 返回客户端能识别的数据
         */
        public function render(\Exception $e){
            if (config('app_debug')==true){
                return parent::render($e);
            }
            //判断属于哪类异常
            if ($e instanceof ApiException) {
                $this->httpCode=$e->httpCode;
            }
            return show(1,$e->getMessage(),[],$this->httpCode);
        }
    }