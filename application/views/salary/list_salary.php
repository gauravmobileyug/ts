<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<?php //fn_ems_debug($user_data); ?>
    <section class="content-header">
      <h1>
        All Pay-Slip
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Salary</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">       
        <div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
				  <h3 class="box-title">Salary Slip</h3>

				  <!-- <div class="box-tools pull-right">
					<div class="has-feedback">
					  <input type="text" class="form-control input-sm" placeholder="Search Policy">
					  <span class="glyphicon glyphicon-search form-control-feedback"></span>
					</div>
				  </div> -->
				  <!-- /.box-tools -->
				</div>
            <!-- /.box-header -->
            <div class="box-body no-padding">
             
              <div class="table-responsive mailbox-messages">
				<table class="table dataTable table-hover table-bordered custom-td" id="salary_history_table">
					<thead>
						<tr>
							<td><label>Sr.No.</label></td>
							
							<td><label>Year</label></td>
							<td><label>Month</label></td>
							<td><label>Date Added</label></td>
							<td class="center"><label>Action</label></td>
							
						</tr>
					</thead>
					
						
						<?php 
						if( isset($salaries) && !empty($salaries) ){ 
							$ci =& get_instance();
							$count = 1;														$months = array(								'1' => 'January',								'2' => 'February',								'3' => 'March',								'4' => 'April',								'5' => 'May',								'6' => 'June',								'7' => 'July',								'8' => 'August',								'9' => 'September',								'10' => 'October',								'11' => 'November',								'12' => 'December'							);							
							foreach($salaries as $key => $salary){ 
							
							$month = $salary['month'];
							$year  = $salary['year'];
							
							$salary_slip = $ci->uploaded_salary_slip($salary['user_id'], $month , $year );
						?>
						<tr>
								<td><?php echo $count++ ;?></td>
								
								<td><?php echo $year ;?></td>
								<td><?php echo $months[$month] ;?></td>
								<td><?php echo $salary['date_added'] ;?></td>
								<td>
									<?php if( isset($salary_slip) && !empty($salary_slip['salary_slip']) ){ ?>
										<a class="btn btn-warning btn-xs" href="<?php echo site_url('salary/download_slip/'.$salary_slip['id'].'/'.$salary['user_id']);?>">
											<i class="fa fa-download"></i> Download Slip </a>
									<?php }?>
								</td>
							
						</tr>
						<?php
							}
						}
						else {?>
						<!-- <tr>
							<td colspan="8" style="text-align:center;color:red"><label>NO SALARY HISTORY !</label></td>
						</tr> -->
						<?php } ?>
					
				</table>
                <!-- /.table -->
              </div>
              <!-- /.mail-box-messages -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer padding">
				<div class="pull-left">
				
				</div>   
              <div class="mailbox-controls">
				<ul class="pagination pagination-sm no-margin pull-right">
				<?php 
					foreach ($links as $link) { 
						echo "<li>". $link."</li>";
					}
				?>
				</ul>
              </div>
            </div>
          </div>
          
        </div>
      </div>
    </section>
  </div>
  
  
<script>$(document).ready(function(){		$('#salary_history_table').DataTable({	  "paging": true,	  "lengthChange": true,	  "searching": false,	  "ordering": true,	  "info": true,	  "autoWidth": true, 	  "columnDefs": [ {		"targets": [4],		"orderable": false		} ]	});});</script>