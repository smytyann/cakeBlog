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

		echo $this->Html->css('cake.generic');
                echo $this->Html->css('bootstrap');
                echo $this->Html->css('style');
                
		echo $this->fetch('meta');
		echo $this->fetch('css');
		echo $this->fetch('script');
	?>
</head>
<body>
       <?php echo $this->Element('navigation'); ?>
	<div id="container">
	<!--	<div id="header">
			<h1><?php echo $this->Html->link($cakeDescription, 'http://cakephp.org'); ?></h1>
			<h1><?php echo $this->Html->link('Users',array('controller' => 'users', 'action' => 'index')); ?></h1>
			<h1><?php echo $this->Html->link('Posts',array('controller' => 'posts', 'action' => 'index')); ?></h1>
			<h1><?php echo $this->Html->link('Logout',array('controller' => 'posts', 'action' => 'logout')); ?></h1>
			<h1><?php echo $this->Html->link('Login',array('controller' => 'posts', 'action' => 'login')); ?></h1>
			
		</div>  //-->
		<div id="content">
                    <div id="log"> 
                        <h4><?php if(AuthComponent::user()){
			echo 'Welcome '.AuthComponent::user('username');
			echo $this->Html->link(' Logout ',array ('controller'=>'users', 'action'=>'logout'));
			}
			else{
				echo $this->Html->link(' Login ',array ('controller'=>'users', 'action'=>'login'));
			}
			?></h4></div>

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false)
				);
			?>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>
