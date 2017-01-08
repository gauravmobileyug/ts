<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<?php //fn_ems_debug($user_data); ?>
    <section class="content-header">
      <h1>
		Designations
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Designation</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	
		
	<div class="row">
		<form action="<?php echo site_url('employeestuff/designation/add'); ?>" method="POST">
		<div class="col-md-12">
		<div class="box box-solid">
			<div class="box-header with-border">
				<i class="fa fa-cubes"></i>
				<h3 class="box-title" class="pull-left">Add New Designation</h3>
				
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
						<td><label>Designation</label></td>
						<td>
							<input type="text" name="designations[user_designation_description]" id="user_designation_description" class="form-control" style="text-transform: capitalize;" value="" required/>
						</td>
					</tr>	
					
				</tbody>
				</table>
				
				
			</div>
			
			<div class="box-footer">
			  <div class="pull-left">
				<a class="btn btn-primary btn-xs" href="<?php echo site_url();?>"><i class="fa fa-arrow-left"></i> Go Back </a> 
			  </div>    
				<div class="pull-right">
					<button type="submit" class="btn btn-success" > Add Designation </button> 
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
				<i class="fa  fa fa-list-alt"></i>
				<h3 class="box-title" class="pull-left">Designations List</h3>
				<div class="box-tools pull-right">
					<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
					<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
				</div>
			</div>
			<!-- /.box-header -->
			<div class="box-body table-responsive no-padding">
				<table class="table table-stripped ">		
				<thead>
					<tr>
						<th>Sr.No.</th>
						<th>Designation Name</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					if( isset($designations) && !empty($designations) ){
						$count = 1;
						foreach($designations as $key => $designation) {
					?>
						<tr>
							<td><?php echo $count++ ;?></td>
							<td><?php echo ucwords($designation['user_designation_description']) ;?></td>
							
							<td >
								
							<div id="edit-designation-<?=$designation['id'];?>" class="modal fade" role="dialog">	
								<form name="emp-of-month" action="<?php echo site_url("employeestuff/edit_designation");?>" id="feedback_form" method="POST" enctype="multipart/form-data">	
								<div class="modal-dialog">	
									<div class="modal-content">	
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal">&times;</button>
											<h4 class="modal-title">Edit Designation <?php echo  ucwords($designation['user_designation_description']);?></h4>	
										</div>			  		
										<div class="modal-body" style="height: 63px;">
										
											<p>
												<input type="text" name="edit_user_designation_description" id="edit_user_designation_description" class="form-control text-capitalize" value="<?php echo ucwords($designation['user_designation_description']) ;?>"/>
												
												<input type="hidden" name="designation_id" value="<?=$designation['id'];?>"/>
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
								

							
								<a href="javascript:void(0);" class="btn btn-warning btn-xs" data-toggle="modal" data-target="#edit-designation-<?=$designation['id'];?>">
									<i class="fa fa-edit"> Edit </i>
								</a>
								|
								<a href="<?=site_url('employeestuff/delete_designation/'.$designation['id']);?>" class="btn btn-danger btn-xs">
									<i class="fa fa-remove"> Delete </i>
								</a>
								
							</td>
						</tr>	
					<?php }
					}else{
					?>
					<tr><td colspan="3" style="text-align:center"> <label class="text-danger" >No Designation Found !</label></td></tr>
					<?php }?>
				</tbody>
				</table>				
			</div>
		</div>
		</div>
	</div>
	</section>
</div>

