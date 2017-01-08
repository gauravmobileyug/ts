
<div class="content-wrapper">
<?php //fn_ems_debug($employee_details); ?>
<section class="content-header">
  <h1>
	Leave Details
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
	<li><a href="<?php echo site_url('user/list_manager_employees/'.$employee_details['reporting_manager']);?>"> Reporting Employees </a></li>
	<li><a href="<?php echo site_url('report/list_leaves/'.$employee_details['id']);?>">Leaves </a></li>
	<li class="active">Leave Details</li>
  </ol>
</section>
<section class="content-header">
 <b>Employee Name </b> -  <?php echo ucwords($employee_details['firstname'].' '.$employee_details['lastname']);?><br/>
 <b>Employee ID </b> -  <?php echo $employee_details['employee_id'];?> 
 <?php $action = '';?>
 
 <?php if($leave_details['approved'] == 1){ $action = 'Approved'; }?>
 <?php if($leave_details['approved'] == 2){ $action = 'Dispproved';} ?>
 
 <div class="pull-right">
	<?php if( isset($leave_details['date_approved']) && !empty($leave_details['date_approved']) ) {?>
		<b><?=$action.' On ';?>:</b><span style="font-size: 17px;padding-left: 10px;	"><?php echo date('d M Y h:i:s A',strtotime($leave_details['date_approved']));?></span>
	<?php }?>
 </div>
</section>

<!-- Main content -->
<section class="content">

	<div class="row">
	
	<div class="col-md-3">
               <div class="box box-primary">
			   <div class="box-header with-border">
					  <i class="fa fa-tags"></i>

					  
					  
					  <h3 class="box-title">Leave Summary</h3>
					  
						<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
						</button>
					 
						<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
						</div>
				</div>
                  <div class="box-body box-profile">
                     <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">						 
						<b>Total Available Leaves</b>
							<a class="pull-right"><label class="label label-success"><?php echo isset($user_leave_summary['TOTAL']) ?  $user_leave_summary['TOTAL'] : 0 ;?></label></a>
						</li>
                        <li class="list-group-item">	
							<b>Available Sick Leaves</b>
							<a class="pull-right"><label class="label label-primary"><?php echo isset($user_leave_summary['SICK']) ?  $user_leave_summary['SICK'] : 0 ;?></label></a>
						</li>
                        <li class="list-group-item">	
							<b>Available Planned Leaves</b>
							<a class="pull-right"><label class="label label-primary"><?php echo isset($user_leave_summary['PLANNED']) ?  $user_leave_summary['PLANNED'] : 0 ;?></label></a>
						</li>
                        <li class="list-group-item">	
							<b>Total Pending Leaves</b>
							<a class="pull-right"><label class="label label-warning"><?php echo isset($user_leave_summary['PENDING']) ?  $user_leave_summary['PENDING'] : 0 ;?></label></a>
						</li>
                     </ul>
                  </div>
               </div>
            </div>
	
	<div class="col-xs-9">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Leave Details</h3>
				<div class="box-tools pull-right">
				
				
				<?php if($leave_details['approved'] == 1){?>
					<a href="javascript:void(0);" class="approve btn-xs btn-success"> &nbsp; Approved</a>
				<?php }elseif($leave_details['approved'] == 2){?>
					<a href="javascript:void(0);" class="approve btn-xs btn-warning"> &nbsp; Dispproved</a>
				<?php }elseif($leave_details['approved'] == 0){ ?>
					<a href="javascript:void(0);" class="approve btn-xs btn-info"> <i class="fa fa-hourglass-start"></i> &nbsp; Pending</a>
				<?php } ?>
				</div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
			<div class="table-responsive no-padding">
				<table class="table dataTable table-hover table-striped">				
					<tbody>
						<tr>
							<td><b>Leave Type</b></td>
							<td><?php echo $leave_details['leave_name'];?></td>
							
							
							<td><b>Application Date</b></td>
							<td><?php echo date('d M Y h:i:s A',strtotime($leave_details['date_added']));?></td>	
							
							
							<td></td>
							<td></td>
						</tr>	
						<tr>	
							
							<td><b>Leave From</b></td>
							<td><?php echo $leave_details['leave_from'];?></td>
							
							<td><b>Leave To</b></td>
							<td><?php echo $leave_details['leave_to'];?></td>
							
							
							<td></td>
							<td></td>
						</tr>
						
						<tr>
							<td><b>Number Of Days</b></td>
							<td><?php echo $leave_details['no_of_days'] .' Day(s)';?></td>
							
							<td><b>Half Day Leave</b></td>
							<td><?php echo ($leave_details['half_day'] == 'N') ?  'NO' : 'Yes';?></td>
							
							<td><b>Emergency Leave</b></td>
							<td><?php echo ($leave_details['emergency_leave'] == 'N') ?  'NO' : 'Yes';?></td>
							
						</tr>
						
						
						<tr>
							<td colspan="2">
								<b>Reason</b>
							</td>
							
							<td colspan="6">
								<?php echo $leave_details['leave_reason'];?>
							</td>
							
							
						</tr>
						
						
					</tbody>
				</table>
				</div>
            </div>
			<div class="box-footer clearfix">
				
				<div class="pull-left padding">
					
				</div>
			
				<?php if($user_data['role'] == 'S'  || $user_data['role'] == 'M' ){ ?>
				<div class="pull-right  ">
				
						<?php if(!$leave_details['approved']){?>
							<a href="javascript:void(0);" onclick="approve('<?php echo $employee_details['id'];?>','<?php echo $leave_details['id'];?>');" class="approve btn btn-primary">
								<i class="fa fa-thumbs-o-up"></i> &nbsp;Approve
							</a>
							
							<a href="javascript:void(0);" onclick="disapprove('<?php echo $employee_details['id'];?>','<?php echo $leave_details['id'];?>');" class="approve btn btn-warning">
								<i class="fa fa-thumbs-o-down"></i> &nbsp;Disapprove
							</a>
							
						<?php }elseif($leave_details['approved'] == 1){ ?>
							<a href="javascript:void(0);" class="approve btn btn-success"> <i class="fa fa-check-square-o"></i> &nbsp; Approved</a>
						<?php }elseif($leave_details['approved'] == 2){ ?>
							<a href="javascript:void(0);" class="approve btn btn-warning"> <i class="fa fa-check-square-o"></i> &nbsp; Dispproved</a>
						<?php } ?>
					
				</div>
				<?php } ?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
	</div>
<section>
</div>