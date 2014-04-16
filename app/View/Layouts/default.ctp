<?php

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
       <?php echo $this->Element('navigation2'); ?>
	<div id="container">
	        <div id="content" class="jumbotron">                                  
                    <h1>Became an Author!</h1>
                    <p class="lead">The Write a book Project incorporates the ideals of the revised English Primary. <br> This website was created by an 3 year student who did not know nothing about CakePHP.</p>
                    <p><a class="btn btn-lg btn-success"  role="button"<?php echo $this->Html->link('Get started today',array('controller' => 'posts', 'action' => 'add')); ?></a></p>
                </div>

      <!-- Example row of columns -->
      
        <div class="col-lg-12">
             <?php echo $this->Session->flash(); ?>
             <?php echo $this->fetch('content'); ?>
        </div>
       
      <div class="clearfix visible-sm"></div>
      <!-- Site footer -->
      <div class="footer">
          <p><h4>&copy; By Yann Nogueira 2014</h4></p>
      </div>

    </div> <!-- /container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <?php echo $this->element('sql_dump'); ?>
  </body>
</html>

                    
		