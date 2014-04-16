

  <div class="col-md-10 col-md-offset-1">
      <div class="row">
      <div class="col-md-6 ">
        <div class="users form">
            <h3>Dear user please Login</h3>

                <?php echo $this->Session->flash('auth'); ?>
                <?php echo $this->Form->create('User'); ?>
                    <fieldset>
                        <legend>
                        <?php echo __('Enter your username and password!'); ?>
                        </legend>
                        <?php 
                        echo $this->Form->input('username');
                        echo $this->Form->input('password');
                    ?>
                    </fieldset>
                    <?php echo $this->Form->end(__('Login')); ?>
                </div> </div>
                    <div class="col-md-4">
                        <?php echo $this->Html->link(
                         $this->Html->image('cakephp1.png'), '/', array('escape' => false));?>
                    </div>

</div>
</div>
