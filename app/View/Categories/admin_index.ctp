	<div class="row">
		<div class="col-md-10">		
			<div class="content-box-large">
  				<div class="panel-heading">
					<div class="panel-title">Categories</div>
					<div style="float:right">
						<a href="<?php echo host ?>admin/categories/add"><button class="btn btn-primary">Add Category</button></a>
					</div>
				</div>
  				<div class="panel-body">
  					<table cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" id="example">
						<thead>
							<tr>
								<th>Category Name</th>
								<th>Status</th>
								
								<th class="">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
								$j=1;
								foreach ($cat as $res) { 
									$cat_name='';
									//echo $res['cat4']["cat4_name"];die;
									for($k=(count($res)-1);$k>=0;$k--){
										if($res['cat'.$k]["cat".$k."_name"] !=''){
											$cat_name .= $res['cat'.$k]["cat".$k."_name"].' > ';
										}
									}
									$cls=($j%2)==0 ? 'even gradeC' : 'odd gradeX' ;
									$j++;
							?>
									<tr class="<?php echo $cls; ?>">
										<td><?php echo rtrim($cat_name,' > '); ?></td>
										<td><?php echo $res['Category']['status']=1 ? 'Active' : 'Disabled' ?></td>
									
										<td class="center" style="cursor:pointer">Edit</td>
									</tr>
							<?php } ?>
						</tbody>
					</table>
					<?php echo $this->element("pagination")?>
				</div>
  			</div>
		</div>
		<?php 
			
			/* $paginator = $this->Paginator;
			//$this->Paginator->paginate('Post', array(), array('title', 'slug')); 
			 echo $paginator->numbers(array('modulus' => 2)); */
		?>
	</div>
	