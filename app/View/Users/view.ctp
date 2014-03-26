<!-- File: /app/View/Users/view.ctp -->
<!--
<h1><?php echo h($user['User']['username']); ?></h1>

<p><small>Created: <?php echo $user['User']['created']; ?></small></p>

<p><?php echo h($user['User']['password']); ?></p>
	
<p><?php echo h($user['User']['role']); ?></p>
*/-->

<div class="users view">
<h2>User</h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>>Id</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>>User Name</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['username']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>>Password</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['password']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>>Role</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['role']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>>Created</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['created']; ?> 
			&nbsp;
		</dd>
                <dt<?php if ($i % 2 == 0) echo $class;?>>Quantity of Posts</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo 'You have '.count($user['Post']).' Posts'?>
			&nbsp;
		</dd>
		
	</dl>
</div>
<div class="actions">
	<h3>Options</h3>
	<ul>
	    <?php if ($current_user['id'] == $user['User']['id'] || $current_user['role'] == 'admin'): ?>
		    <li><?php echo $this->Html->link('Edit User', array('action' => 'edit', $user['User']['id'])); ?> </li>
		    <li><?php echo $this->Form->postLink('Delete User', array('action' => 'delete', $user['User']['id']), array('confirm'=>'Are you sure you want to delete that user?')); ?> </li>
                    <li><?php echo $this->Html->link('List Users', array('action' => 'index')); ?> </li>
                    <li><?php echo $this->Html->link('New User', array('action' => 'add')); ?> </li>
                    
                        <?php endif; ?>
		
	</ul>
</div>