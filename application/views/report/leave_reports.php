<div class="content-wrapper">

	<section class="content-header">
	  <h1>
		Leave Report
	  </h1>
	  <ol class="breadcrumb">
		<li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
		<li class="active">Leave Report</li>
	  </ol>
	</section>
	
	<section class="content">

		
		<div class="row">       
        <div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Leaves Report List</h3>
				</div>
			
				<div class="box-body">
					<?php $this->load->view('report/leave_search_options'); ?>
					<div class="table-responsive">
					<table class="table dataTable margin" id="leaves_report">
						<thead>
							<tr>
							  <th>Sr.No.</th>
							
							  <th>Employee ID</th>
							  <th>Employee Name</th>
							  
							   
							  <th>From</th>
							  <th>To</th>
							  
							  
							  <th>Reporting Manager</th>
							  
							  <th>Action</th>						 
							</tr>
						</thead>
						
						<tbody>
							
							<?php 
								if( isset($leaves) && !empty($leaves) ) {
								$count = 1;
							?>
								<?php foreach($leaves as $key	=>	$report) {?>
								<tr>
									<td><?php echo $count++;?></td>
									<td><?php echo $report['employee_id'];?></td>
									<td><?php echo ucwords($report['firstname'].' '.$report['lastname']);?></td>
									
									<td><?php echo $report['leave_from'];?></td>
									<td><?php echo $report['leave_to'];?></td>
									
									<td><?php echo ucwords($report['manager']);?></td>
									
									
									
									<?php 
									$params = '';
									if(isset($search_params['from_date'] ,$search_params['to_date']  ) && !empty($search_params['from_date']) && !empty($search_params['to_date'])){
										$params = '?params[from_date]='.$search_params['from_date'].'&params[to_date]='.$search_params['to_date'];
									}
									
									
									?>
									
									<td><a class="label label-success" href="<?php echo site_url('report/list_leaves/'.$report['user_id'].$params);?>" >View Details</a></td>
								</tr>
							<?php }?>
							
							<?php }else{ ?>
								<tr>
									<td colspan="8" style="text-align: center;"><b>No Result Found !</b></td>
								</tr>
							<?php }?>
						</tbody>
					</table>
				</div>
				</div>
				
				<div class="box-footer clearfix">
					<div class="pull-left">
					</div>
				</div>
			</div>
		</div>
	</section>

</div>

<script>

$(document).ready(function(){
	
	try{
		$('#leaves_report').DataTable({
		  "paging": false,
		  "lengthChange": true,
		  "searching": false,
		  "ordering": true,
		  "info": true,
		  "autoWidth": true, 
		  "columnDefs": [ {
			"targets": [0,6],
			"orderable": false
			} ]
		});
	}catch(err){
		
	}
	
});
</script>