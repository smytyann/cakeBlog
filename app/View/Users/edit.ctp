<!-- File: /app/View/Users/edit.ctp -->

<h1>Edit User</h1>
<?php
echo $this->Form->create('User'); // create edit form in User model to send to database//
echo $this->Form->input('username');
echo $this->Form->input('password');
echo $this->Form->input('role', array(
				'options' => array('admin' => 'Admin', 'author' => 'Author')));
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end('Save User');
?>