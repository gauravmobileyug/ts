
<div class="content-wrapper">
<!-- Content Header (Page header) -->
<?php //fn_ems_debug($employee_details); ?>

<?php 
	$user_photo = 'assets/images/blank_user.png';
	$documents = array() ;
	if( !empty($employee_details['documents'])){
		$documents = unserialize( $employee_details['documents'] );
		
	/*	if( isset($documents) && array_key_exists('user_photo',$documents) ){
			$user_photo = $documents['user_photo'];
		}
	 */		
	 
		$user_photo  = !empty($employee_details['profile_pic']) ? $employee_details['profile_pic'] : $user_photo;
		//unset($documents['user_photo']);
		unset($documents['user_other']);
		
	}
?>

<section class="content-header">
  <h1>
	<a href="<?php echo site_url('user/edit/'.$employee_details['id']);?>"><?php echo ucwords($employee_details['firstname'].' '.$employee_details['lastname']) ;?> Details</a>
  </h1>
  <ol class="breadcrumb">
	<li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
	<li class="active"><a href="<?=site_url('user/list_employees');?>">Employee List</a></li>
	<li class="active">Employee Details</li>
  </ol>
</section>

<!-- Main content -->
<section class="content">

	<div class="row">		
		
		<div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive" src="<?php echo base_url($user_photo);?>" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo isset($employee_details) ? $employee_details['firstname'] .' '. $employee_details['lastname']  : '' ;?></h3>

              <p class="text-muted text-center"><?php echo ucwords($employee_details['user_designation_description']);?></p>

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <i class="fa fa-birthday-cake"></i> <b> Birthday </b> 
				  
					<?php 
					$dob_this_year = '';
					$class = '';
					if( isset($employee_details) ) {
					   
						$dob = date('d M',strtotime($employee_details['dob']));
						$dob_this_year = $dob. ' '. date('Y');
						
						if($dob == date('d M')){
							$class = 'birth_day';
						}
						
						
					}?>
				  
				  <a class="pull-right label label-primary <?php echo $class;?>">
					<?php echo strtoupper($dob_this_year) ;?>
				  </a>
				  
				 
                </li>
                <li class="list-group-item">
                  <i class="fa fa-thumbs-o-up"></i> <b> Anniversary </b> <a class="pull-right label label-success"><?php echo strtoupper( date('d M Y' ,strtotime($employee_details['doj'])));?></a>
                </li>
               
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

         
        
        </div>
		
		
		
		<div class="col-xs-9">
			<div class="box">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
				  <li class="<?php echo isset($_GET['tab']) ? ($_GET['tab'] == 'personal' ? 'active' : '') : 'active';?>">
					<a href="#personal" data-toggle="tab" aria-expanded="true">Personal Information</a></li>
				  <!--<li class="<?php echo isset($_GET['tab']) && $_GET['tab'] == 'salary' ? 'active' :'';?>"><a href="#salary" data-toggle="tab" aria-expanded="false">Salary</a></li>-->
				  <!--<li class=""><a href="#bank_info" data-toggle="tab" aria-expanded="false">Bank Info</a></li>
				  <li class=""><a href="#documents" data-toggle="tab" aria-expanded="false">Documents</a></li> -->
				</ul>
				
				<div class="tab-content">
					<div class="tab-pane <?php echo isset($_GET['tab']) ? ($_GET['tab'] == 'personal' ? 'active' : '') : 'active';?>" id="personal">
					<form class="form-horizontal own-form" name="edit-profile" id="edit-profile" enctype="multipart/form-data" action="" method="POST">	
					<div class="row">
						
						<div class="col-sm-12">
							<div class="box">
							
							<div class="box-header">
							  <h3 class="box-title">Basic Details</h3>
							</div>
							
							<div class="box-body">	
								<table class="table table-bordered custom-td">
									<tbody>
									
										<tr>
										
											<td><label for="firstname" >First Name</label></td>
											<td><label class="custom-label"><?php echo isset($employee_details) ? $employee_details['firstname'] : '' ;?></label></td>
											<td><label for="lastname" >Last Name</label></td>
											<td><label class="custom-label"><?php echo isset($employee_details) ? $employee_details['lastname'] : '' ;?></label></td>
											<td><label for="empid" >Employee ID</label></td>
											<td><label class="custom-label"><?php echo $employee_details['employee_id'];?></label></td>
											
										</tr>
									
										<tr>
											<td><label for="email">Personal Email</label></td>
											<td><label class="custom-label"><?php echo isset($employee_details) ? $employee_details['email']: '';?></label></td>
											
											<td><label>Official E-mail</label></td>
											<td><label class="custom-label"><?php echo $employee_details['official_email'] ? $employee_details['official_email'] : 'NA';?></label></td>
											
											<td><label>Emergency Number</label></td>
											<td><label class="custom-label"><?php echo $employee_details['emergency_contact'] ? $employee_details['emergency_contact'] : 'NA';?></label></td>
											
										</tr>
										<tr>
										
											<td><label for="doj" >Date Of Joining</label></td>
											<td><label class="custom-label"><?php echo date('d-m-Y' ,strtotime($employee_details['doj']));?></label></td>
											
											<td><label for="doj" >Department</label></td>
											<td><label class="custom-label"><?php echo ucwords($employee_details['department_name']);?></label></td>
										
											<td><label for="doj" >Designation</label></td>
											<td colspan=""><label class="custom-label"><?php echo ucwords($employee_details['user_designation_description']);?></label></td>
											
											
										</tr>
										
										
										<tr>
											<td><label for="phone" >Phone</label></td>
											<td><label class="custom-label"><?php echo isset($employee_details) ? $employee_details['phone']: '';?></label></td>
											
											<td><label for="gender">Gender</label></td>
											<td>
												<label class="custom-label"><?php echo isset($employee_details) && $employee_details['gender'] == 'male' ? 'Male' : 'Female' ;?>
												</label>
											</td>
											<td><label for="dob">Date Of Birth</label></td>
											<td  colspan="3"><label class="custom-label"><?php echo isset($employee_details) ? $employee_details['dob']: '';?></label></td>
										</tr>
										<tr>
											<td><label for="education" >Education</label></td>
											<td><label class="custom-label"><?php echo isset($employee_details) ? $employee_details['education']: '';?></label></td>
											<td><label for="present_address" >Present Address</label></td>
											<td><label class="custom-label"><?php echo isset($employee_details) ? $employee_details['present_address']: '';?></label></td>
											<td><label for="permanent_address" >Permanent Address</label></td>
											<td  colspan="3"><label class="custom-label"><?php echo isset($employee_details) ? $employee_details['permanent_address']: '';?></label></td>
										</tr>
										<tr>
											<td><label for="zipcode">Zip Code</label></td>
											<td><label class="custom-label"><?php echo isset($employee_details) ? $employee_details['zipcode']: '';?></label></td>
											<td><label for="state">State</label></label></td>
											<td><label class="custom-label"><?php echo isset($employee_details) ? $employee_details['state']: '';?></label></td>
											<td><label for="country" >Country</label></td>
											<td  colspan="3"><label class="custom-label"><?php echo isset($employee_details) ? $employee_details['country']: '';?></label></td>
											
										</tr>
									</tbody>
								</table>
							</div>
							</div>
							
							
							<div class="box">
								
								<div class="box-header">
								  <h3 class="box-title">Your Reporting Manager</h3>
								</div>
							
								<div class="box-body">
									<label> <?=ucwords($employee_details['reporting_manager_name']);?></label>
								</div>
							</div>
							
							
							
							<?php 
							$bank_details = '';
							$bank_details = isset($employee_details) && $employee_details['bank_details'] != '' ? unserialize($employee_details['bank_details']) : '';
							?>
							
							<div class="box">
								
								<div class="box-header">
								  <h3 class="box-title">Bank Information</h3>
								</div>
							
								<div class="box-body">
									<table class="table table-bordered custom-td">
										<tbody>
											<tr>
												<td><label for="bank_name">Bank Name</label></td>
												<td>
												<label class="custom-label">
													
													<?php echo !empty($bank_details)?$bank_details['bank_name']:''?>
													
												</label>
												</td>
												<td><label for="account_number">Bank Account Number</label></td>
												<td colspan=""><label class="custom-label"><?php echo !empty($bank_details)?$bank_details['account_number']:''?></label></td>
												<td><label for="account_number">PAN</label></td>
												<td colspan="2"><label class="custom-label"><?php echo !empty($employee_details['pan'])?$employee_details['pan']:'NA'?></label></td>
												
											</tr>
											<tr>
												<td><label for="ifsc" >IFSC Code</label></td>
												<td><label class="custom-label"><?php echo !empty($bank_details)?$bank_details['ifsc']:''?></label></td>
												<td><label for="branch_code">Branch Code</label></td>
												<td><label class="custom-label" ><?php echo !empty($bank_details)?$bank_details['branch_code']:''?></label></td>
												<td><label for="branch_address">Branch Address</label></td>
												<td><label class="custom-label" ><?php echo !empty($bank_details)?$bank_details['branch_address']:''?></label></td>
												
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							
							<!-- Documents -->
							
							<div class="box">
								<div class="box-header">
									<h3 class="box-title">Documents</h3>
								</div>
								
								<div class="box-body">
								
								<?php if(!empty( $documents )) { ?>
									<ul class="mailbox-attachments clearfix">
										<?php 
											foreach($documents as $key => $document ){
												
												if( !empty($document) ) {
													
													//Documents Naming Conventions
													
													$document_name = '';
													if($key == 'user_resume' ){
														$document_name = ' Resume';
													}if($key == 'user_other' ){
														$document_name = ' Others';
													}elseif($key == 'user_photo'){
														$document_name = 'Photo';
													}
												
													//fn_ems_debug( $documents );
												
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
													
													
													
													//Document Size
													
													$file_size = @filesize($document);
													
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
														</li>
										<?php 
												} 
											
											}
										?>
										
										
									</ul>
								<?php } else {?>
									<p>No Documents Found !</p>
								<?php } ?>
								</div>
							</div>
							
						</div>
					</div>
					
					</form>
					</div>
					
					<!-- Personal Details Ends-->
					
					<!-- Salary tab starts Here -->
					
					<div class="tab-pane <?php echo isset($_GET['tab']) &&$_GET['tab'] == 'salary' ? 'active' :'';?>" id="salary">
						
							<div class="">
								<div class="nav-tabs-custom">
									<ul class="nav nav-tabs">
									<!-- <li class="<?php echo !isset($_GET['sal_history']) ? 'active' : '' ;?>"><a href="#salary_info" data-toggle="tab" aria-expanded="true">Salary Structure</a></li> -->
									
									<li class="<?php echo isset($_GET['upload_salary']) ? 'active' : 'active' ;?>"><a href="#upload_salary" data-toggle="tab" aria-expanded="true">Upload Salary Slip</a></li>	
									
									<li class="<?php echo isset($_GET['sal_history']) ? 'active' : '' ;?>"><a href="#salary_history" data-toggle="tab" aria-expanded="true">Salary Histroy</a></li>	
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
													<td colspan="3"><label class="custom-label">EMP-<?php echo $employee_details['id'];?></label></td>
												</tr>	
												<tr>	
													<td><label>Select Month</label></td>
													<td>
														<select name="month" id="salary_month" required>
														<option value="">-Select Month-</option>
														<?php for($i = 1;$i<=12 ;$i++) {?>
															<option value="<?php echo $i;?>"><?php echo $i;?></option>
														<?php }?>
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
										
										
										<div class="tab-pane <?php echo isset($_GET['sal_history']) ? 'active' : '' ;?>" id="salary_history">
											<table class="table table-bordered custom-td">
												<thead>
													<tr>
														<td><label>Sr.No.</label></td>
														<td><label>Month</label></td>
														<td><label>Year</label></td>																												<td><label>Date Added</label></td>
														<td style="    text-align: center;"><label>Action</label></td>
														
													</tr>
												</thead>
												
												<tbody>

													<?php if( isset($salary_history['salary_history']) && !empty($salary_history['salary_history'])){?>
														<?php $count = 1;?>
														<?php foreach($salary_history['salary_history'] as $key => $salary){?>
														<tr>
															<td><label class="custom-label"><?php echo $count++;?></label></td>
															<td><label class="custom-label"><?php echo $salary['month'];?></label></td>															<td><label class="custom-label"><?php echo $salary['year'];?></label></td>																														<td><label class="custom-label"><?php echo date('d/m/Y',strtotime($salary['date_added']));?></label></td>																														<td style="    text-align: center;">																															<a class="label label-warning" target="_blank" data-toggle="tooltip" title="View Salary" href="<?php echo base_url($salary['salary_slip']);?>">																	<i class="fa fa-eye"></i> View																</a>																&nbsp;|&nbsp;																<a class="label label-primary" data-toggle="tooltip" title="Download" href="<?php echo site_url('salary/download_slip/'.$salary['id'].'/'.$salary['user_id']);?>">																	<i class="fa fa-download"></i> Download																</a>															</td>
															
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
														<tr><td colspan="8" style="text-align:center;color:red"><label>NO SALARY HISTORY !</label></td></tr>
													<?php }?>
												</tbody>
											</table>
										</div>
									</div>								
								</div>	
								
								
							</div>
						
					</div>
				</div>
					<!-- Salary tab Ends  Here -->
				
			</div>
	
		
		<div class="box-footer">
						<div class="pull-left">
				
			</div>

		
			<div class="pull-right">
				<a href="<?php echo site_url('user/list_employees');?>" class="btn btn-default "><i class="fa  fa-remove"></i>Cancel</a>
				<a href="<?php echo site_url('user/edit/'.$employee_details['id']);?>" class="btn btn-primary "><i class="fa fa-edit"></i>Edit</a>
			</div>
		</div>
			</div>
		</div>
	</div>
<section>
</div>
<script src="<?php echo base_url('assets/dist/js/moment.min.js');?>"></script>
<script src="<?php echo base_url('assets/plugins/daterangepicker/daterangepicker.js');?>"></script>
<script>
$(function(){

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
				console.log(income_tax);
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