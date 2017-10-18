<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/19
 * Time: 0:03
 */
namespace app\admin\controller;

use think\Exception;

class Adminnav extends Base{
    public function lists(){
        return $this->fetch();
    }

    //添加后台首页菜单
    public function add(){
        if ($this->request->isPost()){
            $data=input('post.');
            try{
                $insertId=model('AdminNav')->addNav($data);
            }catch (Exception $e){
                $this->error($e->getMessage());
            }
            if ($insertId){
                //添加成功
                return $this->result(['jump_url'=>url('adminnav/lists')],config('code.success'),'菜单添加成功');
            }else{
                return $this->result(['jump_url'=>url('adminnav/add')],config('code.error'),'添加失败');
            }
        }else{
            return $this->fetch('',[
                'nav'   =>      config('adminnav.level')
            ]);
        }
    }
}