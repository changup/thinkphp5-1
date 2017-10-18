<?php 
	namespace app\admin\controller;

	use think\Controller;
	use app\common\validate\AdminUser;//引入common模块下的AdminUser模型
	use think\Db;
	use app\common\lib\Fun;

	class Admin extends Base{
	    //用户添加
		public function add(){
			if (request()->isPost()) {
				$data=input('post.');
//				halt($data);
				//validate验证机制
//				$validate=validate('AdminUser');
//				if (!$validate->check($data)) {
//					$this->error($validate->getError());
//				}
				$data['password']=Fun::setPassword($data['password']);
				$data['status']=1;
				$data['create_time']=time();

                //查询数据库是否有相同的用户
                try {
                    $user=model('AdminUser')->get(['username'=>$data['username']]);

                } catch (Exception $e) {
                    $this->error($e->getMessage());
                }
                if ($user['username']==$data['username']){
                    return $this->result('',config('code.exception'),'不能添加相同的用户');
                }

				//捕获异常
				try {
					//添加数据库
					$id=model('AdminUser')->add($data);
				} catch (\Exception $e) {
					$this->error($e->getMessage());
				}

				if ($id) {
                    //添加成功
					return $this->result(['jump_url'=>url('admin/lists')],config('code.success'),'用户添加成功');
				}else{
					return $this->result(['jump_url'=>url('admin/add')],config('code.error'),'添加失败');
				}

			}else{
				return $this->fetch();
			}
		}
        //用户列表
        public function lists(){
		    echo 'aaa';
        }
	}
 ?>