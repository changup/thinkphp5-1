<?php 
	namespace  app\common\model;

	use think\Model;
	class News extends Base{
        /**
         * 自动化分页方法(tp5内置分页)
         */
        public function getNews($data=[]){
            $data['status']=[
                'neq',config('code.status_delete')
            ];
            $order=['id'=>'desc'];
            $result=$this->where($data)->order($order)->paginate();
            return $result;
        }

        /**
         * 根据传递的参数获取列表数据
         * $from===初始值
         * $size===每次搜索的数据数量
         */
        public function getNewsByCondition($condition=[],$from=0,$size=5){
            $condition['status']=[
                'neq',config('code.status_delete')
            ];
            $order=['id'=>'asc'];

            $result=$this->where($condition)->limit($from,$size)->order($order)->select();
            return $result;
        }

        /**
         * 根据条件获取列表的总数
         */
        public function getNewsCount($condition=[]){
            $condition['status']=[
                'neq',config('code.status_delete')
            ];
            $count=$this->where($condition)->count();
            return $count;
        }

        /**
         * 获取首页头图数据
         * 
         */
        public function getIndexHeagerNormalNews($num=4){
            $where=[
                'status'            =>1,
                'is_head_figure'    =>1
            ];
            $order=[
                'id'                =>'desc'
            ];         
            return $this->where($where)
                        ->field($this->getFieldList())
                        ->order($order)
                        ->limit($num)
                        ->select();
	   }

       /**
        * 获取推荐的新闻数据
        * 
        */
       public function getIndexPositionNews($num=15){
            $where=[
                'status'            =>1,
                'is_position'    =>1
            ];
            $order=[
                'id'                =>'desc'
            ];         
            return $this->where($where)
                        ->field($this->getFieldList())
                        ->order($order)
                        ->limit($num)
                        ->select();
       }

       /**
        * 获取需要的字段
        */
       private function getFieldList(){
            return ['id','catid','image','title','read_count'];
       }
    }
 ?>