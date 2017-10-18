<?php 
	namespace app\admin\controller;

	use think\Controller;
	use app\common\lib\Fun;
	use app\common\validate\AdminUser;

	class Login extends Base{
		//覆盖父类的方法
		public function _initialize(){}
		//判断用户是否登录过,是则直接跳转到index
		public function login(){
			if ($this->isLogin()) {
				return redirect('index/index');
			}else{
				return $this->fetch();
			}
		}
		//后台首页展示
		public function welcome(){
			return 'hello world';
		}

		//登录表单
		public function check(){
			if ($this->request->isPost()) {
				$data=input('post.');//表单提交过来的数据
//                halt($data);
				//validate验证机制
//				 $validate=validate('AdminUser');
//				 if (!$validate->check($data)) {
//				 	$this->error($validate->getError());
//				 }

				try {
					$user=model('AdminUser')->get(['username'=>$data['username']]);
				} catch (\Exception $e) {
					$this->error($e->getMessage());				
				}
				// halt($user);
//                if (!captcha_check($data['code'])) {
//                    return $this->result(['jump_url'=>url('login/login')],config('code.captcha_error'),'验证码错误');
//                }
				if (!$user || $user->status!=config('code.status_normal')) {
					$this->error('该用户不存在');
				}
				if (Fun::setPassword($data['password'])!=$user['password']) {
					$this->error('密码不正确');
				}

				//1.用户登录成功更新用户信息
				$update=[
					'last_login_time'=>time(),
					'last_login_ip'=>request()->ip(),
				];
				try {
					model('AdminUser')->save($update,['id'=>$user->id]);
				} catch (Exception $e) {
					$this->error($e->getMessage());
				}
                //2.将用户信息保存到session
                session(config('admin.session_user'),$user,config('admin.session_scope'));
				return $this->result(['jump_url'=>url('index/index')],config('code.success'),'登录成功');
			}else{
                $this->error('请求不合法');
			}
		}

		/** 
		 * 退出登录
		 * 1.清空session
		 * 2.跳转到登录页面
		 */
		public function logout(){
			session(null,config('admin.session_scope'));
            $this->redirect('login/login');
		}
	}
 ?>