<?php 
	namespace app\api\controller\v1;

	use app\api\controller\Common;
	/**
	* 获取首页接口
	* 1.轮播图4-6张
	* 2.推荐位列表
	*/
	class Index extends Common{

		public function index(){
			$headers=model('News')->getIndexHeagerNormalNews();//头图数据
			$headers=$this->getCatName($headers);
			$positions=model('News')->getIndexPositionNews();//推荐新闻数据
			$positions=$this->getCatName($positions);
			$result=[
				'positions'		=>$positions,
				'headers'		=>$headers
			];
			return show(config('code.success'),'ok',$result,200);
		}
	}
 ?>