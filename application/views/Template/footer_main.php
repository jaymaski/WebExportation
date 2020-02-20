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
        function mamamo(projectID, taskID, requestID) {
            //alert(projectID + " " + taskID + " " + requestID);
            var projectID = projectID;
            var taskID = taskID;
            var requestID = requestID;
            $.ajax({
                type:'POST',
                url:"<?php echo site_url('request/view_request'); ?>/" + projectID + "/" + taskID + "/" + requestID,
                dataType: 'json',
                data: "{'projectID':'" + projectID + "','taskID':'" + taskID + "','requestID':'" + requestID + "'}",
                success:function(data) {
                    //alert('lel');
                    console.log(data.curr_request);
                    console.log(data.translation_changes);
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
