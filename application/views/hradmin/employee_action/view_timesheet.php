
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<?php //fn_ems_debug($user_data); ?>
<section class="content-header">
  <h1>
	Timesheet Detail For <?php echo ucwords($employee_details['firstname'].' '.$employee_details['lastname']);?>
  </h1>
  <ol class="breadcrumb">
	<li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Timesheet Detail</li>
  </ol>
</section>



<?php //fn_ems_debug($timesheets); ?>
<!-- Main content -->
<section class="content">

	<div class="row">
	<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Timesheet</h3>
			  
			   <div class="box-tools pull-right">
					<?php echo !empty($timesheets) ?  '<b>'. date('d, M Y',strtotime($timesheets[0]['date_added'])) .'</b>' : '' ;?>
				</div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive ">
			<div class="table-responsive no-padding">
				<table class="table dataTable table-hover table-striped">
					<tbody>
						<tr>
						  <th>Sr.No.</th>
						  <th>Ticket Number</th>
						  <th>Client Name</th>
						  <th>Time</th>
						  <th>Description</th>
						</tr>
						<?php 
						if(!empty($timesheets)){
							$count = 1;							$total_time = 0;
							foreach($timesheets as $key=> $timesheet){
						?>
							<tr>
								<td><?php echo $count++;?></td>
								<td><?php echo $timesheet['ticket_number'];?></td>
								<td><?php echo $timesheet['client_name'];?></td>
								<td><?php echo $timesheet['time'];?></td>								
								<td style="width:40%;word-break: break-word;"><?php echo $timesheet['description'];?></td>
								
							</tr>
						<?php							$total_time+=$timesheet['time'];
							}						?>								<tr>							<td colspan="3" style="text-align: right;padding-right: 155px;"><b>Total Time</b></td>							<td><b><?php echo $total_time;?> Minutes</b></td>							<td></td>							</tr>						<?php
						}else{?>
							<tr><td colspan="5" class="text-center">No Records Found!</td></tr>
						<?php }?>
					</tbody>
				</table>
				</div>
            </div>
			<div class="box-footer clearfix">
             
			   <div class="pull-right">
					
					<?php if($user_data['role'] == 'S' && $timesheets[0]['submit'] == 2){ ?>
						<a href="javascript:void(0);" onclick="change_timesheet_status('<?=$timesheets[0]['sheet_id']?>' , '<?=$timesheets[0]['submit']?>')" class="btn btn-warning btn btn-xs"><i class="fa  fa-exchange"></i> &nbsp;Change Status</a>
					<?php } ?>
					 
			   
			   
					<?php echo !empty($timesheets) && $timesheets[0]['submit'] == 2 ? "<span class='label label-success'>Save & Submitted</span>" :"<span class='label label-warning'>Saved Only </span>";?>
			   </div>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
	</div>
<section>
</div>