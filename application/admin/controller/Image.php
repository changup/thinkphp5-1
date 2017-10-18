<?php 
	namespace app\admin\controller;

	use think\Controller;
    use think\Exception;
    use think\Request;
	use app\common\lib\Upload;

    /**
     * 后台图片上传逻辑
     * @package app\admin\controller
     */
	class Image extends Base{
	    //本地图片上传
		public function uploadImg(){
		    //tp自带上传文件file
            $image=Request::instance()->file('image');
            //将图片上传至本地服务器
            $imgInfo=$image->move('upload');
            if ($imgInfo && $imgInfo->getPathname()){
                $data=[
                    'code'      =>0,
                    'messgae'   =>'成功',
                    'data'=>'/'.$imgInfo->getPathname(),
                ];
                echo json_encode($data);exit;
            }
            echo json_encode(['code'=>250,'message'=>'error']);
		}
		//上传图片至七牛
        public function upload(){
            try{
                //返回图片http路径
                $file=Upload::upToQiniu();
            }catch (Exception $e){
                echo json_encode(['code'=>250,'message'=>$e->getMessage()]);
            }
            if ($file){
                $data=[
                    'code'      =>0,
                    'message'   =>'ok',
                    'data'      =>$file,
                ];
                echo json_encode($data);
            }else{
                echo json_encode(['code'=>250,'message'=>'error']);
            }
        }
	}
 ?>