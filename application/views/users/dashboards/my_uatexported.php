<div class="tab-pane fade" id="nav-my-uat-exported" role="tabpanel" aria-labelledby="nav-my-uat-exported-tab">
<?php if($my_requests){?>
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
				</tr>
			</thead>
			<tbody>
				<?php 	$counter = 0;
					foreach($my_requests as $request){
						if($request->environment == "UAT"){
							if($request->status == "Exported"){ ?>
							<tr onclick="this.onclick = view_project('<?php echo $request->projectID; ?>', '<?php echo $request->taskID; ?>', '<?php echo $request->requestID; ?>')" data-toggle="modal" data-target="#view_request">
								<td class="txt-oflo" id="request-id"><?php echo $request->requestID ;?></td>
								<td class="txt-oflo" id="request-name">PROD_CR-csremail-au-wiscust-au-PO(B2BE#3893292)</td>
								<td class="txt-oflo" id="requestor-name"><?php echo $request->owner ;?></td>
								<td class="txt-oflo" id="urgency">NORMAL</td>
								<td class="txt-oflo" id="request-date"><?php echo $request->requestDate ;?></td>
								<td class="txt-oflo" id="environment"><?php echo $request->environment ;?></td>
								<td class="txt-oflo" id="status"><?php echo $request->status ;?></td>
							</tr>
							<?php $counter += 1	;	
							}
						}
					} 
				?>
			</tbody>
		</table>
		<?php if($counter == 0){ ?>
			<?php $this->view('errors/no-data-found'); ?>
		<?php	}	?>
	</div>
	<?php 	} else{?>
		<?php $this->view('errors/no-data-found'); ?>
	<?php }?>
</div>