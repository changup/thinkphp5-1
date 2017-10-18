<?php 
	namespace  app\common\model;
	use think\Model;

	class Base extends Model{

	    protected $autoWriteTimestamp=true;

		public function add($data){
			if (!is_array($data)) {
				$this->error('输入的数据不合法');
			}
			$this->allowField(true)->save($data);
			return $this->id;
		}

		public function selectAll(){
			$result=$this->select();
			return $result;
		}
	}
 ?>