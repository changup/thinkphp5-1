<?php
    namespace app\admin\controller;

    class System extends Base{
        /**
         * 系统设置
         */
        public function setting(){
            return $this->fetch();
        }

        /**
         * 栏目管理
         */
        public function column(){
            return $this->fetch();
        }

        /**
         * 添加栏目
         */
        public function addcol(){
            return $this->fetch();
        }

        /**
         * 屏蔽词语
         */
        public function shield(){
            return $this->fetch();
        }

        /**
         * 系统日志
         */
        public function log(){
            return $this->fetch();
        }
    }
