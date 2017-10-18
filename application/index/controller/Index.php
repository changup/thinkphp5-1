<?php
	namespace app\index\controller;
	use app\common\controller\Index as commonIndex;	

	class Index
	{
	    public function index()
	    {	
	        return 'this is index module';
	    }
	    public function common(){
	    	$commonIndex=new commonIndex();
	    	return $commonIndex->index();
	    }
	}
