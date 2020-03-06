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
					<span class="invisible" id="requestID[0]"></span>
					<span id="revisionNumber[0]"></span>
					<span id="status[0]"></span>
				</th>
			<tr>
		</thead>
		
		<tbody class="translations" id="translations">
			<tr>
				<th>Request Date</th>
				<td id="requestDate[0]"></td>
				<th>Deployment Date</th>
				<td id="deployDate[0]"></td>
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