<?php
namespace LWJ\Utils;

class PageUtil
{
    /**
     * 分页函数
     *
     * @param $obj 对象
     * @param $urlrule URL规则
     * @param $array 需要传递的数组，用于增加额外的方法
     * @return 分页
     */
    public function pages($obj, $urlrule = '', $array = array(), $perpage = PAGE_NUMS, $setpages = 10, $ishtml = true) {
        //数组模式
        $data = array();
        $num = isset($obj['total']) ? $obj['total'] : $obj->total();
        $curr_page = isset($obj['currentPage']) ? $obj['currentPage'] : $obj->currentPage();
        $multipage = '';
        if($num > $perpage) {
            $page = $setpages+1;
            $offset = ceil($setpages/2-1);
            $pages = ceil($num / $perpage);
            $from = $curr_page - $offset;
            $to = $curr_page + $offset;
            $more = 0;
            if($page >= $pages) {
                $from = 2;
                $to = $pages-1;
            } else {
                if($from <= 1) {
                    $to = $page-1;
                    $from = 2;
                }  elseif($to >= $pages) {
                    $from = $pages-($page-2);
                    $to = $pages-1;
                }
                $more = 1;
            }
            if($curr_page>0) {
                $multipage .= ' <a href="'.$this->_pageUrl($urlrule, $curr_page-1, $array).'" class="prev">上一页</a>';
                $data['prev'] = $this->_pageUrl($urlrule, $curr_page-1, $array);
                if($curr_page==1) {
                    $multipage .= ' <span class="ayes">1</span>';
                    $data[1] = '';
                } elseif($curr_page>6 && $more) {
                    $multipage .= ' <a href="'.$this->_pageUrl($urlrule, 1, $array).'">1</a> <span>...</span> ';
                    $data[1] = $this->_pageUrl($urlrule, 1, $array);
                    $data['dotA'] = '...';
                } else {
                    $multipage .= ' <a href="'.$this->_pageUrl($urlrule, 1, $array).'">1</a>';
                    $data[1] = $this->_pageUrl($urlrule, 1, $array);
                }
            }
            for($i = $from; $i <= $to; $i++) {
                if($i != $curr_page) {
                    $multipage .= ' <a href="'.$this->_pageUrl($urlrule, $i, $array).'">'.$i.'</a>';
                    $data[$i] = $this->_pageUrl($urlrule, $i, $array);
                } else {
                    $multipage .= ' <span class="ayes">'.$i.'</span>';
                    $data[$i] = '';
                }
            }
            if($curr_page<$pages) {
                if($curr_page<$pages-5 && $more) {
                    $multipage .= ' <span>...</span> <a href="'.$this->_pageUrl($urlrule, $pages, $array).'">'.$pages.'</a> <a href="'.$this->_pageUrl($urlrule, $curr_page+1, $array).'" class="next">下一页</a>';
                    $data['dotB'] = '...';
                    $data[$pages] = $this->_pageUrl($urlrule, $pages, $array);
                    $data['next'] = $this->_pageUrl($urlrule, $curr_page+1, $array);
                } else {
                    $multipage .= ' <a href="'.$this->_pageUrl($urlrule, $pages, $array).'">'.$pages.'</a> <a href="'.$this->_pageUrl($urlrule, $curr_page+1, $array).'" class="next">下一页</a>';
                    $data[$pages] = $this->_pageUrl($urlrule, $pages, $array);
                    $data['next'] = $this->_pageUrl($urlrule, $curr_page+1, $array);
                }
            } elseif($curr_page==$pages) {
                $multipage .= ' <span class="ayes">'.$pages.'</span> <a href="'.$this->_pageUrl($urlrule, $curr_page, $array).'" class="next">下一页</a>';
                $data[$pages] = '';
                $data['next'] = $this->_pageUrl($urlrule, $curr_page, $array);
            } else {
                $multipage .= ' <a href="'.$this->_pageUrl($urlrule, $pages, $array).'">'.$pages.'</a> <a href="'.$this->_pageUrl($urlrule, $curr_page+1, $array).'" class="next">下一页</a>';
                $data[$pages] = $this->_pageUrl($urlrule, $pages, $array);
                $data['next'] = $this->_pageUrl($urlrule, $curr_page+1, $array);
            }
        }
        if($ishtml){
            return $multipage;
        }else{
            return $data;
        }
    }
    
    private function _pageUrl($urlrule = '', $pages = 1, $array = array())
    {
        $pages = max(intval($pages), 1);
        //处理分页URL
        if($pages < 2){
            $urlrule = str_replace('_{page}', '', $urlrule);
        }
        $urlrule = str_replace('{page}', $pages, $urlrule);
    
        if (is_array($array) && $array){
            foreach ($array as $k => $v) {
                $findname[] = '{'.$k.'}';
                $replacename[] = $v;
            }
            $urlrule = str_replace($findname, $replacename, $urlrule);
        }
        return U(ltrim($urlrule, '/'));
    }
}
