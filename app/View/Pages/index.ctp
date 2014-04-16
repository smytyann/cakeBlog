<!-- File: /app/View/Posts/index.ctp -->

<h1>Our Pages</h1>
<!-- <p><?php echo $this->Html->link('Add Post', array('action' => 'add')); ?></p>-->
<table>
    <tr>
        <th>Post Id</th>
        <th>Title</th>
        <th>Created</th>
        <th>Modified</th>
        <th class="actions">Action </th>
    </tr>

    <?php
            $i = 0;
            foreach ($posts as $post):
                    $class = null;
                    if ($i++ % 2 == 0) {
                            $class = ' class="altrow"';
                    }
            ?>
<!-- Here's where we loop through our $posts array, printing out post info -->

    <tr<?php echo $class;?>>
		<td><?php echo $post['Post']['id']; ?>&nbsp;</td>
		<td><?php echo $post['Post']['title']; ?>&nbsp;</td>
		<td><?php echo $post['Post']['created']; ?>&nbsp;</td>
		<td><?php echo $post['Post']['modified']; ?>&nbsp;</td>
		
		<td class="actions">
			<?php echo $this->Html->link('View', array('action' => 'view', $post['Post']['id'])); ?>
			<?php if ($current_user['role'] == 'admin'): ?>
                            <?php echo $this->Html->link('Edit', array('action' => 'edit', $post['Post']['id'])); ?>
                            <?php echo $this->Form->postLink('Delete', array('action' => 'delete', $post['Post']['id']), array('confirm'=>'Are you sure you want to delete that user?')); ?>
		    <?php endif; ?>
		</td>
	</tr>
<?php endforeach; ?>
    

</table>

<?php echo $this->Html->link(
    'Add Post',
    array('controller' => 'posts', 'action' => 'add')
); 


?>
