
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<?php //fn_ems_debug($user_data); ?>
<section class="content-header">
  <h1>
	Timesheet History
  </h1>
  <ol class="breadcrumb">
	<li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
	<?php 
	$search['search']['from_date'] = date('Y-m-01'); 
	$search['search']['to_date']   = date('Y-m-31'); 
	$params = http_build_query($search);
	
	$params2 = isset($_SERVER["QUERY_STRING"]) ? $_SERVER["QUERY_STRING"] :'';
	
	//print_r($timesheets);
	
	?>

	<li><a href="<?php echo site_url('report/timesheet_reports?'.$params);?>">Timesheet Report List</a></li>
	<li><a href="<?php echo site_url('report/list_timesheet/'.$timesheets[0]['user_id'].'?'.$params2);?>">Timesheets</a></li>
	<li class="active">Timesheet History</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

	<div class="row">
	<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Timesheet</h3>
			  
			   <div class="box-tools pull-right">
					<?php echo !empty($timesheets) ?  '<b>'. date('d M Y',strtotime($timesheets[0]['timesheet_date'])) .'</b>' : '' ;?>
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