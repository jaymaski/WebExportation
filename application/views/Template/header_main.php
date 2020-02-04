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
</head>
<body>
<div class="wrapper">

<!-- Sidebar  -->
<nav id="sidebar">
	<div class="sidebar-header">
		<h3>GTASS Deployment Request Manager</h3>
		<button type="button" id="sidebarCollapse" class="btn btn-info">
			<i class="fas fa-align-left"></i>
		</button>
		<button class="btn btn-dark d-inline-block d-lg-none ml-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<i class="fas fa-align-justify"></i>
		</button>
	</div>

	<ul class="list-unstyled components">
	  <li>
		<a
		  class="waves-effect waves-dark"
		  href="index.html"
		  aria-expanded="false"
		  ><i class="fa fa-home"></i
		  ><span class="hide-menu">My Request</span></a
		>
	  </li>
	  <li>
		<a
		  class="waves-effect waves-dark"
		  href="shared-to-me.html"
		  aria-expanded="false"
		  ><i class="fa fa-share-alt"></i
		  ><span class="hide-menu">Shared To Me</span></a
		>
	  </li>
	  <li>
		<a
		  class="waves-effect waves-dark"
		  href="translation-request-form.html"
		  aria-expanded="false"
		  ><i class="fa fa-file-text"></i
		  ><span class="hide-menu"></span>Translation Request Form</a
		>
	  </li>
	  <li>
		<a
		  class="waves-effect waves-dark"
		  href="process-model-request-form.html"
		  aria-expanded="false"
		  ><i class="fa fa-globe"></i
		  ><span class="hide-menu"></span>Process Model Request Form</a
		>
	  </li>
	  <li>
		<a
		  class="waves-effect waves-dark"
		  href="table-request-form.html"
		  aria-expanded="false"
		  ><i class="fa fa-table"></i
		  ><span class="hide-menu"></span>Table Change Request Form</a
		>
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
					<li class="nav-item">
						<a class="nav-link" href="#">Logout</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
