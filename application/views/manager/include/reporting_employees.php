<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <?php //fn_ems_debug($user_data); ?>
   <section class="content-header">
      <h1>
        <?php echo ucwords( $manager['firstname'].' '.$manager['lastname'].'\'s' );?> Reporting Employees
      </h1>
      <ol class="breadcrumb">
         <li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
		 <?php 
		$search['search']['from_date'] = date('Y-m-01'); 
		$search['search']['to_date']   = date('Y-m-31'); 
		$params = http_build_query($search);
		
		//$params2 = isset($_SERVER["QUERY_STRING"]) ? $_SERVER["QUERY_STRING"] :'';
		
		//print_r($timesheets);

		?>
		
		<li><a href="<?php echo site_url('report/leave_reports?'.$params);?>"> Leave Report List </a></li>
        <li class="active">Reporting Employees</li>
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
							   <th>ID</th>
							   <th>Name</th>
							   <th>Date</th>                           
							   <th>Contact Number</th>
							   <th>Department</th>
							   <th>Status</th>
							   <th></th>
							   <th>Action</th>
							</tr>
						 </thead>
						 <tbody>
							<?php 
							   if(isset($employees) && !empty($employees)){
								foreach($employees as $key => $employee):
							   ?>
							<tr>
							   <td><?php echo $employee['employee_id'];?></td>
							   <td>
								<a href="<?=site_url('user/view/'.$employee['id']);?>">
								<?php echo strtoupper($employee['firstname']. ' '.$employee['lastname']);?>
								</a>
							   </td>
							   <td><?php echo date('d-M-Y', strtotime($employee['doj']));?></td>
							   <!-- <td><?php echo $employee['email'];?></td> -->
							   <td><?php echo $employee['phone'];?></td>
							   <td><?php echo !empty($employee['department']) ? strtoupper($employee['department_name']) : 'NA';?></td>
							   <td>
								  <?php if( $employee['status'] == 0 ) {?>
								  <span class="label label-warning">Disabled</span>
								  <?php }elseif($employee['status'] == 1) { ?>
								  <span class="label label-success">Enabled</span>
								  <?php }?>
							   </td>
							   <td>
								<?php echo $employee['leaves']['pending']!=0 ? "<small class='label label-warning'>".$employee['leaves']['pending']." New Request</small>" : ''?>
							   </td>
							   <td>
									
									<a class="label label-primary" href="<?php echo site_url('report/list_leaves/'.$employee['id']);?>">View Leaves</a>
									
							   </td>
							</tr>
							<?php
							   endforeach;
							   }else{
							   ?>
							<tr>
							   <td colspan="8" style="text-align: center;" class="center"> No Result Found !</td>
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
					<?php if($links): ?>
				   <ul class="pagination pagination-sm no-margin pull-right">
					  <?php 
						 foreach ($links as $link) { 
							echo "<li>". $link."</li>";
						 }
						 ?>
				   </ul>
				   <?php endif;?>
				</div>
				
				
				<!-- /.box-body -->
			 </div>
			 <!-- /.box -->
		  </div>
	   </div>
   </section>
</div>
<script>
   //$(document).ready(function(){	
		$('#employee_list').DataTable({	  
			"paging": false,	
			"lengthChange": true,	
			"searching": true,	
			"ordering": true,	
			"info": true,
			"autoWidth": true,
			"columnDefs": [ {	
			 "targets": [6,7],
			 "orderable": false	
			} ]
		});
 // });
</script>