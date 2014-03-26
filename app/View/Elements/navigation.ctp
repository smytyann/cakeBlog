<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">Yann CakeBlog</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="">Home</a></li>
         <!--   <li><a href="http://localhost/CakeBlog/users">User</a></li>
            <li><a href="http://localhost/CakeBlog/posts">Post</a></li>//-->
                <li>    <?php echo $this->Html->link('Users',array('controller' => 'users', 'action' => 'index')); ?></li>
		<li>	<?php echo $this->Html->link('Posts',array('controller' => 'posts', 'action' => 'index')); ?></li>
		
          </ul>
        </div><!--/.nav-collapse -->
      </div>
  </div>