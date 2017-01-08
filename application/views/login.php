<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->view('common/header');
$this->load->view('common/notifications');
?>

<body class="hold-transition login-page1 layout-boxed">
<header class="main-header login-header-custom">
    <!-- Logo -->
    <a href="#" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>EMS</b></span>
      <!-- logo for regular state and mobile devices -->
      <!-- <span class="logo-lg"><b>EMS</b></span> -->
	   <span class="logo-lg logo-png"></span>
	   
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
	<div class="ems-header"><span style="color: #7fbb33;font-weight: bold;">E</span>mployee <span style="color: #7fbb33;font-weight: bold;">M</span>anagement <span style="color: #7fbb33;font-weight: bold;">S</span>ystem</div> 
    </nav>
	
  </header>
<div class="login-box">
  <!-- <div class="login-logo">
    <a href=""><b>Employee Management System</a>
  </div> -->
  <!-- /.login-logo -->
  <div class="login-box-body login-box-custom">
    <p class="login-box-msg"><b>Welcome to EMS</b></p>

    <form action="<?php echo site_url('login/login');?>" method="POST">
      <div class="form-group has-feedback">
        <input type="username" id="username" name="username" class="form-control" value="<?php echo set_value('username'); ?>" placeholder="Username" required>
        <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
		<?php echo form_error('username'); ?>
      </div>
      <div class="form-group has-feedback">
        <input type="password" id="password" name="password" class="form-control" value="" placeholder="Password" required>
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
		<?php echo form_error('password'); ?>
      </div>
      <div class="row">
       
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
        </div>
		<div class="col-xs-8">
          <a href="javascript:void(0);" style="cursor: pointer;" data-toggle="modal" data-target="#forgotpass" class="pull-right">Forgot Password ?</a>
        </div>
		
        <!-- /.col -->
      </div>
    </form>
  </div>
  
  
  <div id="forgotpass" class="modal fade" role="dialog">	
	<form name="forgotpass" action="<?php echo site_url("login/forgotpassword");?>" id="forgotpass_form" method="POST" enctype="multipart/form-data">	
	<div class="modal-dialog">	 
		<div class="modal-content">	
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Forgot Password</h4>	
			</div>			  		
			<div class="modal-body" style="height: 200px;">
			
				
				<div class="form-group">
					<div class="input-group">
					  <div class="input-group-addon">
						<i class="fa fa-envelope"></i>
					  </div>
					  <input type="email" class="form-control" name="official_email" id="user_official_email" required class="form-control" placeholder="Enter Official Email Id">
					</div>
				</div>
			
				<div class="form-group">
				 
					<div class="input-group">
					  <div class="input-group-addon">
						<i class="fa fa-lock"></i>
					  </div>
					  <input type="captcha" class="form-control" name="captcha" id="captcha" required class="form-control" placeholder="Enter Below Captcha">
					  <input type="hidden" class="form-control" name="word" id="word" required class="form-control" value="<?=$this->session->userdata('captchaCode');?>">
					</div>
				</div>
				
				<div class="form-group">
				  <p id="captImg"><?php echo $captchaImg; ?></p>
				  <p><a href="javascript:void(0);" class="refreshCaptcha" ><i class="fa fa-refresh"></i></a></p>
				</div>
				
				
			
				
				</form>	
			</div>	
			<div class="modal-footer">	
				<button type="submit" class="btn btn-primary" >Send</button>	
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>	
			</div>		
		</div>	
	</div>	
	
	</form>
	</div>
  
</div>

<script>
	$(document).ready(function(){
		$('.refreshCaptcha').on('click', function(){
			$.get('<?php echo site_url('login/refresh'); ?>', function(data){
				$('#captImg').html(data);
			});
		});
	});
</script>
<!-- /.login-box -->
<footer class="main-footer login-footer-custom">
    <?php echo $this->lang->line('versetal_copyright_content') ;?>
  </footer>
</body>

<?php $this->load->view('common/footer');?>