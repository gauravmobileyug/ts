<?php 	$user_photo = 'assets/images/blank_user.png';	$documents = array() ;	if( !empty($employee_details['documents'])){		$documents = unserialize( $employee_details['documents'] );				
/* if( isset($documents) && array_key_exists('user_photo',$documents) ){	
		$user_photo = $documents['user_photo'];	
} */
		unset($documents['user_photo']);
		unset($documents['user_other']);
		
		$user_photo  = !empty($employee_details['profile_pic']) ? $employee_details['profile_pic'] :$user_photo ;
		
		
}?><div class="content-wrapper"><section class="content-header">  <h1>	Employee Profile  </h1>  <ol class="breadcrumb">	<li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li> <li class="active"><a href="<?=site_url('user/list_employees');?>">Employee List</a></li>	<li class="active">Employee Profile</li>  </ol></section><!-- Main content --><section class="content"><div class="row"><div class="col-md-3">  <div class="box box-primary">	<div class="box-body box-profile">	  <img class="profile-user-img img-responsive" src="<?php echo base_url($user_photo);?>" alt="User profile picture">	  <h3 class="profile-username text-center"><?php echo isset($employee_details) ? $employee_details['firstname'] .' '. $employee_details['lastname']  : '' ;?></h3>	  <p class="text-muted text-center"><?php echo ucwords($employee_details['user_designation_description']);?></p>	  <ul class="list-group list-group-unbordered">		<li class="list-group-item">		  <i class="fa fa-birthday-cake"></i> <b> Birthday </b> 		  			<?php 			$dob_this_year = '';			$class = '';			if( isset($employee_details) ) {				$dob = date('d M',strtotime($employee_details['dob']));				$dob_this_year = $dob. ' '. date('Y');								if($dob == date('d M')){					$class = 'birth_day';				}											}?>		  		  <a class="pull-right <?php echo $class;?> label label-success">			<?php echo $dob_this_year ;?>		  </a>		  		 		</li>		<li class="list-group-item">		  <i class="fa fa-thumbs-o-up"></i> <b> Anniversary </b> <a class="pull-right label label-primary"><?php echo date('d M Y' ,strtotime($employee_details['doj']));?></a>		</li>		<!-- <li class="list-group-item">		  <i class="fa fa-tasks"></i> <b> Applied Leaves </b> <a class="pull-right">22</a>		</li>				-->					  </ul>	</div>	<!-- /.box-body -->  </div></div><div class="col-xs-9">
<style>

.table td {
	padding:13px !important;
}
</style>

<?php //fn_ems_debug($user_data); ?>
<div class="box">
	<div class="box-body">	
		<table class="table table-bordered">
			<tbody>
			
			
			
				<tr>
				
					<td><label for="firstname" >First Name</label></td>
					<td>
						<label class="custom-label">
							<?php echo isset($employee_details) ? $employee_details['firstname'] : '' ;?>
						</label>
					</td>
					<td>
						<label for="lastname" >Last Name</label>
					</td>
					<td>
						<label class="custom-label"><?php echo isset($employee_details) ? $employee_details['lastname'] : '' ;?></label>
					</td>
				
					<td><label for="empid" >Employee ID</label></td>
					<td><label class="custom-label"><?php echo $employee_details['employee_id'];?></label></td>
					
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
					
					
					<td><label>Official E-mail</label></td>
					<td colspan="3"><label class="custom-label"><?php echo $employee_details['official_email'] ? $employee_details['official_email'] : 'NA';?></label></td>
					
					
					<?php if($view_profile) { ?>
					<!-- <td><label>Emergency Contact Number</label></td>
					<td><label class="custom-label"><?php echo $employee_details['emergency_contact'] ? $employee_details['emergency_contact'] : 'NA';?></label></td> -->
					<?php } ?>
					
					<td colspan="5">
						
					</td>
					
					<!-- <td>
						<label for="email">Personal Email</label>
					</td>
					<td colspan="3">
						<label class="custom-label"><?php echo isset($employee_details) ? $employee_details['email']: '';?></label>
					</td> -->
				</tr>
				
				<tr>
					<td>
						<label for="phone" >Phone</label>
					</td>
					<td>
						<label class="custom-label"><?php echo isset($employee_details) ? $employee_details['phone']: '';?></label>
					</td>
					
					<td>
						<label for="gender">Gender</label>
					</td>
					<td>
						<label class="custom-label">
							<?php echo isset($employee_details) && $employee_details['gender'] == 'male' ? 'Male' : 'Female' ;?>
						</label>
					</td>
					<td>
						<label for="dob">Date Of Birth</label>
					</td>
					<td  colspan="3">
						<label class="custom-label"><?php echo isset($employee_details) ? $employee_details['dob']: '';?></label>
					</td>
				</tr>
				<tr>
					<td><label for="education" >Education</label></td>
					<td colspan="5"><label class="custom-label"><?php echo isset($employee_details) ? $employee_details['education']: '';?></label></td>
					<?php if($view_profile) { ?>
					<!-- <td><label for="present_address" >Present Address</label></td>
					<td><label class="custom-label"><?php echo isset($employee_details) ? $employee_details['present_address']: '';?></label></td>
					<td><label for="permanent_address" >Permanent Address</label></td>
					<td  colspan="3"><label class="custom-label"><?php echo isset($employee_details) ? $employee_details['permanent_address']: '';?></label></td> -->
					<?php }?>
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
	</div>	<div class="box-footer clearfix">	 	<div class="pull-right"></div> 	</div>
</div>

	</div></div></div></section>
	