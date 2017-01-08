
<style>
table.dataTable thead th, table.dataTable thead td {
    padding: 5px;
}
#monthly_added_list_length{
	display:none;
}
.table.dataTable thead .sorting {
	background:none !important;
}
</style>


<div class="content-wrapper">

	<section class="content-header">
	  <h1>
		Leave History
	  </h1>
	  <ol class="breadcrumb">
		<li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Leaves</li>
	  </ol>
	</section>
	<section class="content-header">
		<div class="pull-left">
			<b>Employee Name </b> -  <?php echo ucwords($user_data['firstname'].' '.$user_data['lastname']);?><br/>
			<b>Employee ID </b> -  <?php echo $user_data['employee_id'];?> <br/>
			<b>Reporting Manager </b> -  <?php echo ucwords($user_data['reporting_manager_name']);?> 
		</div>
		
		<div class="pull-right">
			<?php /* <a href="" class="btn btn-primary" style="cursor: pointer;" data-toggle="modal" data-target="#monthly_added_history"> Monthly Added Leaves</a> */ ?>
			<a target="_blank" href="<?php echo site_url('report/download_leaves_pdf/'.$user_data['id']) ;?>" class="btn btn-primary" style="cursor: pointer;"> My Leave Report</a> 
			
		</div>
	</section>	
	
	<div style="padding-bottom: 67px;"></div>
	
	
	<div id="monthly_added_history" class="modal fade" role="dialog" >	
		
		<div class="modal-dialog">	
			<div class="modal-content" style="width: 718px;height:620px;">	
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<h4 class="modal-title">Monthly/Yearly Added Leaves</h4>	
				</div>			  		
				<div class="modal-body" style="height: auto; width: auto;min-height:505px;max-height:505px">
						<table class="table dataTable table-hover table-striped" id="monthly_added_list">
							<thead>
								<th>Sr.No.</th>
								<th>Description</th>
								<th>Year</th>
								<th>Month</th>
								<th>Date Added</th>
								<th>Added Value</th>
								<th>SL Bal</th>
								<th>PL Bal</th>
							</thead>
							
							
							<?php if( !empty($monthly_added_leaves) ): $i = 1;?>
							<?php foreach($monthly_added_leaves as $key => $value ):?>
							
							<?php 
								$m_desc = $value['m_sleave'] != 'X' ? 'SL Added' : 'PL Added';
							?>
								
							
							<tr>											
								<td ><?php echo $i++;?></td>									
								<td ><?=$m_desc;?></td>									
								<td ><?php echo $value['year'];?></td>		
								<td ><?php echo $value['month'];?></td>									
								<td ><?php echo date('Y-m-d', strtotime($value['m_date_added']));?></td>									
								<td ><?php echo $value['m_sleave'] != 'X' ? $value['m_sleave'] : $value['m_pleave'];?></td>
								<td><?php echo $value['m_total_sleave'];?></td>
								<td><?php echo $value['m_total_pleave'];?></td>
								
								
								
							</tr>
							<?php endforeach;?>
							<?php else:?>
							<tr><td colspan="8" style="text-align:center;">No Leave Points  Found</td></tr>
							<?php endif;?>
						</table>
				</div>	
				<div class="modal-footer">	
					<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>	
				</div>		
			</div>	
		</div>	
		
		
	</div>
	
	
	
	
	
	<?php //fn_ems_debug( $user_data );?>
	<!-- Main content -->
	<section class="content">

	<div class="row">
	<div class="col-xs-12">

	<div class="box" style="clear:both;">
            <div class="box-body table-responsive no-padding">
				<div class="table-responsive no-padding">
					<?php /*
					<table class="table dataTable table-hover table-bordered">
						<tbody>
							<tr>
								<td><label>Employee Name:</label></td>
								<td><?php echo ucwords($leave_report['short_description']['employee']) ;?></td>
								<td><label>Employee ID:</label></td>
								<td><?php echo strtoupper($leave_report['short_description']['employee_id']);?></td>
								<td><label>Reporting Manager:</label></td>
								<td><?php echo ucwords($leave_report['short_description']['manager']);?></td>
							</tr>
						</tbody>
					</table> 
					
					
					<hr style="border: 1px solid;">
					*/
					?>
					<table class="table dataTable table-hover table-striped">
						<tbody>
							<tr>
								<td style="width: 25%;"><b>SL Opening Balance</b></td>
								<td style="text-align:left"><?php echo $leave_report['short_description']['opening_sleave']; ?></td>
								
								<td  style="width: 25%;"><b>PL Opening Balance</b></td>
								<td style="text-align:left"><?php  echo $leave_report['short_description']['opening_pleave']; ?></td>
								
							</tr>
						</tbody>
					</table> 
					<table class="table dataTable table-hover table-striped" id="leave_history">
							
							<thead>
								<tr>
									<th>Sr.No.</th>
									
									<th>From</th>
									<th>To</th>
									<th>Applied On</th>
									<th>Reason</th>
									
									<th>HD</th>
									<th>EL</th>
									
								
									
									
									<th>Leave Type</th>
									<th>No.Of Days</th>
									<th>Status</th>		
									<th>SL Balance</th>
									<th>PL Balance</th>
								</tr>
							</thead>
						
							<tbody>
							<?php $i=1;
							$sflag = false;
							$pflag = false;
							foreach($leave_report['long_description'] as $key => $value){
							// fn_ems_debug($leave_report['long_description']);?> 
							<?php /* <table class="table dataTable table-hover table-striped">
								<tbody>
									<tr>
										
										<td><label>ID:</label></td>
										<td><?php echo $value['leave_details']['id'];?></td>
										<td><label>Date Applied:</label></td>
										<td><?php echo $value['leave_details']['date_added'] ;?></td>
										<td><label>Approval Date:</label></td>
										<td>
										<?php 
											if ($value['leave_details']['date_approved'] != '') {
												echo $value['leave_details']['date_approved'];
											} else{ 
												echo "<b>Pending</b>";
											}
										?>
										</td>
										
									</tr>
								</tbody>
							</table> */?>
						
								<tr>											
									<td><?php echo $i++;?></td>												
									
									
									<td><?php echo $value['leave_details']['leave_from'];?></td>												
									<td><?php echo $value['leave_details']['leave_to'];?></td>
									<td><?php echo date('d M Y' , strtotime($value['leave_details']['date_added']));?></td>
									
									
									<td style="width:17%;word-break:break-all;"><?php echo $value['leave_details']['leave_reason'];?></td>	
									<td><?php echo $value['leave_details']['half_day'];?></td>	
									<td><?php echo $value['leave_details']['emergency_leave'];?></td>	
									
									<td><?php echo $value['leave_details']['leave_name'];?></td>	
									
									<td><?php echo $value['leave_details']['no_of_days'];?></td>


									<td>
									<?php
										if($value['leave_details']['approved'] == 0){
											echo '<label class="label label-info">Pending</label>';
										}
										if($value['leave_details']['approved'] == 1){
											echo '<label class="label label-success">Approved</label>';
										}
										if($value['leave_details']['approved'] == 2){
											echo '<label class="label label-warning">Declined</label>';
										}
									?>
									</td>											
									<td><?php echo $value['leave_details']['balance_sleave'];?></td>													
									<td><?php echo $value['leave_details']['balance_pleave'];?></td>													
								</tr>
								<?php }?>
							</tbody>
						</table>
				
						
					
				</div>
			</div>
			<div class="box-footer">
				<div class="pull-left">
					
				</div>
			</div>

    </div>
    </div>
    </div>

</section>
</div>
<script>

$(document).ready(function(){
	
	try{
		$('#leave_history').DataTable({
		  "paging": true,
		  "lengthChange": true,
		  "searching": true,
		  "ordering": true,
		  "info": true,
		  "autoWidth": true		  ,
		   "columnDefs": [ {
			"targets": [1],
			"orderable": false
			} ]
		});
		
		$('#monthly_added_list').DataTable({
		  "paging": true,
		  "lengthChange": true,
		  "searching": true,
		  "ordering": true,
		  "info": true,
		  "autoWidth": true
		});
		
		
		
		
	}catch(err){
		
	}
	
});
</script>
   