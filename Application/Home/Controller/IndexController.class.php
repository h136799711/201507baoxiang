<?php
namespace Home\Controller;
use Admin\Api\GoldcoinApi;
use Think\Controller;
class IndexController extends Controller {

    public function game(){
        $random_type = array();
        srand(time());

        for($i=0;$i<9;$i++){
            $type = rand(1,3);
            array_push($random_type,$type);
        }

        $this->assign("random_type",$random_type);
        $this->display();
    }

    /**
     * test
     */
    public function test(){
        $times = I('get.times',100);

        if($times > 3000000){
            $this->error("不要超过300万！");
        }
        $type = I('get.type',32);
        $map = array(
            'dtree_boxid'=>$type,
        );
        $result = apiCall(GoldcoinApi::QUERY_NO_PAGING,array($map));
        if(!$result['status']){
            $this->error($result['info']);
        }

//        dump($result);
        // 计算公式
        // 所有概率 * 100 进行累加
        // 例如 100 ,10 5000 累加 ＝ 5110
        // 从小到大排序
        $result = $this->quick_sort($result['info']);

        $total = 0;
        for($i=0;$i<count($result);$i++){

            $result[$i]['probability'] = $result[$i]['probability'] * 100.0;
            $total +=  $result[$i]['probability'];
            if($i > 0){
                $result[$i]['_between'] =  $result[$i]['probability'] + $result[$i-1]['_between'];
            }else{
                $result[$i]['_between'] =  $result[$i]['probability'];
            }
            $result[$i]['_cnt']=0;
        }

        for($j=0;$j<$times;$j++){
            srand(time().$j);
            $rand = rand(0,$total);

            for($i=0;$i<count($result);$i++) {
                $vo = &$result[$i];
                if($vo['_between'] > $rand){
                    $vo['_cnt']++;
                    break;
                }
            }

        }

        $this->assign("total",$times);
        $this->assign("result",$result);
        $this->display("Index/index");


    }

    public function index(){
        //32 金 33 银 34 铜
        $type = I('get.type',0);
        $map = array(
            'dtree_boxid'=>$type,
        );
        $result = apiCall(GoldcoinApi::QUERY_NO_PAGING,array($map));
        if(!$result['status']){
            $this->error($result['info']);
        }

//        dump($result);
        // 计算公式
        // 所有概率 * 100 进行累加
        // 例如 100 ,10 5000 累加 ＝ 5110
        // 从小到大排序
        $result = $this->quick_sort($result['info']);

        $total = 0;
        for($i=0;$i<count($result);$i++){

            $result[$i]['probability'] = $result[$i]['probability'] * 100.0;
            $total +=  $result[$i]['probability'];
            if($i > 0){
                $result[$i]['_between'] =  $result[$i]['probability'] + $result[$i-1]['_between'];
            }else{
                $result[$i]['_between'] =  $result[$i]['probability'];
            }
        }

//        dump($total);
        $rand = rand(0,$total);
//        dump($rand);
        for($i=0;$i<count($result);$i++) {
            $vo = $result[$i];
            if($vo['_between'] > $rand){
                $this->ajaxReturn(array('status'=>1,'info'=>$vo));
                break;
            }
        }

        $this->ajaxReturn(array('status'=>0,'info'=>'没抽中!'));
    }

    function quick_sort($array){
        if (count($array) <= 1) return $array;

        $key = $array[0]['probability'];
        $left_arr = array();
        $right_arr = array();
        for ($i=1; $i<count($array); $i++){
            if ($array[$i]['probability'] <= $key)
                $left_arr[] = $array[$i];
            else
                $right_arr[] = $array[$i];
        }
        $left_arr = $this->quick_sort($left_arr);
        $right_arr = $this->quick_sort($right_arr);

        return array_merge($left_arr, array($array[0]), $right_arr);
    }
}