<?php
    namespace app\api\controller;

    use app\common\lib\exception\ApiException;
    use think\Controller;
    use app\common\lib\Aes;

    class Test extends Common {
        //获取数据get
        public function index(){
            return [
                'a'=>11,
                'b'=>22
            ];
        }
        //修改put
        public function update($id=0){
            halt(input('put.'));
        }

        //提交数据post
        public function save(){
//            $data=input('post.');
//            if ($data['mt']!=1){
//                throw new ApiException('你提交的数据不合法',401);
//            }

            return show(0,'ok',input('post.'),201);
        }
    }