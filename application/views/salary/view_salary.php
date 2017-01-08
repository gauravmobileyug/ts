<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<?php //fn_ems_debug($user_data); ?>
    <section class="content-header">
      <h1>
		Salary For <?php echo $salary['pay_period'] ;?>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Salary</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row">

		<div class="col-md-12">
		<div class="box box-solid">
			<div class="box-header with-border">
			  <i class="fa fa-text-width"></i>
			  <h3 class="box-title">Salary</h3>
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<table class="table table-bordered">
				<tbody>
					<tr>
						<td><label for="empid">Employee ID</label></td>
						<td><label class="custom-label">EMP-<?php echo $user_data['id'];?></label></td>
						<td><label for="empid">Employee Name</label></td>
						<td>
						<label class="custom-label"><?php echo ucwords($user_data['firstname'].' '.$user_data['lastname']);?></label>
						</td>
						<td><label for="doj">Date Of Joining</label></td>
						<td><label class="custom-label"><?php echo date('d-m-Y',strtotime($user_data['date_added']));?></label></td>
					</tr>	
					<tr>	

						<td><label for="doj">Department</label></td>
						<td><label class="custom-label"><?php echo $user_data['department_name'];?></label></td>
						<td><label for="doj">Designation</label></td>
						<td colspan="3">
						<label class="custom-label"><?php echo $user_data['user_designation_description'];?></label>
						</td>

					</tr>


					<tr>
						<td><label for="pay_period">Select Salary Period</label></td>
						<td colspan="3">
						<label class="custom-label" id="pay_period"><?php echo $salary['pay_period'];?></label>
						<input type="hidden" name="salary_id" id="salary_id" value="<?php echo $salary['id']; ?>">
						</td>
						<td><label for="basic">Paid Days</label></td>
						<td colspan="5">
						<label class="custom-label" id="paid_days"><?php echo $salary['paid_days'];?></label>

						</td>
					</tr>

					<tr>
						<td colspan="6"><label class="label bg-green" >EARNINGS</label></td>
					</tr>

					<tr>
						<td><label for="basic">Basic Salary</label></td>
						<td colspan="5">
						<label class="custom-label" id="basic"><?php echo $salary['basic'];?></label>
						</td>
					</tr>
					<tr>
						<td><label for="hra">H R A</label></td>
						<td colspan="5">
						<label class="custom-label" id="hra"><?php echo $salary['hra'];?></label>
						</td>
					</tr>


					<tr>
						<td><label for="conveyance">Conveyance Allowance</label></td>
						<td colspan="5">
						<label class="custom-label" id="conveyance"><?php echo $salary['conveyance'];?></label></td>
					</tr>

					<tr>
						<td><label for="special_allowance">Special Allowance</label></td>
						<td colspan="5">
						<label class="custom-label" id="special_allowance"><?php echo $salary['special_allowance'];?></label>
						</td>
					</tr>
					
					<tr>
						<td><label for="bonus">Bonus</label></td>
						<td colspan="5">
						<label class="custom-label" id="bonus"><?php echo $salary['bonus'];?></label>
						</td>
					</tr>

					<tr>
						<td><label for="misc_rewards">Miscellaneous Rewards</label></td>
						<td colspan="5">
						<label class="custom-label" id="misc_rewards"><?php echo $salary['misc_rewards'];?></label>
						</td>
					</tr>

					<tr>
						<td><label for="income_tax">Income Tax</label></td>
						<td colspan="5">
							<label class="custom-label" id="income_tax"><?php echo $salary['income_tax'];?></label>	
						</td>
					</tr>

					<tr>
						<td><label for="epf">EPF</label></td>
						<td colspan="5">
						<label class="custom-label" id="epf"><?php echo $salary['epf'];?></label>	
						</td>
					</tr>
					
					<tr>
						<td colspan="6"><label class="label bg-orange"> FORMULA </label></td>
					</tr>
					
					<tr>
						<td colspan=""><label for="EPF">Ne Pay</label></td>
						<td colspan="2"><label for="EPF">Total Earnings</label></td>
						<td colspan="2"><label for="EPF">Total Taxes</label></td>
						<td colspan="2"><label for="EPF">Total Deductions</label></td>
					</tr>
					<tr>
						<td><label>Rs <?php echo $salary['net_pay'];?></label></td>
						<td colspan="2"><label class="custom-label">Rs  <?php echo $salary['total_earning'];?></label></td>
						<td colspan="2"><label class="custom-label">Rs  <?php echo $salary['total_tax'];?></label></td>
						<td colspan="2"><label class="custom-label">Rs  <?php echo $salary['total_deductions'];?></label></td>
					</tr>
					
			
				</tbody>
				</table>
			</div>
			
			<div class="box-footer">
			  <div class="pull-left">
				
			  </div>
              <div class="pull-right">
                <a class="btn btn-info btn-xs" href="<?php echo site_url('salary/download?emp_id[]='.$salary['user_id'].'&salary_id[]='.$salary['id']);?>"><i class="fa fa-print"></i> Print Slip </a>
				<?php if( isset($salary_slip) && !empty($salary_slip['salary_slip']) ){ ?>
					<a class="btn btn-success btn-xs" href="<?php echo site_url('salary/download_slip/'.$salary_slip['id'].'/'.$salary['user_id']);?>">
						<i class="fa fa-download"></i> Download Slip </a>
				<?php }?>
              </div>
            
            </div>
			
		<!-- /.box-body -->
		</div>
		<!-- /.box -->
		</div>
	</div>
</div>