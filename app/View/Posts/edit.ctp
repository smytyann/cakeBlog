<!-- File: /app/View/Posts/edit.ctp -->
<div class="row">
             <div class="col-md-2"> </div>
             <div class="col-md-8"> 
<h1>Edit Post</h1>
<?php
echo $this->Form->create('Post');
echo $this->Form->input('title');
echo $this->Form->input('body', array('rows' => '3'));
echo $this->Form->input('id', array('type' => 'hidden'));
echo $this->Form->end('Save Post');
?>
</div>