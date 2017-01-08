
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<?php //fn_ems_debug($employee_details); ?>

<?php 
	$documents = array() ;
	if( !empty($employee_details['documents'])){
		$documents = unserialize( $employee_details['documents'] );
	}
?>

<section class="content-header">
  <h1>
	Update <?php echo ucwords($employee_details['firstname'].' '.$employee_details['lastname']) ;?> Details
  </h1>
  <ol class="breadcrumb">
	<li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active">Employee Details</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

	<div class="row">		
		
		<div class="col-xs-12">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
				  <li class="<?php echo isset($_GET['tab']) ? ($_GET['tab'] == 'personal' ? 'active' : '') : 'active';?>">
					<a href="#personal" data-toggle="tab" aria-expanded="true">Personal Information</a></li>
				</ul>
				
				<div class="tab-content">
					<div class="tab-pane <?php echo isset($_GET['tab']) ? ($_GET['tab'] == 'personal' ? 'active' : '') : 'active';?>" id="personal">
					
					<form class="form-horizontal own-form" name="edit-profile" id="edit-profile" enctype="multipart/form-data" action="<?php echo site_url('user/edit');?>" method="POST">	
					<div class="row">
						
						<div class="col-sm-12">
							<div class="box">
							<div class="box-body">	
								
								
								<table class="table table-bordered">
									<tbody>
										<tr>
											<td colspan="4" style="text-align:right;"><label>Current Status</label></td>
											<td colspan="2"  style="text-align:center;" class="current_status">
												<select name="user[basic][current_status]" class="select2" id="current_status">
													<option value="">Select Status</option>
													<?php foreach($employee_settings['statuses'] as $key => $status) {?>
													<option value="<?php echo $status['status']; ?>" <?php echo  $status['status'] == $employee_details['current_status'] ? 'selected': '' ;?>>
															<?php  echo $status['status_description'] ?>
													</option>
													<?php }?>
												</select>
											</td>
										</tr>
										<tr>
											<td colspan="6"  class="break"></td>
										</tr>
										<tr>
											<td><label for="empid" >EMP-ID</label></td>
											<td>
											<label class="custom-label">EMP-<?php echo $employee_details['id'];?></label>
											<input type="hidden" name="emp_id" id="emp_id" value="<?php echo $employee_details['id'];?>"/>
											</td>
											<td><label for="doj" >D.O.J</label></td>
											<td><label class="custom-label"><?php echo date('d-m-Y' ,strtotime($employee_details['date_added']));?></label></td>
											<td><label for="department" >Department</label></td>
											<td>
											
											
											<?php if( isset($employee_settings['departments']) && !empty($employee_settings['departments'])) { ?>
												<select name="user[basic][department]"  class="form-control select2" id="department">
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
										</tr>
										<tr>
											<td><label for="designation" >Designation</label></td>
											<td colspan="">
												<?php if( isset($employee_settings['designation']) && !empty($employee_settings['designation'])) { ?>
												<select name="user[basic][user_designation]" class="select2" id="designation">
														<option value="">Please Select Designation</option>
													<?php foreach($employee_settings['designation'] as $key => $designation) {?>
														<option value="<?php echo $designation['user_designation']; ?>" <?php echo  $designation['user_designation'] == $employee_details['user_designation'] ? 'selected': '' ;?>>
															<?php  echo $designation['user_designation_description'] ?>
														</option>
													<?php }?>
												</select>
												<?php } else { ?>
													<label class="custom-label"> No Designation To Assign , Please Insert Designation.</label>
												<?php }?>
											</td>
											
											<td><label>Official Email</label></td>
											<td>
											<input type="text" name="user[basic][official_email]" id="official_email" value="<?php echo $employee_details['official_email'] ? $employee_details['official_email'] : 'NA';?>" class="form-control edit-custom-input"/>
											</td>
											
											<td><label>Emergency Contact Number</label></td>
											<td>
											
											<input type="text" name="user[basic][emergency_contact]"  value="<?php echo $employee_details['emergency_contact'] ? $employee_details['emergency_contact'] : 'NA';?>" class="form-control edit-custom-input"/>
											
											</td>
											
											
										</tr>
										<tr>
											<td><label for="firstname" >First Name</label></td>
											<td>
												<input type="text" name="user[basic][firstname]" id="fisrtname" value="<?php echo isset($employee_details) ? $employee_details['firstname'] : '' ;?>" class="form-control edit-custom-input"/>												
											</td>
											<td>
												<label for="lastname" >Last Name</label>
											</td>
											<td>
												<input type="text" name="user[basic][lastname]" id="lastname" value="<?php echo isset($employee_details) ? $employee_details['lastname'] : '' ;?>" class="form-control edit-custom-input" />
											</td>
											<td>
												<label for="email">Email</label>
											</td>
											<td colspan="3">
												<input type="text" name="user[basic][email]" id="email" value="<?php echo isset($employee_details) ? $employee_details['email']: '';?>" class="form-control edit-custom-input" />
											</td>
										</tr>
										
										<tr>
											<td>
												<label for="phone" >Phone</label>
											</td>
											<td>
												<input type="text" name="user[basic][phone]" id="phone" value="<?php echo isset($employee_details) ? $employee_details['phone']: '';?>" class="form-control edit-custom-input" />
											</td>
											
											<td>
												<label for="gender">Gender</label>
											</td>
											<td>
												<label>
													<input type="radio" name="user[basic][gender]" id="gender" value="male" <?php echo isset($employee_details) && $employee_details['gender'] == 'male' ? 'checked' : '' ;?>/>
												</label>Male 
												<label>
													<input type="radio" name="user[basic][gender]" id="gender" value="female" <?php echo isset($employee_details) && $employee_details['gender'] == 'female' ?  'checked' : ''  ;?>/>
												</label>Female
											
												
												
											</td>
											<td>
												<label for="dob">Date Of Birth</label>
											</td>
											<td  colspan="3">
												<input type="text" value="<?php echo isset($employee_details) ? $employee_details['dob']: '';?>" name="user[extra][dob]" class="form-control pull-right" id="dob" required>
											</td>
										</tr>
										<tr>
											<td><label for="education" >Education</label></td>
											<td>
											<input type="text" name="user[extra][education]" value="<?php echo isset($employee_details) ? $employee_details['education']: '';?>"/>
											</td>
											<td><label for="present_address" >Present Address</label></td>
											<td>
											<input type="text" name="user[extra][present_address]"  value="<?php echo isset($employee_details) ? $employee_details['present_address']: '';?>"/>
											</td>
											<td><label for="permanent_address" >Permanent Address</label></td>
											<td colspan="3">
											<input type="text" name="user[extra][permanent_address]"  value="<?php echo isset($employee_details) ? $employee_details['permanent_address']: '';?>"/>
											</td>
										</tr>
										<tr>
											<td><label for="zipcode">Zip Code</label></td>
											<td>
												<input type="text" name="user[extra][zipcode]" id="zipcode" value="<?php echo isset($employee_details) ? $employee_details['zipcode']: '';?>"/>
											</td>
											<td><label for="state">State</label></label></td>
											<td>
											<input type="text" name="user[extra][state]" id="state" value="<?php echo isset($employee_details) ? $employee_details['state']: '';?>"/></td>
											<td><label for="country" >Country</label></td>
											<td colspan="3">
											<input type="text"  name="user[extra][country]" id="country" value="<?php echo isset($employee_details) ? $employee_details['country']: '';?>"/>
											</td>
											
										</tr>
									</tbody>
								</table>
							</div>
							</div>
							
							
							
							<?php 
							$bank_details = '';
							$bank_details = isset($employee_details) && $employee_details['bank_details'] != '' ? unserialize($employee_details['bank_details']) : '';
							?>
							
							<div class="box">
								<div class="box-body">
									<table class="table table-bordered">
										<tbody>
											<tr>
												<td><label for="bank_name">Bank Name</label></td>
												<td>
												<input type="text" name="user[extra][bank_details][bank_name]" value="<?php echo !empty($bank_details)?$bank_details['bank_name']:''?>" />
												</td>
												<td><label for="account_number">Bank Account Number</label></td>
												<td colspan="">
												<input type="text" name="user[extra][bank_details][account_number]" id="account_number" value="<?php echo !empty($bank_details)?$bank_details['account_number']:''?>"/>
												
												</td>
												<td><label for="account_number">PAN</label></td>
												<td colspan="2">
													<input type="text" name="user[extra][pan]" value="<?php echo !empty($employee_details['pan'])?$employee_details['pan']:'NA'?>"/>
												</td>
												<td><label for="account_number">PF</label></td>
												<td colspan="2">
													<input type="text" name="user[extra][pf]" value="<?php echo !empty($employee_details['pf'])?$employee_details['pf']:'NA'?>"/>
												</td>
											</tr>
											<tr>
												<td><label for="ifsc" >IFSC Code</label></td>
												<td>
												<input type="text" name="user[extra][bank_details][ifsc]" id="ifsc" value="<?php echo !empty($bank_details)?$bank_details['ifsc']:''?>"/>
												</td>
												<td><label for="branch_code">Branch Code</label></td>
												<td>
												<input type="text" name="user[extra][bank_details][branch_code]" id="branch_code" value="<?php echo !empty($bank_details)?$bank_details['branch_code']:''?>"/>
												</td>
												<td><label for="branch_address">Branch Address</label></td>
												<td colspan="5">
												<input type="text" name="user[extra][bank_details][branch_address]" id="branch_address" value="<?php echo !empty($bank_details)?$bank_details['branch_address']:''?>"/>
												</td>
												
												
												
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							
							<!-- Documents -->
							
							<div class="box">
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
													if( !empty( $ext ) && ($ext == 'doc' || $ext == 'docx' )  ){
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
															<?php } else if($key == 'user_resume') { ?>
																<div  class="mailbox-attachment-info">
																	<label class="custom-label"> Upload Resume </label>
																	<input type="file" name="user[extra][documents][user_resume]" class="cm-change" id="user_resume">
																</div>
															<?php }elseif($key == 'user_other'){ ?>
																<div  class="mailbox-attachment-info">
																	<label class="custom-label"> Upload Other Documents </label>
																	<input type="file" name="user[extra][documents][user_other]" class="cm-change" id="user_other">
																</div>
															<?php }?>
														</li>
										<?php 
												} 
											
											}
										?>
										
										
									</ul>
								<?php } else {?>
									<p>Upload Documents</p>
									<div class="form-group">
										<label for="user_photo" class="col-sm-3 control-label">Photo</label>
										<div class="col-sm-9">
											<input type="file" id="user_photo"  name="user[extra][documents][user_photo]" required>
										<p class="help-block">Upload png,jpeg,jpg image type only</p>
										</div>
									</div>

									<div class="form-group">
										<label for="user_resume" class="col-sm-3 control-label">Resume</label>
										<div class="col-sm-9">
											<input type="file" id="user_resume"  name="user[extra][documents][user_resume]" required>
										<p class="help-block">Upload doc,docx files only</p>
										</div>
									</div>

									<div class="form-group">
										<label for="user_resume" class="col-sm-3 control-label">Other</label>
										<div class="col-sm-9">
											<input type="file" id="user_other"  name="user[extra][documents][user_other]">
											<p class="help-block">Upload doc,docx files only</p>
										</div>
									</div>
									</div>
								<?php } ?>
								
								
								<div class="box-footer">
									<div class="pull-right">
										<a href="<?php echo site_url('user/list_employees');?>" class="btn btn-default "><i class="fa  fa-remove"></i>Cancel</a>
										<button type="submit" class="btn btn-primary "><i class="fa fa-edit"></i>Edit</button>
									</div>
								</div>
							</div>
							
						</div>
					</div>
					
					</form>
					</div>
					<!-- Personal Details Ends-->
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
	  autoclose: true
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