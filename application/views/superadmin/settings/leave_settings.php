
	<div class="content-wrapper">
		<?php //fn_ems_debug($employee_details); ?>
		<section class="content-header">
		  <h1>
			Leave Settings
		  </h1>
		  <ol class="breadcrumb">
			<li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
			<li class="active">Leave Settings</li>
		  </ol>
		</section>

		<!-- Main content -->
		<section class="content">

			<div class="row">
				<div class="col-xs-12">
					<div class="box">
						<div class="box-header">
						  <h3 class="box-title">Leave Details</h3>
						</div>
						<form method="POST"  action="<?php echo site_url('leave/leave_setting');?>">
							<div class="box-body table-responsive no-padding">
								<div class="table-responsive no-padding">
									
										<table class="table dataTable table-hover table-striped">		
										
											<thead>
												<tr>
												
													<th>Sr.No.</th>
													<th>Leave Type</th>
													<th>Yealry Leaves</th>
													<th>Monthly Leaves</th>
													<th>Status</th>
													
												</tr>
											</thead>
										
											<tbody>
												
												<?php foreach($leave_types as $key => $leave):?>
											
												<tr>
													<td><label><?php echo $key+1;?></label></td>
													<td><label><?php echo ucwords($leave['leave_name']);?></label></td>
													<td><input type="text" class="form-control leave-class" name="leave[<?php echo $leave['leave_code'];?>][yleave]" alt="<?=$key?>"  value="<?php  echo $leave['yearly_leaves'];?>" placeholder="Add Yearly Leaves"/></td>
													<td>
													<span id="<?php echo 'leave_'.$key;?>"><?php  echo $leave['monthly_leaves'];?></span>
													<input type="hidden" name="leave[<?php echo $leave['leave_code'];?>][mleave]" id="<?php echo 'eleave_'.$key;?>" value="<?php  echo $leave['monthly_leaves'];?>"/>
													
													</td>
													<td>
													<?php echo $leave['status'] == 1 ? "<label class='label label-success'>Active</label>" : "<label class='label label-danger'>Disabled</label>";?>
													</td>
												</tr>
												
												<?php endforeach;?>
											</tbody>
										</table>
									
								</div>
							</div>
							<div class="box-footer clearfix">
							
								<div class="pull-left">
									
								</div>
							
								<button type="submit" class="pull-right btn btn-primary" id="update_leave">
									<i class="fa  fa-check-circle"></i> &nbsp; Update
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			
		</section>
	</div>