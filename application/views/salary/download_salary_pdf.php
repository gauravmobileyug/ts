<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Versetal Information System Pvt Ltd</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url('assets/bootstrap/css/bootstrap.min.css');?>">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/font-awesome.min.css');?>">
  <!-- Ionicons -->
  <link rel="stylesheet" href="<?php echo base_url('assets/css/ionicons.min.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/css/custom.css');?>">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/AdminLTE.min.css');?>">
  <link rel="stylesheet" href="<?php echo base_url('assets/dist/css/AdminLTE.min.css');?>">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<body onload="window.print();">
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice">
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
          <div class="pull-left col-sm-2"><img src="<?php echo base_url('assets/images/versetal-print.png');?>"/></div>
		  <span style="font-size:12px;">Versetal Information System Pvt Ltd</span>
          <small class="pull-right"><b>{salary_date_added}</b></small>
        </h2>
      </div>
      <!-- /.col -->
    </div>
	
	<div  class="row invoice-info">
	 <div class="col-sm-12 table-responsive">
		<table class="table table-bordered">
			<tr>
				<td><label>Salary Slip</label></td>
				<td>#{salary_id}</td>
				<td><label>Paid Days</label></td>
				<td>{paid_days}</td>
			</tr>
			<tr>
				<td><label>Pay Periods</label></td>
				<td>{pay_period}</td>
				<td><label>PF No</label></td>
				<td>{pf}</td>
			</tr>
		</table>
        
      </div>
	</div>
	
    <!-- info row -->
    <div class="row invoice-info">
      <div class="col-sm-6 table-responsive">
		<table class="table table-bordered">
			<tr>
				<td><label>Employee ID</label></td>
				<td>EMP-{emp_id}</td>
				
				<td><label>PAN</label></td>
				<td>{pan}</td>
				
			</tr>
			<tr>
				<td><label>Name</label></td>
				<td>{firstname} {lastname}</td>
				
				<td><label>Bank Name</label></td>
				<td>{bank_name}</td>
			</tr>
			<tr>
				<td><label>Designation</label></td>
				<td>{designation}</td>
				
				<td><label>Bank Account Number</label></td>
				<td>{account_number}</td>
				
			</tr>
			<tr>
				<td><label>Department</label></td>
				<td>{department}</td>
				
				<td><label>DOJ</label></td>
				<td>{user_date_added}</td>
				
			</tr>
			
	
			
		</table>       
      </div>

    </div>
    <!-- /.row -->

    <!-- Table row -->
    <div class="row">
      <div class="col-xs-12 table-responsive">
        <table class="table table-bordered">
			
			<tr>
				<td colspan="6">EARNINGS</td>
			</tr>
			
			<tr>
				<td><label for="basic">Basic Salary</label></td>
				<td colspan="5"><label class="custom-label">{curreny} {basic}</label></td>
			</tr>
			<tr>
				<td><label for="hra">HRA</label></td>
				<td colspan="5"><label class="custom-label">{curreny} {hra}</label></td>
			</tr>
			<tr>
				<td><label for="conveyance">Conveyance Allowance</label></td>
				<td colspan="5"><label class="custom-label">{curreny} {conveyance}</label></td>
			</tr>
			<tr>
				<td><label for="special">Special Allowance</label></td>
				<td colspan="5"><label class="custom-label">{curreny} {special_allowance}</label></td>
			</tr>
			<tr>
				<td><label for="bonus">Bonus</label></td>
				<td colspan="5"><label class="custom-label">{curreny} {bonus}</label></td>
			</tr>
			<tr>
				<td><label for="misc_rewards">Miscellaneous Rewards</label></td>
				<td colspan="5"><label class="custom-label">{curreny} {misc_rewards}</label></td>
			</tr>
			
			
			<tr>
				<td><label for="misc_rewards">Total Earnings</label></td>
				<td colspan="5"><label class="custom-label">{curreny} {total_earning}</label></td>
			</tr>
			
			<tr>
				<td colspan="6">TAXES</td>
			</tr>
			
			<tr>
				<td><label for="inc_tax">Income Tax</label></td>
				<td colspan="5"><label class="custom-label">{curreny} {income_tax}</label></td>
			</tr>
			
			<tr>
				<td colspan="6">DEDUCTIONS</td>
			</tr>
			
			<tr>
				<td><label for="EPF">EPF</label></td>
				<td><label class="custom-label">{curreny} {epf}</label></td>
			</tr>
			
			<tr>
				<td colspan="6">FORMULA</td>
			</tr>
			
			<tr>
				<td colspan=""><label for="EPF">Ne Pay</label></td>
				<td colspan="2"><label for="EPF">Total Earnings</label></td>
				<td colspan="2"><label for="EPF">Total Taxes</label></td>
				<td colspan="2"><label for="EPF">Total Deductions</label></td>
			</tr>
			<tr>
				<td><label>{curreny} {net_pay}</label></td>
				<td colspan="2"><label class="custom-label">{curreny} {total_earning}</label></td>
				<td colspan="2"><label class="custom-label">{curreny} {total_tax}</label></td>
				<td colspan="2"><label class="custom-label">{curreny} {total_deductions}</label></td>
			</tr>
			
        </table>
      </div>
      <!-- /.col -->
    </div>
   
  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
