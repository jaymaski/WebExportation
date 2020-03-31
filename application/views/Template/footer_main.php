</div>
</div>
    <!-- AJAX -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    <!-- Local JS -->
	<script src="<?php echo base_url(); ?>/assets/script/scripts.js"></script>
    <!-- jQuery Custom Scroller CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>	
	
    <script>
        ClassicEditor
        .create(document.querySelector('#richTextEditor'), {
            toolbar: [ 'heading', '|', 'bold', 'italic', 'link', '|', 'bulletedList', 'numberedList', 'blockQuote', 'codeBlock' ],
            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                    { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' }
                ]
            },
            codeBlock: {
                
            }  
        })
        .catch( error => {
            //console.error( error );
        });
    </script>

    <script type="text/javascript">
        function view_project(projectID, taskID) {        
            var projectID = projectID;
            var taskID = taskID;
            var json = {'projectID':'" + projectID + "','taskID':'" + taskID + "','requestID':'" + requestID + "'};
            $.ajax({
                type:'POST',
                url:"<?php echo site_url('request/view_request'); ?>/" + projectID + "/" + taskID,
                dataType: 'json',
                data: json,
                success:function(data) {
                    console.log(data.uat_requests);
                    console.log(data.prod_requests);
                    console.log(data.translation_changes);
                    console.log(data.translations);
                    console.log(data.impacted);

                    //Project Details
                    document.getElementById("projectID").innerHTML = data.uat_requests[0]['projectID'];
                    document.getElementById("taskID").innerHTML = data.uat_requests[0]['taskID'];
                    document.getElementById("projectOwner").innerHTML = data.uat_requests[0]['projectOwner'];
                    document.getElementById("docType").innerHTML = data.uat_requests[0]['docType'];
                    document.getElementById("sender").innerHTML = data.uat_requests[0]['sender'];
                    document.getElementById("receiver").innerHTML = data.uat_requests[0]['receiver'];
                    
                    var requestsNum = Object.keys(data.uat_requests).length;
                    var translationNum = Object.keys(data.translations).length;
                    var impactedNum = Object.keys(data.impacted).length;
                    
                    $( ".revisions:not(:first)").each(function(){
                        $(this).remove();
                    });
                    $( ".translations:not(:first)").each(function(){
                        $(this).remove();
                    });
                    $( ".impacted:not(:first)").each(function(){
                        $(this).remove();
                    });
                    $(".commentSection:not(:first)").each(function(){
                        $(this).remove();
                    });                      

                    //Translation Changes
                    for(var i = 0; i < requestsNum; i++){
                        //Cloning (Per Revision)
                        if(i != 0){
                            var cloneRevision = $('#revisions').clone(true)
                            .insertAfter(".revisions:last")
                            .attr("id", "revisions" + i);

                            cloneRevision.find('[id]').each(function() {
                                var strNewId = $(this).attr('id').replace(/[0-9]/g, i);
                                $(this).attr('id', strNewId);
                                $(this).attr('name', strNewId);
                            });
                        }

                        //Mapping 
                        document.getElementById("revisionNumber["+i+"]").innerHTML = data.uat_requests[i]['revisionNumber'];
						
                        document.getElementById("uatRequestDate["+i+"]").innerHTML = data.uat_requests[i]['requestDate'];
                        document.getElementById("uatDeployDate["+i+"]").innerHTML = data.uat_requests[i]['deployDate']; 
						document.getElementById("uatRequestID["+i+"]").innerHTML = data.uat_requests[i]['requestID'];
						
						document.getElementById("prodRequestDate["+i+"]").innerHTML = data.prod_requests[i]['requestDate'];
						document.getElementById("prodDeployDate["+i+"]").innerHTML = data.prod_requests[i]['deployDate']; 
						document.getElementById("prodRequestID["+i+"]").innerHTML = data.prod_requests[i]['requestID'];
						
                        if(data.uat_requests[i]['status'] == "Exported"){
                            document.getElementById("status["+i+"]").innerHTML = data.uat_requests[i]['status'] + " to " + data.uat_requests[i]['environment'];
                        }
                        else{
                            document.getElementById("status["+i+"]").innerHTML = data.uat_requests[i]['status'];
                        }  
						
						if(data.prod_requests[i]['status'] == "Exported"){
                            document.getElementById("status["+i+"]").innerHTML = data.prod_requests[i]['status'] + " to " + data.prod_requests[i]['environment'];
                        }
                        else{
                            document.getElementById("status["+i+"]").innerHTML = data.prod_requests[i]['status'];
                        }  

                        for(var j = 0; j < translationNum; j++){
                            //Cloning (Per translation)
                            if(	data.uat_requests[i]['requestID'] == data.translations[j]['uatRequestID'] || 
								data.prod_requests[i]['requestID'] == data.translations[j]['prodRequestID']){
                                if(j != 0){
                                    var cloneTranslation = $('#translations').clone(true)
                                    .insertAfter(".translations:last")
                                    .attr("id", "translations" + j);

                                    cloneTranslation.find('[id]').each(function() {
                                        var NewID = $(this).attr('id').replace(/[0-9]/g, j);
                                        $(this).attr('id', NewID);
                                        $(this).attr('name', NewID);
                                    });
                                }           

                                //Mapping              
                                document.getElementById("changes["+j+"]").innerHTML = data.translation_changes[j]['changes'];
                                document.getElementById("name["+j+"]").innerHTML = data.translations[j]['name'];
                                document.getElementById("internalID["+j+"]").innerHTML = data.translations[j]['internalID'];
                            }

                            for(var k = 0; k < impactedNum; k++){
                                //Cloning (Per translation)
                                if(data.translations[k]['translationID'] = data.impacted[k]['translationID']){
                                    if(k != 0){
                                        var cloneTranslation = $('#impacted').clone(true)
                                        .insertAfter(".impacted:last")
                                        .attr("id", "impacted" + k);

                                        cloneTranslation.find('[id]').each(function() {
                                            var NewID_1 = $(this).attr('id').replace(/[0-9]/g, k);
                                            $(this).attr('id', NewID_1);
                                            $(this).attr('name', NewID_1);
                                        });
                                    }           

                                    //Mapping              
                                    document.getElementById("changes["+k+"]").innerHTML = data.impacted[k]['changes'];
                                }
                            }
                        }
                    }
                }
            });
        };

        function comments(requestID) {    
            //console.log(data.recommendations);
            var requestID = requestID;
            $.ajax({
                type:'POST',
                url:"<?php echo site_url('request/view_request_comments'); ?>",
                dataType: 'json',
                data: {
                    requestID: requestID
                },
                success:function(data) {
                    var commentsNum = Object.keys(data.recommendations).length;   
                    $(".commentSection:not(:first)").each(function(){
                        $(this).remove();
                    });                       
                    $(".comments").each(function(){
                        $(this).innerHTML = '';
                    });     
                    $(".names").each(function(){
                        $(this).innerHTML = '';
                    });                                      
                    //console.log(data.recommendations);

                    for(var l = 0; l < commentsNum; l++){
                        //Cloning (Per translation)
                        if(l != 0){
                            var cloneTranslation = $('#commentSection').clone(true)
                            .insertAfter(".commentSection:last")
                            .attr("id", "commentSection" + l);

                            cloneTranslation.find('[id]').each(function() {
                                var NewID_2 = $(this).attr('id').replace(/[0-9]/g, l);
                                $(this).attr('id', NewID_2);
                                $(this).attr('name', NewID_2);
                            });
                        }   

                        //Mapping              
                        document.getElementById("comments["+l+"]").innerHTML = data.recommendations[l]['recommendation'];
                        document.getElementById("names["+l+"]").innerHTML = data.recommendations[l]['recommendedBy'];
                    }
                }
            });            
        }

        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });

		$(document).ready(function() {
        //Fixing jQuery Click Events for the iPad
            var ua = navigator.userAgent,
            event = (ua.match(/iPad/i)) ? "touchstart" : "click";
            if ($('.revisions').length > 0) {
                $('.revisions .header').on(event, function() {
                    $(this).toggleClass("active", "").nextUntil('.header').css('display', function(i, v) {
                        return this.style.display === 'table-row' ? 'none' : 'table-row';
                    });
                });
            }
        })
	</script>

    <script type="text/javascript">
        $(document).ready(function () {
            $("#sidebar").mCustomScrollbar({
                theme: "minimal"
            });

            $('#dismiss, .overlay').on('click', function () {
                $('#sidebar').removeClass('active');
                $('.overlay').removeClass('active');
            });

            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').addClass('active');
                $('.overlay').addClass('active');
                $('.collapse.in').toggleClass('in');
                $('a[aria-expanded=true]').attr('aria-expanded', 'false');
            });
        });
    </script>	

    <script>
        function expandActions(){
            if(window.getComputedStyle(document.getElementById('row-1'),null).getPropertyValue("width") == '0px'){
                document.getElementById('row-1').style.width = '10%';
            }    
            else{
                document.getElementById('row-1').style.width = '0%';
            }
        }

        //init elements
        var projectID = document.getElementById('projectID');
        var taskID = document.getElementById('taskID');
        var projectOwner = document.getElementById('projectOwner');
        var sender = document.getElementById('sender');
        var receiver = document.getElementById('receiver');
        var documentType = document.getElementById('docType');

        //init content holders
        var projectIDContent =  projectID.innerText;
        var taskIDContent = taskID.innerText;
        var projectOwnerContent = projectOwner.innerText;
        var senderContent = sender.innerText;
        var receiverContent = receiver.innerText;
        var documentTypeContent = documentType.innerText;

        //init button listeners
        var editButton = document.getElementById('edit')
        var saveButton = document.getElementById('save')
        var shareButton = document.getElementById('share')
        var cancelButton = document.getElementById('cancel')        

        //function triggers
        saveButton.style.display = 'none';
        cancelButton.style.display = 'none';
        saveButton.onclick = saveChanges;
        editButton.onclick = toggleEdit;
        cancelButton.onclick = toDisplay;

        //main edit
        function toggleEdit(){
            var response = confirm('Editing the document will remove you from the queue! Continue?');
            if (response == true) {
                var isEdit = false;
                if(isEdit){
                    toDisplay();
                    saveButton.style.display = 'none';
                    isEdit = false;
                }

                else{
                    projectIDContent =  projectID.innerText;
                    taskIDContent = taskID.innerText;
                    projectOwnerContent = projectOwner.innerText;
                    senderContent = sender.innerText;
                    receiverContent = receiver.innerText;
                    documentTypeContent = documentType.innerText; 

                    toEdit();
                    editButton.style.display = 'none';
                    shareButton.style.display = 'none';
                    saveButton.style.display = 'inline';
                    cancelButton.style.display = 'inline';
                    isEdit = true;
                }
            }
        }

        //save to server and update holders
        function saveChanges(){
            projectIDContent = document.getElementById('projectIDInput').value
            taskIDContent = document.getElementById('taskIDInput').value
            projectOwnerContent =  document.getElementById('projectOwnerInput').value
            senderContent =  document.getElementById('senderInput').value
            receiverContent = document.getElementById('receiverInput').value
            documentTypeContent =  document.getElementById('documentTypeInput').value
            
            toDisplay();
            isEdit = false;

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('request/update') ?>",
                dataType: "JSON",
                data: {
                    projectID: projectIDContent,
                    taskID: taskIDContent,
                    projectOwner:projectOwnerContent,
                    sender:senderContent,
                    receiver:receiverContent,
                    docType:documentTypeContent,
                },
                success: function(data) {
                    console.log(data);
                },
                error: function(){
                    alert('failed');
                }
            });
        }

        //toggle textbox
        function toEdit(){
            projectID.innerHTML = '<input name=\'projectIDInput\' id=\'projectIDInput\' value='+projectIDContent+ '></input>';
            taskID.innerHTML = '<input name=\'taskIDInput\' id=\'taskIDInput\' value='+taskIDContent+ '></input>';
            projectOwner.innerHTML = '<input name=\'projectOwnerInput\' id=\'projectOwnerInput\' value='+projectOwnerContent+ '></input>';
            sender.innerHTML = '<input name=\'senderInput\' id=\'senderInput\' value='+senderContent+ '></input>';
            receiver.innerHTML = '<input name=\'receiverInput\' id=\'receiverInput\' value='+receiverContent+ '></input>';
            documentType.innerHTML = '<input name=\'documentTypeInput\' id=\'documentTypeInput\' value='+documentTypeContent+ '></input>';
        }

        //toggle display
        function toDisplay(){
            saveButton.style.display = 'none';
            editButton.style.display = 'inline';
            shareButton.style.display = 'inline';
            cancelButton.style.display = 'none';
            projectID.innerHTML = projectIDContent;
            taskID.innerHTML = taskIDContent;
            projectOwner.innerHTML = projectOwnerContent;
            sender.innerHTML =senderContent;
            receiver.innerHTML = receiverContent;
            documentType.innerHTML =documentTypeContent;
        }    
    </script>

    <script type='text/javascript'>
        $(document).ready(function(){
            // Detect pagination click
            $('#pagination').on('click','a',function(e){
                e.preventDefault(); 
                var pageno = $(this).attr('data-ci-pagination-page');
                console.log(pageno);
                loadPagination(pageno);
            });

            loadPagination(0);

            // Load pagination
            function loadPagination(pagno){
                $.ajax({
                url:"<?php echo site_url('request/loadRecord'); ?>/" + pagno,
                type: 'get',
                dataType: 'json',
                success: function(response){
                    $('#pagination').html(response.pagination);
                        createTable(response.uat_requests,response.row);
                        console.log(response);
                    }
                });
            }

            // Create table list
            function createTable(uat_requests,sno){
                sno = Number(sno);
                $('#requests tbody').empty();
                for(index in uat_requests){
                    if(uat_requests[index].environment == 'UAT') {
                        if(uat_requests[index].status == 'Exported') {
                            var projectID = uat_requests[index].projectID;
                            var taskID = uat_requests[index].taskID;
                            var environment = uat_requests[index].environment;
                            var status = uat_requests[index].status;
                            var owner = uat_requests[index].owner;
                            var requestDate = uat_requests[index].requestDate;
                            //content = content.substr(0, 60) + " ...";
                            //var link = uat_requests[index].link;
                            sno+=1;

                            var tr = "<tr onclick='this.onclick = view_project(`"+ projectID +"`, `"+ taskID +"`)' data-toggle='modal' data-target='#view_request'>";
                            //var tr = "<tr" + onclick = "this.onclick = view_project('" + uat_requests[index].projectID + ", '" + uat_requests[index].taskID + "') data-toggle='modal' data-target='#view_request'" + ">";
                            tr += "<td>"+ projectID +"</td>";
                            tr += "<td>"+ "PROD_CR-csremail-au-wiscust-au-PO(B2BE#3893292)" +"</td>";
                            tr += "<td>"+ owner +"</td>";
                            tr += "<td>"+ "NORMAL" +"</td>";
                            tr += "<td>"+ requestDate +"</td>";                            
                            tr += "<td>"+ environment +"</td>";     
                            tr += "<td>"+ status +"</td>"; 
                            tr += "</tr>";
                            $('#requests tbody').append(tr);
                        }
                    }
                }
            }
        });
    </script>    
    <script type="text/javascript">
        var regex = /^(.+?)(\d+)$/i;
        var addTranslationIndex = 1;
        function add() {
            let template = `             <div id="translation">
                                                <div>
                                                    <table name="revision-translations0">
                                                        <tr><td colspan="4" class="action-remove" onclick="remove(this)"><span class="span-remove">Remove translation</span><td></tr>
                                                        <tr>
                                                            <td class="label-class">Test Internal ID: </td>
                                                            <td class="input-class" type="text" name="translationDetails.translation.${addTranslationIndex}.testId" contenteditable="true"></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="label-class">Translation Name:</td>
                                                            <td class="input-class" type="text" name="translationDetails.translation.${addTranslationIndex}.translationName" contenteditable="true"></td>
                                                            <td class="label-class">Release as Document Type:</td>
                                                            <td class="input-class" type="text" name="translationDetails.translation.${addTranslationIndex}.releaseAsDocType" contenteditable="true"></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="label-class">Translation Changes</td>
                                                            <td colspan="4" ><textarea class="input-class" name="translationDetails.translation.${addTranslationIndex}.translationChange" ></textarea></td>
                                                        </tr>
                                                    </table>
                                                    <table id="translationDetails.translation.${addTranslationIndex}.impacted.0">
                                                        <tr>
                                                            <th colspan="4">List of impacted relationship</th>
                                                        </tr>
                                                        <tr><td colspan="4" class="action" onclick="addImpacted(this)"><span class="span-add">Add Impacted</span><td></tr>
                                                        <tr>
                                                            <td class="label-class">Relationship (Sender, Receiver & Documentype </td>
                                                            <td class="input-class" type="text" name="translationDetails.translation.${addTranslationIndex}.impacted.0.impactedRelationship" contenteditable="true"></td>
                                                            <td class="label-class">List of 3 LIVE internal ID vs 3 TEST internal ID</td>
                                                            <td class="input-class" type="text" name="translationDetails.translation.${addTranslationIndex}.impacted.0.testIdVSliveID" contenteditable="true"></td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>`;

        let container = document.getElementById('translation');
        let div = document.createElement('div');
        div.innerHTML = template;
        container.appendChild(div);
        addTranslationIndex++;

        };

        function addImpacted(e) {

            var tableID ="";
            var impIndex="";
            var newName = "";
            while(e.tagName.toUpperCase() !== "TABLE") {
                e = e.parentNode;
            }
            tableID =e.id;
            impIndex = tableID.substring(tableID.length-1,tableID.length);
            newName = tableID.substring(0,tableID.length-1) + (parseInt(impIndex)+1);
            console.log(e.id);
            let container = document.getElementById(e.id);
            let div = document.createElement('tr');
            let template = `<td colspan="4" class="action" onclick="removeI(this)"><span class="span-remove">Remove Impacted</span><td>`;
            div.innerHTML = template;
            container.appendChild(div);
            div = document.createElement('tr');
                template = `<td class="label-class">Sender: </td>
                            <td class="input-class" type="text" name="${newName}.sender" contenteditable="true"></td>
                            <td class="label-class">Receiver:</td>
                            <td class="input-class" type="text" name="${newName}.recever" contenteditable="true"></td>`;
            div.innerHTML = template;
            container.appendChild(div);
            div = document.createElement('tr');
                template = `<td class="label-class">Documentype: </td>
                            <td class="input-class" type="text" name="${newName}.documentType" contenteditable="true"></td>
                            <td class="label-class">Three Internal ID (Test vs LIVE): </td>
                            <td class="input-class" type="text" name="${newName}.testvslive" contenteditable="true"></td>`;
            div.innerHTML = template;
            container.appendChild(div);

            e.setAttribute("id",newName)};

        function remove(e) {
            console.log(e.parentElement.parentElement.parentElement.parentElement);
            e.parentElement.parentElement.parentElement.parentElement.remove();
            addTranslationIndex--;
        }

        function removeI(e) {
            console.log(e.className.indexOf("action"));

            while(e.tagName.toUpperCase() !== "TABLE") {
                e = e.parentNode;
            }
            tableID =e.id;
            console.log(tableID);
        }

        var selectedRow = null;

        $('#btn_save').on('click', function() {


        let elements = document.querySelectorAll('#add-request .input-class');
        let data = {};
        for (let i = 0; i < elements.length; i++) {
            let el = elements[i];
            let val = "";

        if( el.innerHTML.length !=0) val = el.innerHTML;
        else val = el.value;

        if (!val) val = "";

        let fullName = el.getAttribute("name");
        if (!fullName) continue;
        let fullNameParts = fullName.split('.');
        let prefix = '';
        let stack = data;
        for (let k = 0; k < fullNameParts.length - 1; k++) {
            prefix = fullNameParts[k];
            if (!stack[prefix]) {
            stack[prefix] = {};
            }
            stack = stack[prefix];
        }
        prefix = fullNameParts[fullNameParts.length - 1];
        if (stack[prefix]) {

            let newVal = stack[prefix] + ',' + val;
            stack[prefix] += newVal;
        } else {
            stack[prefix] = val;
        }
        }
        let jsonData = JSON.stringify(data);
        console.log(jsonData);

        $.ajax({
            type: "POST",
            url: "<?php echo site_url('request/save') ?>",
            dataType: "JSON",
            data: {
                data: jsonData
            },
            success: function(data) {
                console.log(data);
                console.log("pasok na :D ");
            }
        });
        });
    </script>
</body>
</html>
