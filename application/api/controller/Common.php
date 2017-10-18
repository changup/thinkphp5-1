<?php
    namespace app\api\controller;

    use app\common\lib\exception\ApiException;
    use think\Controller;
    use app\common\lib\Fun;
    use app\common\lib\Time;
    use think\Cache;

    class Common extends Controller{

        public $headers='';
        /**
         * 初始化方法
         */
        public function _initialize(){
            $this->checkAuth();
//            $this->testAes();
        }

        /**
         * 检验app每次请求的数据是否合法
         */
        public function checkAuth(){
            //获取header头信息
            $headers=request()->header();
//            halt($headers);

            //sign 加密->客户端工程师      解密->服务端工程师

            //基础参数校验sign
            if (empty($headers['sign'])){
                throw new ApiException('sign不存在',400);
            }
            //app_type
            if (!in_array($headers['app_type'],config('app.apptypes'))){
                throw new ApiException('app_type不合法',400);
            }
            //did
            if (empty($headers['did'])){
                throw new ApiException('did不合法',400);
            }

            //校验sign是否合法
            if (!Fun::checkSignPass($headers)){
                throw new ApiException('授权码无效',400);
            }

            //sign唯一性
            //1.写入缓存    2.写入mysql   3.写入redis
            Cache::set($headers['sign'],1,config('app.app_sign_cache_time'));
            $this->headers=$headers;
        }

        //测试aes加密算法
        public function testAes(){
            //测试生成的sign
            $data=[
                'version'   =>1.0,
                'app_type'  =>'android',
                'time'      =>Time::get13TimeStamp()
            ];
//            $str='9ge5ODfsZP4QH+Og46SVf2mcFazUHJdRm64OCMOT8OyxUJTeHBjhrEycsAXuY4Vz';
//            list()=parse_str($str,$arr);
//            echo (new Aes())->decrypt($str);exit;
            echo Fun::setSign($data);exit;
//            $str="id=2&usernmae=sind&age=21";
//            echo (new Aes())->encrypt($str);exit;
        }

        /**
         * 栏目id转化成name
         */
        public function getCatName($news=[]){
            $catList=config('column.lists');
            foreach ($news as $k => $v) {
                $news[$k]['catname']=$catList[$v['catid']]?$catList[$v['catid']]:'-';
            }
            return $news;
        }
    }