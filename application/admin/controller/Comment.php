<?php
    namespace app\admin\controller;

    class Comment extends Base{
        public function lists(){
            return $this->fetch();
        }
    }