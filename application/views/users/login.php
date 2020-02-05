<div class="login">
    <div class="login login-title"><?php echo $title ?></div>

    <?php echo form_open('users/login', array(
        'class' => 'login-form mx-auto',
    )); ?>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">Username</span>
            </div>
            <input type="text" name="username" class="form-control" aria-label="Sizing example input" value="<?php echo set_value('username'); ?>" aria-describedby="inputGroup-sizing-default" required="">
        </div>
        
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroup-sizing-default">Password</span>
            </div>
            <input type="password" name="password" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-default" required="">
        </div>      

        <div><button type="submit" class="btn btn-outline-secondary" value="Submit"> Submit </button></div>
    <?php echo form_close(); ?>
</div>