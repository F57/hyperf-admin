<?php

declare(strict_types=1);

namespace App\Service;

use Hyperf\Paginator\Paginator;
use Hyperf\Di\Annotation\Inject;

class PaginatorService
{
    public function getPaginator($list)
    {
        $perPage = 2;
        $paginator = new Paginator($list['list'],$perPage);
        $total = ceil($list['count']/$list['num']);
        $url = array();
        $currentPage = $paginator->currentPage();
        if($currentPage>$total){
            return '';
        }
        for ($i=$currentPage-5;$i<=$currentPage;$i++){
            if($i>0){
                if($currentPage==$i){
                    $url[]='<li class="active"><span>'.$i.'</span></li>';
                }else{
                    $url[]='<li><a href="?page='.$i.'">'.$i.'</a></li>';
                }
            }
        }
        $result = $this->getHtml($total,$currentPage);
        if(!$result){
            return '';
        }
        $html='<ul class="pagination">';
        foreach ($result as $v){
            $html .= $v;
        }
        $html .= '</ul>';
        return $html;
    }

    protected function getHtml($total,$currentPage)
    {
        if($total==1){
            return false;
        }
        if($total==$currentPage){
            $urls = $this->getPerHtml($currentPage,true,$total);
            $urls[]='<li class="disabled"><span>»</span></li>';
        }else{
            $urls = $this->getPerHtml($currentPage,false,$total);
            $urls[]='<li><a href="?page='.$total.'">»</a></li>';
        }
        return $urls;
    }

    protected function getPerHtml($currentPage,$full=true,$total)
    {
        $url=array();
        if($currentPage==1){
            $url[]='<li class="disabled"><span>«</span></li>';
        }else{
            $url[]='<li><a href="?page=1">«</a></li>';
        }
        if($full){
            for ($i=$currentPage-9;$i<=$currentPage;$i++){
                if($i>0 && $i<=$total){
                    if($currentPage==$i){
                        $url[]='<li class="active"><span>'.$i.'</span></li>';
                    }else{
                        $url[]='<li><a href="?page='.$i.'">'.$i.'</a></li>';
                    }
                }
            }
            return $url;
        }
        for ($i=$currentPage-5;$i<=$currentPage;$i++){
            if($i>0 && $i<=$total){
                if($currentPage==$i){
                    $url[]='<li class="active"><span>'.$i.'</span></li>';
                }else{
                    $url[]='<li><a href="?page='.$i.'">'.$i.'</a></li>';
                }
            }
        }
        $count = count($url);
        for ($j=$count+1;$j<=11;$j++){
            $p = $currentPage+$j-$count;
            if($p<=$total){
                if($currentPage==$p){
                    $url[]='<li class="active"><span>'.$p.'</span></li>';
                }else{
                    $url[]='<li><a href="?page='.$p.'">'.$p.'</a></li>';
                }
            }
        }
        return $url;
    }
}