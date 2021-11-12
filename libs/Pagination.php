<?php

class Pagination
{
    private $totalItems;					// Tổng số phần tử
    private $totalItemsPerPage 	= 1;		// Tổng số phần tử xuất hiện trên một trang
    private $pageRange 			= 5;		// Số trang xuất hiện
    private $totalPage;						// Tổng số trang
    private $currentPage		= 1;		// Trang hiện tại

    public function __construct($totalItems, $pagination)
    {
    
        $this->totalItems 			= $totalItems;
        $this->totalItemsPerPage 	= $pagination['totalItemsPerPage'];
        if ($pagination['pageRange'] % 2 == 0) $pagination['pageRange'] = $pagination['pageRange'] + 1;
        
        $this->pageRange 			= $pagination['pageRange'];
        $this->currentPage 			= $pagination['currentPage'];
        $this->totalPage 			= ceil($totalItems/$pagination['totalItemsPerPage']);
    }



    public function showPagination($link){
		// Pagination
		$paginationHTML = '';
		if($this->totalPage > 1){
			//$start 	= '<div class="button2-right off"><div class="start"><span>Start</span></div></div>';
			//$prev 	= '<div class="button2-right off"><div class="prev"><span>Pre</span></div></div>';
			$start 	= '<li><a style="color:darkgreen" href="#" aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link">Start</a></li>';
			$prev 	= '<li class="paginate_button page-item previous disabled" id="example2_previous"><a style="color:darkgreen" href="#" aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link">&laquo;</a></li>';
			if($this->currentPage > 1){
				$start 	= '<li><a style="color:darkgreen" onclick="javascript:changePage(1)" href="#" aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link">Start</a></li>';
				$prev 	= '<li class="paginate_button page-item previous" id="example2_previous"><a style="color:darkgreen" onclick="javascript:changePage('.($this->currentPage-1).')" href="#" aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link">&laquo;</a></li>';
			}
		
			$next 	= '<li class="paginate_button page-item disabled" id="example2_next"><a style="color:darkgreen" href="#" aria-controls="example2" data-dt-idx="7" tabindex="0" class="page-link">&raquo;</a></li>';
			$end 	= '<li><a style="color:darkgreen" href="#" aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link">End</a></li>';
			if($this->currentPage < $this->totalPage){
				$next 	= '<li class="paginate_button page-item next" id="example2_next"><a style="color:darkgreen" onclick="javascript:changePage('.($this->currentPage+1).')" href="#" aria-controls="example2" data-dt-idx="7" tabindex="0" class="page-link">&raquo;</a></li>';
                $end 	= '<li><a style="color:darkgreen" onclick="javascript:changePage('.$this->totalPage.')" href="#" aria-controls="example2" data-dt-idx="0" tabindex="0" class="page-link">End</a></li>';
			}
		
			if($this->pageRange < $this->totalPage){
				if($this->currentPage == 1){
					$startPage 	= 1;
					$endPage 	= $this->pageRange;
				}else if($this->currentPage == $this->totalPage){
					$startPage		= $this->totalPage - $this->pageRange + 1;
					$endPage		= $this->totalPage;
				}else{
					$startPage		= $this->currentPage - ($this->pageRange-1)/2;
					$endPage		= $this->currentPage + ($this->pageRange-1)/2;
		
					if($startPage < 1){
						$endPage	= $endPage + 1;
						$startPage = 1;
					}
		
					if($endPage > $this->totalPage){
						$endPage	= $this->totalPage;
						$startPage 	= $endPage - $this->pageRange + 1;
					}
				}
			}else{
				$startPage		= 1;
				$endPage		= $this->totalPage;
			}
			$listPages = '';
			for($i = $startPage; $i <= $endPage; $i++){
				if($i == $this->currentPage) {
					$listPages .= '<li class="paginate_button page-item active"><a style="color:darkgreen" href="#" class="page-link">'.$i.'</a></li>';
				}else{
					$listPages .= '<li class="paginate_button page-item"><a style="color:darkgreen" onclick="javascript:changePage('.$i.')" href="#" class="page-link">'.$i.'</a></li>';
				}
			}

			$paginationHTML = '<ul class="pagination">' . $start . $prev . $listPages . $next . $end .'</ul>';
		}
		return $paginationHTML;
	}

	public function showPaginationPublic($link){
		$paginationHTML = '';
		if($this->totalPage > 1){
			$start 	= '<li class="next"><a>Start</a></li>';
			$prev 	= '<li class="next"><a>&laquo;</a></li>';
			if($this->currentPage > 1){
				$start 	= '<li class="next"><a onclick="javascript:changePage(1)" href="#">Start</a></li>';
				$prev 	= '<li class="next"><a onclick="javascript:changePage('.($this->currentPage-1).')" href="#">&laquo;</a></li>';
			}
		
			$next 	= '<li class="next"><a>&raquo;</a></li>';
			$end 	= '<li class="next"><a>End</a></li>';
			if($this->currentPage < $this->totalPage){
				$next 	= '<li class="next"><a onclick="javascript:changePage('.($this->currentPage+1).')" href="#">&raquo;</a></li>';
                $end 	= '<li class="next"><a onclick="javascript:changePage('.$this->totalPage.')" href="#">End</a></li>';
			}
		
			if($this->pageRange < $this->totalPage){
				if($this->currentPage == 1){
					$startPage 	= 1;
					$endPage 	= $this->pageRange;
				}else if($this->currentPage == $this->totalPage){
					$startPage		= $this->totalPage - $this->pageRange + 1;
					$endPage		= $this->totalPage;
				}else{
					$startPage		= $this->currentPage - ($this->pageRange-1)/2;
					$endPage		= $this->currentPage + ($this->pageRange-1)/2;
		
					if($startPage < 1){
						$endPage	= $endPage + 1;
						$startPage = 1;
					}
		
					if($endPage > $this->totalPage){
						$endPage	= $this->totalPage;
						$startPage 	= $endPage - $this->pageRange + 1;
					}
				}
			}else{
				$startPage		= 1;
				$endPage		= $this->totalPage;
			}
			$listPages = '';
			for($i = $startPage; $i <= $endPage; $i++){
				if($i == $this->currentPage) {
					$listPages .= '<li class="current"><a href="#">'.$i.'</a></li>';
				}else{
					$listPages .= '<li><a onclick="javascript:changePage('.$i.')" href="#">'.$i.'</a></li>';
				}
			}

			$paginationHTML = ' <div class="shop_toolbar t_bottom">
			<div class="pagination"><ul>' . $start . $prev . $listPages . $next . $end .'</ul></div>
			</div>';
		}
		return $paginationHTML;
	}

	public function showEndPagination(){
		$xhtml = '<div class="dataTables_info" id="example2_info" role="status" aria-live="polite">Page '.$this->currentPage.' of '.$this->totalPage.'</div>';
		return $xhtml;
	}
}