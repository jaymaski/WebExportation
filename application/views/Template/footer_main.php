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
                    // console.log(data.requests);
                    // console.log(data.curr_request);
                    // console.log(data.translation_changes);
                    console.log(data.translations);
                    console.log(data.impacted);

                    //Project Details
                    document.getElementById("projectID").innerHTML = data.requests[0]['projectID'];
                    document.getElementById("taskID").innerHTML = data.requests[0]['taskID'];
                    document.getElementById("projectOwner").innerHTML = data.requests[0]['projectOwner'];
                    document.getElementById("docType").innerHTML = data.requests[0]['docType'];
                    document.getElementById("sender").innerHTML = data.requests[0]['sender'];
                    document.getElementById("receiver").innerHTML = data.requests[0]['receiver'];
                    
                    var requestsNum = Object.keys(data.requests).length;
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
                        document.getElementById("revisionNumber["+i+"]").innerHTML = data.requests[i]['revisionNumber'];
                        document.getElementById("requestDate["+i+"]").innerHTML = data.requests[i]['requestDate'];
                        document.getElementById("deployDate["+i+"]").innerHTML = data.requests[i]['deployDate']; 
                        document.getElementById("requestID["+i+"]").innerHTML = data.requests[i]['requestID'];
                        if(data.requests[i]['status'] == "Exported"){
                            document.getElementById("status["+i+"]").innerHTML = data.requests[i]['status'] + " to " + data.requests[i]['environment'];
                        }
                        else {
                            document.getElementById("status["+i+"]").innerHTML = data.requests[i]['status'];
                        }              
                        
                        data

                        for(var j = 0; j < translationNum; j++){
                            //Cloning (Per translation)
                            if(data.requests[i]['requestID'] = data.translations[j]['requestID']){
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
                    console.log(data.recommendations);

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
                        createTable(response.my_requests,response.row);
                    }
                });
            }

            // Create table list
            function createTable(my_requests,sno){
                sno = Number(sno);
                $('#requests tbody').empty();
                for(index in my_requests){
                    if(my_requests[index].environment == 'UAT') {
                        if(my_requests[index].status == 'Exported') {
                            var projectID = my_requests[index].projectID;
                            var taskID = my_requests[index].taskID;
                            var environment = my_requests[index].environment;
                            var status = my_requests[index].status;
                            var owner = my_requests[index].owner;
                            var requestDate = my_requests[index].requestDate;
                            //content = content.substr(0, 60) + " ...";
                            //var link = my_requests[index].link;
                            sno+=1;

                            var tr = "<tr onclick='this.onclick = view_project(`"+ projectID +"`, `"+ taskID +"`)' data-toggle='modal' data-target='#view_request'>";
                            //var tr = "<tr" + onclick = "this.onclick = view_project('" + my_requests[index].projectID + ", '" + my_requests[index].taskID + "') data-toggle='modal' data-target='#view_request'" + ">";
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
</body>
</html>
