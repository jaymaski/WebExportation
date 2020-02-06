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
	<script src="https://use.fontawesome.com/fa7d61d75c.js"></script>
	
	<!-- Google Fonts CDN -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat|Raleway:800&display=swap" rel="stylesheet">

</head>
<body>
<div class="wrapper">

<!-- Page Content  -->
<div id="content">
	<div>
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-auto header logo">
					<img src="https://via.placeholder.com/125/808080/FFFFFFF/C/O" alt="app-icon" height="125" width="125">
				</div>
				<div class= "col">
					<div class="row header name">
						<h3>GTASS DEPLOYMENT REQUEST MANAGER</h3>
					</div>
					<div class="row header filters">
						<button type="button" class="btn btn-outline-dark">
							<i class="fa fa-file-text" aria-hidden="true"></i> Create New Request
						</button>
						
						<button type="button" class="btn btn-outline-dark">
							<i class="fa fa-share-square-o" aria-hidden="true"></i> Share Request
						</button>

						<button type="button" class="btn btn-outline-dark">
							<i class="fa fa-filter" aria-hidden="true"></i> Filter
						</button>
						<span class="search icon"><i class="fa fa-search" aria-hidden="true"></i></span>
						<input class="search field"type="text" placeholder="Search..." >
					</div>
						
				</div>
				<div class="col-md-auto header accounts">
					<ul class="tabs">
						<li>Hi, <strong>Juan Dela Cruz </strong><i class="fa fa-user" aria-hidden="true"></i><li>
						<li>6:00 AM (Friday) 07/02/2020 PHT <i class="fa fa-calendar" aria-hidden="true"></i><li>
						<li><strong><a href="#">Logout <i class="fa fa-sign-out" aria-hidden="true"> </a></strong></i><li>
					</ul>
				</div>
			</div>
		</div>
	</div>
