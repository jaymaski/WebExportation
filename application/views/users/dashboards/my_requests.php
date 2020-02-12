<div class="tab-pane fade show active" id="nav-myrequest" role="tabpanel" aria-labelledby="nav-myrequest-tab">
	<div class="table-responsive">
	<?php if ($requests) {?>
		<table class="table table-hover">
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
			<?php foreach ($requests as $request) { ?>
				<tr>
					<td><?php echo $request->indexID; ?></td>
					<td><?php echo $request->projectID; ?></td>
					<td><?php echo $request->projectOwner; ?></td>
					<td><?php echo $request->taskID; ?></td>
					<td><?php echo $request->owner; ?></td>
					<td><?php echo $request->sender; ?></td>
					<td><?php echo $request->receiver; ?></td>
					<td><?php echo $request->revisionNumber; ?></td>
					<td><?php echo $request->docType; ?></td>
					<td><?php echo $request->environment; ?></td>
					<td class="txt-oflo">
						<button class="btn btn-success btn-sm text-light" onclick="window.location.replace('<?php echo site_url('request/view_request').'/'.$request->projectID.'/'.$request->taskID.'/'.$request->requestID; ?>');"> 
							View
						</button>
						<button class="btn btn-info btn-sm" onclick="$('#modal-summary').modal('show');return false;"> edit </button>
						<button class="btn btn-warning btn-sm" onclick="$('#modal-summary').modal('show');return false;"> share </button>
					</td>
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<?php } else {
			echo '<div style="color:red;"><p>Record Not Found!</p></div>';
		} ?>
	</div>
</div>