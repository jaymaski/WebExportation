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



<script type="text/javascript">
    function view_project(projectID, taskID, requestID) {
        var projectID = projectID;
        var taskID = taskID;
        var requestID = requestID;
        var json = {
            'projectID': '" + projectID + "',
            'taskID': '" + taskID + "',
            'requestID': '" + requestID + "'
        };
        $.ajax({
            type: 'POST',
            url: "<?php echo site_url('request/view_request'); ?>/" + projectID + "/" + taskID + "/" + requestID,
            dataType: 'json',
            data: json,
            success: function(data) {
                console.log(data.requests);
                console.log(data.curr_request);
                console.log(data.translation_changes);
                console.log(data.translations);

                //Project Details
                document.getElementById("projectID").innerHTML = data.curr_request[0]['projectID'];
                document.getElementById("taskID").innerHTML = data.curr_request[0]['taskID'];
                document.getElementById("projectOwner").innerHTML = data.curr_request[0]['projectOwner'];
                document.getElementById("docType").innerHTML = data.curr_request[0]['docType'];
                document.getElementById("sender").innerHTML = data.curr_request[0]['sender'];
                document.getElementById("receiver").innerHTML = data.curr_request[0]['receiver'];

                var requestsNum = Object.keys(data.requests).length;
                var translationNum = Object.keys(data.translations).length;

                $(".revisions:not(:first)").each(function() {
                    $(this).remove();
                });
                $(".translations:not(:first)").each(function() {
                    $(this).remove();
                });

                //Translation Changes
                for (var i = 0; i < requestsNum; i++) {
                    //Cloning (Per Revision)
                    if (i != 0) {
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
                    document.getElementById("revisionNumber[" + i + "]").innerHTML = data.requests[i]['revisionNumber'];
                    document.getElementById("requestDate[" + i + "]").innerHTML = data.requests[i]['requestDate'];
                    document.getElementById("deployDate[" + i + "]").innerHTML = data.requests[i]['deployDate'];
                    if (data.requests[i]['status'] == "Exported") {
                        document.getElementById("status[" + i + "]").innerHTML = data.requests[i]['status'] + " to " + data.requests[i]['environment'];
                    } else {
                        document.getElementById("status[" + i + "]").innerHTML = data.requests[i]['status'];
                    }

                    // document.getElementById("environment["+i+"]").innerHTML = data.requests[i]['environment'];
                    // document.getElementById("status["+i+"]").innerHTML = data.requests[i]['status'];                   

                    for (var j = 0; j < translationNum; j++) {
                        //Cloning (Per translation)
                        if (data.requests[i]['requestID'] + data.translations[j]['requestID']) {
                            if (j != 0) {
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
                            document.getElementById("changes[" + j + "]").innerHTML = data.translation_changes[j]['changes'];
                            document.getElementById("name[" + j + "]").innerHTML = data.translations[j]['name'];
                            document.getElementById("internalID[" + j + "]").innerHTML = data.translations[j]['internalID'];
                        }
                    }
                }
            }
        });
    };

    $(document).ready(function() {
        $('#sidebarCollapse').on('click', function() {
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
    $(document).ready(function() {
        $("#sidebar").mCustomScrollbar({
            theme: "minimal"
        });

        $('#dismiss, .overlay').on('click', function() {
            $('#sidebar').removeClass('active');
            $('.overlay').removeClass('active');
        });

        $('#sidebarCollapse').on('click', function() {
            $('#sidebar').addClass('active');
            $('.overlay').addClass('active');
            $('.collapse.in').toggleClass('in');
            $('a[aria-expanded=true]').attr('aria-expanded', 'false');
        });
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
  


        //if (validate()) {
        // var formData = {};
        // $("section").each(function() {
        //     var section = {};

        //     $(this)
        //         .find(".input-class")
        //         .each(function() {
        //             section[$(this).attr("name")] = $(this).val();
        //         });

        //     formData[$(this).attr("name")] = section;
        // });
        // formData["index"] = cloneIndex;
        // var jsonData = JSON.stringify(formData);
        // console.log(jsonData);
        // console.log(document.querySelectorAll('translation0 #impactedtable').length);
        // $.ajax({
        //     type: "POST",

        //     dataType: "JSON",
        //     data: {
        //         data: jsonData
        //     },
        //     success: function(data) {
        //         console.log(data);
        //         console.log("pasok na :D ");
        //     }
        // });


    });
</script>



</body>

</html>