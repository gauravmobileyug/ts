<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="image text-center" >
			<?php if(empty($user_data['profile_pic'])):?>
			  <span class="glyphicon glyphicon-user custom-user-icon" data-toggle="modal" data-target="#myModal" style="cursor:pointer"></span>
			<?php else:?>
			  <img src="<?php echo base_url($user_data['profile_pic']);?>" class="img-circle" alt="User Image" data-toggle="modal"  style="cursor:pointer;max-width:70%;width:140px;height:140px;" data-target="#myModal">   
			<?php endif;?>
        </div>
        <div class="info text-center" style="position:relative;left: 0;padding-left: 5px;">
          <p style="font-size:20px;"><?php echo ucwords($user_data['firstname'].' '.$user_data['lastname']);?></p>
		   <a href="#"><i class="fa fa-user text-success"></i>	 <?php echo $user_data['user_designation_description'];?></a>
          <!-- <a href="#"><i class="fa fa-circle text-success"></i> Online</a> -->
        </div>
      </div>
      <!-- search form -->
      <!-- <form action="#" method="get" class="sidebar-form">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
        </div>
      </form> -->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">MAIN NAVIGATION</li>
		<li class="treeview">
          <a href="<?php echo site_url();?>">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>
          </a>
        </li> 
		
		<li class="treeview">
          <a href="<?php echo site_url('user/profile');?>">
            <i class="fa fa-slack"></i> <span>My Profile</span>
          </a>
        </li> 
		
		
		<li class="treeview">
          <a href="#">
            <i class="fa fa-envelope"></i> <span>Policy</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active">
			 <a href="<?php echo site_url('policy/create_policy');?>"><i class="fa fa-circle-o"></i> <span>Create Policy</span></a>
            </li>
            <li>
				<a href="<?php echo site_url('policy/list_policy');?>"><i class="fa fa-circle-o"></i> <span>List Policies</span></a>
			</li>
          </ul>
        </li>
		
		<li class="treeview">
          <a href="#">
            <i class="fa fa-users"></i> <span>Employees</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="active">
			 <a href="<?php echo site_url('user/add_employee');?>"><i class="fa fa-circle-o"></i> <span>Add New Employee</span></a>
            </li>
            <li>
				<a href="<?php echo site_url('user/list_employees');?>"><i class="fa fa-circle-o"></i> <span>List Employees</span></a>
			</li>
          </ul>
        </li>
		
		
		<li class="treeview">
          <a href="#">
            <i class="fa  fa-book"></i> <span>Employee Report</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
			<li class="">
              <a href="#"><i class="fa fa-circle-o"></i> Leave Report
              </a>
            </li>
			
			<li class="">
              <a href="#"><i class="fa fa-circle-o"></i> Timesheet Report
              </a>
            </li>
			
          </ul>
        </li>
		
		
		
		<li class="treeview">
		
			<a href="#">
				<i class="fa fa-random"></i>
				<span>Miscellaneous</span>   
				<span class="pull-right-container">
				<i class="fa fa-angle-left pull-right"></i>
				</span>				
			</a>
			<ul class="treeview-menu">
				<li>
					<a href="<?php echo site_url('otheractivity/add_misc');?>"><i class="fa fa-circle-o"></i> Add Miscellaneous</a>
				</li>
				<li>
					<a href="<?php echo site_url('otheractivity/get_all_misc');?>"><i class="fa fa-circle-o"></i> Get Miscellaneous</a>
				</li>
			</ul>
		</li>
		
		
		
		<li class="treeview">
		
			<a href="<?php echo site_url('employeestuff/department/list');?>">
				<i class="fa fa-institution"></i>
				<span>Departments</span>   
			</a>
			
		</li>
		
		<li class="treeview">
		
			<a href="<?php echo site_url('employeestuff/designation/list');?>">
				<i class="fa fa-cubes"></i>
				<span>Designations</span>   
			</a>
			
		</li>
		
      </ul>
	  
    </section>
    <!-- /.sidebar -->
  </aside>