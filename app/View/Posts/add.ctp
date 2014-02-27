<!-- File: /app/View/Posts/add.ctp -->
//We will create all the atributs , all the 
<h1>Add Post</h1>
<?php
echo $this->Form->create('Post');
echo $this->Form->input('title');
echo $this->Form->input('body', array('rows' => '3'));
echo $this->Form->end('Save Post');
?>