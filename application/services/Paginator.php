<?php

namespace application\services;

class Paginator {

	private $page;
    private $per_page;
    private $total;


    public function __construct($per_page, $total, $page = 1) {
        $this->per_page = $per_page;
        $this->total = $total;
        $this->page = $page;
    }

	public function getPagination()
    {
        $num_pages=ceil($this->total/$this->per_page);
        $pages = '';
        if ($num_pages > 1) {
            if ($this->page == 1) $start = 1;
            elseif (($this->page >= ($num_pages - 2)) && ($num_pages > 2) && ($this->page > 2)) $start = $num_pages - 2;
            else $start = $this->page - 1;
            if ($num_pages > 2) $end = $start+2;
            else $end = $start+1;
            for($start; $start<=$end; $start++) {
                if ($start == $this->page) {
                    $pages .= '<span class="selected">'.$start.'</span>&emsp;';
                } else {
                    $pages .= '<a href="?' . http_build_query(array_merge($_GET, ['page' => $start ])) . '">'.$start.'</a>&emsp;';
                }
            }
            if (($this->page > 2) && ($num_pages > 3)) $pages = '<a href="?' . http_build_query(array_merge($_GET, ['page' => '1'])) . '"><<</a>&emsp;. . .&emsp;' . $pages;
            if (($this->page < $end) && ($end < $num_pages)) $pages = $pages.'. . .&emsp;<a href="?' . http_build_query(array_merge($_GET, ['page' => $num_pages])) . '">>></a>';
        }
        return $pages;
    }

}