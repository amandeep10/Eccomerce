<div class="login-wrapper">
	<div class="box">
		<div class="content-wrap">
			<h6>Register</h6>
			<!--<div class="social">
				<a class="face_login" href="#">
					<span class="face_icon">
						<img src="images/facebook.png" alt="fb">
					</span>
					<span class="text">Sign in with Facebook</span>
				</a>
				<div class="division">
					<hr class="left">
					<span>or</span>
					<hr class="right">
				</div>
			</div>-->
			<?php echo $this->Form->create('User',array('type' => 'post'));?>
			<?php 
				echo $this->Form->input('email',array(
												'type' => 'text',
												'label' => false,
												'div' => false,
												'class' => 'form-control',
												'placeholder' => 'E-mail address',
											)
										); 
				echo $this->Form->input('password',array(
											'type' => 'password',	
											'label' => false,
											'div' => false,
											'class' => 'form-control',
											'placeholder' => 'Password',
										)
									); 
									
				echo $this->Form->input('role',array(
											'type' => 'text',	
											'label' => false,
											'div' => false,
											'class' => 'form-control',
											'placeholder' => 'Role',
										)
									); 
				$options = array(
					'label' => false,
					'class' => 'btn btn-primary signup',
					'div' => array(
						'class' => 'action',
					)
				);
				echo $this->Form->end($options);
			?>
		</div>
	</div>
</div>