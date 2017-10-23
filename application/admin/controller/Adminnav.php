<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/10/19
 * Time: 0:03
 */
namespace app\admin\controller;

use think\Db;
use think\Exception;
use app\common\lib\Treetool;

class Adminnav extends Base{

    //查询后台首页所有菜单
    public function lists(){
//        $data=model('AdminNav')->findAllnav();
        $data=model('AdminNav')->select();
        $allNav=[];
        //模型查询结果是对象数组,必须用循环来遍历
        foreach ($data as $res){
            $allNav[]=$res->getData();
        }
        //无限极分类


        //分页页码
//        $page=$data->render();

        return $this->fetch('',[
            'data'      =>      Treetool::tree($data),
//            'page'      =>      $page
        ]);
    }

    //添加后台首页菜单
    public function add(){
        //查询后台所有一级菜单
        $data=model('AdminNav')->findTopnav();  //返回对象
//        $topNav=Db::name('Admin_nav')->where('pid=0')->select();

        $topNav=[];
        //模型查询结果是对象数组,必须用循环来遍历
        foreach ($data as $res){
            $topNav[]=$res->getData();
        }
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
                'nav'       =>      config('adminnav.level'),
                'topnav'    =>      $topNav
            ]);
        }
    }
}