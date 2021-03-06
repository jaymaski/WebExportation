<div class="tab-pane fade" id="nav-sharedwithme" role="tabpanel" aria-labelledby="nav-sharedwithme-tab">
 <?php if($shared_requests){?>
	<div class="table-responsive">
		<table class="table-hover table dashboard">
			<thead>
				<tr>
					<th id="request-name">NAME</th>
					<th id="requestor-name">OWNER</th>
					<th id="urgency">URGENCY</th>
					<th id="request-date">EXPORTATION DATE</th>
					<th id="environment">ENVIRONMENT</th>
					<th id="status">STATUS</th>
				</tr>
			</thead>
			<tbody id="data">
				<?php foreach($shared_requests as $request){ ?>
					<tr onclick="this.onclick = view_project('<?php echo $request->projectID; ?>', '<?php echo $request->taskID; ?>', '<?php echo $request->requestID; ?>')" data-toggle="modal" data-target="#view_request">
						<td class="txt-oflo" id="request-name">PROD_CR-csremail-au-wiscust-au-PO(B2BE#3893292)</td>
						<td class="txt-oflo" id="requestor-name"><?php echo $request->owner ;?></td>
						<td class="txt-oflo" id="urgency">NORMAL</td>
						<td class="txt-oflo" id="request-date"><?php echo $request->requestDate ;?></td>
						<td class="txt-oflo" id="environment"><?php echo $request->environment ;?></td>
						<td class="txt-oflo" id="status"><?php echo $request->status ;?></td>
					</tr>
				<?php } ?>
			</tbody>
		</table>
	</div>
	<?php } else {
		$this->view('errors/no-data-found');
	} ?>

