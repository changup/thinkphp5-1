<?php 
	namespace app\admin\controller;

	use think\Controller;
	use app\common\controller\Index as commonIndex;
	class Index extends Base {
		public function index(){
//		    $common=new commonIndex();
//		    return $common->index();
			// halt(session(config('admin.session_user'),'',config('admin.session_scope')));
			return $this->fetch();
		}
		//后台首页展示
		public function welcome(){
			return $this->fetch();
		}
	}
 ?>