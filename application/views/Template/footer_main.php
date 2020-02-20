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

    <!-- <script>
    var txt = "";
    var numbers = [45, 4, 9, 16, 25];
    numbers.forEach(myFunction);
    document.getElementById("demo").innerHTML = txt;

    function myFunction(value) {
        txt = txt + value + "<br>"; 
    }
    </script> -->

    <script type="text/javascript">
        function view_project(projectID, taskID, requestID) {
            var projectID = projectID;
            var taskID = taskID;
            var requestID = requestID;
            var json = {'projectID':'" + projectID + "','taskID':'" + taskID + "','requestID':'" + requestID + "'};
            $.ajax({
                type:'POST',
                url:"<?php echo site_url('request/view_request'); ?>/" + projectID + "/" + taskID + "/" + requestID,
                dataType: 'json',
                data: json,
                success:function(data) {
                    //var req = $.parseJSON(data);
                    console.log(data.curr_request);
                    console.log(data.translation_changes);
                    console.log(data.translations);
                    //curr_request = '"curr_request_json":' + JSON.stringify(data.curr_request);
                    //translations = '"translations_json":' + JSON.stringify(data.translations);
                    //translation_changes = '"translation_changes_json":' + JSON.stringify(data.translation_changes);

                    //Project Details
                    document.getElementById("projectID").innerHTML = data.curr_request[0]['projectID'];
                    document.getElementById("taskID").innerHTML = data.curr_request[0]['taskID'];
                    document.getElementById("projectOwner").innerHTML = data.curr_request[0]['projectOwner'];
                    document.getElementById("docType").innerHTML = data.curr_request[0]['docType'];
                    document.getElementById("sender").innerHTML = data.curr_request[0]['sender'];
                    document.getElementById("receiver").innerHTML = data.curr_request[0]['receiver'];
                    document.getElementById("revisionNumber").innerHTML = data.curr_request[0]['revisionNumber'];
                    document.getElementById("environment").innerHTML = data.curr_request[0]['environment'];
                    document.getElementById("status").innerHTML = data.curr_request[0]['status'];
                    document.getElementById("requestDate").innerHTML = data.curr_request[0]['requestDate'];
                    document.getElementById("deployDate").innerHTML = data.curr_request[0]['deployDate'];
                    
                    for(var i; i < 4; i++) {
                        var clone = $(this).parents(".translationInput").clone()
                        .insertAfter(".translationInput:last")
                        .attr("id", "translationInput" + i);

                        clone.find('[id]').each(function() {
                            //console.log(this.id);
                            var strNewId = $(this).attr('id').replace(/[0-9]/g, i);
                            //console.log("strNewId: " + strNewId);
                            $(this).attr('id', strNewId);
                            $(this).attr('name', strNewId);
                            $(this).val('234234');
                        });
                    }
                }
            });
        };

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
</body>
</html>
