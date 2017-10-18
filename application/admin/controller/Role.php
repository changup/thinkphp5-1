<?php
    namespace app\admin\controller;

    class Role extends Base{
        public function lists(){
            return $this->fetch();
        }

        public function add(){
            if ($this->request->isPost()){
                $data=input('post.');
//                halt($data);
                //捕获异常
                try {
                    //添加数据库
                    $id=model('Role')->addRole($data);
                } catch (\Exception $e) {
                    $this->error($e->getMessage());
                }

                if ($id) {
                    //添加成功
                    return $this->result(['jump_url'=>url('role/lists')],config('code.success'),'角色添加成功');
                }else{
                    return $this->result(['jump_url'=>url('role/add')],config('code.error'),'添加失败');
                }
            }else{
                return $this->fetch();
            }
        }
    }