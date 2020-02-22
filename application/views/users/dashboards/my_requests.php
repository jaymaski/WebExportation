<div class="tab-pane fade show active" id="nav-myrequest" role="tabpanel" aria-labelledby="nav-myrequest-tab">
	<div class="table-responsive">
	<?php if ($requests) {?>
		<table class="table table-hover">
			<thead>
				<tr class="header">
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
				</tr>
			</thead>
			<tbody>
			<?php foreach ($requests as $request) { ?>
				<tr onclick="this.onclick = view_project('<?php echo $request->projectID; ?>', '<?php echo $request->taskID; ?>', '<?php echo $request->requestID; ?>')" data-toggle="modal" data-target="#view_request">
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
				</tr>
				<?php } ?>
			</tbody>
		</table>
		<?php } else {
			echo '<div style="color:red;"><p>Record Not Found!</p></div>';
		} ?>
	</div>
</div>