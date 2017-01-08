
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<?php //fn_ems_debug($employees); ?>
	<section class="content-header">
	  <h1>
		Select Employee Of The Month
	  </h1>
	  <ol class="breadcrumb">
		<li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Employee Of The Month</li>
	  </ol>
	</section>

	<!-- Main content -->
	<section class="content">

		<div class="row">
			<div class="col-xs-12">
				<div class="box">
					<div class="box-header">
					  <h3 class="box-title">Employees</h3>	
					</div>
					<!-- /.box-header -->
					<div class="box-body">
						<div class="table-responsive no-padding">
						<table class="table dataTable table-hover table-striped" id="employee_list">
							<thead>
								<tr>
								  <th>Profile</th>
								  <th>ID</th>
								  <th>Name</th>
								  <th>Date Of Joining</th>
								  
								  <th>Contact Number</th>
								  <th>Department</th>
								  <th>Action</th>
								</tr>					
							</thead>	
							<tbody>
								
							<?php 
							if(isset($employees) && !empty($employees)){
								foreach($employees as $key => $employee):
							?>
								<tr>
									<td>
										<div>
											<img style="width: 50px;height: 50px;" src="<?php echo !empty($employee['profile_pic']) ? base_url($employee['profile_pic']) : base_url('assets/images/blank_user.png') ;?>"/>
										</div>
									</td>
									<td style="width:40%;    word-break: break-all;"><?php echo $employee['employee_id'];?></td>
									<td style="width:40%;    word-break: break-all;">
									<a href="<?php echo site_url('user/view/'.$employee['id']);?>">
										<?php echo strtoupper($employee['firstname']. ' '.$employee['lastname']);?>
									</a>
									</td>
									<td><?php echo date('d-M-Y', strtotime($employee['date_added']));?></td>
									
									<td><?php echo $employee['phone'];?></td>
									<td><?php echo !empty($employee['department']) ? strtoupper($employee['department_name']) : 'NA';?></td>
									<td>
									
									<!-- -->
									
									<div id="emp_month_modal<?=$employee['id'];?>" class="modal fade" role="dialog">	
										<form name="emp-of-month" action="<?php echo site_url("user/employee_of_month");?>" id="form_emp_month_modal<?=$employee['id'];?>" method="POST" enctype="multipart/form-data">	
										<div class="modal-dialog">	
											<div class="modal-content">	
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal">&times;</button>
													<h4 class="modal-title">Add Remarks For <?php echo ucwords($employee['firstname'].' '.$employee['lastname']);?></h4>	
												</div>			  		
												<div class="modal-body" style="height: 160px;">
													
														<p >				
															<textarea style="height: 130px;" id="remarks" name="remarks" class="form-control" placeholder="Add Remarks e.g a positive attitude toward work responsibilities, co-workers, and customers, and serves as a role model for others"></textarea>	
															<input type="hidden" name="user_id" value="<?=$employee['id'];?>" id="user_id"/>
														</p>		
												
													</form>	
												</div>	
												<div class="modal-footer">	
													<button type="submit" class="btn btn-primary" >Save</button>	
													<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>	
												</div>		
											</div>	
										</div>	
										
										</form>
									</div>
									
									
									<!-- -->
									
									
									<?php if(empty($valid)):?>
									
										<a href="#" data-toggle="modal" data-target="#emp_month_modal<?=$employee['id'];?>" style="cursor:pointer" class="btn btn-primary">Select</a>
									
									<?php elseif(!empty($valid)):?>
										<?php if($valid['user_id'] == $employee['id']){ ?>
											<a href="javascript:void(0);" class="btn btn-success">Selected</a>
										<?php } else{ ?>
											<a href="javascript:void(0);" data-toggle="modal" data-target="#emp_month_modal<?=$employee['id'];?>" class="btn btn-warning">Select</a>
										<?php } ?>
										
									<?php else:?>
										
									<?php endif;?>
									</td>
								</tr>
							<?php
								endforeach;
							}else{
							?>
								<tr>
									<td class="center"> No Result Found !</td>
								</tr>
							<?php
							}
							?>
							
							
							</tbody>
						</table>
						
						</div>
					</div>
					
					<div class="box-footer clearfix">
					<div class="pull-left">
				
				</div>
					  <ul class="pagination pagination-sm no-margin pull-right">
						<?php 
							foreach ($links as $link) { 
								echo "<li>". $link."</li>";
							}
						?>
					  </ul>
					</div>
				</div>
			</div>
		</div>
		
	</section>

</div>
<script>$(document).ready(function(){		$('#employee_list').DataTable({	  "paging": true,	  "lengthChange": true,	  "searching": true,	  "ordering": true,	  "info": true,	  "autoWidth": true, 	  "columnDefs": [ {		"targets": [0,6],		"orderable": false		} ]	});});</script>