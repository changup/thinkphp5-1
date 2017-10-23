<?php
namespace  app\common\model;

use think\Model;
class AdminNav extends Model {
    public function addNav($data){
        $insertId=$this->allowField(true)->save($data);
        return $insertId;
    }

    //查询后台所有一级菜单
    public function findTopnav(){
        $topnav=$this->where('pid=0')->select();
        return $topnav;
    }

    //查询后台所有菜单
    public function findAllnav(){
        $allnav=$this->where('status=0')->paginate(10,true);
        return $allnav;
    }
}
?>