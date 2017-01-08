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
				<table class="table table-bordered dataTable ">		
				<thead>
					<tr>
						<th>Sr.No.</th>
						<th>Designation Name</th>
						<th>Designation Code</th>
						<th>Status</th>
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
							<td><?php echo strtoupper($designation['user_designation']) ;?></td>
							<td>
								<?php 
								$status_class = $designation['status'] == 1 ? "label-success" : "label-danger" ;
								$status 	  = $designation['status'] == 1 ? "Enabled" : "Disabled" ;
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

