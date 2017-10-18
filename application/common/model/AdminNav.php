<?php
namespace  app\common\model;

use think\Model;
class AdminNav extends Model {
    public function addNav($data){
        $insertId=$this->allowField(true)->save($data);
        return $insertId;
    }
}
?>