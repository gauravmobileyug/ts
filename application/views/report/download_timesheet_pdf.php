<style>
body, p, li, td, table, tr, .bodytext, .stepfield {
 word-wrap: normal;
}
.wiki-content p {
 word-wrap: normal;
}
li
{ font-size: 10pt; }

input, textarea, select
{
    border: dashed 1mm red;
    background: #FCC;
    color: #400;
    text-align: left;
    font-size: 11pt;
}

</style>
<page style="font-size: 14px">
<br/><br/>
<img src="<?php echo base_url('assets/images/versetal-print.png');?>"/> 
		<br/><br/>
    
            <h3 style="text-align:center;">Timesheet Report Of <b><?php echo ucwords($timesheet_report['short_description']['employee']) ;?></b></h3>
		
		
					<table class="" border="1" style="border-collapse:collapse;width:100%">
						<tbody>
							<tr>
								<td style="text-align:center; padding: 10px;text-align:center;background-color: #f6be2e;color: black;width:20%"><b>From:</b></td>
								<td  style="width:13%;text-align:center"><?php echo isset($date_range['from_date']) ? $date_range['from_date'] : "Begining" ;?></td>
								<td style="text-align:center; padding: 10px;text-align:center;background-color: #f6be2e;color: black;width:20%"><b>To:</b></td>
								<td  style="width:13%;text-align:center"><?php echo isset($date_range['to_date']) ? $date_range['to_date'] : "Begining" ;?></td>
								<td style="text-align:center; padding: 10px;text-align:center;background-color: #f6be2e;color: black;width:20%"><b>Total Time:</b></td>
								<td  style="width:13%;text-align:center"><?php echo date('H:i:s', mktime(0,$total_time));?></td>
							</tr>
						</tbody>
					</table>
					
					<?php 
					$color_box 	= array('#ffd965'/* ,'#f7caac','#a7d08c' */); 
					
					$color_count = 0;
					?>
					<br/><br/>
					<?php foreach($timesheet_report['long_description'] as $key => $value){ ?> 
					
					 
						<table class="" border="1" style="border-collapse:collapse;width:100%">
						<tbody>
								<tr>
									<?php /* ?>
									<td><label>Sheet ID:</label></td>
									<td><?php echo $value['ticket_summary']['breif']['sheet_id'];?></td>
									<?php */
									
									//if($color_count == 3){
										$color_count = 0;
									//}
									
									
									$bg_color  	= $color_box[$color_count];
									$color_count++;
									?>
									<td style="text-align: center;  background-color: <?=$bg_color?>; padding: 7px;   width:50%"><b>Date:</b></td>
									<td style="text-align:center;font-weight: bold;width:50%" ><?php echo $value['ticket_summary']['breif']['date_added'] ;?></td>
									
									
									<?php 
									/*
									<td style="text-align: left; background-color: <?=$bg_color?>; padding: 7px;width: 37%;"><b>Last Modified:</b></td>
									<td style="text-align:center"><?php echo $value['ticket_summary']['breif']['date_updated'];?></td>
									
									*/?>
									
								</tr>
							</tbody>
						</table>
						<br/><br/>
						<table border="0"  style="border-collapse:collapse;border:1px solid #cccccc;border: 1px solid;width:100%">
							
							<thead>
								<tr style="background-color: #bfbfbf;">
									<td  style="font-size:16px;font-weight:bold;text-align:center"><b>Sr.No.</b></td>
									<td  style="font-size:16px;font-weight:bold;text-align:center"><b>Ticket Number</b></td>
									<td  style="font-size:16px;font-weight:bold;text-align:center"><b>Client Name</b></td>
									<td  style="font-size:16px;font-weight:bold;text-align:center"><b>Description</b></td>
									<td  style="font-size:16px;font-weight:bold;text-align:center"><b>Time</b></td>
									
								</tr>
							</thead>
						
							<tbody border="1"  style=" text-align:center;border-collapse:collapse;border:1px solid #cccccc;width:100%">
								<?php $total_time = 0; $i=1;?>
								<?php foreach($value['ticket_summary']['tickets'] as $_key => $_value){?>
									<tr>											
										<td style="padding: 7px;width:3%;font-size:12px"><?php echo $i++;?></td>												
										<td style="text-align:center;width:15%;font-size:12px;word-break: break-all;word-wrap: break-word;">
										<?php
										$break = strlen($_value['ticket_number']);

										if($break >= 18){
											
											for($i=0;$i<=$break;){	
												
												$j = $i+18;
												echo substr($_value['ticket_number'],$i,18).' ';		
												
												$i = $i+18;
											}
											
											
										}else{
											echo $_value['ticket_number'];		
										}
										
										
										?></td>												
										<td style="text-align:center;width:15%;font-size:12px;word-break: break-all;word-wrap: break-word;">
										<?php

										$break = strlen($_value['client_name']);

										if($break >= 18){
											
											for($i=0;$i<=$break;){	
												
												$j = $i+18;
												echo substr($_value['client_name'],$i,18).' ';		
												
												$i = $i+18;
											}
											
											
										}else{
											echo $_value['client_name'];
										}

										
										
										
										
										?></td>												
										<td style="text-align:center;width:25%;font-size:12px;word-break: break-all;word-wrap: break-word;">
										<?php 
										$break = strlen($_value['description']);

										if($break >= 18){
											
											for($i=0;$i<=$break;){	
												
												$j = $i+18;
												echo substr($_value['description'],$i,18).' ';		
												
												$i = $i+18;
											}
											
											
										}else{
											echo $_value['description'];
										}
										
										?></td>	
										<td style="text-align:center;width:4%;font-size:12px"><?php echo $_value['time'];?></td>												
										
										<?php  $total_time+=$_value['time'];?>
									</tr>
									<tr><td colspan="5" style="height: 16px;"></td></tr>
								<?php }?>
								
								<tr>
									<td style="padding: 7px;    text-align: right;width:40%;" colspan="4" >
										<b>Total Time:</b>
									</td>
									<td style="text-align:center;width:40%;">
										<b><b><?php echo $total_time;?></b> Minutes</b>
									</td>
								</tr>
								
							</tbody>
						</table>
						<br/>
					<?php }?>
	

</page>	