<!DOCTYPE html>
<!-- 
Template Name:  SmartAdmin Responsive WebApp - Template build with Twitter Bootstrap 4
Version: 4.0.2
Author: Sunnyat Ahmmed
Website: http://gootbootstrap.com
Purchase: https://wrapbootstrap.com/theme/smartadmin-responsive-webapp-WB0573SK0
License: You must have a valid license purchased only from wrapbootstrap.com (link above) in order to legally use this theme for your project.
-->
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>
		Forward Sports - Labeling Stock Management -
	</title>
	<style>
		#overlay {
			position: fixed;
			top: 0;
			z-index: 100;
			width: 100%;
			height: 100%;
			display: none;
			background: rgba(0, 0, 0, 0.6);
		}

		.cv-spinner {
			height: 100%;
			display: flex;
			justify-content: center;
			align-items: center;
		}

		.spinner {
			width: 40px;
			height: 40px;
			border: 4px #ddd solid;
			border-top: 4px #2e93e6 solid;
			margin-right: 380px;
			border-radius: 50%;
			animation: sp-anime 0.8s infinite linear;
		}

		@keyframes sp-anime {
			100% {
				transform: rotate(360deg);
			}
		}

		.is-hide {
			display: none;
		}
	</style>
	<meta name="description" content="Introduction">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no, user-scalable=no, minimal-ui">
	<!-- Call App Mode on ios devices -->
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<!-- Remove Tap Highlight on Windows Phone IE -->
	<meta name="msapplication-tap-highlight" content="no">

	<!-- base css -->
	<link rel="stylesheet" media="screen, print" href="<?php echo base_url('/') ?>assets/css/vendors.bundle.css">
	<link rel="stylesheet" media="screen, print" href="<?php echo base_url('/') ?>assets/css/app.bundle.css">
	<!-- Place favicon.ico in the root directory -->
	<link rel="apple-touch-icon" sizes="180x180" href="<?php echo base_url('/') ?>assets/img/Forward.png">
	<link rel="icon" type="<?php echo base_url('/') ?>assets/img/Forward.png" sizes="32x32" href="<?php echo base_url('/') ?>assets/img/Forward.png">
	<link rel="mask-icon" href="<?php echo base_url('/') ?>assets/img/Forward.png" color="#5bbad5">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- Custom style CSS -->
	<!-- <link rel="stylesheet" media="screen, print" href="assets/css/vendors.bundle.css">
        <link rel="stylesheet" media="screen, print" href="assets/css/app.bundle.css"> -->
	<link rel="stylesheet" href="<?php echo base_url('/') ?>assets/css/custom.css">
	<link rel='shortcut icon' type='image/x-icon' href='<?php echo base_url('/') ?>assets/img/Dlogo.png' />
	<script src="assets/js/jquery.js"></script>
	<link rel="stylesheet" href="<?php echo base_url('/') ?>assets/bundles/pretty-checkbox/pretty-checkbox.min.css">
	<link rel="stylesheet" href="<?php echo base_url('/') ?>assets/css/components.css">
	<link rel="stylesheet" href="<?php echo base_url('/') ?>assets/bundles/bootstrap-daterangepicker/daterangepicker.css">
	<link rel="stylesheet" href="<?php echo base_url('/') ?>assets/bundles/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
	<link rel="stylesheet" href="<?php echo base_url('/') ?>assets/bundles/select2/dist/css/select2.min.css">
	<link rel="stylesheet" href="<?php echo base_url('/') ?>assets/bundles/jquery-selectric/selectric.css">
	<link rel="stylesheet" href="<?php echo base_url('/') ?>assets/bundles/bootstrap-timepicker/css/bootstrap-timepicker.min.css">
	<link rel="stylesheet" href="<?php echo base_url('/') ?>assets/bundles/bootstrap-tagsinput/dist/bootstrap-tagsinput.css">
	<link rel="stylesheet" href="<?php echo base_url('/') ?>assets/Select/select2.min.css">

	<script src="<?php echo base_url('/') ?>assets/js/jquery.min.js"></script>
	<script src="<?php echo base_url('/') ?>assets/js/selectize.min.js" integrity="sha256-+C0A5Ilqmu4QcSPxrlGpaZxJ04VjsRjKu+G82kl5UJk=" crossorigin="anonymous"></script>
	<link rel="stylesheet" href="<?php echo base_url('/') ?>assets/css/selectize.bootstrap3.min.css" integrity="sha256-ze/OEYGcFbPRmvCnrSeKbRTtjG4vGLHXgOqsyLFTRjg=" crossorigin="anonymous" />

	<script type="text/javascript" src="<?php echo base_url('/') ?>assets/js/bootstrap.min.js"></script>
	<style>
		.fa-angle-down:before {
			content: "\f107";
			display: none;
		}

		.fa-angle-up:before {
			content: "\f106";
			display: none;
		}
	</style>
</head>
