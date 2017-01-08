
<div class="content-wrapper">
<?php 
	$user_photo = 'assets/images/blank_user.png';
	$documents = array() ;
	if( !empty($employee_details['documents'])){
		$documents = unserialize( $employee_details['documents'] );

		//fn_ems_debug($user_data );
		
		/*
		if( isset($documents) && array_key_exists('user_photo',$documents) ){
			$user_photo = $documents['user_photo'];
		}
		*/
		
			$user_photo  = !empty($user_data['profile_pic']) ? $user_data['profile_pic'] : $user_photo;
		
		//unset($documents['user_photo']);
		unset($documents['user_other']);
		
	}
?>

<section class="content-header">
  <h1>
	<?php echo ucwords($employee_details['firstname'].' '.$employee_details['lastname']) ;?>
  </h1>
  <ol class="breadcrumb">
	<li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
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
              <img class="profile-user-img img-responsive" src="<?php echo base_url($user_photo);?>" alt="User profile picture" data-toggle="modal"  style="cursor:pointer" data-target="#myModal">

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
					<?php echo $dob_this_year ;?>
				  </a>
				  
				 
                </li>
                <li class="list-group-item">
                  <i class="fa fa-thumbs-o-up"></i> <b> Anniversary </b> <a class="pull-right label label-warning"><?php echo date('d M Y' ,strtotime($employee_details['doj']));?></a>
                </li>
                
				
              </ul>
            </div>
           
          </div> 
        </div>
		
		
		
		<div class="col-xs-9">
			<div class="box">
			<div class="nav-tabs-custom">
				<ul class="nav nav-tabs">
				  <li class="<?php echo isset($_GET['tab']) ? ($_GET['tab'] == 'personal' ? 'active' : '') : 'active';?>">
					<a href="#personal" data-toggle="tab" aria-expanded="true">Personal Information</a></li>
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
										
											<td><label for="doj" >D.O.J</label></td>
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
							
							<?php if($user_data['role'] != 'H' && $user_data['role'] != 'S' ):?>
							
							<div class="box">
								
								<div class="box-header">
								  <h3 class="box-title">Your Reporting Manager</h3>
								</div>
							
								<div class="box-body">
									<label> <?=ucwords($user_data['reporting_manager_name']);?></label>
								</div>
							</div>
							
							<?php endif;?>
							
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
																<a target="_blank" href="#" class="mailbox-attachment-name"><i class="fa <?php echo $type;?>"></i>&nbsp;<?php echo $document_name;?></a>
																<span class="mailbox-attachment-size">
																<?php echo $file_size.' bytes';?>
																<a target="_blank" href="<?php echo base_url($document) ;?>" class="btn btn-default btn-xs pull-right">
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
				
				</div>
					<!-- Salary tab Ends  Here -->
				
			</div>
	
		
		<div class="box-footer">
			<div class="pull-left">
				
			</div>
			
			
			<?php if($user_data['role'] == 'S'):?> 
				<div class="pull-right">
					<a href="<?=site_url('user/edit_profile_profile/'.$user_data['id']); ?>" class="btn btn-default"><i class="fa fa-edit"></i> Edit Your Details</a>
				</div>
			<?php endif;?>
		
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

	
});
</script>