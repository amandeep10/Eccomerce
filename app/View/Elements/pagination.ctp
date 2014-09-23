<?php
	
	$action=explode("_",$this->params['action']);
	$action=$action[count($action)-1];
	$pages=$this->params['paging']['Category']['pageCount'];
	$currentPage=$this->params['paging']['Category']['page'];
	$nxtClass=($currentPage==$pages) ? 'disabled' :'';
	$preClass=($currentPage==1) ? 'disabled' :'';
	$lastPage=($currentPage==$pages) ?  $this->params['paging']['Category']['count']:($currentPage*$this->params['paging']['Category']['limit']);
?>
	
	<div class="row">
		<div class="col-xs-6">
			<div class="dataTables_info" id="example_info">
				Showing <?php echo $currentPage; ?> to <?php echo $lastPage; ?> of <?php echo $this->params['paging']['Category']['count'];?> entries
			</div>
		</div>
		<div class="col-xs-6">
			<div class="dataTables_paginate paging_bootstrap">
				<ul class="pagination">
					<li class="prev <?php echo $preClass; ?>">
						<a href="http://localhost/pract/cakeDev/admin/<?php echo $this->params['controller'] ; ?>/<?php echo $action ?>/page:<?php echo $currentPage-1; ?>">? Previous</a>
					</li>
					<?php 
						for($j=1;$j<=$pages;$j++){ ?>
							<li class="<?php if($j==$currentPage){echo "active";} ?>">
								<a href="http://localhost/pract/cakeDev/admin/<?php echo $this->params['controller'] ; ?>/<?php echo $action ?>/page:<?php echo $j; ?>/"><?php echo $j; ?></a>
							</li>
					<?php
						}
					?>
					<li class="next <?php echo $nxtClass; ?>">
						<a href="http://localhost/pract/cakeDev/admin/<?php echo $this->params['controller'] ; ?>/<?php echo $action ?>/page:<?php echo $currentPage+1; ?>/">Next ? </a>
					</li>
				</ul>
			</div>
		</div>
	</div>