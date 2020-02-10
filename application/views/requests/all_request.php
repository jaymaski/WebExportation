<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <title>Exportation101</title>
</head>
    <body>
	<p>	<?php echo anchor('request/create_task', 'Create');?>	</p>
            <div>
                <?php
					if ($requests) {
					?>
					<table>
						<thead>
							<tr>
								<th>Index</th>
								<th>Project ID</th>
								<th>Project Owner</th>
								<th>Task ID</th>
								<th>Owner</th>
								<th>Sender</th>
								<th>Receiver</th>
								<th>Revision Number</th>
								<th>Document</th>
								<th>Environment</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
								foreach ($requests as $request) {
								?>	
									<tr>
										<td>
											<?php echo $request->indexID; ?>
										</td>
										<td>
											<?php echo $request->projectID; ?>
										</td>
										<td>
											<?php echo $request->projectOwner; ?>
										</td>
										<td>
											<?php echo $request->taskID; ?>
										</td>
										<td>
											<?php echo $request->owner; ?>
										</td>
										<td>
											<?php echo $request->sender; ?>
										</td>
										<td>
											<?php echo $request->receiver; ?>
										</td>
										<td>
											<?php echo $request->revisionNumber; ?>
										</td>
										<td>
											<?php echo $request->docType; ?>
										</td>
										<td>
											<?php echo $request->environment; ?>
										</td>
										<td>
											<p>
												<a href="<?php echo site_url('request/view_request').'/'.$request->projectID.'/'.$request->taskID.'/'.$request->requestID; ?>">View</a>
												
												View<?php echo   $request->requestID; ?>
												Edit<?php echo   $request->requestID; ?>
											</p>
										</td>
									</tr>
								<?php
								}
							?>
						</tbody>
					</table>
			<?php
					} else {
						echo '<div style="color:red;"><p>Record Not Found!</p></div>';
					}
			?>
					
	</body>
</html>