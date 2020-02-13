</div>

    <!-- Popper.JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
    
	<!-- Data Table CDN -->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
  	<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
    
    <!-- Local JS -->
	<script src="<?php echo base_url(); ?>/assets/script/scripts.js"></script>
    

    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
        });
    </script>
    
	<script>
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
</body>
</html>