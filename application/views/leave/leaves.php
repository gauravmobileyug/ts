
<div class="content-wrapper">
<?php // fn_ems_debug($leaves); ?>
<section class="content-header">
  <h1>
	Leaves History 
  </h1>
  <ol class="breadcrumb">
	<li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
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
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
			<div class="table-responsive no-padding">
				<table class="table dataTable table-hover table-striped" id="leave_history">
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
								<td><?php echo $leave['no_of_days'].' Day(s)' ;?></td>
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
				<a class="btn btn-primary btn-xs" href="javascript:history.go(-1);"><i class="fa fa-arrow-left"></i> Go Back </a> 
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

<script>

$(document).ready(function(){
	
	try{
		$('#leave_history').DataTable({
		  "paging": false,
		  "lengthChange": true,
		  "searching": false,
		  "ordering": true,
		  "info": true,
		  "autoWidth": true		  
		});
	}catch(err){
		
	}
	
});
</script>