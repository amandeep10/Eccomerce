<?php
/**
 *
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'CakePHP: the rapid development php framework');
?>
<!DOCTYPE html>
<html>
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('bootstrap.min');
		echo $this->Html->css('styles');
		echo $this->Html->css('general');

		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
	<?php 
		echo $this->Html->script('https://code.jquery.com/jquery.js'); 
		echo $this->Html->script('bootstrap.min'); 
		echo $this->Html->script('custom'); 
	
	?>
	<script type="text/javascript">
		var baseUrl = '<?php echo SITE_URL;?>';
		var imageUrl = '<?php echo $this->webroot; ?>img/';
	</script>
</head>
<body>
	<?php if(!isset($login) && @$login !='true'): ?>
		<?php echo $this->element('header');?>
		<div class="page-content">
			<div class="row">
				<?php echo $this->element('sidebar');?>
				<div class="col-md-10">
					<?php echo $this->Session->flash(); ?>
					<?php echo $this->Session->flash('auth');  ?>
					<?php echo $this->fetch('content'); ?>
				</div>
			</div> 
		</div>
		<?php echo $this->element('footer');?>
	<?php 
		else:
			echo '<div class="page-content container">
			<div class="row">
				<div class="col-md-4 col-md-offset-4">
					'.$this->Session->flash().' 
					'.$this->fetch("content").'
				</div>
			</div> 
		</div>
		'.$this->element("footer").'';
	endif; 
	?>
	
	<?php /* echo $this->Html->link(
			$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
			'http://www.cakephp.org/',
			array('target' => '_blank', 'escape' => false)
		); */
	?>
	<?php echo $this->element('sql_dump'); ?>
	
</body>
</html>
