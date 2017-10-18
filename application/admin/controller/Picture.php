<?php 
	namespace app\admin\controller;

	class Picture extends Base{
		public function lists(){
			$picList=model('Picture')->select();
			//将url地址转化为数组
			foreach ($picList as $k => $v) {
				$picList[$k]['url']=explode(';',$v['url']);
			}
			// halt($picList);
			return $this->fetch('',[
				'types'		=>	config('pictype.types'),
				'typeid'	=>	empty($data['type'])?'':$data['type'],
				'title'         =>  empty($data['title'])?'':$data['title'],
				'picList'	=>	$picList,
			]);
		}
		public function add(){
			if ($this->request->isPost()) {
				$data=input('post.');
				$data['create_time']=time();
				$data['status']=0;

				//使用正则表达式匹配正文内容中所有的img标签
		        $preg = '/<img.*?src=[\"|\']?(.*?)[\"|\']?\s.*?>/i';//匹配img标签的正则表达式
		        preg_match_all($preg, html_entity_decode($data['url']), $allImg);
		        //这里匹配所有的img
		        $data['url']=implode(';',$allImg[1]);
				try{
					$id=model('Picture')->add($data);
				}catch(Exception $c){
					return $this->result('',config('code.error'),'添加失败');
				}
				if ($id){
	                return $this->result(['jump_url'=>url('picture/lists')],config('code.success'),'添加成功');
	            }else{
	                return $this->result('',config('code.error'),'添加失败');
	            }
			}else{
				return $this->fetch('',['types'=>config('pictype.types')]);
			}
		}
	}
 ?>