
<div class="content-wrapper">

<section class="content-header">
  <h1>
	Leave Report 
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
	<li class="active">Leaves</li>
  </ol>
</section>
<section class="content-header">
 <b>Employee Name </b> -  <?php echo ucwords($employee_details['firstname'].' '.$employee_details['lastname']);?><br/>
 <b>Employee ID </b> -  <?php echo $employee_details['employee_id'];?> 
</section>

<!-- Main content -->
<section class="content">

	<div class="row">
	<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Leaves</h3>
			  <div class="box-tools">	
			  	<?php 
				$params = '';
				if(isset($search_params['from_date'] ,$search_params['to_date']  ) && !empty($search_params['from_date']) && !empty($search_params['to_date'])){
					$params = '?params[from_date]='.$search_params['from_date'].'&params[to_date]='.$search_params['to_date'];
				}				
				?>
				<a target="_blank" href="<?php echo site_url('report/download_leaves_pdf/'.$user_id.$params);?>" class="btn btn-primary  btn-xs"><i class="fa fa-download"></i> &nbsp;Download PDF</a>
			  </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
			<div class="table-responsive no-padding">
				<table class="table dataTable table-hover table-striped">
					<tbody>
						<tr>
						  <th>Sr.No.</th>
						  <th>Leave From</th>
						  <th>Leave To</th>
						  <th>No. Of Days</th>
						 <!-- <th>Leave Reason</th> -->
						  <th>Leave Type</th>
						  <th>Approve Status</th>						 
						  <th>View Details</th>						 
						</tr>
						<?php 
						if(!empty($leaves)){
							$count = 1;
							foreach($leaves as $key=> $leave){
						?>
							<tr>
								<td><?php echo $count++ ;?></td>
								<td><?php echo $leave['leave_from'] ;?></td>
								<td><?php echo $leave['leave_to'] ;?></td>
								<td><?php echo $leave['no_of_days'] .' Day(s)' ;?></td>
								<!--<td><?php //echo $leave['leave_reason'] ;?></td> -->
								<td><?php echo $leave['leave_name'] ;?></td>
								<td>
								<?php if ($leave['approved'] == 1 ){ ?>
									<a class="label label-success ">Approved</a>
								<?php }elseif($leave['approved'] == 2){?>
									<a class="label label-warning ">Disapproved</a>
								<?php }elseif($leave['approved'] == 0){?>
								<a class="label label-danger ">Not Approved</a>
								<?php }?>
								
								<?php /*<?php if($user_data['user_designation'] == 6) { ?> onclick="approve('<?php echo $employee_details['id'];?>','<?php echo $leave['id'];?>');" <?php } ?>*/?>
								</td>
								<td>
									<a href="<?php echo site_url('leave/leave_details/'.$leave['user_id'].'/'.$leave['id']);?>" class="btn btn-primary btn-xs">View Details</a>
								</td>
								
							</tr>
						<?php
							}
						}else{?>
							<tr> <td style="text-align:center" colspan="7">No Data Found!<td></tr>
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