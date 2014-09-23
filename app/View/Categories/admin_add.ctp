<?php echo $this->Html->script('ckeditor/ckeditor'); ?>
<div class="row">
	<div class="col-md-12 panel-default">
		<div class="content-box-large">
			<div class="panel-heading">
				<legend><div class="panel-title">Add Category</div></legend>
			</div>
			<div class="panel-body">
				<div class="form-horizontal">
					<?php echo $this->Form->create('Category',array('type' => 'file')); ?>
					<div class="form-group">
						<label class="col-md-2 control-label" for="text-field">Category Name</label>
						<div class="col-sm-5 pull-left">
							<?php 
								echo $this->Form->input('cat_name',
										array('class' => 'form-control',
										'type' => 'text',
										'label' => false,
										'required' => false,
										"placeholder" => "Category Name"
									)); 
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label" for="text-field">Parent Name</label>
						<div class="col-md-5 pull-left">
							<?php 
								echo $this->Form->select('parent_id', $allCat, 
										array('class' => 'form-control input-sm',
										'escape' => false,
										'label' => false,
										'required' => false,
										"placeholder" => "Parent Category Name"
									));
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label" for="text-field">Meta Title</label>
						<div class="col-sm-5 pull-left">
							<?php 
								echo $this->Form->input('meta_title',
										array('class' => 'form-control',
										'type' => 'text',
										'label' => false,
										'required' => false,
										"placeholder" => "Meta Title"
									)); 
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label" for="text-field">Meta Keywords</label>
						<div class="col-sm-5 pull-left">
							<?php 
								echo $this->Form->input('meta_keywords',
										array('class' => 'form-control',
										'type' => 'text',
										'label' => false,
										'required' => false,
										"placeholder" => "Meta Keywords"
									)); 
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label" for="text-field">Meta Description</label>
						<div class="col-sm-5 pull-left">
							<?php 
								echo $this->Form->input('meta_description',
										array( 'class' => 'ckeditor',
										'type' => 'textarea',
										'label' => false,
										'required' => false,
										"placeholder" => "Meta Description"
									)); 
							?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-2 control-label" for="text-field">Meta Description</label>
						<div class="col-sm-5 pull-left">
							<?php 
								echo $this->Form->input('image',
										array('class' => 'btn btn-default',
										'type' => 'file',
										'label' => false,
										"placeholder" => "image"
									)); 
							?>
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button class="btn btn-primary" type="submit">Submit</button>
						</div>
					</div>
					<?php echo $this->Form->end(); ?>
				</div>
			</div>
		</div>
	</div>
</div>