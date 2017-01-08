
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<?php //fn_ems_debug($user_data); ?>
    <section class="content-header">
      <h1>
        Add Employee
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Add Employee</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">
        <!-- /.col -->
        <div class="col-md-12">
          <div class="nav-tabs-custom">
			<ul class="nav nav-tabs">
				<li <?php if(!isset($_GET['next_step'])){ echo 'class="active"'; }?>>
					<a href="#personal" data-toggle="tab">Personal Information</a>
				</li>
				<li <?php if(isset($_GET['next_step']) && $_GET['next_step'] == '2'){ echo 'class="active"'; }?>>
					<a href="#department" data-toggle="tab">Employee Department</a>
				</li>
				<li <?php if(isset($_GET['next_step']) && $_GET['next_step'] == '3'){ echo 'class="active"'; }?>>
					<a href="#bank_info" data-toggle="tab">Bank Info</a>
				</li>
				<li <?php if(isset($_GET['next_step']) && $_GET['next_step'] == '4'){ echo 'class="active"'; }?>>
					<a href="#documents" data-toggle="tab">Documents</a>
				</li>	
				<li <?php if(isset($_GET['next_step']) && $_GET['next_step'] == '5'){ echo 'class="active"'; }?>>
					<a href="#leaves" data-toggle="tab">Leaves</a>
				</li>				
			</ul>
            <div class="tab-content">
			
              <div class="tab-pane  <?php if(!isset($_GET['next_step'])){ echo 'active'; }?>" id="personal">
				<?php 
					$action = '';
					if(isset($new_user_data)) { 
						$action = 'user/update_employee';
					}else{
						$action = 'user/add_employee';
					}
				?>
			  
			  
			  
				<form class="form-horizontal" name="edit-profile" id="edit-profile" enctype="multipart/form-data" action="<?php echo site_url($action);?>" method="POST">
				
				  <input type="hidden" name="step" value="1"/>
				  <input type="hidden" name="next_step" value="2"/>
				  <input type="hidden" name="tab" value="personal"/>
				  <input type="hidden" name="user_id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : 0;  ?>"/>
				  
                  <div class="form-group">
                    <label for="firstname" class="col-sm-2 control-label">First Name<span class="em-required">*</span></label>

                    <div class="col-sm-10">
                      <input type="text"  name="user[basic][firstname]" class="form-control text-capitalize" id="firstname" value="<?php echo isset($new_user_data) ? $new_user_data['firstname'] : '' ;?>" required>
                    </div>
                  </div>
				  
				  <div class="form-group">
                    <label for="lastname" class="col-sm-2 control-label">Last Name<span class="em-required"></span></label>

                    <div class="col-sm-10">
                      <input type="text" name="user[basic][lastname]" class="form-control text-capitalize" id="lastname" value="<?php echo isset($new_user_data) ? $new_user_data['lastname'] : '' ;?>">
                    </div>
                  </div>

				  
				  <div class="form-group">
                    <label for="employee_id" class="col-sm-2 control-label">Employee ID<span class="em-required">*</span></label>

                    <div class="col-sm-10">
					
					<div class="input-group">
						<input type="text" class="form-control text-uppercase" id="employee_id" name="user[basic][employee_id]" value="<?php echo isset($new_user_data) ? $new_user_data['employee_id'] : '' ;?>">
						<span class="input-group-addon"><i class="fa hidden" id="validate_emp_id"></i></span>
					</div>
					
                    <!--   <input type="text" name="user[basic][employee_id]" class="form-control text-uppercase" id="employee_id" value="<?php echo isset($new_user_data) ? $new_user_data['employee_id'] : '' ;?>" required> -->
                    </div>
                  </div>
				  
				  
				  <div class="form-group">
					<label for="gender" class="col-sm-2 control-label">Select Gender<span class="em-required">*</span></label>
					<div class="radio col-sm-10">
						<label>
						  <input type="radio" name="user[basic][gender]" id="gender" value="male" <?php echo isset($new_user_data) && $new_user_data['gender'] == 'male' ? 'checked' : '' ;?> required>
						  Male
						</label>
						<label>
						  <input type="radio" name="user[basic][gender]" id="gender" value="female" <?php echo isset($new_user_data) && $new_user_data['gender'] == 'female' ? 'checked' : '' ;?> required>
						  Female
						</label>
					</div>
					
                  </div>
				  
				  
				  
				  
				  
				  <div class="form-group">
					<label for="dob" class="col-sm-2 control-label">Date Of Birth<span class="em-required">*</span></label>

					<div class="input-group date col-sm-9" style="padding-left: 16px;    width: 603px;">
					  <div class="input-group-addon">
						<i class="fa fa-calendar"></i>
					  </div>
					  <input type="text" value="<?php echo isset($new_user_data) ? $new_user_data['dob']: '';?>" name="user[extra][dob]" class="form-control pull-right text-capitalize" id="dob" autocomplete="off" placeholder="Select Date Of Birth" required>
					</div>
					
				  </div>
				  
				  
				  
				  
				  <div class="form-group">
					<label for="doj" class="col-sm-2 control-label">Date Of Joining<span class="em-required">*</span></label>

					<div class="input-group date col-sm-9" style="padding-left: 16px;    width: 603px;">
					  <div class="input-group-addon">
						<i class="fa fa-calendar"></i>
					  </div>
					  <input type="text" value="<?php echo isset($new_user_data) ? $new_user_data['doj']: '';?>" name="user[basic][doj]" class="form-control pull-right text-capitalize" id="doj" autocomplete="off"  placeholder="Select Date Of Joining" required>
					</div>
					
				  </div>
				  
				  
				  
                  <div class="form-group fg">
                    <label for="email" class="col-sm-2 control-label">Personal Email<span class="em-required">*</span></label>

                    <div class="col-sm-10">
					<div class="input-group">
                      <input type="email" name="user[basic][email]" class="form-control email" id="email" value="<?php echo set_value('email'); ?><?php echo isset($new_user_data) ? $new_user_data['email']: '';?>" required>
					  <span class="input-group-addon"><i class="fa fa-check hidden" id="validate_email_id"></i></span>
                    </div>
					<span class="help-block hidden"></span>
                  </div>
                  </div>
                 
				  <div class="form-group fg">
                    <label for="email" class="col-sm-2 control-label">Official Email<span class="em-required">*</span></label>

                    <div class="col-sm-10">
						<div class="input-group">
						  <input type="email" name="user[basic][official_email]" class="form-control email" id="official_email" value="<?php echo set_value('official_email'); ?><?php echo isset($new_user_data) ? $new_user_data['official_email']: '';?>" required>
						  <span class="input-group-addon"><i class="fa hidden" id="validate_emp_off_id"></i></span>
						
						  
						</div>
                    </div>
                  </div>
				 
				 
				 
				 
				<div class="form-group">
					
                    <label for="role" class="col-sm-2 control-label">Role Of Employee<span class="em-required">*</span></label>
                    <div class="col-sm-10">
					  
                      <select  name="user[basic][role]" class="form-control" style="width: 100%;" style="width: 100%;" id="role" required>
						<option> Select Role Of Employee</option>
	
							
							
							<?php /* ?><option value="H"  <?php echo isset($new_user_data['role']) && $new_user_data['role'] == 'H' ? 'selected' : '' ?>>HR</option>
							<?php */ ?>
							<option value="M"  <?php echo isset($new_user_data['role']) && $new_user_data['role'] == 'M' ? 'selected' : '' ?>>Manager</option>
							<option value="E"  <?php echo isset($new_user_data['role']) && $new_user_data['role'] == 'E' ? 'selected' : '' ?>>Employee</option>
					
					  </select>
                    </div>
                </div>
				
                  
                  <div class="form-group">
                    <label for="phone" class="col-sm-2 control-label">Phone<span class="em-required">*</span></label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control text-capitalize" name="user[basic][phone]" maxlength="10" id="phone" value="<?php echo isset($new_user_data) ? $new_user_data['phone']: '';?>" required>
                    </div>
                  </div>
				  
				  
				  <div class="form-group">
                    <label for="emergency_contact" class="col-sm-2 control-label">Emergency Contact<span class="em-required">*</span></label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control text-capitalize" name="user[basic][emergency_contact]" maxlength="10" id="emergency_contact" value="<?php echo isset($new_user_data) ? $new_user_data['emergency_contact']: '';?>" required>
                    </div>
                  </div>
				  
				  
				  
				  
				  <div class="form-group">
                    <label for="education" class="col-sm-2 control-label">Education<span class="em-required">*</span></label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control text-capitalize" name="user[extra][education]" id="education" value="<?php echo isset($new_user_data) ? $new_user_data['education']: '';?>" required>
                    </div>
                  </div>
				  
				  
				  <div class="form-group">
                    <label for="present_address" class="col-sm-2 control-label">Present Address<span class="em-required">*</span></label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control text-capitalize" name="user[extra][present_address]" id="present_address" value="<?php echo isset($new_user_data) ? $new_user_data['present_address']: '';?>" required>
                    </div>
                  </div>
				  
				  <div class="form-group">
                    <label for="permanent_address" class="col-sm-2 control-label">Permanent Address<span class="em-required">*</span></label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control text-capitalize" name="user[extra][permanent_address]" id="permanent_address" value="<?php echo isset($new_user_data) ? $new_user_data['permanent_address']: '';?>" required>
                    </div>
                  </div>
				  
				  <div class="form-group">
                    <label for="zipcode" class="col-sm-2 control-label">Zip Code<span class="em-required">*</span></label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control text-capitalize" name="user[extra][zipcode]" id="zipcode" value="<?php echo isset($new_user_data) ? $new_user_data['zipcode']: '';?>" required>
                    </div>
                  </div>
				  
				  <div class="form-group">
                    <label for="city" class="col-sm-2 control-label">City<span class="em-required">*</span></label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control char-field text-capitalize" name="user[extra][city]" id="city" value="<?php echo isset($new_user_data) ? $new_user_data['city']: '';?>" required>
                    </div>
                  </div>
				  
				  
				  <div class="form-group">
                    <label for="state" class="col-sm-2 control-label">State<span class="em-required">*</span></label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control char-field text-capitalize" name="user[extra][state]" id="state" value="<?php echo isset($new_user_data) ? $new_user_data['state']: '';?>" required>
                    </div>
                  </div>
				  
				   <div class="form-group">
                    <label for="country" class="col-sm-2 control-label">Country<span class="em-required">*</span></label>
                    <div class="col-sm-10">
                      <input type="text" class="form-control char-field text-capitalize" name="user[extra][country]" id="country" value="<?php echo isset($new_user_data) ? $new_user_data['country']: '';?>" required>
                    </div>
                  </div>
				  
				  
				  
				  
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
					 <button type="submit" class="btn btn-primary">Next Step</button> 
                    </div>
                  </div>
				</form>
              </div>
			  <div class="tab-pane tab-min-height <?php if(isset($_GET['next_step']) && $_GET['next_step'] == '2'){ echo 'active'; }?>" id="department">
				
				<form class="form-horizontal" name="edit-profile" id="edit-profile" enctype="multipart/form-data" action="<?php echo site_url($action);?>" method="POST">
			  
				<input type="hidden" name="step" value="2"/>
				<input type="hidden" name="next_step" value="3"/>
				<input type="hidden" name="tab" value="department"/>
				
				<input type="hidden" name="user_id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : 0;  ?>"/>
				
				  <?php if(isset($new_user_data)) { ?>
				
				<div class="form-group">
                    <label class="col-sm-3 control-label">Username</label>
                    <div class="col-sm-9">
                      <label class="control-label">
						<?php echo $new_user_data['username'] !== null ? $new_user_data['username']:'';?>
					  </label>
                    </div>
                </div>
			  
			  
				<div class="form-group">
                    <label class="col-sm-3 control-label">Password</label>
                    <div class="col-sm-9">
                      <label class="control-label">
						<?php echo $new_user_data['password'] !== null ? 'vis@123':'';?>
					  </label>
                    </div>
                </div>
			  
				<?php }?>
			  
				<div class="form-group">
					
                    <label for="user_designation" class="col-sm-3 control-label">Employee Department<span class="em-required">*</span></label>
                    <div class="col-sm-9">					  
                      <select  name="user[department]" class="form-control select2" style="width: 100%;" style="width: 100%;" id="user_department" required>
						<option value=""> Select Departments</option>
						<?php foreach($employee_settings['departments'] as $key => $department){?>

							<option value="<?php echo $department['id'];?>" <?php echo isset($new_user_data) && $new_user_data['department'] == $department['id'] ? 'selected' : '' ?>>
								<?php echo $department['department_name']; ?>
							</option>
						<?php }?>
					  </select>
                    </div>
                </div>
				
				
				<div class="form-group">
					
                    <label for="user_designation" class="col-sm-3 control-label">Employee Designation<span class="em-required">*</span></label>
                    <div class="col-sm-9">
					  
                      <select  name="user[user_designation]" class="form-control select2" style="width: 100%;" style="width: 100%;" id="user_designation" required>
					  <option value=""> Select Designation</option>
						<?php foreach($employee_settings['designation'] as $key => $designation){?>

							<option value="<?php echo $designation['id'];?>" <?php echo isset($new_user_data) && $new_user_data['user_designation'] == $designation['id'] ? 'selected' : '' ?>>
								<?php echo $designation['user_designation_description']; ?>
							</option>
						<?php }?>
					  </select>
                    </div>
                </div>
				
				<div class="form-group">
					
					
					<?php //fn_ems_debug($employee_settings);?>
					
                    <label for="reporting_manager" class="col-sm-3 control-label">Reporting Manager<span class="em-required"></span></label>
                    <div class="col-sm-9">
					  
                      <select  name="user[reporting_manager]" class="form-control select2" style="width: 100%;" style="width: 100%;" id="reporting_manager">
						<option value=""> Select Reporting Manager</option>
						<?php foreach($employee_settings['reporting_manager'] as $key => $reporting_manager){?>
	
							<option value="<?php echo $reporting_manager['id'];?>" <?php echo isset($new_user_data) && $new_user_data['reporting_manager'] == $reporting_manager['id'] ? 'selected' : '' ?>>
								<?php echo $reporting_manager['name']; ?>
							</option>
						<?php }?>
					  </select>
                    </div>
                </div>
				
				
				
				<div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-primary">Next Step</button> 
                    </div>
                </div>
				
				</form>
			  </div>
				<div class="tab-pane tab-min-height <?php if(isset($_GET['next_step']) && $_GET['next_step'] == '3'){ echo 'active'; }?>" id="bank_info">
				<?php 
				$bank_details = '';
				$bank_details = isset($new_user_data) && $new_user_data['bank_details'] != '' ? unserialize($new_user_data['bank_details']) : '';

				?>
				<form class="form-horizontal" name="edit-profile" id="edit-profile" enctype="multipart/form-data" action="<?php echo site_url($action);?>" method="POST">
					<input type="hidden" name="user_id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : 0;  ?>"/>
					<input type="hidden" name="step" value="3"/>
					<input type="hidden" name="next_step" value="4"/>
					<input type="hidden" name="tab" value="bank_info"/>
					
					
					<div class="form-group">
						<label for="state" class="col-sm-3 control-label">PAN<span class="em-required">*</span></label>
						<div class="col-sm-9">
						  <input type="text" class="form-control text-capitalize" name="user[extra][pan]" id="pan" value="<?php echo isset($new_user_data) ? $new_user_data['pan']: '';?>" required>
						</div>
					</div>
					
					<div class="form-group">
						<label for="state" class="col-sm-3 control-label">PF<span class="em-required">*</span></label>
						<div class="col-sm-9">
						  <input type="text" class="form-control text-capitalize" name="user[extra][pf]" id="pf" value="<?php echo isset($new_user_data) ? $new_user_data['pf']: '';?>" required>
						</div>
					</div>
				
					<div class="form-group">
						<label for="bank_name" class="col-sm-3 control-label">Bank Name<span class="em-required">*</span></label>
						<div class="col-sm-9">
						<input type="text" name="user[extra][bank_details][bank_name]" class="form-control text-capitalize" id="bank_name" value="<?php echo !empty($bank_details)?$bank_details['bank_name']:''?>" required>
						</div>
					</div>
					<div class="form-group">
						<label for="account_number" class="col-sm-3 control-label">Bank Account Number<span class="em-required">*</span></label>
						<div class="col-sm-9">
						<input type="text" name="user[extra][bank_details][account_number]" id="account_number" class="form-control text-capitalize" id="account_number" value="<?php echo !empty($bank_details)?$bank_details['account_number']:''?>" required>
						</div>
					</div>
					<div class="form-group">
						<label for="ifsc" class="col-sm-3 control-label">IFSC Code<span class="em-required">*</span></label>

						<div class="col-sm-9">
						<input type="text" name="user[extra][bank_details][ifsc]" class="form-control text-capitalize" id="ifsc" value="<?php echo !empty($bank_details)?$bank_details['ifsc']:''?>" required>
						</div>
					</div>
					<div class="form-group">
						<label for="branch_code" class="col-sm-3 control-label">Branch Code<span class="em-required">*</span></label>

						<div class="col-sm-9">
						<input type="text" name="user[extra][bank_details][branch_code]" class="form-control text-capitalize" id="branch_code" value="<?php echo !empty($bank_details)?$bank_details['branch_code']:''?>" required>
						</div>
					</div>
					<div class="form-group">
						<label for="branch_address" class="col-sm-3 control-label">Branch Address<span class="em-required">*</span></label>

						<div class="col-sm-9">
						<input type="text" name="user[extra][bank_details][branch_address]" class="form-control text-capitalize" id="branch_address" value="<?php echo !empty($bank_details)?$bank_details['branch_address']:''?>" required>
						</div>
					</div>
					
					<div class="form-group">
                    <div class="col-sm-offset-3 col-sm-10">
						<button type="submit" class="btn btn-primary">Next Step</button> 
                    </div>
                </div>
				</form>
				</div>
				<div class="tab-pane tab-min-height <?php if(isset($_GET['next_step']) && $_GET['next_step'] == '4'){ echo 'active'; }?>" id="documents">
				
				<form class="form-horizontal" name="edit-profile" id="edit-profile" enctype="multipart/form-data" action="<?php echo site_url($action);?>" method="POST">
					<input type="hidden" name="user_id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : 0;  ?>"/>
					<input type="hidden" name="step" value="4"/>
					<input type="hidden" name="next_step" value="5"/>
					<input type="hidden" name="tab" value="documets"/>
				
					<div class="form-group">
						<label for="user_photo" class="col-sm-3 control-label">Photo<span class="em-required">*</span></label>
						<div class="col-sm-9">
							<input type="file" id="user_photo"  name="user[extra][documents][user_photo]" required>
							<p class="help-block">Upload png,jpeg,jpg image type only</p>
						</div>
					</div>
					
					<div class="form-group">
						<label for="user_resume" class="col-sm-3 control-label">Resume<span class="em-required">*</span></label>
						<div class="col-sm-9">
							<input type="file" id="user_resume"  name="user[extra][documents][user_resume]" required>
							<p class="help-block">Upload doc,docx,pdf files only</p>
						</div>
					</div>
					
					<!-- <div class="form-group">
						<label for="user_resume" class="col-sm-3 control-label">Other</label>
						<div class="col-sm-9">
							<input type="file" id="user_other"  name="user[extra][documents][user_other]">
							<p class="help-block">Upload doc,docx files only</p>
						<div class="col-sm-9">
					</div> -->
					
					<div class="form-group">
                    <div class="col-sm-offset-3 col-sm-10">
						<button type="submit" class="btn btn-primary">Next Step</button> 
                    </div>
					</div>
				</form>
				</div>
				
				
				
				<div class="tab-pane tab-min-height <?php if(isset($_GET['next_step']) && $_GET['next_step'] == '5'){ echo 'active'; }?>" id="leaves">
				
				<form class="form-horizontal" name="edit-profile" id="edit-profile" enctype="multipart/form-data" action="<?php echo site_url($action);?>" method="POST">
					<input type="hidden" name="user_id" value="<?php echo isset($_GET['id']) ? $_GET['id'] : 0;  ?>"/>
					<input type="hidden" name="step" value="5"/>
					<input type="hidden" name="next_step" value="6"/>
					<input type="hidden" name="tab" value="leaves"/>
					
					
					<?php // fn_ems_debug($new_user_data);?>
					
					<div class="form-group">
						<label for="sick_leave" class="col-sm-3 control-label">Sick Leave<span class="em-required">*</span></label>
						<div class="col-sm-9">
							<input type="text" class="form-control text-capitalize" id="sleave"  name="user[basic][sleave]" value="<?php echo isset($new_user_data['sleave']) ? $new_user_data['sleave'] : 0.00;?>" required>							
						</div>
					</div>
					
					<div class="form-group">
						<label for="sick_leave" class="col-sm-3 control-label">Planned Leave<span class="em-required">*</span></label>
						<div class="col-sm-9">
							<input type="text" class="form-control text-capitalize" id="pleave"  name="user[basic][pleave]" value="<?php echo isset($new_user_data['pleave']) ? $new_user_data['pleave'] : 0.00;?>" required>							
						</div>
					</div>
					
					<div class="form-group">
						<div class="col-sm-10">
					
							<button type="submit" class="btn btn-primary pull-right">Finish</button>
					
						</div>
					</div>
					
					
				</form>	
				
				</div>
				
			  </div>
              

              
			
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      <!-- /.row -->

    </section>
    <!-- /.content -->
  </div>
	<script src="<?php //echo base_url('assets/dist/js/moment.min.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/datepicker/bootstrap-datepicker.js');?>"></script>
	<script src="<?php echo base_url('assets/plugins/select2/select2.full.min.js');?>"></script>
	<script>
	$(function(){
	//Date picker
	$('#dob').datepicker({
	  autoclose: true,
	  format: 'yyyy-mm-dd',
	});
	
	$('#doj').datepicker({
	  autoclose: true,
	  format: 'yyyy-mm-dd',
	});
		//select
	$(".select2").select2();
	});
	</script>