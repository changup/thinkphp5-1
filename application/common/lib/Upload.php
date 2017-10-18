<?php

    namespace app\common\lib;

    //引入鉴权类
    use Qiniu\Auth;
    //引入七牛上传类
    use Qiniu\Storage\UploadManager;


    /**七牛图片上传基础类库
     * Class Upload
     * @package app\common\lib
     */
    class Upload{
        //上传图片至七牛云
        public static function upToQiniu(){

            if (empty($_FILES['image']['tmp_name'])){
                exception('您提交的图片不合法',404);
            }
            //上传至七牛云的临时文件
            $tmpFile=$_FILES['image']['tmp_name'];

            //获取文件后缀
            $fileName=$_FILES['image']['name'];
            $exts=explode('.',$fileName);
            $exts=$exts[1];

            //获取七牛云配置信息
            $config=config('qiniu');

            //1.鉴权
            $auth=new Auth($config['accesskey'],$config['secretkey']);

            //2.生成Token
            $token=$auth->uploadToken($config['work_name']);

            //上传至七牛云保存的文件
            $savePath=date('Y').'/'.date('m').'/'.date('d').'/'.substr(md5($tmpFile),0,6).date('YmdHis').mt_rand(0,10000).'.'.$exts;

            //初始化上传类
            $uploadManager=new UploadManager();
            list($ret,$error)=$uploadManager->putFile($token,$savePath,$tmpFile);
            if ($error!==null){
                return null;
            }else{
                return config('qiniu.qiniu_site').'/'.$savePath;
            }
        }
    }