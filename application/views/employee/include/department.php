<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<?php //fn_ems_debug($user_data); ?>
    <section class="content-header">
      <h1>
		Department
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Department</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	
		
	<div class="row">
		<form action="<?php echo site_url('employeestuff/department/add'); ?>" method="POST">
		<div class="col-md-12">
		<div class="box box-solid">
			<div class="box-header with-border">
				<i class="fa fa-institution"></i>
				<h3 class="box-title" class="pull-left">Add New Department</h3>
				
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body table-responsive no-padding">
				<table class="table table-bordered  dataTable">	
				
				
				<tbody>
					<tr>
						<td><label>Department Name</label></td>
						<td>
							<input type="text" name="departments[department_name]" id="department_name" class="form-control" style="text-transform: capitalize;" value="" required/>
						</td>
					</tr>	
					<tr>
						<td><label>Department Code</label></td>
						<td>
							<input type="text" name="departments[department_code]" id="department_code" class="form-control" style="text-transform: lowercase;" value=""  required/>
						</td>
					</tr>	
					
				</tbody>
				</table>
				
				
			</div>
			
			<div class="box-footer">
			  <div class="pull-left">
				
			  </div>    
				<div class="pull-right">
					<button type="submit" class="btn btn-success" > Add Department </button> 
			  </div> 			  
            </div>
			
		<!-- /.box-body -->
		</div>
		<!-- /.box -->
		</div>
		</form>
	</div>
	
	
	
      <div class="row">
		
		<div class="col-md-12">
		<div class="box box-solid">
			<div class="box-header with-border">
				<i class="fa fa-list-alt"></i>
				<h3 class="box-title" class="pull-left">Departments List</h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body table-responsive no-padding">
				<table class="table table-bordered dataTable ">		
				<thead>
					<tr>
						<th>Sr.No.</th>
						<th>Department Name</th>
						<th>Department Code</th>
						<th>Status</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if( isset($departments) && !empty($departments) ){
							$count = 1;
						foreach($departments as $key => $department) {
					?>
						<tr>
							<td><?php echo $count++ ;?></td>
							<td><?php echo ucwords($department['department_name']) ;?></td>
							<td><?php echo strtolower($department['department_code']) ;?></td>
							<td>
								<?php 
								$status_class = $department['status'] == 1 ? "label-success" : "label-danger" ;
								$status 	  = $department['status'] == 1 ? "Enabled" : "Disabled" ;
								?>
								<span class="label <?php echo $status_class;?>"><?php echo $status;?></span>
							</td>
						</tr>	
					<?php }
					}
					?>
				</tbody>
				</table>				
			</div>
		</div>
		</div>
	</div>
	</section>
</div>

