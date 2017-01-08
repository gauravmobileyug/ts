
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<?php //fn_ems_debug($employees); ?>
<section class="content-header">
  <h1>
	Managers List
  </h1>
  <ol class="breadcrumb">
	<li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Managers</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

	<div class="row">
	<div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Managers</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
			<div class="table-responsive no-padding">
				<table class="table dataTable table-hover table-striped" id="managers_list">
					<thead>
						<tr>
						  <th>Manager Name</th>						
						  <th>Employee Count</th>						
						  <th>Action</th>						
						</tr>
					</thead>
					<tbody>
						
					<?php 
					if(isset($managers) && !empty($managers)){
						foreach($managers as $key => $manager):
					?>
						<tr>
							<td>
							<a href="<?=site_url('user/view/'.$manager['id']);?>">
								<?php echo ucwords($manager['firstname'].' '.$manager['lastname']);?>
							</a>
							</td>
							<td><?php echo $manager['employees'];?></td>
							<td>
							<?php if($view_leaves) :?>
							<a class="btn btn-xs btn-primary" href="<?php echo site_url('user/list_manager_employees/'.$manager['id']);?>"><i class="fa fa-eye"></i> View Employees </a>
							<?php else :?>
							<a class="btn btn-xs btn-primary" href="<?php echo site_url('user/get_manager_employee_list/'.$manager['id']);?>"><i class="fa fa-eye"></i> View Employees </a>
							
							<?php endif;?>
							
							</td>
						</tr>
					<?php
						endforeach;
					}else{
					?>
						<tr>
							<td  colspan="3" style="text-align:center;"> No Data Found !</td>
						</tr>
					<?php
					}
					?>
					
					
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
<script>
$(document).ready(function(){	
	$('#managers_list').DataTable({	
		"paging": false,	
		"lengthChange": true,	
		"searching": true,
		"ordering": true,	
		"info": true,	
		"autoWidth": true, 	
		"columnDefs": [ {	
			"targets": [2],	
			"orderable": false
		} ]
	});
});
</script>