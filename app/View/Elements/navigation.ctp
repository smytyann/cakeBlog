<!--/FIRST BLACK NAVIGATION -->
<div class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">NewsYann</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a <?php echo $this->Html->link('Home',array('controller' => 'homes', 'action' => 'index')); ?></a></li>
               <li>    <?php echo $this->Html->link('Users',array('controller' => 'users', 'action' => 'index')); ?></li>
		<li>	<?php echo $this->Html->link('Posts',array('controller' => 'posts', 'action' => 'index')); ?></li>
		
          </ul>
        </div><!--/.nav-collapse -->
      </div>
  </div>