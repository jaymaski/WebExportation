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

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>    
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<!-- Font Awesome JS -->
	<link href="<?php echo base_url(); ?>assets/fonts/fontawesome/css/all.css" rel="stylesheet">
	<!-- Bootstrap CSS/JS-->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">	
	<!-- Google Fonts CDN -->
	<link href="https://fonts.googleapis.com/css?family=Montserrat|Raleway:800&display=swap" rel="stylesheet">
</head>
<body>
	<div class="overlay"></div>
	<div class="wrapper">
		<nav id="sidebar">
			<div id="dismiss">
				<i class="fas fa-arrow-left"></i>
			</div>

			<div class="sidebar-header">
				<h3>Menu</h3>
			</div>

			<ul class="list-unstyled components">
				<li>
					<p class="menu-header" data-toggle="" aria-expanded="false">Dashboards <i class="fab fa-buffer"></i></p>
					<ul class="list-unstyled" id="pageSubmenu">
						<li>
							<a href="<?php echo base_url(); ?>users">Translation Requests</a>
						</li>
						<li>
							<a href="#">Process Model Requests</a>
						</li>
						<li>
							<a href="#">Table Change Requests</a>
						</li>
					</ul>
				</li>
			</ul>

			<ul class="list-unstyled CTAs">
				<li>
					<a href="<?php echo base_url(); ?>users/logout" class="logout">Logout</a>
				</li>
			</ul>
		</nav>

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
						<button type="button" class="btn btn-outline-dark" type="button" data-toggle="modal" data-target="#newRequestModal">
							<i class="fas fa-plus"></i> Create New Request
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
						<button type="button" id="sidebarCollapse" class="btn">
							<i class="fas fa-bars"></i>
							<span>MENU</span>
						</button>							
					</div>
				</div>
			</div>
		</div>

		<!-- newRequestModal -->
		<div class="modal fade" id="newRequestModal" tabindex="-1" role="dialog" aria-labelledby="newRequestModal" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">New Request</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<!-- Modal Body -->
					<div class="modal-body">
					...
					</div>

					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>

		<!-- view_request -->
		<div data-backdrop="static" data-keyboard="true" class="modal fade view_request_modal" id="view_request" tabindex="-1" role="dialog" aria-labelledby="view_request" aria-hidden="true">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<i class="fas fa-times"></i>
			</button>
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<table class="modal-table">
						<tr>
							<td rowspan="2" class="left">
								<div class="modal-body project-section">
									<?php $this->load->view('users/requests/view_request'); ?>
								</div>
							</td>
							<td class="action-section">
								<div class="modal-body action-section-div">
									<button class="btn share" id="share">
										Share
									</button>
									<button class="btn edit" id="edit">
										Edit
									</button>	
									<button class="btn cancel" id="cancel">
										Cancel
									</button>										
									<button class="btn save" id="save">
										Save
									</button>
								</div>
							</td>
						</tr>
						<tr>
							<td class="comment-section">
								<div class="modal-body comment-section-div">
									comment section here
								</div>								
							</td>
						</tr>
					</table>						
				</div>
			</div>
		</div>
