<div class="content-wrapper">

	<section class="content-header">
	  <h1>
		Timesheet Report
	  </h1>
	  
	  <?php 
		$params = '';
		if(isset($search_params['from_date'] ,$search_params['to_date']  ) && !empty($search_params['from_date']) && !empty($search_params['to_date'])){
			$params = '?params[from_date]='.$search_params['from_date'].'&params[to_date]='.$search_params['to_date'];
		}
		?>
	  
	  <ol class="breadcrumb">
		<li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
		
		<li class="active">Timesheet Report</li>
	  </ol>
	</section>
	
	<section class="content">		
		
		<div class="row">       
        <div class="col-md-12">
			<div class="box box-primary">
			  <div class="box-header with-border">
				 <h3 class="box-title">Timesheet Report List</h3>
			  </div>
			
			<div class="box-body">
			<div class="table-responsive">
				<?php $this->load->view('report/timesheet_search_options'); ?>
				<table class="table dataTable " id="timesheet_report">
					<thead>
						<tr>
						  <th>Sr.No.</th>
						  <th>Employee Name</th>
						  <th>Total Minutes</th>
						  <th>Action</th>						 
						</tr>
					</thead>
					
					<tbody>
						
						<?php 
						
							$role = $user_data['role'];
							
						
							if( isset($timesheet_reports) && !empty($timesheet_reports) ) {
							$count = 1;
						?>
							<?php foreach($timesheet_reports as $key	=>	$report) {?>
							<tr>
								<td><?php echo $count++;?></td>
								<td><?php echo ucwords($report['firstname'].' '.$report['lastname']);?></td>
								<td><?php echo $report['total_time'];?></td>
								
								<?php 
								$params = '';
								if(isset($search_params['from_date'] ,$search_params['to_date']  ) && !empty($search_params['from_date']) && !empty($search_params['to_date'])){
									$params = '?params[from_date]='.$search_params['from_date'].'&params[to_date]='.$search_params['to_date'];
								}
								
								
								?>
								
								<td>
								<?php if( 
									($role == 'M' && if_it_is_reporting_employee($user_data ,$report['user_id'] )) ||
									($role == 'M' && $report['user_id'] == $user_data['id'] ) || 
									($role == 'E' && $report['user_id'] == $user_data['id'] ) || 
									($role == 'H' || $role == 'S')
									) {?>
								<a class="label label-success" href="<?php echo site_url('report/list_timesheet/'.$report['user_id'].$params);?>" >View Details</a>
								
								<?php if($report['user_id'] == $user_data['id'] ):?>
								<a class="label label-info" href="<?php echo site_url('user/list_timesheet/'.$report['user_id']);?>" >My All Entries</a>
								<?php endif;?>
								
									<?php  }?>
								</td>
							</tr>
						<?php }?>
						
						<?php }else{ ?>
							<tr>
								<td colspan="4" style="text-align: center;"><b>No Result Found !</b></td>
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
		$('#timesheet_report').DataTable({
		  "paging": false,
		  "lengthChange": true,
		  "searching": false,
		  "ordering": true,
		  "info": true,
		  "autoWidth": true, 
		  "columnDefs": [ {
			"targets": [3],
			"orderable": false
			} ]
		});
	}catch(err){
		
	}
	
});
</script>