<div class="tab-pane fade" id="nav-sharedwithme" role="tabpanel" aria-labelledby="nav-sharedwithme-tab">
 <?php if($shared_requests){?>
	<div class="table-responsive">
		<table class="table-hover table dashboard">
			<thead>
				<tr>
					<th id="request-id">ID</th>
					<th id="request-name">NAME</th>
					<th id="requestor-name">OWNER</th>
					<th id="urgency">URGENCY</th>
					<th id="request-date">EXPORTATION DATE</th>
					<th id="environment">ENVIRONMENT</th>
					<th id="status">STATUS</th>
					<th id="actions">ACTIONS</th>
				</tr>
			</thead>
			<tbody>
				<?php 	foreach($shared_requests as $request){?>
				<tr>
					<td class="txt-oflo" id="request-id"><?php echo $request->requestID ;?></td>
					<td class="txt-oflo" id="request-name">PROD_CR-csremail-au-wiscust-au-PO(B2BE#3893292)</td>
					<td class="txt-oflo" id="requestor-name"><?php echo $request->owner ;?></td>
					<td class="txt-oflo" id="urgency">NORMAL</td>
					<td class="txt-oflo" id="request-date"><?php echo $request->requestDate ;?></td>
					<td class="txt-oflo" id="environment"><?php echo $request->environment ;?></td>
					<td class="txt-oflo" id="status"><?php echo $request->status ;?></td>
					<td class="txt-oflo" id="actions" >
						<button class="btn btn-success btn-sm" onclick="window.location.replace('<?php echo site_url('request/view_request').'/'.$request->projectID.'/'.$request->taskID.'/'.$request->requestID; ?>');"> view </button>
						<button class="btn btn-info btn-sm" onclick="$('#modal-summary').modal('show');return false;"> edit </button>
						<button class="btn btn-warning btn-sm" onclick="$('#modal-summary').modal('show');return false;"> share </button>
					</td>
				</tr>
				<?php	} ?>
				
			</tbody>
		</table>
	</div>
<?php 	} else{?>
			<p>No Shared Request found.</p>
<?php }?>