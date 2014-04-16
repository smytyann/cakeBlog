<!-- File: /app/View/Users/index.ctp -->
      <div class="row">
             <div class="col-md-2"> </div>
             <div class="col-md-7"> 
                 <h2>Currently Users</h2>
                  <p><a class="btn btn-lg btn-success"  role="button"<?php echo $this->Html->link('New USER',array('controller' => 'users', 'action' => 'add')); ?></a></p> 
<table>
    <tr>
        <th>User Id</th>
        <th>UserName</th>
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
            </table>

          
       </div>
               <div class="col-md-3 imgUser "> 
                   <div id="imgUser" >   <?php echo $this->Html->link(
                         $this->Html->image('user.jpg'), '/', array('escape' => false));?>
               
              </div>
                   </div>
           
           </div>
           </div>