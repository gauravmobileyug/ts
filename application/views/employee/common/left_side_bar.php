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
          <p style="font-size:20px;"><?php echo ucwords($user_data['firstname'].' '.$user_data['lastname']);?></p>
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
        <li class="treeview">
          <a href="#">
            <i class="fa fa-folder"></i>
            <span>HR</span>   
			<span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>	
          </a>
          <ul class="treeview-menu">
            <li>
				<a href="<?php echo site_url('policy/list_policy');?>">
					<i class="fa fa-circle-o"></i> Policies
					<small class="label pull-right bg-blue"></small>
				</a>
			</li>
            <li><a href="<?php echo site_url('salary/salaries');?>"><i class="fa fa-circle-o"></i> Pay-Slip</a></li>
			
			<li>
				<a href="<?php echo site_url('otheractivity/get_all_misc');?>"><i class="fa fa-circle-o"></i> Get Miscellaneous</a>
			</li>
			<?php /*?>
			<li>
				<a href="<?php echo site_url('otheractivity/request_doc');?>"><i class="fa fa-circle-o"></i> Request For Document</a>
			</li>
			<?php */?>
			
          </ul>
		  
        </li>
		
		
		<li class="treeview">
			<a href="<?php echo site_url('user/list_employees');?>"><i class="fa  fa-users"></i><span> Employees </span> </a>			
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
				<?php /* ?>
				<li>
					<a href="<?php echo site_url('report/leave_reports');?>"> 
					<i class="fa fa-circle-o"></i> Leave Reports
					<small class="label pull-right bg-blue"></small>
					</a>
				</li>
				
				<?php */?>
			</ul>
		</li>
		
		
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
		
		<?php 
	
		if(isset($user_data['activities']) && !empty($user_data['activities'])){ $total = count($user_data['activities']); ?>
		
		<li class="treeview">
		
			<a href="#">
				<i class="fa  fa-smile-o"></i>
				<span>Activities</span> <!-- &nbsp;<span class="label label-warning"><?php echo $total;?></span>  -->
				<span class="pull-right-container">
				  <i class="fa fa-angle-left pull-right"></i>
				</span>					
			</a>
			<ul class="treeview-menu">
				<?php foreach($user_data['activities'] as $key => $activity) { ?>
					<li>
						<a href="<?php echo site_url('otheractivity/view_activity/'.$activity['id']);?>">
							<i class="fa fa-circle-o text-aqua"></i>
							<?php echo ucwords($activity['activity_name']);?>
						</a>
					</li>
					<?php 
					} 
				?>
				
				
			</ul>
		</li>
		<?php
			}
		?>
		
		
      </ul>
	  
    </section>
    <!-- /.sidebar -->
  </aside>