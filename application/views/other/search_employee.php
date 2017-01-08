<div class="content-wrapper">

    <!-- Content Header (Page header) -->

	<?php //fn_ems_debug($user_data); ?>

    <section class="content-header">

      <h1>

		Advanced Search 

      </h1>

      <ol class="breadcrumb">

        <li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="<?php echo site_url('user/list_employees');?>"> Employee List</a></li>

        <li class="active">Advanced Search</li>

      </ol>

    </section>



    <!-- Main content -->

    <section class="content">

	<form method="POST" action="<?php echo site_url('user/search_employee');?>">
	<div class="box">
		<div class="box-header">
			<h3 class="box-title"><i class="fa  fa-search"></i> Search Employee</h3>
			<div class="box-tools pull-right">
                <button type="button" id="ems-collapse" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus "></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
            </div>
		</div>
		<div class="box-body table-responsive ems-box-body">
			<table class="table table-hover table-striped">
				<tbody>
				
					<tr>
					  <td>ID</td>
					  <td><input type="text" class="form-control" name="search[id]" id="id"  value="" /></td>
					</tr>
					
					<tr>
					  <td>Contact Number</td>
					  <td><input type="text" class="form-control" name="search[phone]" id="phone"  value="" maxlength="10"/></td>
					</tr>
					
					<tr>
					  <td>First Name</td>
					  <td><input type="text" class="form-control" name="search[firstname]" id="firstname"  value=""/></td>
					</tr>
					
					<tr>
					  <td>Last Name</td>
					  <td><input type="text" class="form-control" name="search[lastname]" id="lastname"  value=""/></td>
					</tr>
					
					<tr>								
					  <td>Current Status</td>
					  <td>
						<select  name="search[current_status]" class="form-control select2" style="width: 100%;" id="current_status">
							<option value="">--</option>
						<?php foreach($employee_settings['statuses'] as $key => $status) {?>
							<option value="<?php echo $status['status']; ?>"><?php  echo $status['status_description'] ?></option>
						<?php }?>
						</select>  
					  </td>
					</tr>
					
					<tr>
					  <td>Official E-Mail</td>
					  <td><input type="email" class="form-control" name="search[official_email]" id="official_email_"  value=""/></td>
					</tr>
					
					<tr>
					  <td>Date Of Joining</td>
					  <td><input type="text" class="form-control" name="search[doj]" id="doj"  value=""/></td>
					</tr>
					</tr>
				</tbody>
			</table>
		</div>
		<div class="box-footer clearfix">
			<div class="pull-left">
				
				</div>
			<button type="submit" name="submit" value="1" class="btn btn-primary  pull-right"><i class="fa   fa-search"></i>  Search</button>
		</div>
	</div>
	</form>
	<?php  if(isset($employees) && !empty($employees)){		$this->load->view('other/search_results'); 	 }?>
</section>
</div>
<script src="<?php echo base_url('assets/dist/js/moment.min.js');?>"></script>
<script src="<?php echo base_url('assets/plugins/datepicker/bootstrap-datepicker.js');?>"></script>
<script src="<?php echo base_url('assets/plugins/select2/select2.full.min.js');?>"></script>
<script>
$(function(){	$('#ems-collapse').click(function(event){});//Date picker
$('#doj').datepicker({
  autoclose: true,
  format: 'yyyy-mm-dd',
});
	//select
	$(".select2").select2();
});
</script>