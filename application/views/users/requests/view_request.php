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
				<th>Document</th>
				<td><?php echo $request->docType; ?></td>
			</tr>

			<tr>
				<th>Sender</th>
				<td><?php echo $request->sender; ?></td>
				<th>Receiver</th>
				<td><?php echo $request->receiver; ?></td>
			</tr>

			<?php } ?>	
		</table>
	</div>
	<?php } else {
		echo '<div class="none-found">No History found for this Request</div>';
	} ?>

	<?php if($requests){
		foreach ($requests as $request) { ?>
		<div class="container view-request">
			<table class="revisions table table-bordered">
				<tr class="header text-dark">
					<th colspan="4" class="text-center">
						REVISION <?php echo $request->revisionNumber; ?>
						<span><?php echo $request->status; ?> to <?php echo $request->environment; ?></span>
					</th>
				<tr>

				<tr>
					<th>Request Date</th>
					<td><?php echo $request->requestDate; ?></td>
					<th>Deployment Date</th>
					<td><?php echo $request->deployDate; ?></td>
				</tr>					
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