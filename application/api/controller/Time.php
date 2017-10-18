<?php
    namespace  app\api\controller;

    class Time extends Controller{
        public function index(){
            return show(0,'ok',time());
        }
    }