<?php echo $title ?>
<?php if($curr_request){
	foreach ($curr_request as $request) { ?>
	<div class="container view-request">
		<table class="project-details">
			<tr>
				<th colspan="4" class="text-center">
				PROJECT DETAILS
				</th>
			</tr>

			<tr>
				<th>Project ID</th>
				<td><?php echo $request->projectID; ?></td>
				<th>Task ID</th>
				<td><?php echo $request->taskID; ?></td>
			</tr>

			<tr>
				<th>Project Owner</th>
				<td><?php echo $request->projectOwner; ?></td>
				<th>Owner</th>
				<td><?php echo $request->owner; ?></td>
			</tr>

			<tr>
				<th>Sender</th>
				<td><?php echo $request->sender; ?></td>
				<th>Receiver</th>
				<td><?php echo $request->receiver; ?></td>
			</tr>

			<tr>
				<th>Document</th>
				<td><?php echo $request->docType; ?></td>
				<th>Status</th>
				<td><?php echo $request->status; ?></td>
			</tr>

			<tr>
				<th>Revision Number</th>
				<td><?php echo $request->revisionNumber; ?></td>
				<th>Environment</th>
				<td><?php echo $request->environment; ?></td>
			</tr>

			<tr>
				<th>Request Date</th>
				<td><?php echo $request->requestDate; ?></td>
				<th>Deployed Date</th>
				<td><?php echo $request->deployDate; ?></td>
			</tr>
			<?php }?>	
		</table>
	</div>
	<?php } else {
		echo '<div class="none-found">No History found for this Request</div>';
	} ?>

	<?php if($request_history){
		foreach ($request_history as $request) { ?>
		<div class="container view-request">
			<table class="revisions table table-bordered">
				<tr class="header text-dark">
					<th colspan="4" class="text-center">
						REVISION <?php echo $request->revisionNumber; ?>
						<span><?php echo $request->status; ?> to <?php echo $request->environment; ?></span>
					</th>
				<tr>
				<?php
					if($translations){
						foreach ($translations as $translation) {
							if($request->requestID == $translation->requestID){ ?>			
								<tr>
									<td><strong>Test Internal ID:</strong> </td>
									<td colspan=""><?php echo $translation->internalID;?></td>
									<th colspan="">Release as Document Type:</th>
									<td colspan=""><?php echo $request->docType; ?></td>
								</tr>
								<tr>
									<th>Translation Name:</th>
									<td><?php echo $translation->name;?></td>	
									<th>Translation Changes</th>	
									<?php if($translation_changes){
										foreach($translation_changes as $change){
											if($translation->translationID == $change->translationID){ ?>
													<td colspan="3"><?php echo $change->changes ;?></td>
												</tr>
												<tr class="spacer"><td colspan="4"></td></tr>
								<?php   }
									}
								}
							}
						}
					} 
				}?>		
				</table>
			</div>
	<?php } else {
		echo '<div class="none-found">No History found for this Request</div>';
	} ?>

<!-- <p>Current Request</p>
	<?php
		if ($curr_request) {
			foreach ($curr_request as $request) {
		?>
	<div class="container">
	<table class="table table-dark table-bordered">
		<tr class="header text-dark">
			<th colspan="2" class="text-center">
			Revision Number : <?php echo $request->revisionNumber; ?>
			</th>
			<th colspan="2" class="text-center">
			Environment : <?php echo $request->environment; ?>
			</th>
		</tr>
		<tr>
			<th>Project ID</th>
			<td><?php echo $request->projectID; ?></td>
			<th>Task ID</th>
			<td><?php echo $request->taskID; ?></td>
		</tr>
		<tr>
			
			<th>Project Owner</th>
			<td><?php echo $request->projectOwner; ?></td>
			<th>Owner</th>
			<td><?php echo $request->owner; ?></td>
		</tr>
		<tr>
			<th>Sender</th>
			<td><?php echo $request->sender; ?></td>
			<th>Receiver</th>
			<td><?php echo $request->receiver; ?></td>
		</tr>
		<tr>
			<th>Document</th>
			<td><?php echo $request->docType; ?></td>
			<th>Status</th>
			<td><?php echo $request->status; ?></td>
			
		</tr>
		<tr>
			<th>Revision Number</th>
			<td><?php //echo $request->revisionNumber; ?></td>
			
			<th>Environment</th>
			<td><?php //echo $request->environment; ?></td>
		
		</tr>
		<tr>
			<th>Request Date</th>
			<td><?php echo $request->requestDate; ?></td>
			<th>Deployed Date</th>
			<td><?php echo $request->deployDate; ?></td>
		</tr>
		<tr>
			<th colspan="4" class="text-center">Changes</th>
		<tr>
		<tr>
			<th>Translation Name</th>
			<th>Test Internal ID</th>
			<th colspan="2" rowspan="2">Translation Changes</th>
		</tr>
		
		<?php
			if($translations){
				foreach ($translations as $translation) {
					if($request->requestID == $translation->requestID){
		?>
					<tr>
						<td><?php echo $translation->name;?></td>
						<td><?php echo $translation->internalID;?></td>		
					</tr>
		<?php
						if($translation_changes){
							foreach($translation_changes as $change){
								if($translation->translationID == $change->translationID){
		?>
					<tr>
						<td colspan="2"></td>				
						<td colspan="2"><?php echo $change->changes ;?></td>
					</tr>
		<?php
									}
								}
							}
						}
					}
				}	
			}
		} else {
					echo '<div style="color:black;"><p>No History found for this Request</p></div>';
		}
	?>
	</table>
</div> -->