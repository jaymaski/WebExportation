<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Exportation101</title>

	<!-- Local CSS -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/main_css/main.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/styles_css/styles.css">

	<!-- Bootstrap CSS/JS-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

	<!-- Font Awesome JS -->
	<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
	<script defer src="https://use.fontawesome.com/releases/v5.0.13/js/fontawesome.js" integrity="sha384-6OIrr52G08NpOFSZdxxz1xdNSndlD4vdcf/q2myIUVO0VsqaGHJsB0RaBE01VTOY" crossorigin="anonymous"></script>	
</head>
<body>
<div class="wrapper">

<!-- Sidebar  -->
<nav id="sidebar">
	<div class="sidebar-header">
		<button type="button" id="sidebarCollapse" class="btn">
			<i class="fas fa-bars"></i>
		</button>		
		<h3>GTASS Deployment Request Manager</h3>
	</div>

	<ul class="list-unstyled components">
		<li>
			<a class="waves-effect waves-dark"
			href="<?php echo base_url();?>users/index"
			aria-expanded="false">
			<i class="fa fa-home"></i>
			<span class="hide-menu">My Request</span></a>
		</li>

		<li>
			<a class="waves-effect waves-dark" href="<?php echo base_url();?>users/index" aria-expanded="false">
			<i class="fa fa-share-alt"></i>
			<span class="hide-menu">Shared To Me</span></a>
		</li>

		<li>
			<a class="waves-effect waves-dark"
			href="<?php echo base_url();?>users/index"
			aria-expanded="false">
			<i class="fa fa-home"></i>
			<span class="hide-menu">Exported</span></a>
		</li>		

		<li>
			<a href="#homeSubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle"><i class="fa fa-table"></i> <span>Request Forms</span></a>
			<ul class="collapse list-unstyled" id="homeSubmenu">
				<li>
					<a class="waves-effect waves-dark" href="<?php echo base_url();?>users/index" aria-expanded="false">
					<i class="fas fa-globe-asia"></i>
					<span class="hide-menu">Translation Request Form</span></a>
				</li>

				<li>
					<a class="waves-effect waves-dark" href="<?php echo base_url();?>users/index" aria-expanded="false">
					<i class="fa fa-cogs"></i>
					<span class="hide-menu">Process Model Request Form</span></a>
				</li>

				<li>
					<a class="waves-effect waves-dark" href="<?php echo base_url();?>users/index">
					<i class="fa fa-table"></i>
					<span class="hide-menu">Table Change Request Form</span></a>
				</li>				
			</ul>
		</li>	  
	</ul>
</nav>
<!-- End Sidebar  -->

<!-- Page Content  -->
<div id="content">
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<div class="container-fluid">

			<button type="button" id="createRequest" class="btn btn-success">
				Create New Request
			</button>
			
			<button type="button" id="shareRequest" data-toggle="modal" data-target="#shareModal" class="btn btn-info">
				Share Request
			</button>
			
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="nav navbar-nav ml-auto">
					<li class="nav-item active">
						<a class="nav-link" href="#">User Name</a>
					</li>
					<li class="logout nav-item">
						<?php echo form_open('users/logout'); ?>
							<button class="btn btn-sm btn-danger nav-link" type="submit">
								Logout
							</button>
						</form>						
					</li>
				</ul>
			</div>
		</div>
	</nav>
