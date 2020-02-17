<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>GTASS Web Exportation</title>

	<!-- Local CSS -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/main_css/main.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/styles_css/styles.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/view_request-form/view_request-form.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/sidebar/sidebar.css">

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
		<nav id="sidebar">
			<div id="dismiss">
				<i class="fas fa-arrow-left"></i>
			</div>

			<div class="sidebar-header">
				<h3>Bootstrap Sidebar</h3>
			</div>

			<ul class="list-unstyled components">
				<p>Dummy Heading</p>

				<li>
					<a href="#pageSubmenu" data-toggle="collapse" aria-expanded="false">Dashboard</a>
					<ul class="collapse list-unstyled" id="pageSubmenu">
						<li>
							<a href="#">Translation</a>
						</li>
						<li>
							<a href="#">Process Model</a>
						</li>
						<li>
							<a href="#">Table</a>
						</li>
					</ul>
				</li>
				<li>
					<a href="#">Portfolio</a>
				</li>
				<li>
					<a href="#">Contact</a>
				</li>
			</ul>

			<ul class="list-unstyled CTAs">
				<li>
					<a href="<?php echo base_url(); ?>users/logout" class="logout">Logout</a>
				</li>
			</ul>
		</nav>
	</div>

	<div id="content">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-auto header logo">
					<img src="https://via.placeholder.com/125/808080/FFFFFFF/C/O" alt="app-icon" height="125" width="125">
				</div>
				<div class= "col header">
					<div class="row header name">
						<p>GTASS DEPLOYMENT REQUEST MANAGER</p>
					</div>
					<div class="row header filters">
						<button type="button" class="btn btn-outline-dark">
							<i class="fa fa-file-text" aria-hidden="true"></i> Create New Request
						</button>
						<span class="search icon"><i class="fa fa-search" aria-hidden="true"></i><input class="search field"type="text" placeholder="Search..." ></span>
					</div>
						
				</div>
				<div class="col-md-auto header accounts">
					<div class="row"> 
						<ul class="tabs">
							<li>Hi, <strong><?php echo $this->session->userdata('name'); ?> </strong><i class="fa fa-user" aria-hidden="true"></i></li>
						</ul>
					</div>
					<div class="row identifier float-right">
						<button type="button" id="sidebarCollapse" class="btn btn-info">
							<i class="fas fa-align-left"></i>
							<span>MENU</span>
						</button>							
					</div>
				</div>
			</div>
		</div>
