<div class="content-wrapper">
   <!-- Content Header (Page header) -->
   <?php //echo '<pre>';print_r($user_data);die;?>
   <section class="content-header">
      <h1>
         Apply For Leave
      </h1>
      <ol class="breadcrumb">
         <li><a href="<?php echo base_url();?>"><i class="fa fa-dashboard"></i>Home</a></li>
         <li class="active">Leave</li>
      </ol>
   </section>
   
   <section>
	<div style="    padding-left: 15px;  padding-top: 15px;">
		<span><b>Reporting Manager : </b></span>
		<span style="font-size:14px"><?=ucwords($user_data['reporting_manager_name']);?></span>
	</div>
   </section>
   <section class="content">
      <form method="POST" action="<?php echo site_url('leave/apply/'.$user_id);?>" name="policy_form" id="policy_form">
         <div class="row">
            <div class="col-md-3">
               <div class="box box-primary">
			   <div class="box-header with-border">
					  <i class="fa fa-tags"></i>

					  
					  
					  <h3 class="box-title">Leave Summary</h3>
					  
						<div class="box-tools pull-right">
						<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
						</button>
					 
						<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
						</div>
				</div>
                  <div class="box-body box-profile">
                     <ul class="list-group list-group-unbordered">
                        <li class="list-group-item">						 
						<b>Total Available Leaves</b>
							<a class="pull-right"><label class="label label-success"><?php echo isset($user_leave_summary['TOTAL']) ?  $user_leave_summary['TOTAL'] : 0 ;?></label></a>
						</li>
                        <li class="list-group-item">	
							<b>Available Sick Leaves</b>
							<a class="pull-right"><label class="label label-primary"><?php echo isset($user_leave_summary['SICK']) ?  $user_leave_summary['SICK'] : 0 ;?></label></a>
						</li>
                        <li class="list-group-item">	
							<b>Available Planned Leaves</b>
							<a class="pull-right"><label class="label label-primary"><?php echo isset($user_leave_summary['PLANNED']) ?  $user_leave_summary['PLANNED'] : 0 ;?></label></a>
						</li>
                        <li class="list-group-item">	
							<b>Total Pending Leaves</b>
							<a class="pull-right"><label class="label label-warning"><?php echo isset($user_leave_summary['PENDING']) ?  $user_leave_summary['PENDING'] : 0 ;?></label></a>
						</li>
                     </ul>
                  </div>
               </div>
            </div>
            <div class="col-md-9">
               <div class="box box-primary">
                  <div class="box-header with-border">
                     <h3 class="box-title">Leave Application</h3>
                  </div>
                  <!-- /.box-header -->
                  <div class="box-body">
                     <div class="form-group">
                        <label>Leave From</label><small class="text-danger">*</small>
                        <input class="form-control"  id="leave_from" name="leave_from" value="" required autocomplete="off">
                     </div>
                     <div class="form-group">
                        <label>Leave To</label><small  class="text-danger">*</small>
                        <input class="form-control" id="leave_to" name="leave_to" value="" required autocomplete="off">
                     </div>
                     <div class="form-group">	
						<label style="padding-right: 10px;"><input type="radio" class="flat-red" id="eh_leave" name="eh_leave"  value="E">	Emergency Leave ?</label> 	
						
						
						<label style="padding-right: 10px;"><input type="radio" class="flat-red" id="eh_leave" name="eh_leave" value="H">  Half Day Leave ?</label> 
						
						
						<label style="padding-right: 10px;"><input type="radio" class="flat-red" id="eh_leave" name="eh_leave" value="N" checked> None</label> 
						

						
					 </div>
                     <div class="form-group">
                        <label>Leave Type</label><small  class="text-danger">*</small>
                        <select name="leave_type" id="leave_type" class="form-control select2" required>
                           <option value="">Select Leave Type</option>
                           <?php foreach($leave_types as $key => $leave){ ?>
                           <option value="<?php echo $leave['id'] ;?>"><?php echo $leave['leave_name'];?></option>
                           <?php }?>
                        </select>
                     </div>
                     <div class="form-group">
                        <label>Reason</label><small  class="text-danger">*</small>
                        <textarea id="leave_reason" class="form-control" style="height: 100px" name="leave_reason" required></textarea>
                     </div>
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
					<div class="pull-left" style="padding-right: 12px;">
						
					  </div>   
                     <div class="pull-right">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Apply </button>
                     </div>
                  
                  </div>
                  <!-- /.box-footer -->
               </div>
               <!-- /. box -->
            </div>
            <!-- /.col -->
         </div>
         <!-- /.row -->
   </section>
   </form>
   <!-- /.content -->
</div>
<script src="<?php echo base_url('assets/dist/js/moment.min.js');?>"></script>
<script src="<?php echo base_url('assets/plugins/daterangepicker/daterangepicker.js');?>"></script>
<script src="<?php echo base_url('assets/plugins/datepicker/bootstrap-datepicker.js');?>"></script>
<script src="<?php echo base_url('assets/plugins/select2/select2.full.min.js');?>"></script>
<script>
   //Date picker
   $('#leave_from , #leave_to').datepicker({
     autoclose: true,
     format: 'yyyy-mm-dd',
   });
   //select
   $(".select2").select2();
</script>