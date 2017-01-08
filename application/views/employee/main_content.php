	
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<?php //fn_ems_debug($user_data); ?>
		<section class="content-header">
			<h1>        Dashboard      </h1>
			<?php /*
			<ol class="breadcrumb">
				<li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a>
				</li>
				<li class="active">Dashboard</li>
			</ol>
			*/ ?>
		</section>
		<!-- Main content -->
		<section class="content">
			<div class="row">
				<!-- /.col -->
				<div class="col-md-12">
					<div class="row">
						<!-- Total Employees -->
						<div class="col-lg-3 col-xs-6">
							<!-- small box -->
							<div class="small-box bg-yellow">
								<div class="inner">
									<h3><?php echo $count_employees;?></h3>
									<p>Total Employees</p>
								</div>
								<div class="icon"> <i class="fa fa-user"></i> </div> <a href="<?php echo site_url('user/list_employees');?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> </div>
						</div>
						<!-- Total Policies -->
						<div class="col-lg-3 col-xs-6">
							<!-- small box -->
							<div class="small-box bg-green">
								<div class="inner">
									<h3><?php echo $count_policies;?><sup style="font-size: 20px"></sup></h3>
									<p>Total Policies</p>
								</div>
								<div class="icon"> <i class="fa fa-book"></i> </div> <a href="<?php echo site_url('policy/list_policy');?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> </div>
						</div>
						<div class="col-lg-3 col-xs-6">
							<!-- small box -->
							<div class="small-box bg-red">
								<div class="inner">
									<h3><?php echo $count_leaves;?><sup style="font-size: 20px"></sup></h3>
									<p>Leave Reports</p>
								</div>
								<div class="icon"> <i class="fa fa-pie-chart"></i> </div> <a href="<?php echo site_url('leave/history/'.$user_data['id']);?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> </div>
						</div>
						<div class="col-lg-3 col-xs-6">
							
							<div class="small-box bg-aqua">
								<div class="inner">
									<h3><?php echo count($user_data['activities']);?><sup style="font-size: 20px"></sup></h3>
									<p>Activities</p>
								</div>
								<div class="icon"> <i class="fa fa-linux"></i> </div>
									<?php if(count($user_data['activities'])):?>
									<a href="<?php echo site_url('otheractivity/view_activity/'.$user_data['activities'][0]['id']);?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
									<?php else:?>
									<a href="<?php echo site_url('otheractivity/activities');?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
									<?php endif;?>
							</div>
						</div>
						
						
						<!-- <div class="col-lg-3 col-xs-6">
							
							<div class="small-box bg-aqua">
								<div class="inner">
									<h3><?php echo $count_timesheets;?><sup style="font-size: 20px"></sup></h3>
									<p>Timesheet Reports</p>
								</div>
								<div class="icon"> <i class="fa fa-clock-o"></i> </div>
									
									
									<a href="<?php echo site_url('report/timesheet_reports');?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
								</div>
						</div> -->
						
						
						
						
						
						<!-- <a href="<?php echo site_url('user/list_timesheet/'.$user_data['id']);?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a> -->
						
					</div>
				  </div>
			</div>
			
			<div class="row">
				<?php $this->load->view('common/thoughts') ;?>
				<?php $this->load->view('common/carousel') ;?>
			</div>
			
			<div class="row">
				<?php $this->load->view('common/emp_of_month') ;?>
				<?php $this->load->view('common/feedback_appraisal') ;?>	
				<?php $this->load->view('common/calendar') ;?>		
			</div>
			
			<div class="row">
				<?php $this->load->view('common/birthdays') ;?>
				<?php $this->load->view('common/todo') ;?>	
				
			</div>
		</section>
	</div>