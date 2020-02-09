<div> 
    <h3>Add note:</h3> 
    <!-- Testing inputs for email -->
    <?php echo form_open('users/email'); ?>
        <input type="text" name="note" class="form-control">
        <br>
        <button class="btn btn-primary" name="emailBtn" value="requested">Submit Request</button>
        <button class="btn btn-primary" name="emailBtn" value="revised">Submit Fix</button>
        <br><br>
        <button class="btn btn-primary" name="emailBtn" value="reviewed">Send Review</button>
        <button class="btn btn-primary" name="emailBtn" value="exported">Exported</button>
    <?php echo form_close(); ?>
</div>