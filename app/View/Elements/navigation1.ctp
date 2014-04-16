<!--/SECOND SILVER NAVIGATION -->
<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">NewsYann</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a <?php echo $this->Html->link('Home',array('controller' => 'homes', 'action' => 'index')); ?></a></li>
        <li> <?php echo $this->Html->link('Users',array('controller' => 'users', 'action' => 'index')); ?></li>
        <li> <?php echo $this->Html->link('Posts',array('controller' => 'posts', 'action' => 'index')); ?></li>
        
      </ul>
      
      <ul class="nav navbar-nav navbar-right">
         
    <!--   <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle">Admin <b class="caret"></b> </a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Action</a></li>
                            <li><a href="#">Another action</a></li>
                            <li class="divider"></li>
                            <li><a href="#">Settings</a></li>
                        </ul>
                    </li>-->
                     <li><div id="log"> 
                        <h4>  <?php if(AuthComponent::user()){
			echo 'Welcome '.AuthComponent::user('username');
			echo $this->Html->link(' Logout ',array ('controller'=>'users', 'action'=>'logout'));
			}
			else{
				echo $this->Html->link(' Login ',array ('controller'=>'users', 'action'=>'login'));
			}
			?> </h4> </div> </li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>