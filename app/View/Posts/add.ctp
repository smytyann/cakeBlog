<!-- File: /app/View/Posts/add.ctp -->
    <div class="row">
             <div class="col-md-1"> </div>
              <div class="col-md-3 imgUser "> 
                   <div id="imgUser" >   <?php echo $this->Html->link(
                         $this->Html->image('jornal.jpg'), '/', array('escape' => false));?>
               
              </div>
                   </div> 
             <div class="col-md-7">
                <h1>Add Post</h1>
                <?php
                echo $this->Form->create('Post');
                echo $this->Form->input('title');
                echo $this->Form->input('body', array('rows' => '3'));
                echo $this->Form->end('Save Post');
                ?>

            </div>
              </div>