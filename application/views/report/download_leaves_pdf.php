	
	<page style="font-size: 14px">
	
	<br/><br/>
	<img src="<?php echo base_url('assets/images/versetal-print.png');?>"/> 
		
    
	  <br/><br/>

     
		<table  class="" border="1" style="border-collapse:collapse;width:100%">
			<tbody>
				<tr>
					<td style="text-align:center; padding: 10px;text-align:center;background-color: #f6be2e;color: black;"><label>Employee Name:</label></td>
					<td style="width:15%;text-align:center"><?php echo ucwords($leave_report['short_description']['employee']) ;?></td>
					<td style="text-align:center; padding: 10px;text-align:center;background-color: #f6be2e;color: black;"><label>Employee ID:</label></td>
					<td  style="width:15%;text-align:center"><?php echo strtoupper($leave_report['short_description']['employee_id']);?></td>
					<td style="text-align:center padding: 7px;text-align:center;background-color: #f6be2e;color: black;"><label>Reporting Manager:</label></td>
					<td  style="width:20%;text-align:center"><?php echo ucwords($leave_report['short_description']['manager']);?></td>
				</tr>
			</tbody>
		</table>
					
		<hr style="border: 1px solid;">
		
		<table class="" border="1" style="border-collapse:collapse;width:100%">
			<tbody>
				<tr>
					<td style="text-align: center; background-color: #ffd965; padding: 7px;width:30%"><b>SL Opening Balance</b></td>
					<td style="text-align:center;width:20%"><?php echo $leave_report['short_description']['opening_sleave']; ?></td>
					
					<td style="text-align: center; background-color: #ffd965; padding: 7px;width:30%"><b>PL Opening Balance</b></td>
					<td style="text-align:center ;width:20%"><?php  echo $leave_report['short_description']['opening_pleave']; ?></td>
					
				</tr>
			</tbody>
		</table> 
					
		<br/>
					<table border="0"  style="border-collapse:collapse;border:1px solid #cccccc;border: 1px solid;width:100%">
							
							<thead>
								<tr>
									<td style="font-size:10px;font-weight:bold">Sr.No.</td>
									<td style="font-size:10px;font-weight:bold">From</td>
									<td style="font-size:10px;font-weight:bold">To</td>
									<td style="font-size:10px;font-weight:bold">Applied On</td>
									<td style="font-size:10px;font-weight:bold">Reason</td>
									
									<td style="font-size:10px;font-weight:bold">HD</td>
									<td style="font-size:10px;font-weight:bold">EL</td>
									
									<td style="font-size:10px;font-weight:bold">Type</td>
									<td style="font-size:10px;font-weight:bold">Total Days</td>
									<td style="font-size:10px;font-weight:bold">Status</td>		
									<td style="font-size:10px;font-weight:bold;width:10%">SL Bal.</td>
									<td style="font-size:10px;font-weight:bold">PL Bal.</td>
								</tr>
							</thead>
						
							<tbody border="1"  style=" text-align:center;border-collapse:collapse;border:1px solid #cccccc;width:100%">
							<?php $i=1; foreach($leave_report['long_description'] as $key => $value){ ?>
							
						
								<tr>											
									<td style="padding: 7px;width:3%;font-size:12px"><?php echo $i++;?></td>												
									<td style="text-align:center;width:10%;font-size:12px"><?php echo $value['leave_details']['leave_from'];?></td>												
									<td style="text-align:center;width:10%;font-size:12px"><?php echo $value['leave_details']['leave_to'];?></td>
									<td style="text-align:center;width:10%;font-size:12px"><?php echo date('Y-m-d' , strtotime($value['leave_details']['date_added']));?></td>
									<td style="text-align:left;width:20%;font-size:12px;word-wrap: break-word;">
									<?php 
									
									$break = strlen($value['leave_details']['leave_reason']);

									if($break >= 18){
										
										for($i=0;$i<=$break;){	
											
											$j = $i+18;
											echo substr($value['leave_details']['leave_reason'],$i,18).' ';		
											
											$i = $i+18;
										}
										
										
									}else{
										echo $value['leave_details']['leave_reason'];
									}
									?>
									</td>
									
									
									<td style="text-align:center;width:30px;font-size:12px"><?php echo $value['leave_details']['half_day'];?></td>	
									<td style="text-align:center;width:30px;font-size:12px"><?php echo $value['leave_details']['emergency_leave'];?></td>	
									
									<td style="text-align:center;width:40px;font-size:12px">
									<?php
									if($value['leave_details']['leave_type'] == 1) {
										$leave_name = 'SL' ;
									}elseif($value['leave_details']['leave_type'] == 2){
										$leave_name = 'PL' ;
									}elseif($value['leave_details']['leave_type'] == 3){
										$leave_name = 'CL' ;
									}
									?>
									
									<?php echo $leave_name;//$value['leave_details']['leave_name'];?>
									
									
									</td>	
									
									<td style="text-align:center;width:50px;font-size:12px"><?php echo $value['leave_details']['no_of_days'];?></td>

									

									<td style="text-align:center;width:10%;font-size:12px">
									<?php
										if($value['leave_details']['approved'] == 0){
											echo 'Pending';
										}
										if($value['leave_details']['approved'] == 1){
											echo 'Approved';
										}
										if($value['leave_details']['approved'] == 2){
											echo 'Declined';
										}
									?>
									</td>											
									<td style="text-align:center;width:5%;font-size:12px"><?php echo $value['leave_details']['balance_sleave'];?></td>													
									<td style="text-align:center;width:5%;font-size:12px"><?php echo $value['leave_details']['balance_pleave'];?></td>													
								</tr>
								
								<tr><td colspan="12" style="padding-top: 20px;"></td></tr>
								<?php }?>
							</tbody>
						</table>
						<br/>
						<hr style="border: 1px solid;">
						<?php if( !empty($monthly_added_leaves) ):?>
						<table border="1" style="border-collapse:collapse;width:100%">
							<tbody>
								<tr>
									<td style="text-align: center; background-color: #ffd965; padding: 7px;    width: 100%;"><b>Monthly/Yearly Added Leaves</b></td>
									
								</tr>
							</tbody>
						</table> 
						
						<table border="0"  width="100%" style="border-collapse:collapse;border:1px solid #cccccc;border: 1px solid;">
							
							<thead>

								<tr>
								
									<td style="font-size:14px;width:13%;font-weight:bold">Sr.No.</td>
									<td style="font-size:14px;width:13%;font-weight:bold">Description</td>
									<td style="font-size:14px;width:13%;font-weight:bold">Year</td>
									<td style="font-size:14px;width:13%;font-weight:bold">Month</td>
									<td style="font-size:14px;width:13%;font-weight:bold">Date Added</td>
									<td style="font-size:14px;width:13%;font-weight:bold">Added Value</td>
									<td style="font-size:14px;width:13%;font-weight:bold">SL Bal</td>
									<td style="font-size:14px;width:13%;font-weight:bold">PL Bal</td>
									
									
								</tr>
							</thead>
						
							<tbody  border="1"  style=" text-align:center;border-collapse:collapse;border:1px solid #cccccc;width:100%;padding-top:10px">
							<?php $i=1; foreach($monthly_added_leaves as $key => $value){ ?> 							
						
								<?php 
								
									$m_desc = $value['m_sleave'] != 'X' ? 'SL Added' : 'PL Added';
								?>
								
								<tr>											
									<td style="text-align:center;width:10%"><?php echo $i++;?></td>									
									<td style="text-align:center;width:10%"><?=$m_desc;?></td>									
									<td style="text-align:center;width:10%"><?php echo $value['year'];?></td>		
									<td style="text-align:center;width:10%"><?php echo $value['month'];?></td>								
									<td style="text-align:center;width:10%"><?php echo date('Y-m-d', strtotime($value['m_date_added']));?></td>									
									<td style="text-align:center;width:10%"><?php echo $value['m_sleave'] != 'X' ? $value['m_sleave'] : $value['m_pleave'];?></td>													
									<td style="text-align:center;width:10%"><?php echo $value['m_total_sleave'];?></td>	
									<td style="text-align:center;width:10%"><?php echo $value['m_total_pleave'];?></td>	
									
									
								</tr>
								<?php }?>
							</tbody>
						</table>
						
						<?php endif; ?>


</page>				