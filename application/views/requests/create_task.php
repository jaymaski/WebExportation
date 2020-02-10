<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <title>Exportation101</title>
</head>
    <body>
		<p>Create</p>
		<?php
					if (isset($error)) {
						echo '<p style="color:red;">' . $error . '</p>';
					} else {
						echo validation_errors();
					}
        ?>
				
		<?php 
					$attributes = array('name' => 'form', 'id' => 'form');
					echo form_open($this->uri->uri_string(), $attributes);
        ?>		
				<h5>Task ID</h5>
                <input type="text" name="taskID" value="" size="50" />

                <h5>Project ID</h5>
                <input type="text" name="projectID" value="" size="50" />

                <h5>Owner ID</h5>
                <input type="text" name="ownerID" value="" size="30" />

                <h5>Sender</h5>
               <input type="text" name="sender" value="" size="50" />
			   
			   <h5>Receiver</h5>
               <input type="text" name="receiver" value="" size="50" />
			   
			    <h5>Document</h5>
               <input type="text" name="docType" value="" size="50" />

                <p><input type="submit" name="submit" value="Submit"/></p>
                
       <?php echo form_close(); ?>	
	</body>
</html>