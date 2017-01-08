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
						<th>Action</th>
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
							
							<td>
								
								<div id="edit-department-<?=$department['id'];?>" class="modal fade" role="dialog">	
								<form name="edit-department" action="<?php echo site_url("employeestuff/edit_department");?>" id="edit-department" method="POST" enctype="multipart/form-data">	
								<div class="modal-dialog">	
									<div class="modal-content">	
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title">Edit Department <?php echo  ucwords($department['department_name']);?></h4>	
										</div>			  		
										<div class="modal-body" style="height: 63px;">
										
											<p>
												<input type="text" name="edit_user_department_name" id="edit_user_department_name" class="form-control text-capitalize" value="<?php echo ucwords($department['department_name']) ;?>"/>
												
												<input type="hidden" name="department_id" value="<?=$department['id'];?>"/>
											</p>
												
									
											</form>	
										</div>	
										<div class="modal-footer">	
											<button type="submit" class="btn btn-primary" >Edit</button>	
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>	
										</div>		
									</div>	
								</div>	
								
								</form>
							</div>
							
							
							
							
							
							
							
							
								<a href="javascript:void(0);" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#edit-department-<?=$department['id'];?>">
									<i class="fa fa-edit"> Edit </i>
								</a>
								|
								<a href="<?=site_url('employeestuff/delete_department/'.$department['id']);?>" class="btn btn-danger btn-xs">
									<i class="fa fa-remove"> Delete </i>
								</a>
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

