<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<?php //fn_ems_debug($user_data); ?>
    <section class="content-header">
      <h1>
		Available Leaves
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Leaves</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">

		<div class="col-md-12">
		<div class="box box-solid">
			<div class="box-header with-border">
			  <i class="fa fa fa-plane"></i>
			  <h3 class="box-title">Available Leaves</h3>
			  <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
			  </div>
			</div>
			<!-- /.box-header -->
			<div class="box-body table-responsive ">
				<table class="table table-hover table-striped">
					<thead>
						<tr>
							<th>Leave Type</th>
							<th>Total Used Leaves</th>
							<th>Max Leaves</th>
							<th>Per Month/Year</th>
						</tr>
					</thead>
					<tbody>
					 <?php foreach($availed_leaves as $key => $availed_leave){ ?>
						<tr>
							<td><label><?php echo $availed_leave['leave_name'];?></label></td>
							<td><?php echo $availed_leave['used'];?></td>
							<td><?php echo $availed_leave['max_leave_days'];?></td>
							<td><?php echo ucwords($availed_leave['leave_month_year']);?></td>
						</tr>
					 <?php } ?>
					</tbody>
				</table>
			</div>
			
			<div class="box-footer">
			<div class="pull-left">
				<a class="btn btn-primary btn-xs" href="javascript:history.go(-1);"><i class="fa fa-arrow-left"></i> Go Back </a> 
			  </div>   
              <div class="pull-right">
                <a class="btn btn-primary btn-xs" href="<?php echo site_url();?>"><i class="fa fa-reply"></i> Go Back </a>
              </div>
            
            </div>
			
		<!-- /.box-body -->
		</div>
		<!-- /.box -->
		</div>
	</div>
</div>