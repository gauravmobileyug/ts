<div class="content-wrapper">

<section class="content-header">
  <h1>
	<?=$employee_name?>  Timesheets
  </h1>
  <ol class="breadcrumb">
	<li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
	<?php 
	$search['search']['from_date'] = date('Y-m-01'); 
	$search['search']['to_date']   = date('Y-m-31'); 
	$params = http_build_query($search);
	?>

	<li><a href="<?php echo site_url('report/timesheet_reports?'.$params);?>">Timesheet Report List</a></li>
	<li class="active"> Timesheets</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

	<div class="row">
	<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Timesheets</h3>
			  <div class="box-tools">	
				<?php 
				
				$reporting_manager = if_it_is_reporting_employee($user_data ,$user_id);
				
				$param_string = '';
				if(!empty($search_params)) { 
					$param_string = "params[from_date]=".$search_params['from_date']."&params[to_date]=".$search_params['to_date'];
				};
				?>
				<?php if($reporting_manager || $user_data['role'] == 'H' || $user_data['role'] == 'S'):?>
				<a target="_blank" href="<?php echo site_url('report/download_timesheet_pdf/'.$user_id.'?'.$param_string);?>" class="btn btn-primary  btn-xs"><i class="fa fa-download"></i> &nbsp;Download PDF</a>
				<?php endif;?>
			  </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
			<div class="table-responsive no-padding">
				<table class="table dataTable table-hover table-striped">
					<tbody>
						<tr>
						  <th>Sr.No.</th>
						  <th>Total Tickets</th>
						  <th>Total Time</th>
						  <th>Date</th>
						  <th>Last Modified</th>
						  <th>Submit Status</th>
						<?php  if( ($user_data['role'] == 'M' && $reporting_manager) || $user_data['role'] == 'S' || $user_data['id'] == $user_id): ?>	
						  <th>Action</th>		
						<?php endif;?>
						</tr>
						<?php 
						if(!empty($timesheets)){
							$count = 1;$total_time = 0;
							foreach($timesheets as $key=> $timesheet){
						?>
							<tr>
								<td><?php echo $count++ ;?></td>
								<td><?php echo $timesheet['total_tickets'];?></td>
								
								<?php $total_time += $timesheet['total_time']; ?>
								
								
								<td><?php echo $timesheet['total_time'];?></td>
								<td><?php echo date('d M Y',strtotime($timesheet['timesheet_date']));?></td>
								<td><?php echo date('d M Y',strtotime($timesheet['date_updated']));?></td>
								<td>
								<?php $submit_status_class =  $timesheet['submit'] == 2 ? 'label-success' : 'label-warning';?>
								<?php $submit_status       =  $timesheet['submit'] == 2 ? 'Submitted'     : 'Saved Only';?>
								<span class="label <?php echo $submit_status_class;?>"><?php echo $submit_status;?></span>
								</td>
								<?php  if( ($user_data['role'] == 'M' && $reporting_manager) || $user_data['role'] == 'S' || $user_data['id'] == $user_id): ?>								
								<td>
								
									<?php 
									$query_string =  isset($_SERVER["QUERY_STRING"]) ? $_SERVER["QUERY_STRING"] : '';
									?>
								
									<a href="<?php echo site_url('user/get_timesheet/'.$user_id.'/'.$timesheet['sheet_id'].'?'.$query_string);?>" class="btn btn-primary btn-xs">
										<i class="fa fa-eye"></i> View 	
									</a>	
								
									<?php $valid_month = date('m',strtotime($timesheet['timesheet_date'])) == date('m') ? true : false; ?>	
									
									<?php if(($valid_month && $timesheet['submit'] == 1) || (($user_data['role'] == 'M' && $reporting_manager))  && ($user_data['id'] == $timesheet['user_id']) || ($user_data['role'] == 'S') ) { ?>	
									|
									<a href="<?php echo site_url('user/edit_timesheet/'.$user_id.'/'.$timesheet['sheet_id'].'?'.$query_string);?>" class="btn btn-warning btn-xs">
										<i class="fa fa-edit"></i> Edit		
									</a>
									
									
									
									<?php }?>	
									
									
									<?php if($user_data['role'] == 'S' && $timesheet['submit'] == 2 && $valid_month){ ?>
										| <a href="javascript:void(0);" onclick="change_timesheet_status('<?=$timesheet['sheet_id'];?>' , '<?=$timesheet['submit']?>')" class="btn btn-warning btn btn-xs"><i class="fa  fa-exchange"></i> &nbsp;Change Status</a>
									<?php } ?>
									
								</td>
								<?php endif;?>
							</tr>
						<?php
							}
						?>
							<tr>
								<td colspan="2"><b> Total Time :</b></td>
								<td><b><?=$total_time?> Minutes</b></td>
								<td colspan="4"></td>
							</tr>
						<?php
						}else{?>
							<tr> <td style="text-align:center" colspan="5">No Data Found!<td></tr>
						<?php }?>
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
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
	</div>
<section>
</div>