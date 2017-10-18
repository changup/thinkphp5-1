<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/9/23
 * Time: 20:39
 */
    namespace app\api\controller\v1;

    use app\api\controller\Common;

    class Cat extends Common{
        /*
         * 新闻栏目接口
         */
        public function read(){
            $data=config('column.lists');
            $result[]=[
                'catid'     =>0,
                'catname'   =>'首页'
            ];
            foreach ($data as $catid=>$catname){
                $result[]=[
                  'catid'      =>$catid,
                  'catname'    =>$catname
                ];
            }
            return show(config('code.success'),'ok',$result,200);
        }
    }