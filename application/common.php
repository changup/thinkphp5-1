<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

/**
 * 数据分页函数
 */
function getpage($obj){
    if (!$obj){
        return '';
    }
    $param=request()->param();
    return "<div class='imooc-app'>".$obj->appends($param)->render()."</div>";
}

/**
 * 获取新闻栏目分类信息
 */
function getcat($catid){
    if (intval($catid)<0){
        return '';
    }
    $column=config('column.lists');
    return !empty($column[$catid])?$column[$catid]:'';
}

/**
 * 获取图片分类信息
 */
function getleixing($typeid){
    if (intval($typeid)<0){
        return '';
    }
    $types=config('pictype.types');
    return !empty($types[$typeid])?$types[$typeid]:'';
}

/**
 * 判断是否推荐函数
 */
function isYesNo($id){
    return !empty($id)?'<i style="color: red;" class="Hui-iconfont Hui-iconfont-xuanze"></i>':'<span style="color: #000;">否</span>';
}

/**
 * 新闻状态
 *
 */
function getstatus($id,$status){
    $controller=request()->controller();//当前控制器名称News
    $stat=$status==1?0:1;
    $url=url($controller.'/changeStatus',['id'=>$id,'status'=>$stat]);

    if ($status==1){
        $str="<a href='javascript:' onclick='statusedit(this)' status_url='".$url."' title='修改状态'><span class='label label-success radius'>已审</span></a>";
    }else if($status==0){
        $str="<a href='javascript:' onclick='statusedit(this)' status_url='".$url."' title='修改状态'><span class='label label-warning radius'>待审</span></a>";
    }
    return $str;
}
/**
 * 通用化接口返回方法封装
 * @param $code 业务状态码
 * @param $messgae  信息提示
 * @param array $data   数据
 * @param int $httpCode    http状态码
 * @return \think\response\Json
 */
function show($code,$messgae,$data=[],$httpCode=200){

    $data=[
      'code'        =>  $code,
      'message'     =>  $messgae,
      'data'        =>  $data,
    ];
    return json($data,$httpCode);
}