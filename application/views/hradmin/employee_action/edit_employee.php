<style>
#salary_history_table{ width:100% !important}
</style>
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<?php 
	$documents = array() ;
	if( !empty($employee_details['documents'])){
		$documents = unserialize( $employee_details['documents'] );
		unset($documents['user_other']);
	}
	
	$months_array = array(
	
		'1'	=>	'JAN',
		'2'	=>	'FEB',
		'3'	=>	'MAR',
		'4'	=>	'APR',
		'5'	=>	'MAY',
		'6'	=>	'JUN',
		'7'	=>	'JUL',
		'8'	=>	'AUG',
		'9'	=>	'SEPT',
		'10'	=>	'OCT',
		'11'	=>	'NOV',
		'12'	=>	'DEC',
	);
?>

<section class="content-header">
  <h1>
	Update <?php echo ucwords($employee_details['firstname'].' '.$employee_details['lastname']) ;?> Details
  </h1>
  <ol class="breadcrumb">
	<li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active"><a href="<?=site_url('user/view/'.$employee_details['id']);?>">Employee Details</a></li>
	<li class="active">Update Employee Details</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

	<?php /*if($user_data['role'] == 'S'):?>

	<div class="row">
		<div class="col-xs-12">
			<div class="pull-right">
				<a class="btn btn-warning btn-xs" href="javascript:resetpass('<?=$employee_details['id']?>');" >
				<i class="fa fa-refresh" ></i>&nbsp;Reset Password</a>
			</div>
		</div>
	</div>
	
	<?php endif;*/ ?>
	
	<div class="row">		
		
		<div class="col-xs-12">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
				  <li class="<?php echo isset($_GET['tab']) ? ($_GET['tab'] == 'personal' ? 'active' : '') : 'active';?>">
					<a href="#personal" data-toggle="tab" aria-expanded="true">Employee Information</a>
				</li>
				 <li class="<?php echo isset($_GET['tab']) && $_GET['tab'] == 'salary' ? 'active' :'';?>">
					<a href="#salary" data-toggle="tab" aria-expanded="false">Salary</a>
				</li>
				</ul>
				
				<div class="tab-content">
					<div class="tab-pane <?php echo isset($_GET['tab']) ? ($_GET['tab'] == 'personal' ? 'active' : '') : 'active';?>" id="personal">
					
					<form class="form-horizontal own-form" name="edit-profile" id="edit-profile" enctype="multipart/form-data" action="<?php echo site_url('user/edit');?>" method="POST">	
					<div class="row">
						
						<div class="col-sm-12">
							<div class="box">
							<div class="box-body">	
								
								
								<table class="table table-bordered custom-td">
									<tbody>
										
										<tr>
										
										
											<td><label for="firstname" >First Name<span class="em-required">*</span></label></td>
											<td>
												<input type="text"  name="user[basic][firstname]" id="fisrtname" value="<?php echo isset($employee_details) ? $employee_details['firstname'] : '' ;?>" class="col-md-12 form-control"  <?php if($user_data['role'] == 'H'){ echo 'disabled';} ?> required/>												
											</td>
											<td>
												<label for="lastname" >Last Name<span class="em-required"></span></label>
											</td>
											<td>
												<input type="text"  name="user[basic][lastname]" id="lastname" value="<?php echo isset($employee_details) ? $employee_details['lastname'] : '' ;?>" class="col-md-12 form-control"  <?php if($user_data['role'] == 'H'){ echo 'disabled';} ?>/>
											</td>
										
										
											<td><label for="empid" >EMP-ID<span class="em-required">*</span></label></td>
											<td>
												
												
												<?php if($user_data['role'] == 'S'):?>
												
												<div class="input-group">
													<input type="text" class="col-md-12 form-control text-uppercase" id="employee_id2" value="<?php echo isset($employee_details) ? $employee_details['employee_id']: '';?>" name="user[basic][employee_id]" required>
													<span class="input-group-addon"><i class="fa fa-check" id="validate_emp_id"></i></span>
												</div>	
												<?php else:?>
													<label class="custom-label"><?php echo $employee_details['employee_id'];?></label>
												<?php endif;?>
												
												
												<input type="hidden" name="emp_id" id="emp_id" class="form-control" value="<?php echo $employee_details['id'];?>"/>
											</td>
											
										</tr>
										<tr>
										
										
										
											<td><label for="doj" >D.O.J<span class="em-required">*</span></label></td>
											<td>
											<?php if($user_data['role'] == 'S') : ?>
												<input type="text" class="col-md-12 form-control" value="<?php echo isset($employee_details) ? $employee_details['doj']: '';?>" name="user[basic][doj]"  id="doj"  required>
											<?php else:?>
												<label class="custom-label">
													<?php echo date('d-m-Y' ,strtotime($employee_details['doj']));?>
												</label>
											<?php endif;?>
											</td>
											<td><label for="department" >Department <span class="em-required">*</span></label></td>
											<td>
											
											
											<?php if( isset($employee_settings['departments']) && !empty($employee_settings['departments'])) { ?>
												<select name="user[basic][department]" required  class="form-control select2" id="department"  <?php if($user_data['role'] == 'H'){ echo 'disabled';}?>>
														<option value="">Please Select Department</option>
													<?php foreach($employee_settings['departments'] as $key => $department) {?>
														<option value="<?php echo $department['id']; ?>" <?php echo $department['id'] == $employee_details['department'] ? 'selected': '' ;?>>
															<?php  echo $department['department_name'] ?>
														</option>
													<?php }?>
												</select>
											<?php } else { ?>
												<label class="custom-label"> No Departments To Assign , Please Insert Departments.</label>
											<?php }?>											
											</td>
										
										
										
										
											<td><label for="designation" >Designation<span class="em-required">*</span></label></td>
											<td colspan="">
												<?php if( isset($employee_settings['designation']) && !empty($employee_settings['designation'])) { ?>
												<select name="user[basic][user_designation]" required class="select2" id="designation">
														<option value="">Please Select Designation</option>
													<?php foreach($employee_settings['designation'] as $key => $designation) {?>
														<option value="<?php echo $designation['id']; ?>" <?php echo  $designation['id'] == $employee_details['user_designation'] ? 'selected': '' ;?>>
															<?php  echo $designation['user_designation_description'] ?>
														</option>
													<?php }?>
												</select>
												<?php } else { ?>
													<label class="custom-label"> No Designation To Assign , Please Insert Designation.</label>
												<?php }?>
											</td>
											
											
											
										</tr>
										<tr>
											
											<td>
												<label for="email">Personal Email<span class="em-required">*</span></label>
											</td>
											<td>
											<div class="input-group">
												<input type="email"  name="user[basic][email]" id="email2" value="<?php echo isset($employee_details) ? $employee_details['email']: '';?>" class="col-md-12 form-control email2" required />
												<span class="input-group-addon"><i class="fa fa-check" id="validate_email_id"></i></span>
												</div>
											</td>
											
											
											<td><label>Official Email<span class="em-required">*</span></label></td>
											<td>
											<div class="input-group">
											
												<input type="email"  name="user[basic][official_email]" class="col-md-12 form-control email2" id="official_email2" value="<?php echo $employee_details['official_email'] ? $employee_details['official_email'] : 'NA';?>" class="form-control email2 edit-custom-input"  <?php if($user_data['role'] == 'H'){ echo 'disabled';} ?> required/>
												
												<span class="input-group-addon"><i class="fa fa-check" id="validate_emp_off_id"></i></span>
											</div>
											</td>
											
											
											
											<td><label>Emergency Number<span class="em-required">*</span></label></td>
											<td>
											
											<input type="text" name="user[basic][emergency_contact]"  value="<?php echo $employee_details['emergency_contact'] ? $employee_details['emergency_contact'] : 'NA';?>" class="col-md-12 vms-phone form-control" required/>
											
											</td>
											
											
											
											
										</tr>
										
										<tr>
											<td>
												<label for="phone" >Phone<span class="em-required">*</span></label>
											</td>
											<td>
												<input type="text"  name="user[basic][phone]" id="phone" value="<?php echo isset($employee_details) ? $employee_details['phone']: '';?>" class="col-md-12 vms-phone form-control" required/>
											</td>
											
											<td>
												<label for="gender">Gender<span class="em-required">*</span></label>
											</td>
											<td>
											
												<?php if($user_data['role'] == 'S'):?>
											
												<label style="cursor: pointer;padding-right: 20px;">
													
													<input type="radio" name="user[basic][gender]" id="gender" value="male" <?php echo isset($employee_details) && $employee_details['gender'] == 'male' ? 'checked' : '' ;?> required/>
													Male 
												</label>
											
											
												<label style="cursor: pointer;padding-right: 20px;">
													
													<input type="radio" name="user[basic][gender]" id="gender" value="female" <?php echo isset($employee_details) && $employee_details['gender'] == 'female' ?  'checked' : ''  ;?> required/>
													Female
												</label>
												
												
												<?php else:?>
													<?php echo isset($employee_details) && $employee_details['gender'] == 'male' ? 'Male' : 'Female'; ?>
												<?php endif;?>
											</td>
											<td>
												<label for="dob">Date Of Birth<span class="em-required">*</span></label>
											</td>
											<td  colspan="3">											
												<input type="text" class="col-md-12 form-control" value="<?php echo isset($employee_details) ? $employee_details['dob']: '';?>" name="user[extra][dob]"  id="dob"  <?php if($user_data['role'] == 'H'){ echo 'disabled';} ?> required>
											</td>
										</tr>
										<tr>
											<td><label for="education" >Education<span class="em-required">*</span></label></td>
											<td>
											<input type="text" class="col-md-12 form-control"name="user[extra][education]" value="<?php echo isset($employee_details) ? $employee_details['education']: '';?>" required/>
											</td>
											<td><label for="present_address" >Present Address<span class="em-required">*</span></label></td>
											<td>
											<input type="text" class="col-md-12 form-control" name="user[extra][present_address]"  value="<?php echo isset($employee_details) ? $employee_details['present_address']: '';?>" required/>
											</td>
											<td><label for="permanent_address" >Permanent Address<span class="em-required">*</span></label></td>
											<td colspan="3">
											<input type="text" class="col-md-12 form-control" name="user[extra][permanent_address]"  value="<?php echo isset($employee_details) ? $employee_details['permanent_address']: '';?>" required/>
											</td>
										</tr>
										<tr>
											<td><label for="zipcode">Zip Code<span class="em-required">*</span></label></td>
											<td>
												<input type="text" class="col-md-12 form-control" name="user[extra][zipcode]" id="zipcode" value="<?php echo isset($employee_details) ? $employee_details['zipcode']: '';?>" required/>
											</td>
											<td><label for="state">State<span class="em-required">*</span></label></td>
											<td>
											<input type="text" class="col-md-12 form-control" name="user[extra][state]" id="state" value="<?php echo isset($employee_details) ? $employee_details['state']: '';?>" required/></td>
											<td><label for="country" >Country<span class="em-required">*</span></label></td>
											<td colspan="3">
											<input type="text" class="col-md-12 form-control"  name="user[extra][country]" id="country" value="<?php echo isset($employee_details) ? $employee_details['country']: '';?>" required/>
											</td>
											
										</tr>
										
										<tr>
											<td colspan="6"  class="break"></td>
										</tr>
										
										<tr>
											<td colspan="1" style="text-align:center;"><label>Status<span class="em-required">*</span></label></td>
											<td colspan="1" style="text-align:center;">
												<select name="user[basic][status]" class="select1 form-control" required>
													<option value="1"  <?php echo ($employee_details['status'] == 1) ? 'selected' :'' ?>>Active</option>
													<option value="0"  <?php echo ($employee_details['status'] == 0) ? 'selected' :'' ?>>Inactive</option>
												</select>
											</td>
											
											<td colspan="1" style="text-align:center;"><label>Current Status<span class="em-required">*</span></label></td>
											<td colspan="1"  style="text-align:center;" class="current_status">
												<select name="user[basic][current_status]" class="select2" id="current_status" required>
													<option value="">Select Status</option>
													<?php foreach($employee_settings['statuses'] as $key => $status) {?>
													<option value="<?php echo $status['status']; ?>" <?php echo  $status['status'] == $employee_details['current_status'] ? 'selected': '' ;?>>
															<?php  echo $status['status_description'] ?>
													</option>
													<?php }?>
												</select>
											</td>
											
											<?php //fn_ems_debug( $employee_settings ); ?>
											<?php if($user_data['role'] == 'H' || $user_data['role'] == 'S' ) : ?>
												<td colspan="1" style="text-align:center;"><label>Reporting Manager</label></td>
												<td colspan="1"  style="text-align:center;" class="reporting Manager">
													<select name="user[basic][reporting_manager]" class="select2" id="reporting_manager">
														<option value="">Select Reporting Manager</option>
														<?php if( !empty($employee_settings['reporting_manager']) ){
															foreach($employee_settings['reporting_manager'] as $k => $reporting_manager){
														?>
															<option value="<?php echo $reporting_manager['id'];?>"
																<?php echo $reporting_manager['id'] == $employee_details['reporting_manager']  ? 'selected' : ''; ?>>
																<?php echo ucwords($reporting_manager['name']);?>
															</option>
														<?php	
															}
														}?>
													</select>
												</td>
											<?php else:?>
											<td colspan="2" style="text-align:center;"></td>
											<?php endif;?>
											
											
											
										</tr>
										<tr>
											<td>
												<label>Role Of Employee<span class="em-required">*</span></label>
											</td>
											<td>
											  <select  name="user[basic][role]" class="form-control" style="width: 100%;" style="width: 100%;" id="role" required>
												<option> Select Role Of Employee</option>
							
													
													<?php /* ?>
													<option value="H"  <?php echo isset($employee_details['role']) && $employee_details['role'] == 'H' ? 'selected' : '' ?>>HR</option>
													
													<?php */ ?>
													<option value="M"  <?php echo isset($employee_details['role']) && $employee_details['role'] == 'M' ? 'selected' : '' ?>>Manager</option>
													<option value="E"  <?php echo isset($employee_details['role']) && $employee_details['role'] == 'E' ? 'selected' : '' ?>>Employee</option>
											
											  </select>
											</td>
											<td colspan="4"></td>
											
										</tr>
										<tr>
											<td colspan="6"  class="break"></td>
										</tr>
										
									</tbody>
								</table>
							</div>
							</div>		

							<?php //fn_ems_debug($user_data); ?>
							
								
							<?php /* if(($user_data['role'] == 'H' || $user_data['role'] == 'S') && ($employee_details['role'] != '3' && $employee_details['role'] != '6') ){?>
							<div class="box">
								
								<div class="box-header">
									<h3 class="box-title">Employee Leave</h3>
								</div>
							
							
								<div class="box-body">
									
									<table class="table table-bordered custom-td">
										<tbody>
											<tr>
												<td><label>Sick Leave</label></td>
												
												<td>
												
													<?php if($user_data['role'] == 'S') :?>			
												
													<input type="text" required class="form-control" id="sleave"  name="user[basic][sleave]" value="<?php echo isset($employee_details['sleave']) ? $employee_details['sleave'] : 0.00;?>" required>							
													
													<?php else:?>
													<?php echo $employee_details['sleave']; ?>
													<?php endif; ?>
												</td>
											</tr>
											
											<tr>
												<td><label>Planned Leave</label></td>
												<td>
												<?php if($user_data['role'] == 'S') :?>			
													<input type="text" required class="form-control" id="sleave"  name="user[basic][pleave]" value="<?php echo isset($employee_details['pleave']) ? $employee_details['pleave'] : 0.00;?>" required>
												<?php else:?>
												<?php echo $employee_details['pleave']; ?>
												<?php endif;?>
												</td>
											</tr>
											
											
										</tbody>
									</table>
								</div>
							</div>
							<?php } */ ?>
							
							
							
							
							<?php 
							if($user_data['role'] == 'S' && ($employee_details['role'] != 'H' && $employee_details['role'] != 'M')  ){ ?>
							<?php 
							
							$bank_details = '';
							$bank_details = isset($employee_details) && $employee_details['bank_details'] != '' ? unserialize($employee_details['bank_details']) : '';
							?>
							
							<div class="box">
								<div class="box-header">Bank Details</div>
								<div class="box-body">
									<table class="table table-bordered custom-td">
										<tbody>
											<tr>
												<td><label for="bank_name">Bank Name</label></td>
												<td>
												<input type="text" required class="col-md-12 form-control" name="user[extra][bank_details][bank_name]" value="<?php echo !empty($bank_details)?$bank_details['bank_name']:''?>" />
												</td>
												<td><label for="account_number">Bank Account Number</label></td>
												<td colspan="">
												<input type="text" required class="col-md-12 form-control" name="user[extra][bank_details][account_number]" id="account_number" value="<?php echo !empty($bank_details)?$bank_details['account_number']:''?>"/>
												
												</td>
												<td><label for="account_number">PAN</label></td>
												<td colspan="2">
													<input type="text" required class="col-md-12 form-control" name="user[extra][pan]" value="<?php echo !empty($employee_details['pan'])?$employee_details['pan']:'NA'?>"/>
												</td>
												<td><label for="account_number">PF</label></td>
												<td colspan="2">
													<input type="text" required class="col-md-12 form-control" name="user[extra][pf]" value="<?php echo !empty($employee_details['pf'])?$employee_details['pf']:'NA'?>"/>
												</td>
											</tr>
											<tr>
												<td><label for="ifsc" >IFSC Code</label></td>
												<td>
												<input type="text" required class="col-md-12 form-control" name="user[extra][bank_details][ifsc]" id="ifsc" value="<?php echo !empty($bank_details)?$bank_details['ifsc']:''?>"/>
												</td>
												<td><label for="branch_code">Branch Code</label></td>
												<td>
												<input type="text" required class="col-md-12 form-control" name="user[extra][bank_details][branch_code]" id="branch_code" value="<?php echo !empty($bank_details)?$bank_details['branch_code']:''?>"/>
												</td>
												<td><label for="branch_address">Branch Address</label></td>
												<td colspan="5">
												<input type="text" required class="col-md-12 form-control" name="user[extra][bank_details][branch_address]" id="branch_address" value="<?php echo !empty($bank_details)?$bank_details['branch_address']:''?>"/>
												</td>
												
												
												
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							
							
							<?php } ?>
							<!-- Documents -->
							
							<div class="box">
							<div class="box-header">Documents</div>
								<div class="box-body">
								
								<?php if(!empty( $documents )) { ?>
									<ul class="mailbox-attachments clearfix">
										<?php 
											//fn_ems_debug( $documents );
										
											foreach($documents as $key => $document ){
												
												if( !empty($document) ) {
													
													//Documents Naming Conventions
													
													$document_name = '';
													if($key == 'user_resume' ){
														$document_name = ' Resume';
													}if($key == 'user_other' ){
														$document_name = ' Others';
													}elseif($key == 'user_photo'){
														$document_name = ' Photo';
													}
												
												
												
													//Decide Extension Types Anf Relative Icons
												
													$ext  = strtolower(substr($document,strrpos($document,'.')+1));
													$icon = '';
													$type = '' ;
													if( !empty( $ext ) && ($ext == 'doc' || $ext == 'docx' || $ext == 'pdf' )  ){
														$icon =  'fa-file-word-o' ;
														$type = 'fa-paperclip' ;
														
													}elseif( !empty( $ext ) && ($ext == 'pdf')  ){
														$icon =  'fa-file-pdf-o' ;
														$type = 'fa-paperclip' ;
													}elseif(!empty( $ext ) && ($ext == 'jpg' || $ext == 'jpeg' ||  $ext == 'png' ) ){
														$icon =  '' ;
														$type = 'fa-camera' ;
													}
													
													
													
													//Doument Size
													
														$file_size = @filesize($document);
														$file_size = round($file_size/(1024));
										?>
														<li>
															
															<?php if($ext == 'jpg' || $ext == 'jpeg' ||  $ext == 'png' ) {?>
															<span class="mailbox-attachment-icon has-img">
																<img src="<?php echo base_url($document) ;?>" style="height: 133px;" alt="Attachment">
															</span>
															<?php } else {?>
															<span class="mailbox-attachment-icon"><i class="fa <?php echo $icon;?>"></i></span>
															<?php } ?>
															<div class="mailbox-attachment-info">
																<a href="#" class="mailbox-attachment-name"><i class="fa <?php echo $type;?>"></i><?php echo $document_name;?></a>
																<span class="mailbox-attachment-size">
																<?php echo $file_size.' bytes';?>
																<a href="<?php echo base_url($document) ;?>" class="btn btn-default btn-xs pull-right">
																	<i class="fa fa-cloud-download"></i>
																</a>
																</span>
															</div>
															
															<?php if($key == 'user_photo') {?>
															<div  class="mailbox-attachment-info">
																<label class="custom-label"> Update Image </label>
																<input type="file" name="user[extra][documents][user_photo]" class="cm-change" id="user_photo">
															</div>
															<?php } if($key == 'user_resume') { ?>
																<div  class="mailbox-attachment-info">
																	<label class="custom-label"> Upload Resume </label>
																	<input type="file" name="user[extra][documents][user_resume]" class="cm-change" id="user_resume">
																</div>
															<?php } if($key == 'user_other'){ ?>
																<!-- <div  class="mailbox-attachment-info">
																	<label class="custom-label"> Upload Other Documents </label>
																	<input type="file" name="user[extra][documents][user_other]" class="cm-change" id="user_other">
																</div> -->
															<?php }?>
														</li>
										<?php 
												} 
											
											}
										?>
										
										
									</ul>
								<?php if($user_data['role'] == 'S'):?>
									<div class="form-group">
										<div class=" col-sm-12 ">
											<div class="pull-right">
												<a class="btn btn-warning" href="javascript:void(0);" data-toggle="modal" data-target="#reset_password">
												<i class="fa fa-refresh" ></i>&nbsp;Reset Password</a> 
											</div>
										</div>
									</div>
									<?php endif;?>
								<?php } else {?>
									<p>Upload Documents</p>
									<div class="form-group">
										<label for="user_photo" class="col-sm-3 control-label">Photo</label>
										<div class="col-sm-9">
											<input type="file"  id="user_photo"  name="user[extra][documents][user_photo]">
										<p class="help-block">Upload png,jpeg,jpg image type only</p>
										</div>
									</div>

									<div class="form-group">
										<label for="user_resume" class="col-sm-3 control-label">Resume</label>
										<div class="col-sm-9">
											<input type="file" id="user_resume"  name="user[extra][documents][user_resume]">
										<p class="help-block">Upload doc,docx,pdf files only</p>
										</div>
									</div>
									<?php if($user_data['role'] == 'S'):?>
									<div class="form-group">
									
									
										
									
									
										<div class=" col-sm-12 pull-right">
											<a class="btn btn-warning btn-xs" href="javascript:void(0);" data-toggle="modal" data-target="#reset_password">
											<i class="fa fa-refresh" ></i>&nbsp;Reset Password</a> 
										</div>
									</div>
									<?php endif;?>
									<!-- <div class="form-group">
										<label for="user_resume" class="col-sm-3 control-label">Other</label>
										<div class="col-sm-9">
											<input type="file" id="user_other"  name="user[extra][documents][user_other]">
											<p class="help-block">Upload doc,docx files only</p>
										</div>
									</div> -->
									
								<?php } ?>
								</div>
								
								
								<div class="box-footer">
									<div class="pull-left">
										
									</div>
									<div class="pull-right">
									
									
										<a href="<?php echo site_url('user/list_employees');?>" class="btn btn-default ">
										<i class="fa  fa-remove"></i>Cancel</a>
								
										
										
										
										
										<button type="submit" class="btn btn-primary "><i class="fa fa-check-square-o"></i> Save</button>
									</div>
								</div>
							</div>
							
						</div>
					</div>
					
					</form>
					</div>
					<!-- Personal Details Ends-->
					
					<div id="reset_password" class="modal fade" role="dialog">	
						<form name="reset_password" id="reset_password" method="POST" enctype="multipart/form-data">	
						<div class="modal-dialog">	
							<div class="modal-content">	
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Reset <?php echo  ucwords($employee_details['firstname'].' '.$employee_details['lastname']);?>'s Password</h4>	
								</div>			  		
								<div class="modal-body" style="height: 75px;">
								
									<p>
										<input type="text" name="reset_user_password"  placeholder="Enter New Password" id="reset_user_password" class="form-control " value="" required />
										<input type="hidden" name="id" value="<?=$employee_details['id'];?>"/>
									</p>
										
							
									</form>	
								</div>	
								<div class="modal-footer">	
									<button type="button" class="btn btn-primary" onclick="resetpass('<?=$employee_details['id']?>');">Reset Password</button>	
									<button type="button" class="btn btn-default edit-close" data-dismiss="modal">Close</button>	
								</div>		
							</div>	
						</div>	
						
						</form>
					</div>
							
					
					
					<div class="tab-pane <?php echo isset($_GET['tab']) &&$_GET['tab'] == 'salary' ? 'active' :'';?>" id="salary">
						
							<div class="">
								<div class="nav-tabs-custom">
									<ul class="nav nav-tabs">
									<!-- <li class="<?php echo !isset($_GET['sal_history']) ? 'active' : '' ;?>"><a href="#salary_info" data-toggle="tab" aria-expanded="true">Salary Structure</a></li> -->
									
									<li class="<?php echo isset($_GET['upload_salary']) ? 'active' : 'active' ;?>"><a href="#upload_salary" data-toggle="tab" aria-expanded="true">Upload Salary Slip</a></li>	
									
									<!--<li class="<?php echo isset($_GET['sal_history']) ? 'active' : '' ;?>"><a href="#salary_history" data-toggle="tab" aria-expanded="true">Salary Histroy</a></li>	-->
									</ul>
								
									<div class="tab-content">
										<div class="tab-pane <?php echo isset($_GET['sal_history']) ? '' : 'active1' ;?>" id="salary_info">
											<form method="POST" action="<?php echo site_url('salary/create_salary');?>">
											<input type="hidden" name="user[salary][user_id]" id="user_id" value="<?php echo $employee_details['id'];?>"/>
											<input type="hidden" name="user_id" id="user_id" value="<?php echo $employee_details['id'];?>"/>
											<table class="table table-bordered custom-td">
												<tbody>
													<tr>
														<td><label for="empid" >Employee ID</label></td>
														<td><label class="custom-label">EMP-<?php echo $employee_details['id'];?></label></td>
														<td><label for="empid" >Employee Name</label></td>
														<td>
														<label class="custom-label">
															<?php echo ucwords($employee_details['firstname'].' '.$employee_details['lastname']) ;?>
														</label>
														</td>
														<td><label for="doj" >Date Of Joining</label></td>
														<td><label class="custom-label"><?php echo date('d-m-Y' ,strtotime($employee_details['doj']));?></label></td>
													</tr>	
													<tr>	
														
														<td><label for="doj" >Department</label></td>
														<td><label class="custom-label"><?php echo ($employee_details['department']) ? strtoupper($employee_details['department']) : 'NA';?></label></td>
														<td><label for="doj" >Designation</label></td>
														<td colspan="3">
														<label class="custom-label"><?php echo $employee_details['user_designation_description'] ? ucwords($employee_details['user_designation_description']) : 'NA';?></label>
														</td>

													</tr>
													
													
													<tr>
														<td><label for="pay_period" >Select Salary Period</label></td>
														<td colspan="3">
															<?php if (!isset($current_month_salary)) {?>
															<div class="input-group" style="width:100%;">
															  <div class="input-group-addon">
																<i class="fa fa-calendar"></i>
															  </div>
																<input type="text" name="user[salary][pay_period]" class="form-control pull-right" id="pay_period" value="<?php echo set_value('user[salary][pay_period]'); ?>">
															</div>
															<?php }else{?>
																<label class="custom-label"  id="pay_period"><?php echo $current_month_salary['pay_period']; ?></label>
																<input type="hidden" name="salary_id" id="salary_id" value="<?php echo $current_month_salary['id'];?>" />
															<?php }?>
														
														</td>
														<td><label for="basic" >Paid Days</label></td>
														<td colspan="5">
														<?php if (!isset($current_month_salary)) {?>
															<input type="text" class="form-control" name="user[salary][paid_days]" id="paid_days" value="<?php echo set_value('user[salary][paid_days]'); ?>">
														<?php }else{?>
															<label class="custom-label"  id="paid_days"><?php echo $current_month_salary['paid_days']; ?></label>
														<?php }?>
														
														</td>
													</tr>
													
													
													<tr>
														<td><label for="basic" >Basic Salary</label></td>
														<td colspan="5">
														<?php if (!isset($current_month_salary)) {?>
															<input type="text" class="form-control" name="user[salary][basic]" id="basics" value="<?php echo set_value('user[salary][basic]'); ?>">
														<?php }else{?>
															<label class="custom-label"  id="basic"><?php echo $current_month_salary['basic']; ?></label>
														<?php }?>
														
														</td>
													</tr>
													<tr>
														<td><label for="hra" >H R A</label></td>
														<td colspan="5">
														
														<?php if (!isset($current_month_salary)) {?>
															<input type="text" class="form-control" name="user[salary][hra]" id="hra" value="<?php echo set_value('user[salary][hra]'); ?>">
														<?php }else{?>
															<label class="custom-label"  id="hra"><?php echo $current_month_salary['hra']; ?></label>
														<?php }?>
														
														</td>
													</tr>
													
													</tr>
														<td><label for="conveyance" >Conveyance Allowance</label></td>
														<td colspan="5">
														<?php if (!isset($current_month_salary)) {?>
															<input type="text" class="form-control" name="user[salary][conveyance]" id="conveyance" value="<?php echo set_value('user[salary][conveyance]'); ?>">
														<?php }else{?>
															<label class="custom-label"  id="conveyance"><?php echo $current_month_salary['conveyance']; ?></label>
														<?php }?>
														
														</td>
													</tr>
													
													<tr>
														<td><label for="special_allowance" >Special Allowance</label></td>
														<td colspan="5">
														<?php if (!isset($current_month_salary)) {?>
															<input type="text" class="form-control" name="user[salary][special_allowance]" id="special_allowance" value="<?php echo set_value('user[salary][special_allowance]'); ?>">
														<?php } else{?>
															<label class="custom-label"  id="special_allowance"><?php echo $current_month_salary['special_allowance']; ?></label>
														<?php }?>
														
														</td>
													
													</tr>
														<td><label for="bonus" >Bonus</label></td>
														<td colspan="5">
														<?php if (!isset($current_month_salary)) {?>
															<input type="text" class="form-control" name="user[salary][bonus]" id="bonus" value="<?php echo set_value('user[salary][bonus]'); ?>">
														<?php }else{?>
															<label class="custom-label"  id="bonus"><?php echo $current_month_salary['bonus']; ?></label>
														<?php }?>
														</td>
													</tr>
													</tr>
														<td><label for="misc_rewards" >Miscellaneous Rewards</label></td>
														<td colspan="5">
														
														<?php if (!isset($current_month_salary)) {?>
															<input type="text" class="form-control" name="user[salary][misc_rewards]" id="misc_rewards" value="<?php echo set_value('user[salary][misc_rewards]'); ?>">
														<?php } else {?>
															<label class="custom-label"  id="misc_rewards"><?php echo $current_month_salary['misc_rewards']; ?></label>
														<?php }?>
														
														</td>
													</tr>
													
													</tr>
														<td><label for="income_tax" >Income Tax</label></td>
														<td colspan="5">
															<?php if (!isset($current_month_salary)) {?>
															
																<label class="custom-label"  id="income_tax"><?php echo set_value('user[salary][income_tax]'); ?></label>
																<input type="hidden" name="user[salary][income_tax]" id="income_tax1" value="<?php echo set_value('user[salary][income_tax]'); ?>">
																
															<?php } else {?>
															
																<label class="custom-label"  id="income_tax"><?php echo $current_month_salary['income_tax']; ?></label>	
																
															<?php }?>
															
															
														</td>
													</tr>
													</tr>
														<td><label for="epf" >EPF</label></td>
														<td colspan="5">
															
															
															<?php if (!isset($current_month_salary)) {?>
															
																<label class="custom-label"  id="epf"><?php echo set_value('user[salary][epf]'); ?></label>
																<input type="hidden" class="form-control" name="user[salary][epf]" id="epf1" value="<?php echo set_value('user[salary][epf]'); ?>">
																
															<?php } else{?>
																	<label class="custom-label"  id="epf"><?php echo $current_month_salary['epf']; ?></label>	
															<?php }?>
															
															
														</td>
													</tr>
													<?php if (!isset($current_month_salary)) {?>
													<tr>
														<td colspan="6"> 
															<div class="pull-right">
															<button type="submit" class="btn btn-primary">Save</button>
															</div>
														</td>
													</tr>
													<?php }else{?>
													<tr>
														<td colspan="6"> 
															<div class="pull-right">
															<?php if($current_month_salary['paid'] == 0) { ?>
																<a class="btn btn-info" id="pay-salary"> Pay</a>
															<?php }else{?>
																<a class="btn btn-success" id="paid-salary"><i class="fa fa-check-square-o"></i> Salary Paid</a>
															<?php }?>
															</div>
														</td>
													</tr>	
													<?php }?>
												</tbody>
											</table>
											</form>
										</div>
										
										<div class="tab-pane <?php echo isset($_GET['upload_salary']) ? 'active' : 'active' ;?>" id="upload_salary">
											
											<table class="table table-bordered custom-td">
												<tr>
													<td><label>Employee ID</label></td>
													<td colspan="3"><label class="custom-label"><?php echo $employee_details['employee_id'];?></label></td>
												</tr>	
												<tr>	
													<td><label>Select Month</label></td>
													<td>
														<select name="month" id="salary_month" required>
														<option value="">-Select Month-</option>
														
															<option value="1">JAN</option>
															<option value="2">FEB</option>
															<option value="3">MAR</option>
															<option value="4">APR</option>
															<option value="5">MAY</option>
															<option value="6">JUN</option>
															<option value="7">JUL</option>
															<option value="8">AUG</option>
															<option value="9">SEP</option>
															<option value="10">OCT</option>
															<option value="11">NOV</option>
															<option value="12">DEC</option>
															
													
														</select>
													</td>
													<td><label class="custom-label">Select Year</label></td>
													<td>
														<select name="year" id="salary_year" required>
														<option value="">-Select Year-</option>
														<?php for($i = date('Y');$i<=(date('Y')+5) ;$i++) {?>
															<option value="<?php echo $i;?>"><?php echo $i;?></option>
														<?php }?>
														</select>
													</td>
												</tr>
												<tr>
												
													<td><label for="salary_slip" class="control-label">Upload Salary Slip</label></td>
													<td>
														<input type="hidden" name="emp_id" class="form-control" id="emp_id" value="<?php echo $employee_details['id'];?>">
														<input type="file" name="salary_slip" class="form-control" id="salary_slip" required>
													</td>
													<td colspan="2">
													<a href="javascript:void(0)" name="salary_slip_button" class="form-control btn btn-primary" id="salary_slip_button">
														<i class="fa fa-upload"></i> Upload Salary Slip
													</a>
													</td>
												</tr>
											</table>
											
										</div>
										
										
										<div class="box <?php echo isset($_GET['sal_history']) ? 'active' : '' ;?>" id="salary_history">
											<div class="box-header"> <h3>Salary History</h3> </div>
											<div class="box-body table-responsive no-padding">
											<table class="table dataTable table-hover table-bordered custom-td" id="salary_history_table">
												<thead>
													<tr>
														<td><label>Year</label></td>
														<td><label>Month</label></td>
														<td><label>Date Added</label></td>
														<td style="    text-align: center;"><label>Action</label></td>
														
													</tr>
												</thead>
												
												

													<?php if( isset($salary_history['salary_history']) && !empty($salary_history['salary_history'])){?>
														
														<?php foreach($salary_history['salary_history'] as $key => $salary){?>
														<tr>
															<td><label class="custom-label"><?php echo $salary['year'];?></label></td>
															<td><label class="custom-label"><?php echo $months_array[$salary['month']];?></label></td>			
															
															<td><label class="custom-label"><?php echo date('d/m/Y',strtotime($salary['date_added']));?></label></td>																														<td style="    text-align: center;">																						<a class="label label-danger" target="" data-toggle="tooltip" title="Delete Salary" href="<?php echo site_url("salary/salary_delete/".$employee_details['id']."/".$salary['id']);?>">
															<i class="fa fa-remove"></i> Delete	
															</a>
															&nbsp;|&nbsp;	
															<a class="label label-primary" data-toggle="tooltip" title="Download" href="<?php echo site_url('salary/download_slip/'.$salary['id'].'/'.$salary['user_id']);?>">																	<i class="fa fa-download"></i> Download																</a>															</td>
															
														</tr>
														<?php }?>
														
														<?php if( !empty($salary_history['salary_history_links']) ) { ?>
														<tr>
															<td colspan="7">
																<ul class="pagination pagination-sm no-margin pull-right">
																	<?php 
																		foreach ($salary_history['salary_history_links'] as $link) { 
																			echo "<li>". $link."</li>";
																		}
																	?>
																</ul>
															</td>
														</tr>
														<?php } ?>
													<?php }else{?>
														<!-- <tr><td colspan="8" style="text-align:center;color:red"><label>NO SALARY HISTORY !</label></td></tr>--> 
													<?php }?>
												
											</table>
											</div>
										</div>
									</div>								
								</div>	
								
								<div class="box-footer">
									<div class="pull-left">
										
									</div>
									
								</div>
							</div>
						
					</div>
					
					
					
					
					
					
				</div>
				
			</div>
			</div>
		</div>
	<section>
</div>




<script src="<?php echo base_url('assets/dist/js/moment.min.js');?>"></script>
<script src="<?php echo base_url('assets/plugins/daterangepicker/daterangepicker.js');?>"></script>
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
	

	$('[data-toggle="tooltip"]').tooltip(); 

	//Date picker
	$('#pay_period').daterangepicker();
	
	$('#basics').change(function(){
		var basic = $(this).val();		
		var url = '<?php echo site_url('salary/calculate_salary/'.$employee_details['id']); ?>';
		var cal = ['hra','epf'];
		
		$.ajax({
			url			:	url,
			dataType	:	'JSON',
			method		:	'POST',
			data		:	{basic:basic,request_for:cal},
			beforesend	:	function(){},
			success		:	function(response){
			
				var hra = parseFloat(response.hra).toFixed(2);
				var epf = parseFloat(response.epf).toFixed(2);
				var income_tax = parseFloat(response.income_tax).toFixed(2);
			
				$('#hra').val(hra);
				$('#hra').val(hra);	
				
				$('#epf').text(epf);
				$('#epf1').val(epf);
				
				$('#income_tax').text(parseFloat(income_tax/12));
				$('#income_tax1').val(parseFloat(income_tax/12));
				
				
				
				//others fields set to zero.
				
				$('#conveyance').val('0.00');
				$('#special_allowance').val('0.00');
				$('#bonus').val('0.00');
				$('#misc_rewards').val('0.00');
				
				
				
			}
		});
		
	});
	// $.ajax({
		
	// });
	

	
});
</script>
<script>$(document).ready(function(){		$('#salary_history_table').DataTable({	  "paging": true,	  "lengthChange": true,	  "searching": false,	  "ordering": true,	  "info": true,	  "autoWidth": true, 	  "columnDefs": [ {		"targets": [3],		"orderable": false		} ]	});});</script>