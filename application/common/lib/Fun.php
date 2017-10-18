<?php 
	namespace app\common\lib;

    use app\common\lib\Aes;
    use think\Cache;

    /**
	 * 常用的一些功能函数
	 */
	class Fun{
        /**密码加密
         * @param $data 要加密的数据
         * @return string 加密后的数据
         */
		public static function setPassword($data){
			return md5($data.config('app.admin_password'));
		}

        /**
         * 生成每次请求的sign
         * @param array $data
         * @return string sign
         */
		public static function setSign($data=[]){
            //1.按字段升序排序
		    ksort($data);
		    //2.将数组类型数据转化为以&连接的数据
		    $str=http_build_query($data);
            //3.通过aes加密
            $str=(new Aes())->encrypt($str);
            //4.将字符串转化为大写
//            $str=strtoupper($str);
            return $str;
        }

        /**检查sign是否正常
         * @param $data
         * @return boolean
         */
        public static function  checkSignPass($data){
            $str=(new Aes())->decrypt($data['sign']);
            if (empty($str)){
                return false;
            }
            parse_str($str,$arr);
            if (!is_array($arr)||empty($data['did'])||$arr['app_type']!=$data['app_type']){
                return false;
            }
            if (config('app_debug')!=true){
                //sign时间校验
//            if ((time()-ceil($arr['time']/1000))>config('app.app_sign_time')){
//                return false;
//            }
                //sign缓存时间(sign唯一性)
                if (Cache::get($data['sign'])){
                    return false;
                }
            }
            return true;
        }
	}
 ?>