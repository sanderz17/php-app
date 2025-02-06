<?php

class Admin extends Functions
{
    public function getAddButton($ctable,$ctable1,$url=null)
    {
		if($ctable!="" && $ctable1!=""){
			if($url!=null){
				?>
				<a class="btn btn-gradient-light mb-3" href="<?php echo $url; ?>" title="Add <?php echo $ctable1; ?>"><i class="mdi mdi-database-plus"></i></a>
				<?php
			}else{
				?>
				<a class="btn btn-gradient-light mb-3" href="<?php echo ADMINURL; ?>add-<?php echo $ctable; ?>/add/" title="Add <?php echo $ctable1; ?>"><i class="mdi mdi-database-plus"></i></a>
				<?php
			}
		}	
    }

	public function getUpdateButton($frmId=null)
    {
		if($frmId!=null){
			?>
			<button class="btn btn-gradient-success mb-3" style="float:right;" onClick="document.<?php echo $frmId; ?>.submit();" title="Update"><i class="mdi mdi-update"></i></button>
			<?php
		}else{
			?>
			<button class="btn btn-gradient-success mb-3" style="float:right;" onClick="document.frm.submit();" title="Update"><i class="mdi mdi-update"></i></button>
			<?php

		}
    }

	public function getDeleteButton()
    {
		?>
		<button type="button" class="btn btn-gradient-light mb-3" onClick="return bulk_delete();" title="Delete"><i class="mdi mdi-delete-sweep"></i></button>
		<?php
    }
    public function getRestoreButton()
    {
		?>
		<button type="button" class="btn btn-gradient-light mb-3" onClick="return bulk_restore();" title="Restore"><i class="mdi mdi-file-restore"></i></button>
		<?php
    }
    public function getArchieveButton()
    {
		?>
		<button type="button" class="btn btn-gradient-light mb-3" onClick="return bulk_archieve();" title="Delete"><i class="mdi mdi-delete-sweep"></i></button>
		<?php
    }

	public function getTablePaginationBlock($pagiArr){
		?>
		<div class="tablePagination" style="margin-bottom: 5px;">
			<div class="row">
				<div class="col-md-2">
					<div class="dataTables_info dataTables_length"> Rows Limit:
						<select id="numRecords" class="form-control input-sm" onChange="changeDisplayRowCount(this.value);">
							<option value="10" <?php if ($_REQUEST["show"] == 10 || $_REQUEST["show"] == "" ) { echo ' selected="selected"'; }  ?> >10</option>
							<option value="25" <?php if ($_REQUEST["show"] == 25) { echo ' selected="selected"'; }  ?> >25</option>
							<option value="50" <?php if ($_REQUEST["show"] == 50) { echo ' selected="selected"'; }  ?> >50</option>
							<option value="75" <?php if ($_REQUEST["show"] == 75) { echo ' selected="selected"'; }  ?> >75</option>
							<option value="100" <?php if ($_REQUEST["show"] == 100) { echo ' selected="selected"'; }  ?> >100</option>
						</select>
					</div>
				</div>
				<div class="col-md-10">
					<div class="dataTables_paginate paging_simple_numbers text-right">
						<ul class="pagination">
						<?php 
						echo $this->paginate_function($pagiArr[0], $pagiArr[1], $pagiArr[2], $pagiArr[3]); 
						?>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
	public function paginate_function($item_per_page, $current_page, $total_records, $total_pages)
	{
		$pagination = '';
		if($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages){ //verify total pages and current page number
			$right_links    = $current_page + 3; 
			$previous       = $current_page - 3; //previous link 
			$next           = $current_page + 1; //next link
			$first_link     = true; //boolean var to decide our first link

			if($current_page > 1){
				$previous_link = ($previous<=0)?1:$previous;
				$pagination .= '<li class="paginate_button "><a href="#" aria-controls="datatable1" data-page="1" title="First">&laquo;</a></li>'; //first link
				$pagination .= '<li class="paginate_button "><a href="#" aria-controls="datatable1" data-page="'.$previous_link.'" title="Previous">&lt;</a></li>'; //previous link
					for($i = ($current_page-2); $i < $current_page; $i++){ //Create left-hand side links
						if($i > 0){
							$pagination .= '<li class="paginate_button "><a href="#"  data-page="'.$i.'" aria-controls="datatable1" title="Page'.$i.'">'.$i.'</a></li>';
						}
					}   
				$first_link = false; //set first link to false
			}
			
			if($first_link){ //if current active page is first link
				$pagination .= '<li class="paginate_button active"><a aria-controls="datatable1">'.$current_page.'</a></li>';
			}elseif($current_page == $total_pages){ //if it's the last active link
				$pagination .= '<li class="paginate_button active"><a aria-controls="datatable1">'.$current_page.'</a></li>';
			}else{ //regular current link
				$pagination .= '<li class="paginate_button active"><a aria-controls="datatable1">'.$current_page.'</a></li>';
			}
			
			for($i = $current_page+1; $i < $right_links ; $i++){ //create right-hand side links
				if($i<=$total_pages){
					$pagination .= '<li class="paginate_button "><a href="#" aria-controls="datatable1" data-page="'.$i.'" title="Page '.$i.'">'.$i.'</a></li>';
				}
			}

			if($current_page < $total_pages){ 
				$next_link = ($i > $total_pages)? $total_pages : $i;
				$pagination .= '<li class="paginate_button "><a href="#" aria-controls="datatable1" data-page="'.$next_link.'" title="Next">&gt;</a></li>'; //next link
				$pagination .= '<li class="paginate_button "><a href="#" aria-controls="datatable1" data-page="'.$total_pages.'" title="Last">&raquo;</a></li>'; //last link
			}
		}
		return $pagination; //return pagination links
	}
}
?>
