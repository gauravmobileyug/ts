
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<?php //fn_ems_debug($user_data); ?>
<section class="content-header">
  <h1>
	All Employee
  </h1>
  <ol class="breadcrumb">
	<li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">All Employee</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

	<div class="row">
	<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Employees</h3>			  			   
            </div>
            <!-- /.box-header -->
            <div class="box-body">
			<div class="table-responsive no-padding">
				<table class="table dataTable table-hover table-striped" id="employee_list">
					<thead>
						<tr>
						  <th>ID</th>
						  <th>Name</th>
						  <th>Date Of Joining</th>
						  <!-- <th>Email</th> -->
						  <th>Contact Number</th>
						  <th>Department</th>
						 <!--  <th>Status</th> -->
						  <th>View</th>
						  
						  <!-- <th>Delete</th> -->
						</tr>					</thead>					<tbody>
						
					<?php 
					if(isset($employees) && !empty($employees)){
						foreach($employees as $key => $employee):
					?>
						<tr>
							<td style="    width: 12%;  word-break: break-all;"><?php echo $employee['employee_id'];?></td>
							<td style="    width: 18%;  word-break: break-all;">
							
							<?php echo strtoupper($employee['firstname']. ' '.$employee['lastname']);?>
							
							</td>
							<td><?php echo date('d-M-Y', strtotime($employee['doj']));?></td>
							<!-- <td><?php echo $employee['email'];?></td> -->
							<td><?php echo $employee['phone'];?></td>
							<td style="    width: 14%;  word-break: break-all;"><?php echo !empty($employee['department']) ? strtoupper($employee['department_name']) : 'NA';?></td>
							<?php /* ?>
							<td>
						
							<?php if( $employee['status'] == 0 ) {?>
								<span class="label label-warning">Disabled</span>
							<?php }elseif($employee['status'] == 1) { ?>
								<span class="label label-success">Enabled</span>
							<?php }?>
							
							</td>
							<?php */?>
							<td><a class="btn btn-xs btn-primary" href="<?php echo site_url('user/view/'.$employee['id']);?>"><i class="fa fa-eye"></i> View</a></td>
						</tr>
					<?php
						endforeach;
					}else{
					?>
						<tr>
							<td></td>
						</tr>
					<?php
					}
					?>
					
					
					</tbody>
				</table>
				</div>
            </div>
			<div class="box-footer clearfix">
				<div class="box-footer clearfix">
					
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
</div><script>$(document).ready(function(){		$('#employee_list').DataTable({	  "paging": true,	  "lengthChange": true,	  "searching": true,	  "ordering": true,	  "info": true,	  "autoWidth": true	});});</script>