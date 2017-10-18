<?php
namespace app\admin\controller;

use think\Model;
use think\Controller;

class News extends Base{
    //新闻展示页面
    public function lists(){
        //获取传递的参数
        $data=input('param.');

        $query=http_build_query($data); //将搜索条件转化为url的普通地址
//halt($query);
        $where=[];

        //转换查询条件
        if (!empty($data['start_time'])&&!empty($data['end_time'])&&$data['end_time']>$data['start_time']){
            $where['create_time']=array('lt',strtotime($data['end_time']));
            $where['create_time']=array('gt',strtotime($data['start_time']));
        }
        if (!empty($data['catid'])){
            $where['catid']=intval($data['catid']);
        }
        if (!empty($data['title'])){
            $where['title']=[
                'like','%'.$data['title'].'%'
            ];
        }
        //获取数据库的新闻信息(模式一)
//        $newsList=model('Test')->getNews();

        //模式二
        $this->getPageAndSize($data);

        //获取表里的数据
        $newsList=model('News')->getNewsByCondition($where,$this->from,$this->size);
        //获取满足条件的记录总数
        $dataTotal=model('News')->getNewsCount($where);

        //计算出有多少页(总页数)
        $pageTotal=ceil($dataTotal/$this->size);

        //模式三
//        $page=$newsList->render();

        return $this->fetch('',[
            'column'        =>  config('column.lists'),
            'newsList'      =>  $newsList,
            'pageTotal'     =>  $pageTotal,
            'curr'          =>  $this->page,
            'start_time'    =>  empty($data['start_time'])?'':$data['start_time'],
            'end_time'      =>  empty($data['end_time'])?'':$data['end_time'],
            'title'         =>  empty($data['title'])?'':$data['title'],
            'catid'         =>  empty($data['catid'])?'':$data['catid'],
            'query'         =>  $query,
            ]);
    }
    //娱乐新闻添加
    public function add(){
        if ($this->request->isPost()){
            $data=input('post.');
            $data['create_time']=time();
            $data['update_time']=time();
            $data['status']=1;
            //插入数据库操作
            try{
                $id=model('News')->add($data);
            }catch (Exception $e){
                return $this->result('',config('code.error'),'新增失败');
            }
            if ($id){
                return $this->result(['jump_url'=>url('news/lists')],config('code.success'),'新增成功');
            }else{
                return $this->result('',config('code.error'),'新增失败');
            }
        }else{
            return $this->fetch('',['column'=>config('column.lists')]);
        }
    }
}
?>