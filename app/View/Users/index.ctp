<!-- File: /app/View/Users/index.ctp -->

<h1>Blog Users</h1>

<table>
    <tr>
        <th>User Id</th>
        <th>UserName</th>
        <th>Password</th>
        <th>Role</th>
        <th>Created</th>
        <th class="actions">Actions</th>
    </tr>

        <?php
	$i = 0;
	foreach ($users as $user):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $user['User']['id']; ?>&nbsp;</td>
		<td><?php echo $user['User']['username']; ?>&nbsp;</td>
		<td><?php echo $user['User']['password']; ?>&nbsp;</td>
		<td><?php echo $user['User']['role']; ?>&nbsp;</td>
		<td><?php echo $user['User']['created']; ?>&nbsp;</td>
		<td class="actions">
			<?php echo $this->Html->link('View', array('action' => 'view', $user['User']['id'])); ?>
			<?php if ($current_user['id'] == $user['User']['id'] || $current_user['role'] == 'admin'): ?>
			    <?php echo $this->Html->link('Edit', array('action' => 'edit', $user['User']['id'])); ?>
			    <?php echo $this->Form->postLink('Delete', array('action' => 'delete', $user['User']['id']), array('confirm'=>'Are you sure you want to delete that user?')); ?>
		    <?php endif; ?>
		</td>
	</tr>
<?php endforeach; ?>

	
	
<!-- Here's where we loop through our $users array, printing out user info -->

 <!--  /* 
 <?php foreach ($users as $user): ?>
    <tr>
        <td><?php echo $user['User']['id']; ?></td>
        <td>
            <?php
                echo $this->Html->link(
                    $user['User']['username'],
                    array('controller' => 'users', 'action' => 'view', $user['User']['id'])
                );
            ?>
        </td>
		<td><?php echo $user['User']['password']; ?></td>
        
        <td><?php echo $user['User']['role']; ?></td>
        
        <td><?php echo $user['User']['created']; ?></td>
        
        <td>
            <?php
                echo $this->Form->postLink(
                    'Delete',
                    array('action' => 'delete', $user['User']['id']),
                    array('confirm' => 'Are you sure?')
                );
            ?>
            <?php
                echo $this->Html->link(
                    'Edit', array('action' => 'edit', $user['User']['id'])
                );
            ?>
        </td>
			
    </tr>
    <?php endforeach; ?> */-->

</table>

<?php echo $this->Html->link(
    'Add User',
    array('controller' => 'users', 'action' => 'add')
); ?>
