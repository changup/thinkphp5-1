<?php
namespace  app\common\model;

use think\Db;
use think\Model;
class Role extends Model {
    public function addRole($data){
        $insertId=Db::name('Role')->insert($data);
        return $insertId;
    }
}
?>