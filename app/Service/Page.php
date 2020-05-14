<?php

declare(strict_types=1);

namespace App\Service;

class Page
{

    protected function getPaginator($total,$currentPage,$showpage)
    {

        if($currentPage>$total){
            $currentPage=$total;
        }

        if($currentPage<1){
            $currentPage=1;
        }

        //左侧
        $url = array();
        for($i=$currentPage-$showpage;$i<$currentPage;$i++){
            if($i>0){
                $url[$i]='<li><a href="?page='.$i.'">'.'第'.$i.'页'.'</a></li>';
            }
        }

        //右侧越界
        $right_num = $currentPage+$showpage;
        if($right_num>$total){
            $left_add_num = $right_num-$total;
            for ($j=$currentPage-$showpage-$left_add_num;$j<$currentPage-$showpage;$j++){
                if($j>0){
                    $url[$j]='<li><a href="?page='.$j.'">'.'第'.$j.'页'.'</a></li>';
                }
            }
        }
        //右侧
        $times = $currentPage+$showpage*2-count($url);
        for ($x=$currentPage+1;$x<=$times;$x++){
            if($x<=$total){
                $url[$x]='<li><a href="?page='.$x.'">'.'第'.$x.'页'.'</a></li>';
            }
        }
        //当前页面
        $url[$currentPage]='<li class="active"><span>'.'第'.$currentPage.'页'.'</span></li>';
        ksort($url);

        return $url;
    }

    /**
     * @param $data 数据
     * @param int $showpage 分页数量
     */
    public function getHtml($data,$showpage=4)
    {

        $totalPage = $data['last_page']; //总页数
        $currentPage = $data['current_page'];//当前页数
        $total = $data['total'];//数据总量
        $per_page=$data['per_page'];//每页数据量

        $all=array();

        $all['data']=$data['data'];

        $htmls=array();

        $arr = array();

        if($currentPage<=$totalPage){
            $htmls = $this->getPaginator($totalPage,$currentPage,$showpage);
        }

        if(!empty($htmls)){

            $arr[]='<ul class="pagination"><li class="total-info">共'.$total.'条记录,每页显示'.$per_page.'条,当前第'.$currentPage.'/'.$totalPage.'页</li>';
            if($currentPage==1){
                $arr[]='<li class="disabled"><span>«</span></li>';
            }else{
                $arr[]='<li><a href="?page=1">«</a></li>';
            }
            foreach ($htmls as $v){
                $arr[]=$v;
            }
            if($currentPage==$totalPage){
                $arr[]='<li class="disabled"><span>«</span></li>';
            }else{
                $arr[]='<li><a href="?page='.$totalPage.'">«</a></li>';
            }

            $arr[]='</ul>';
        }

        $all['page']=implode('',$arr);
        unset($data);
        unset($htmls);
        unset($arr);
        return $all;
    }


}
