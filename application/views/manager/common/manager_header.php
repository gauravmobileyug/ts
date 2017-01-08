<header class="main-header">
<?php //fn_ems_debug($user_data);?>
    <!-- Logo -->
    <a href="<?php echo site_url('user/dashboard') ;?>" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>EMS</b></span>
      <!-- logo for regular state and mobile devices -->
      <!-- <span class="logo-lg"><b>EMS</b></span> -->
	   <span class="logo-lg logo-png"></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>	  
	  
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
        
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
		  
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
				<?php if(empty($user_data['profile_pic'])):?>
				<span class="glyphicon glyphicon-user custom-user-icon2"></span>
				<?php else:?>
				<img src="<?php echo base_url($user_data['profile_pic']);?>" class="user-image" alt="User Image">
				<?php endif;?>
				<span class="hidden-xs"><?php echo ucwords($user_data['firstname'].' '.$user_data['lastname']);?></span>
            </a>
			
            <ul class="dropdown-menu">
            <!-- User image -->

              <li class="user-header">
				<?php if(empty($user_data['profile_pic'])):?>
					<img src="<?php echo base_url('assets/images/blank_user.png');?>" class="img-circle" alt="User Image" data-toggle="modal"  style="cursor:pointer" data-target="#myModal">
				<?php else:?>
					<img src="<?php echo base_url($user_data['profile_pic']);?>" class="img-circle" alt="User Image" data-toggle="modal"  style="cursor:pointer" data-target="#myModal">
				<?php endif;?>


                <p>

				 <?php echo $user_data['user_designation_description'];?>

                  <small>Working since <?php echo date('M,Y',strtotime($user_data['doj']));?></small>

                </p>

              </li>
             
              <li class="user-footer">
                <div class="pull-left">
					<a href="javascript:void(0);" class="btn btn-primary btn-flat" data-toggle="modal" data-target="#credentials_modal"><i class="fa fa-edit"></i> Change Password</a>
                </div>
                <div class="pull-right">
                  <a href="<?php echo site_url('login/logout');?>" class="btn btn-danger btn-flat"><i class="fa fa-sign-out"></i> Sign out</a>
                </div>
              </li>
			  
            </ul>
          </li>
			<?php /* ?>
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
		  <?php */?>
        </ul>
      </div>
    </nav>
  </header>
 <?php $this->load->view('common/credential_form'); ?>
