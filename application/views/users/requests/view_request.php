<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <title>Exportation101</title>
	<style>
		body {
		  color: #6a6c6f;
		  background-color: #f1f3f6;
		  margin-top: 30px;
		}

		.container {
		  max-width: 960px;
		}

		.table>tbody>tr.active>td,
		.table>tbody>tr.active>th,
		.table>tbody>tr>td.active,
		.table>tbody>tr>th.active,
		.table>tfoot>tr.active>td,
		.table>tfoot>tr.active>th,
		.table>tfoot>tr>td.active,
		.table>tfoot>tr>th.active,
		.table>thead>tr.active>td,
		.table>thead>tr.active>th,
		.table>thead>tr>td.active,
		.table>thead>tr>th.active {
		  background-color: #fff;
		}

		.table-bordered > tbody > tr > td,
		.table-bordered > tbody > tr > th,
		.table-bordered > tfoot > tr > td,
		.table-bordered > tfoot > tr > th,
		.table-bordered > thead > tr > td,
		.table-bordered > thead > tr > th {
		  border-color: #e4e5e7;
		}

		.table tr.header {
		  font-weight: bold;
		  background-color: #fff;
		  cursor: pointer;
		  -webkit-user-select: none;
		  /* Chrome all / Safari all */
		  -moz-user-select: none;
		  /* Firefox all */
		  -ms-user-select: none;
		  /* IE 10+ */
		  user-select: none;
		  /* Likely future */
		}

		.table tr:not(.header) {
		  display: none;
		}

		.table .header td:after {
		  content: "\002b";
		  position: relative;
		  top: 1px;
		  display: inline-block;
		  font-family: 'Glyphicons Halflings';
		  font-style: normal;
		  font-weight: 400;
		  line-height: 1;
		  -webkit-font-smoothing: antialiased;
		  -moz-osx-font-smoothing: grayscale;
		  float: right;
		  color: #999;
		  text-align: center;
		  padding: 3px;
		  transition: transform .25s linear;
		  -webkit-transition: -webkit-transform .25s linear;
		}

		.table .header.active td:after {
		  content: "\2212";
		}
	</style>
	<script>
		$(document).ready(function() {
		  //Fixing jQuery Click Events for the iPad
		  var ua = navigator.userAgent,
			event = (ua.match(/iPad/i)) ? "touchstart" : "click";
		  if ($('.table').length > 0) {
			$('.table .header').on(event, function() {
			  $(this).toggleClass("active", "").nextUntil('.header').css('display', function(i, v) {
				return this.style.display === 'table-row' ? 'none' : 'table-row';
			  });
			});
		  }
		})
	</script>
</head>
    <body>
		<p>Request History</p>
		<?php
			if($request_history){
				foreach ($request_history as $request) {
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
				<!--<th>Revision Number</th>
				<td><?php //echo $request->revisionNumber; ?></td>
				-->
				<!--<th>Environment</th>
				<td><?php //echo $request->environment; ?></td>
				-->
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
		</div>
		
		<p>Current Request</p>
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
				<!--<th>Revision Number</th>
				<td><?php //echo $request->revisionNumber; ?></td>
				-->
				<!--<th>Environment</th>
				<td><?php //echo $request->environment; ?></td>
				-->
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
		</div>
				
						
			
	</body>
</html>