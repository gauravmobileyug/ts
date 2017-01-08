	<!DOCTYPE html>
	<html>
	<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>EMS</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">  <link rel="icon" href="<?php echo base_url('assets/images/versetal-print.png');?>" type="image/gif" sizes="16x16">
	<!-- Bootstrap 3.3.6 -->
	<link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css');?>">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css');?>">
	<!-- Ionicons -->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/ionicons.min.css');?>">
	<!-- jvectormap -->
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css');?>">
	<!-- Theme style -->
	<link rel="stylesheet" href="<?php echo base_url('assets/dist/css/AdminLTE.min.css');?>">
	<!-- AdminLTE Skins. Choose a skin from the css/skins
	folder instead of downloading all of them to reduce the load. -->
	<link rel="stylesheet" href="<?php echo base_url('assets/dist/css/skins/_all-skins.min.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/css/custom.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/pace/pace.min.css');?>">


	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/iCheck/flat/blue.css');?>">
	<!-- Morris chart -->
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/morris/morris.css');?>">
	<!-- jvectormap -->
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/jvectormap/jquery-jvectormap-1.2.2.css');?>">
	<!-- Date Picker -->
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/datepicker/datepicker3.css');?>">
	<!-- Daterange picker -->
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/daterangepicker/daterangepicker.css');?>">
	<!-- bootstrap wysihtml5 - text editor -->
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css');?>">

	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/fullcalendar/fullcalendar.min.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/fullcalendar/fullcalendar.print.css');?>" media="print">

	<link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css');?>">
	<!-- Ionicons -->
	<link rel="stylesheet" href="<?php echo base_url('assets/css/ionicons.min.css');?>">
	<!-- Date Range Picker -->
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/daterangepicker/daterangepicker.css');?>">
	<!-- Date Picker -->
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/datepicker/datepicker3.css');?>">
	<!-- Select -->
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/select2/select2.min.css');?>">
	<link rel="stylesheet" href="<?php echo base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css');?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/datatables.min.css');?>"/>


	<!-- jQuery 2.2.3 -->
	<script src="<?php echo base_url('assets/plugins/jQuery/jquery-2.2.3.min.js');?>"></script>
	<script src="<?php echo base_url('assets/dist/js/jquery-ui.min.js');?>"></script>
	<!-- Bootstrap 3.3.6 -->
	<script src="<?php echo base_url('assets/bootstrap/js/bootstrap.min.js');?>"></script>

	<script src="<?php echo base_url('assets/plugins/pace/pace.min.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js');?>"></script>
	<script src="<?php echo base_url('assets/dist/js/moment.min.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/fullcalendar/fullcalendar.min.js');?>"></script>



	<script type="text/javascript" src="<?php echo base_url('assets/dist/js/datatables.min.js');?>"></script>
	<script src="<?php echo base_url('assets/dist/js/custom.js');?>"></script>


	<script>
	$(function () {
	//Add text editor
	$("#long_description").wysihtml5();
	});
	</script>


	<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	</head>
	<div id="myModal" class="modal fade" role="dialog">	
		<div class="modal-dialog">	
			<div class="modal-content">	
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Upload Profile Picture</h4>	
				</div>			  		
				<div class="modal-body" style="height: 85px;">
					<form name="profile_pic" action="<?php echo site_url("user/upload_pic");?>" id="profile_form" method="POST" enctype="multipart/form-data">	
						<p style="float:left">				
							<input type="file"  id="profile_pic" name="profile_pic" class="file">	
						</p>		
						<p style="float:right">		
							<a href="#" class="btn btn-primary" onclick="$('#profile_form').submit();">	
							<i class="fa fa-upload"></i>Upload	
							</a>	
						</p>	
					</form>	
				</div>	
				<div class="modal-footer">	
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>	
				</div>		
			</div>	
		</div>	
	</div>
	