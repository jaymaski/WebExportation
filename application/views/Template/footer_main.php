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
    var cloneIndex = $(".translationInput").length;

    function clone() {

        /* $(this).parents(".translationInput").clone()
		.insertAfter(".translationInput:last")
        .attr("id", "translationInput" +  cloneIndex)
        .find("*") 
        .each(function() {
            var id = this.id || "";
            var match = id.match(regex) || [];
            if (match.length == 3) {
                this.id = match[1] + (cloneIndex);
            }
        })
        .on('click', 'button.add-translation', clone)
    .on('click', 'button.remove', remove);*/


        var clone = $(this).parents(".translationInput").clone()
            .insertAfter(".translationInput:last")
            .attr("id", "translationInput" + cloneIndex);
        clone.find('[id]').each(function() {
            console.log(this.id);
            var strNewId = $(this).attr('id').replace(/[0-9]/g, cloneIndex);
            console.log("strNewId: " + strNewId);
            $(this).attr('id', strNewId);
            $(this).attr('name', strNewId);
            $(this).val('');
        });
        //    $('.translationInput[0]').append(clone);

        cloneIndex++;
    }

    function remove() {
        $(this).parents(".translationInput").remove();
    }
    $("button.add-translation").on("click", clone);
    $("button.remove").on("click", remove);

    var selectedRow = null;

    $('#btn_save').on('click', function() {
        //if (validate()) {
        var formData = {};
        $("form").each(function() {

            $(this)
                .find(".input-class")
                .each(function() {
                    formData[$(this).attr("id")] = $(this).val();
                });
        });
        formData["index"] = cloneIndex;
        var jsonData = JSON.stringify(formData);
        console.log(jsonData);

        // var inputs = document.getElementsByTagName("input");
        // var formValue = "";

        // for (var i = 0; i < inputs.length; i++) {
        //     var message = "";
        //     if (inputs[i].getAttribute('class') == 'input-class') {
        //         message = inputs[i].getAttribute('name') + ":" + message + inputs[i].value + ",";
        //     }
        //     formValue = formValue + message;
        // }
        // console.log(formValue);

        // var str = formValue.substring(0, formValue.length - 1);
        // console.log(str);
        //console.log(JSON.stringify(formData));
        //  console.log(data);
        //  console.log(data.projectDetails.projectId);

        // $.ajax({
        // 	url: "save",
        // 	type: "post", // To protect sensitive data
        // 	dataType: "JSON",
        // 	data: formData,
        // 	success: function(data) {
        // 		alert("PUmasok na");
        // 	}
        // });
        // var projecID = document.getElementById('projectId').value
        //   console.log('projecID in footer: ' + data[0][projecId]);
        //var taskID = $('#taskID').val();
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
    //          $("button.submit-request").on("click", onFormSubmit);
</script>



</body>

</html>