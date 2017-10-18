<?php 
	namespace app\admin\controller;

	use think\Db;
	class Cartoon extends Base{
		public function lists(){
			// $result=model('data')->selectAll();
			//漫画数据
			$data=Db::name('data')->paginate(7);
			// 获取分页显示
			$page = $data->render();
			// halt($page);
			return $this->fetch('',[
				'data'	=> $data,
				'page'	=> $page
			]);
		}

		public function add(){

		}
	}
 ?>