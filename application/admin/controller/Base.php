<?php 
	namespace app\admin\controller;

	use think\Controller;
    use think\Exception;
    use think\Request;

	/**
	 *后台基础类库
	 * 
	 */
	class Base extends Controller{
	    public $page='';    //当前页数
	    public $size='';    //每页显示的数据条数
        public $from=0;     //查询条件的起始值
        public $request='';
		//初始化方法
		public function _initialize(){
            $this->request=Request::instance();
			$isLogin=$this->isLogin();
			if (!$isLogin) {
				return $this->redirect('login/login');
			}
		}

		//判断用户是否登录的方法
		public function isLogin(){
			$userinfo=session(config('admin.session_user'),'',config('admin.session_scope'));
			if ($userinfo && $userinfo->id) {
				return true;
			}
			return false;
		}

		/**
         * 分页方法封装
         */
		public function getPageAndSize($data){
            $this->page=!empty($data['page'])?$data['page']:1;   //当前页面
            $this->size=!empty($data['size'])?$data['size']:config('paginate.list_rows');
            $this->from=($this->page-1)*$this->size;
        }

        /**
         * 数据逻辑删除
         */
        public function delete($id=0){
            //解决不同模块实例化不同的表
            $model=$this->request->controller();
            if (!intval($id)){
                return $this->result('',0,'不合法');
            }
            try{
                $result=model($model)->save(['status'=>-1],['id'=>$id]);
            }catch (Exception $e){
                $this->error($e->getMessage());
            }
            //修改成功
            if ($result){
                return $this->result(['jump_url'=>$_SERVER['HTTP_REFERER']],1,'OK');
            }
            return $this->result('',0,'');
        }

        /**
         * 新闻状态修改
         */
        public function changeStatus(){
            $data=input('param.');
            $news=model('Test')->get(['id'=>$data['id']]);
            if (!$news){
                return $this->result('',0,'error');
            }
            try{
                $result=model('Test')->save(['status'=>$data['status']],['id'=>$data['id']]);
            }catch (Exception $e){
                $this->error($e->getMessage());
            }
            //修改成功
            if ($result){
                return $this->result(['jump_url'=>$_SERVER['HTTP_REFERER']],1,'OK');
            }
            return $this->result('',0,'');
        }
	}
 ?>