<!--/3 Narrow NAVIGATION -->
<div class="masthead">
    
    
        <h3 class="text-muted">YannNewsBlog</h3>
        <ul class="nav nav-justified">
          <li class="active"><a <?php echo $this->Html->link('Home',array('controller' => 'homes', 'action' => 'index')); ?></a></li>
          <li><a <?php echo $this->Html->link('Users',array('controller' => 'users', 'action' => 'index')); ?></a></li>
          <li><a <?php echo $this->Html->link('Posts',array('controller' => 'posts', 'action' => 'index')); ?></a></li>
          <li><a href="#">Downloads</a></li>
          <li><a href="#">About</a></li>
          <li><div id="log"> 
            <h4>   <?php if(AuthComponent::user()){
			echo 'Welcome '.AuthComponent::user('username');
                        
			echo $this->Html->link(' Logout ',array ('controller'=>'users', 'action'=>'logout'));
			}
			else{
				echo $this->Html->link(' Login ',array ('controller'=>'users', 'action'=>'login'));
			}
			?> </h4> </div> </a> </li>
        </ul>
      </div>