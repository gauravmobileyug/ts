
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<?php //fn_ems_debug($user_data); ?>
<section class="content-header">
  <h1>
	Timesheet Entry
  </h1>
  <ol class="breadcrumb">
	<li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Timesheet Entry</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

	<div class="row">
	<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Timesheets</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
			<div class="table-responsive no-padding">
				<table class="table dataTable table-hover table-striped">
					<tbody>
						<tr>
						  <th>Sr.No.</th>
						  <th>Total Tickets</th>
						  <th>Date For</th>
						  <th>Last Modified</th>
						  <th>Total Time (Mins)</th>
						  <th>Submit Status</th>
						  <th>Action</th>						 
						</tr>
						<?php 
						
						//fn_ems_debug($timesheets);
						
						if(!empty($timesheets)){
							$count = 1;
							foreach($timesheets as $key=> $timesheet){
						?>
							<tr>
								<td><?php echo $count++ ;?></td>
								<td><?php echo $timesheet['total_tickets'];?></td>
								<td><?php echo date('d M Y',strtotime($timesheet['timesheet_date']));?></td>
								<td><?php echo date('d M Y',strtotime($timesheet['date_updated']));?></td>
								<td><?php echo $timesheet['total_time'];?></td>
								<td>
								<?php $submit_status_class =  $timesheet['submit'] == 2 ? 'label-success' : 'label-warning';?>
								<?php $submit_status       =  $timesheet['submit'] == 2 ? 'Submitted'     : 'Saved Only';?>
								<span class="label <?php echo $submit_status_class;?>"><?php echo $submit_status;?></span>
								</td>
								<td>	
									<a href="<?php echo site_url('user/get_timesheet/'.$user_id.'/'.$timesheet['sheet_id']);?>" class="btn btn-primary btn-xs">
										<i class="fa fa-eye"></i> View 	
									</a>	
									<?php $days = intval((time() - strtotime($timesheet['date_added'])) / (24 *3600)); ?>	
									<?php if($days <= 7 && $editable && $timesheet['submit'] == 1) { ?>	
									|
									<a href="<?php echo site_url('user/edit_timesheet/'.$user_id.'/'.$timesheet['sheet_id']);?>" class="btn btn-warning btn-xs">
										<i class="fa fa-edit"></i> Edit		
									</a>
									<?php }?>	
									
									<?php if($user_data['role'] == 'S' && $timesheets[0]['submit'] == 2){ ?>
										<a href="javascript:void(0);" onclick="change_timesheet_status('<?=$timesheets[0]['sheet_id']?>' , '<?=$timesheets[0]['submit']?>')" class="btn btn-warning btn btn-xs"><i class="fa  fa-exchange"></i> &nbsp;Change Status</a>
									<?php } ?>
								</td>
							</tr>
						<?php
							}
						}?>
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