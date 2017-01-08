<link rel="stylesheet" href="<?php echo base_url('assets/plugins/timepicker/bootstrap-timepicker.min.css');?>">
<style>
.time_table thead th{padding: 10px 5px!important;}
.time_table tbody td{padding: 8px 2px!important;}
.timesheet-span {visibility:hidden;}
.time_table textarea{width:100%;}
.update-timesheet{
	display: flex;
    margin-top: 14px;
    margin-bottom: -15px;
}
.update-timesheet > p{ padding-right: 12px;}

.wysihtml5-toolbar{display:none !important;}
.wysihtml5-sandbox { height:60px !important}

</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<?php $readonly = '';$disabled = ''; //fn_ems_debug($timesheets); ?>
    <section class="content-header">
      <h1>
		Update Timesheet 
	  </h1>
	  <div class="update-timesheet">
		<p><label>Employee Name : </label><?php echo ucwords($employee_details['firstname'] . ' '.$employee_details['lastname']); ?></p>
		<p><label>Employee ID : </label><?php echo ucwords($employee_details['employee_id']); ?></p>
		<p><label>Timsheet Date : </label><?php echo $timesheets[0]['timesheet_date']; ?></p>
	  </div>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <?php 
		$search['search']['from_date'] = date('Y-m-01'); 
		$search['search']['to_date']   = date('Y-m-31'); 
		$params = http_build_query($search);
		
		$params2 = isset($_SERVER["QUERY_STRING"]) ? $_SERVER["QUERY_STRING"] :'';
		
		//print_r($timesheets);
	
		?>

		<li><a href="<?php echo site_url('report/timesheet_reports?'.$params);?>">Timesheet Report List</a></li>
        <li><a href="<?php echo site_url('report/list_timesheet/'.$employee_details['id'].'?'.$params2);?>"> Timesheet Entry</a></li>
        <li class="active">Timesheet</li>
      </ol>
    </section>
	<?php $valid_month = date('m',strtotime($timesheets[0]['timesheet_date'])) == date('m') ? true : false; ?>	
    <!-- Main content -->
    <section class="content">
	<form action="<?php echo site_url('user/edit_timesheet/'.$user_id.'/'.$sheet_id); ?>" method="POST">
      <div class="row">

		<div class="col-md-12">
		<div class="box box-solid">
			<div class="box-header with-border">
			  <i class="fa fa-calendar-check-o"></i>
			  <h3 class="box-title" class="pull-left">Timesheet</h3>
			  
					
			 <?php if(empty($timesheets)){?>
			 
				<div class="pull-right">
					<button type="submit" name="submit" value="1" class="btn btn-primary save-submit"><i class="fa   fa-save"></i>  Save</button>
					<?php /* <button type="submit" name="submit" value="2" class="btn btn-primary save-submit"><i class="fa  fa-check-square-o"></i>  Submit</button> */?>
				</div>
			  
			 <?php } elseif(!empty($timesheets) && $timesheets[0]['submit'] == 1 && $valid_month) { ?>
				 <div class="pull-right">
					<button type="submit" name="submit" value="1" class="btn btn-primary save-submit"><i class="fa   fa-save"></i>  Save</button>
					<input type="hidden" name="sheet_id" value="<?php echo $sheet_id;?>" />
					<button type="submit" name="submit" value="2" class="btn btn-primary save-submit"><i class="fa  fa-check-square-o"></i>  Submit</button>
				  </div>
			 <?php } elseif(!empty($timesheets) && $timesheets[0]['submit'] == 1 && !$valid_month) {
					$readonly = 'readonly';$disabled = 'disabled'; 
				?> 
				<div class="pull-right">
					<span class="label bg-purple">Not Allowed To Modify Your Previous Month Time Sheet</span>
				</div>
			 <?php } elseif(!empty($timesheets) && $timesheets[0]['submit'] == 2 && $valid_month) { 
					$readonly = 'readonly';$disabled = 'disabled'; 
			?>
				<div class="pull-right">
					<span class="label bg-purple">Timesheet Saved And Submitted</span>
				</div>
			 <?php }?>
			 
			 
			  
			  
			  
			</div>
			<!-- /.box-header -->
			<div class="box-body">
				<div class="">
				Select Date Of Timesheet <span class="em-required">*</span> : 
		
		
				
					<div>
						<input type="text" class="form-control" name="timesheet_date" id="timesheet_date"  value="<?=$timesheets[0]['timesheet_date'];?>" placeholder="Timesheet Date" autocomplete="off" <?=$readonly.' '.$disabled;?> style=" width:23%"/>
					</div>
			  
			 
				
				</div>
			
			
				<table class="table table no-margin table-hover dataTable timesheet timesheet-table time_table">
				<thead>
					<tr>
						<th>S.No.</th>
						<th>Assigned By</th>
						<th>Ticket Number</th>
						<th>Client Name</th>
						
						<th>Time</th>
						<th colspan="2">Description</th>
						<th></th>
					</tr>
				</thead>
				<?php $timesheet_row = 0;?>
				<?php $total_time = 0;?>
				<tbody>
					<?php 
					if(!empty($timesheets)) {
						foreach($timesheets as $key => $timesheet){ 
						?>
							<tr id="timesheet-<?php echo $timesheet_row;?>">
								<td style="width:15px;text-align:center;" class="text-center">#<?php echo $timesheet_row+1;?></td>
								<td style="width:80px;"><input required <?=$readonly;?> type="text" name="timesheet[<?php echo $timesheet_row;?>][assigned_by]" value="<?php echo $timesheet['assigned_by'] ;?>" /></td>
								<td style="width:80px;"><input <?=$readonly;?> type="text" name="timesheet[<?php echo $timesheet_row;?>][ticket_number]" value="<?php echo $timesheet['ticket_number'] ;?>" /></td>
								<td style="width:80px;"><input <?=$readonly;?> type="text" name="timesheet[<?php echo $timesheet_row;?>][client_name]"  value="<?php echo $timesheet['client_name'] ;?>" /></td>
								<td style="width:80px;"> 
									<div class="bootstrap-timepicker">
										<input required type="number" <?=$readonly;?> name="timesheet[<?php echo $timesheet_row;?>][time]" value="<?php echo $timesheet['time'] ;?>" class="timesheet-time"  id="timepicker-<?php echo $timesheet_row;?>">
									</div>
								</td>
								<td colspan="2">
								
									<?php if( $readonly == 'readonly') { ?>
										<style>
											.wysihtml5-sandbox { height:60px !important;     pointer-events: none !important;}
										</style>
									<?php }?>
								
								
									<textarea <?=$readonly;?> required class="timesheet-desc" name="timesheet[<?php echo $timesheet_row;?>][description]"><?php echo $timesheet['description'] ;?></textarea>																											
								</td>
								<td>
									<?php if(empty($timesheets)){?>	
									<span class="timesheet-span">
										<a href="javascript:void(0);" onclick="remove_timesheet(<?php echo $timesheet_row;?>);"> <i class="fa fa-trash-o text-red"></i> </a>
									</span>			
									<?php }elseif(!empty($timesheets) && $timesheets[0]['submit'] == 1) { ?>				
									<span class="timesheet-span">
										<a href="javascript:void(0);" onclick="remove_timesheet(<?php echo $timesheet_row;?>);"> <i class="fa fa-trash-o text-red"></i> </a>
									</span>
									<?php }elseif(!empty($timesheets) && $timesheets[0]['submit'] == 2) { ?>	
									<a class="btn btn-success btn-xs" href="javascript:void(0);"> Saved</a> 
									<?php } ?>
								
								</td>
							</tr>

						<?php 
							$total_time+=$timesheet['time'];
							$timesheet_row++;
						} 
					}else{?>
					
					<tr id="timesheet-<?php echo $timesheet_row;?>">
						<td style="width:15px;text-align:center;" class="text-center">#<?php echo $timesheet_row+1;?></td>
						<td  style="width:80px;"><input <?=$readonly;?> required type="text" name="timesheet[<?php echo $timesheet_row;?>][assigned_by]" value="" /></td>
						<td  style="width:80px;"><input <?=$readonly;?> type="text" name="timesheet[<?php echo $timesheet_row;?>][ticket_number]" value="" /></td>
						<td  style="width:80px;"><input <?=$readonly;?> type="text" name="timesheet[<?php echo $timesheet_row;?>][client_name]"  value="" /></td>
						<td  style="width:80px;"> 
							<div class="bootstrap-timepicker">
								<input required <?=$readonly;?> type="number" name="timesheet[<?php echo $timesheet_row;?>][time]" value="" class="time timesheet-time"  id="timepicker-<?php echo $timesheet_row;?>">
							</div>
						</td>
						<td colspan="2">
							
							<?php if( $readonly == 'readonly') { ?>
								<style>
									.wysihtml5-sandbox { height:60px !important;     pointer-events: none !important;}
								</style>
							<?php }?>
								
						
							<textarea required <?=$readonly;?> class="timesheet-desc" name="timesheet[<?php echo $timesheet_row;?>][description]"></textarea>
						</td>
						<td>
						
							<?php if(empty($timesheets)){?>	
							<span class="timesheet-span">
								<a href="javascript:void(0);" onclick="remove_timesheet(<?php echo $timesheet_row;?>);"> <i class="fa fa-trash-o text-red"></i> </a>
							</span>			
							<?php }elseif(!empty($timesheets) && $timesheets[0]['submit'] == 1) { ?>				
							<span class="timesheet-span">
								<a href="javascript:void(0);" onclick="remove_timesheet(<?php echo $timesheet_row;?>);"> <i class="fa fa-trash-o text-red"></i> </a>
							</span>
							<?php }elseif(!empty($timesheets) && $timesheets[0]['submit'] == 2) { ?>	
							<a class="btn btn-success btn-xs" href="javascript:void(0);"> Saved</a> 
							<?php } ?>

						</td>
							
						<?php $timesheet_row++; ?>
					</tr>
					<?php } ?>
				</tbody>
				<tfoot></tfoot>
				</table>
			</div>
			
			<div class="box-footer">
			  <div class="pull-left">
				
			  </div>   

				<div class="total-time"><i class="fa fa-clock-o"></i> Total Time : <span id="total_time"><?php echo $total_time;?></span> Minutes </div>
				<div class="pull-right">
				
				<?php if(empty($timesheets)){?>
					<a class="btn btn-success" href="javascript:void(0);" onclick="add_timesheet();"> Add More </a> 
				<?php }elseif(!empty($timesheets) && $timesheets[0]['submit'] == 1 && $valid_month) { ?>
					<a class="btn btn-success" href="javascript:void(0);" onclick="add_timesheet();"> Add More </a> 
				<?php } ?>
				
				
				
			  </div> 			  
            </div>
			
		<!-- /.box-body -->
		</div>
		<!-- /.box -->
		</div>
	</div>
	</form>
	</section>
</div>
<script src="<?php echo base_url('assets/plugins/timepicker/bootstrap-timepicker.min.js');?>"></script>
<script>
var timesheet_row = <?php echo $timesheet_row;?>;

function add_timesheet(){
	
	var html = '<tbody>';
	
	html+='<tr id="timesheet-'+ timesheet_row +'">';
	html+=	'<td class="text-center">#'+parseInt(timesheet_row+1)+'</td>';
	html+=	'<td><input required type="text"  name="timesheet['+timesheet_row+'][assigned_by]" value="" /></td>';
	html+=	'<td><input  type="text"  name="timesheet['+timesheet_row+'][ticket_number]" value="" /></td>';
	html+=	'<td><input  type="text"  name="timesheet['+timesheet_row+'][client_name]"  value="" /></td>';
	html+=	'<td>'; 
	html+=		'<div class="bootstrap-timepicker">';
	//html+=			'<div class="form-group">';
	//html+=			  '<div class="input-group">';
	html+=					'<input required type="number" name="timesheet['+timesheet_row+'][time]" value="" class="timesheet-time" onkeypress="javascript:void(0);" id="timepicker_'+timesheet_row+'" id="timepicker-"'+timesheet_row+'">';
	//html+=					'<div class="input-group-addon">';
	//html+=					'<i class="fa fa-clock-o"></i>';
	//html+=					'</div>';
	//html+=				  '</div>';
	//html+=				'</div>';
	html+=		'</div>';
	html+=	'</td>';
	html+=	'<td colspan="2"><textarea required class="timesheet-desc" name="timesheet['+timesheet_row+'][description]"></textarea></td>';	
	html+=  '<td><span class="timesheet-span"><a  href="javascript:void(0);" onclick="remove_timesheet('+timesheet_row+');"> <i class="fa fa-trash-o text-red"></i></a></td>';
	html+='</tr>';
	
	html+='</tbody>';
	
	$('.timesheet tfoot').before(html);
	 $(".timesheet-desc").wysihtml5();	
	$(".wysihtml5-toolbar").remove();
	
	/* $("#timepicker_"+timesheet_row).timepicker({
      showInputs: false,
	   minuteStep: 5
    }); */
	
	
	timesheet_row++;	
	
}

function remove_timesheet(timesheet_row){
	
	$('#timesheet-'+timesheet_row).remove();
	this.timesheet_row--;
}


$(document).ready(function(){
	var total_time = 0;
	$('input.time').keyup(function(){
		$('.time').each(function() {
			console.log($(this).val());
		});
	});
});
</script>

<script src="<?php echo base_url('assets/dist/js/moment.min.js');?>"></script>
<script src="<?php echo base_url('assets/plugins/datepicker/bootstrap-datepicker.js');?>"></script>

<script>

$(function () {
    $(".timesheet-desc").wysihtml5();	
	$(".wysihtml5-toolbar").remove();
	
});

$(function(){	
	$('#timesheet_date').datepicker({
	  autoclose: true,
	  format: 'yyyy-mm-dd',
	});

});
</script>
