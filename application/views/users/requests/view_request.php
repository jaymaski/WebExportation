<div class="container view-request">
	<table class="project-details">
		<tr>
			<th colspan="4" class="text-center">
				PROJECT DETAILS
			</th>
		</tr>

		<tr>
			<th>Project ID</th>
			<td id="projectID"></td>
			<th>Task ID</th>
			<td id="taskID"></td>
		</tr>

		<tr>
			<th>Project Owner</th>
			<td id="projectOwner"></td>
			<th>Document</th>
			<td id="docType"></td>
		</tr>

		<tr>
			<th>Sender</th>
			<td id="sender"></td>
			<th>Receiver</th>
			<td id="receiver"></td>
		</tr>	
	</table>
</div>


<div class="container view-request">
	<table class="revisions table table-bordered" id="revisions">
		<thead class="header">
			<tr class="header text-dark">
				<th colspan="4" class="text-center" onclick="comments(this.firstElementChild.textContent)">
					REVISION 
					<span class="invisible" id="uatRequestID[0]"></span>
					<span class="invisible" id="prodRequestID[0]"></span>
					<span id="revisionNumber[0]"></span>
					<span id="status[0]"></span>
				</th>
			<tr>
		</thead>
		
		<tbody class="translations" id="translations">
			<tr>
				<th>UAT Request Date</th>
				<td id="uatRequestDate[0]"></td>
				<th>UAT Deployment Date</th>
				<td id="uatDeployDate[0]"></td>
			</tr>
			<tr>
				<th>PROD Request Date</th>
				<td id="prodRequestDate[0]"></td>
				<th>PROD Deployment Date</th>
				<td id="prodDeployDate[0]"></td>
			</tr>
			<tr>
				<td><strong>Test Internal ID:</strong> </td>
				<td id="internalID[0]"></td>
				<th colspan="">Release as Document Type:</th>
				<td id="doctype[0]"></td>
			</tr>
			<tr>
				<th>Translation Name:</th>
				<td id="name[0]"></td>	
				<th>Translation Changes</th>
				<td id="changes[0]" colspan=""></td>
			</tr>

			<span>
				<tr>
					<th>Sender</th>
					<td id="sender[0]"></td>	
					<td rowspan="3" colspan="2"></td>			
				</tr>
				<tr>	
					<th>Receiver</th>
					<td id="receiver[0]" colspan=""></td>				
				</tr>	
				<tr>
					<th>DocumentType</th>
					<td id="docType[0]" colspan=""></td>					
				</tr>							
			</span>
			<tr class="spacer"><td colspan="4"></td></tr>
		</tbody>
	</table>
</div>