<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
	  
	  
		<!-- Profile PIc -->
	  
        <div class="text-center image">
		
			<?php if(empty($user_data['profile_pic'])):?>
			  <span class="glyphicon glyphicon-user custom-user-icon" data-toggle="modal" data-target="#myModal" style="cursor:pointer"></span>
			<?php else:?>
			  <img src="<?php echo base_url($user_data['profile_pic']);?>" class="img-circle" alt="User Image" data-toggle="modal"  style="cursor:pointer;max-width:70%;width: 140px;height: 140px;" data-target="#myModal">   
			<?php endif;?>
			
			
        </div>
		
		<!-- Profile PIc -->
		
		
        <div class="text-center info" style="position:relative;left: 0;padding-left: 5px;">
          <p style="font-size:20px;"><?php echo $user_data['firstname'].' '.$user_data['lastname'];?></p>
		   <a href="#"><i class="fa fa-user text-success"></i>	 <?php echo $user_data['user_designation_description'];?></a>
        </div>
      </div>
    
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
		
		<?php /*?>
		
		
		<li class="treeview active">
          <a href="#">
            <i class="fa fa-share"></i> <span>Multilevel</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu menu-open" style="display: block;">
            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
            <li>
              <a href="#"><i class="fa fa-circle-o"></i> Level One
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-circle-o"></i> Level Two</a></li>
                <li>
                  <a href="#"><i class="fa fa-circle-o"></i> Level Two
                    <span class="pull-right-container">
                      <i class="fa fa-angle-left pull-right"></i>
                    </span>
                  </a>
                  <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                    <li><a href="#"><i class="fa fa-circle-o"></i> Level Three</a></li>
                  </ul>
                </li>
              </ul>
            </li>
            <li><a href="#"><i class="fa fa-circle-o"></i> Level One</a></li>
          </ul>
        </li>
		
		<?php */?>
		
		
		
		
		
		<!-- <li class="treeview">
          <a href="#">
            <i class="fa fa-folder"></i>
            <span>HR</span>   
			<span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>	
          </a>
          <ul class="treeview-menu">
           
            <li><a href="<?php echo site_url('salary/salaries');?>"><i class="fa fa-circle-o"></i> <span>Pay-Slip</span></a></li>
			
			
          </ul>
        </li> -->
		
		<li>
		  <a href="#"><i class="fa fa-header"></i> <span>HR</span>
			<span class="pull-right-container">
			  <i class="fa fa-angle-left pull-right"></i>
			</span>
		  </a>
		  <ul class="treeview-menu">
			
		
		
				<li class="treeview">	
					<a href="<?php echo site_url('otheractivity/add_gallery');?>"><i class="fa fa-camera"></i> <span>Gallery</span></a>
				</li>
				
				
				<li>	
					<a href="<?php echo site_url('otheractivity/add_thoughts');?>"><i class="fa  fa-lightbulb-o"></i> <span>Add Thought Of The Day</span></a>
				</li>
				
				<li>	
					<a href="<?php echo site_url('otheractivity/add_forms');?>"><i class="fa fa-book"></i> <span>Forms</span></a>
				</li>
				
				<li>	
					<a href="<?php echo site_url('otheractivity/feedback');?>"><i class="fa fa-mail-reply-all"></i> <span>Feedbacks</span></a>
				</li>
				
		
		<li class="treeview">		
			<a href="<?php echo site_url('otheractivity/activities');?>">
				<i class="fa  fa-smile-o"></i>		
				<span>Activity</span>   	
			</a>	
		</li>
		
		<li class="treeview">	
			<a href="<?php echo site_url('otheractivity/calendarevents');?>">
				<i class="fa  fa-calendar"></i>	
				<span>Calendar Events</span>  
 			</a>	
		</i>
			
			
			<li>
				<a href="#"><i class="fa fa-envelope"></i> Policy
					<span class="pull-right-container">
						<i class="fa fa-angle-left pull-right"></i>
					</span>
				</a>
				<ul class="treeview-menu">
					<li class="active">
						<a href="<?php echo site_url('policy/create_policy');?>"><i class="fa fa-circle-o"></i> <span>Create Policy</span></a>
					</li>
					<li>
						<a href="<?php echo site_url('policy/list_policy');?>"><i class="fa fa-circle-o"></i> <span>Policies</span></a>
					</li>
				</ul>
			</li>
			
			<li class="treeview">
		
				<a href="#">
					<i class="fa fa-random"></i>
					<span>Miscellaneous Docs</span>   
					<span class="pull-right-container">
					<i class="fa fa-angle-left pull-right"></i>
					</span>				
				</a>
				<ul class="treeview-menu">
					<li>
						<a href="<?php echo site_url('otheractivity/add_misc');?>"><i class="fa fa-circle-o"></i> Add Misc Docs</a>
					</li>
					<li>
						<a href="<?php echo site_url('otheractivity/get_all_misc');?>"><i class="fa fa-circle-o"></i> List Misc Docs</a>
					</li>
					
				</ul>
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
			<li>	
				<a href="<?php echo site_url('user/search_employee');?>"><i class="fa fa-circle-o"></i> <span>Advanced Search</span></a>
			</li>
			<li>	
				<a href="<?php echo site_url('user/employee_of_month');?>"><i class="fa fa-circle-o"></i> <span>Employee Of The Month</span></a>
			</li>
          </ul>
        </li>
		
		
		<li class="treeview">
			<a href="#">
				<i class="fa fa-pie-chart"></i>
				<span>Reports</span>   
				<span class="pull-right-container">
				<i class="fa fa-angle-left pull-right"></i>
				</span>	
			</a>
			<ul class="treeview-menu">
				<li>
					<?php 
					$search['search']['from_date'] = date('Y-m-01'); 
					$search['search']['to_date']   = date('Y-m-31'); 
					$params = http_build_query($search);
					?>
					<a href="<?php echo site_url('report/timesheet_reports?'.$params);?>">
					<i class="fa fa-circle-o"></i> Timesheet Reports
					<small class="label pull-right bg-blue"></small>
					</a>
				</li>
				<li>
					<a href="<?php echo site_url('report/leave_reports?'.$params);?>"> 
					<i class="fa fa-circle-o"></i> Leave Reports
					<small class="label pull-right bg-blue"></small>
					</a>
				</li>
			</ul>
		</li>
		
		
		<?php /* if($user_data['role'] != '4'){?>
		<li class="treeview">
			<a href="#">
				<i class="fa fa-calendar-check-o"></i>
				<span>Timesheets</span>   
				<span class="pull-right-container">
				  <i class="fa fa-angle-left pull-right"></i>
				</span>	
			</a>
			<ul class="treeview-menu">
				<li>
					<a href="<?php echo site_url('user/timesheet/'.($user_data['id']));?>">
						<i class="fa fa-circle-o"></i>
						<span>Add Timesheet</span>          
					</a>
				</li>
				
				<li>
					<a href="<?php echo site_url('user/list_timesheet/'.($user_data['id']));?>">
						<i class="fa fa-circle-o"></i>
						<span>Timesheet Entries</span>          
					</a>
				</li>
				
			</ul>
			
		</li>
		
		
		<li class="treeview">
		
			<a href="#">
				<i class="fa fa-plane"></i>
				<span>Leave</span> 
				<span class="pull-right-container">
				  <i class="fa fa-angle-left pull-right"></i>
				</span>					
			</a>
			<ul class="treeview-menu">
				<!-- <li>
					<a href="<?php echo site_url('leave/avail_leaves/'.$user_data['id']);?>"><i class="fa fa-circle-o"></i> Available Leaves </a>
				</li> -->
				<li>
					<a href="<?php echo site_url('leave/apply/'.$user_data['id']);?>"><i class="fa fa-circle-o"></i> Apply For Leave </a>
				</li>
				<li>
					<a href="<?php echo site_url('leave/history/'.$user_data['id']);?>"><i class="fa fa-circle-o"></i> View Leave History</a>
				</li>
			</ul>
		</li>
		
		
		<?php } */?>
		
		
		<li class="treeview">
          <a href="<?php echo site_url('user/list_managers_list');?>">
            <i class="fa  fa-user-secret"></i> <span>Managers</span>
          </a>
        </li>
		
		
		
		
		
		
		
		
		
		
		<li class="treeview">
		
			<a href="<?php echo site_url('employeestuff/settings');?>">
				
				<i class="fa fa-gears"></i>
				<span>Settings</span> 
				<span class="pull-right-container">
					<i class="fa fa-angle-left pull-right"></i>
				</span>		
				
			</a>
			<ul class="treeview-menu">
			
				<li class="treeview">
		
					<a href="<?php echo site_url('employeestuff/designation/list');?>">
						<i class="fa fa-cubes"></i>
						<span>Designations</span>   
					</a>
					
				</li>
				
				<li class="treeview">
		
					<a href="<?php echo site_url('employeestuff/department/list');?>">
						<i class="fa fa-institution"></i>
						<span>Departments</span>   
					</a>
					
				</li>
				<?php if( $user_data['role'] == 'S'){?>
				<li class="treeview">
		
					<a href="<?php echo site_url('leave/leave_setting');?>">
						<i class="fa fa-arrows"></i>
						<span>Leave Setting</span>   
					</a>
					
				</li>
				<?php } ?>
				
			</ul>
		</li>
		
		
		
		
      </ul>
	  
    </section>
    <!-- /.sidebar -->
  </aside>