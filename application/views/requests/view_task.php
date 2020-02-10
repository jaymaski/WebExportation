<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <title>Exportation101</title>
</head>
    <body>
		<?php
			if($indexID)
				 if($indexID != -1)
				 {
					echo "Success";
					print_r($indexID);
					}
				else
					echo "Failed";
			else
				echo "No indexID caught."
		?>
	</body>
</html>