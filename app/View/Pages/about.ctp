<!-- File: /app/View/Posts/view.ctp -->


<!-- <h1><?php echo h($post['Post']['title']); ?></h1>

<p><small>Created: <?php echo $post['Post']['created']; ?></small></p>

<p><?php echo h($post['Post']['body']); ?></p>-->



<div class="posts view">
<h2>Post ABOUT US</h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>>Id</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $post['Post']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>>Title</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $post['Post']['title']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>>Created</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $post['Post']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>>Body</dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $post['Post']['body']; ?>
			&nbsp;
		</dd>
		
		
	</dl>
</div>
<div class="actions">
	<h3>Options</h3>
	<ul>
	    <?php if ($current_user['id'] == $post['Post']['user_id'] || $current_user['role'] == 'admin'): ?>
		    <li><?php echo $this->Html->link('Edit Post', array('action' => 'edit', $post['Post']['id'])); ?> </li>
		    <li><?php echo $this->Form->postLink('Delete Post', array('action' => 'delete', $post['Post']['id']), array('confirm'=>'Are you sure you want to delete that Post?')); ?> </li>
                    <li><?php echo $this->Html->link('List Post', array('action' => 'index')); ?> </li>
                    <li><?php echo $this->Html->link('New Post', array('action' => 'add')); ?> </li>
                    
                        <?php endif; ?>
		
	</ul>
</div>