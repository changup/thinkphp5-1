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
 * 获取后台左侧菜单
 */
function getAdminNav(){
    //加载后台主页左侧菜单
    $adminNav=model('AdminNav')->where('pid',1)->select();
    return $adminNav;
}
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
 * 菜单显示切换
 */
    function switcher($param){
        return empty($param)?'<span class="label label-success radius">显示</span>':'<span class="label label-warning radius">隐藏</span>';
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


/**
 * 中文字符串截取
 */
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true) {
    if(function_exists("mb_substr"))
        $slice = mb_substr($str, $start, $length, $charset);
    elseif(function_exists('iconv_substr')) {
        $slice = iconv_substr($str,$start,$length,$charset);
        if(false === $slice) {
            $slice = '';
        }
    }else{
        $re['utf-8']   = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|[\xe0-\xef][\x80-\xbf]{2}|[\xf0-\xff][\x80-\xbf]{3}/";
        $re['gb2312'] = "/[\x01-\x7f]|[\xb0-\xf7][\xa0-\xfe]/";
        $re['gbk']    = "/[\x01-\x7f]|[\x81-\xfe][\x40-\xfe]/";
        $re['big5']   = "/[\x01-\x7f]|[\x81-\xfe]([\x40-\x7e]|\xa1-\xfe])/";
        preg_match_all($re[$charset], $str, $match);
        $slice = join("",array_slice($match[0], $start, $length));
    }
    return $suffix ? $slice.'...' : $slice;
}