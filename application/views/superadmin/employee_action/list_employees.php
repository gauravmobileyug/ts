
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
            <div class="box-body table-responsive ">
				<table class="table table-hover table-striped">
					<tbody>
						<tr>
						  <th>ID</th>
						  <th>Name</th>
						  <th>Date</th>
						  <th>Email</th>
						  <th>Contact Number</th>
						  <th>Department</th>
						  <th>Status</th>
						  <th>View</th>
						  <th>Edit</th>
						  <th>Delete</th>
						</tr>
						
					<?php 
					if(isset($employees) && !empty($employees)){
						foreach($employees as $key => $employee):
					?>
						<tr>
							<td><?php echo $employee['id'];?></td>
							<td>
							<a href="<?php echo site_url('user/view/'.$employee['id']);?>">
								<?php echo strtoupper($employee['firstname']. ' '.$employee['lastname']);?>
							</a>
							</td>
							<td><?php echo date('d-M-Y', strtotime($employee['date_added']));?></td>
							<td><?php echo $employee['email'];?></td>
							<td><?php echo $employee['phone'];?></td>
							<td><?php echo !empty($employee['department']) ? strtoupper($employee['department_name']) : 'NA';?></td>
							<td>
							<?php if( $employee['status'] == 0 ) {?>
								<span class="label label-warning">Disabled</span>
							<?php }elseif($employee['status'] == 1) { ?>
								<span class="label label-success">Enabled</span>
							<?php }?>
							</td>
							<td><a href="<?php echo site_url('user/view/'.$employee['id']);?>"><i class="fa fa-eye"></i></a></td>
							<td><a href="<?php echo site_url('user/edit/'.$employee['id']);?>"><i class="fa  fa-edit"></i></a></td>
							<td><a href="#" onclick="fn_del_Emp('<?php echo $employee['id'];  ?>');"><i class="fa fa-remove"></i></a></td>
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
			<div class="box-footer clearfix">
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