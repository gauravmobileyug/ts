

<link rel="stylesheet" href="<?php echo base_url('assets/plugins/timepicker/bootstrap-timepicker.min.css');?>">
<style>
.time_table thead th{padding: 10px 5px!important;}
.time_table tbody td{padding: 8px 2px!important;}
.timesheet-span {visibility:hidden;}
.time_table textarea{width:100%;}

.wysihtml5-toolbar{display:none !important;}
.wysihtml5-sandbox { height:60px !important}
	
</style>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
	<?php //fn_ems_debug($user_data); ?>
    <section class="content-header">
      <h1>
		Add Timesheet 
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Timesheet</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
	<form action="<?php echo site_url('user/timesheet/'.$user_id); ?>" method="POST">
      <div class="row">

		<div class="col-md-12">
		<div class="box box-solid">
			<div class="box-header with-border">
			  <i class="fa fa-calendar-check-o"></i>
			  <h3 class="box-title" class="pull-left">Timesheet</h3>
			 
			 <?php if(empty($timesheets)){?>
			 
				<div class="pull-right">
					<button type="submit" name="submit" value="1" class="btn btn-primary save-submit"><i class="fa   fa-save"></i>  Save</button>
					<?php /*<button type="submit" name="submit" value="2" class="btn btn-primary save-submit"><i class="fa  fa-check-square-o"></i>  Submit</button> */ ?>
				</div>
			  
			 <?php } elseif(!empty($timesheets) && $timesheets[0]['submit'] == 1) { ?>
				 <div class="pull-right">
					<?php /*<button type="submit" name="submit" value="1" class="btn btn-primary save-submit"><i class="fa   fa-save"></i>  Save</button> */?>
					<input type="hidden" name="sheet_id" value="<?php echo $sheet_id;?>" />
					<button type="submit" name="submit" value="2" class="btn btn-primary save-submit"><i class="fa  fa-check-square-o"></i>  Submit</button>
				  </div>
			 <?php }  elseif(!empty($timesheets) && $timesheets[0]['submit'] == 2) { ?>
				<div class="pull-right">
					<span class="label bg-purple">Timesheet Saved And Submitted</span>
				</div>
			 <?php }?>
			 
			 
			  
			  
			  
			</div>
			<!-- /.box-header -->
			<div class="box-body">
			
				
				Select Date Of Timesheet <span class="em-required">*</span> : 
		
				<?php  if(empty($timesheets)){ ?>
				
					<div>
						<input type="text" class="form-control" name="timesheet_date" id="timesheet_date"  value="" placeholder="Timesheet Date" autocomplete="off"  style=" width:23%"/>
					</div>
				
				<?php } elseif(!empty($timesheets) && $timesheets[0]['submit'] == 1) { ?>
					
					<div>
						<input type="text" class="form-control" name="timesheet_date" id="timesheet_date" style=" width:23%" value="<?php echo isset($timesheets[0]['timesheet_date']) ? $timesheets[0]['timesheet_date']:''; ?>" placeholder="Timesheet Date" autocomplete="off" required/>
					</div>
				<?php } elseif(!empty($timesheets) && $timesheets[0]['submit'] == 2) { ?>
					
					<div>
						<?php echo isset($timesheets[0]['timesheet_date']) ? $timesheets[0]['timesheet_date']:''; ?>
					</div>
					
				<?php } ?>
			
			
			
			
			<div class="table-responsive">
				<table class="table no-margin table-hover dataTable timesheet timesheet-table time_table">
				<thead>
					<tr>
						<th>S.No.</th>
						<th>Assigned By<span class="em-required">*</span></th>
						<th>Ticket Number</th>
						<th>Client Name</th>
						
						<th>Time<span class="em-required">*</span></th>
						<th colspan="2">Description<span class="em-required">*</span></th>
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
								<td style="width:15px;text-align:center;">#<?php echo $timesheet_row+1;?></td>
								<td style="width:80px;"><input required type="text" name="timesheet[<?php echo $timesheet_row;?>][assigned_by]" value="<?php echo $timesheet['assigned_by'] ;?>" /></td>
								<td style="width:80px;"><input  type="text" name="timesheet[<?php echo $timesheet_row;?>][ticket_number]" value="<?php echo $timesheet['ticket_number'] ;?>" /></td>
								<td style="width:80px;"><input  type="text" name="timesheet[<?php echo $timesheet_row;?>][client_name]"  value="<?php echo $timesheet['client_name'] ;?>" /></td>
								<td style="width:80px;"> 
									<div class="bootstrap-timepicker">
										<input required type="number" name="timesheet[<?php echo $timesheet_row;?>][time]" value="<?php echo $timesheet['time'] ;?>" class="timesheet-time"  id="timepicker-<?php echo $timesheet_row;?>">
									</div>
								</td>
								<td colspan="2">
									<textarea required class="timesheet-desc" name="timesheet[<?php echo $timesheet_row;?>][description]"><?php echo $timesheet['description'] ;?></textarea>																											
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
						<td style="width:15px;text-align:center;">#<?php echo $timesheet_row+1;?></td>
						<td style="width:80px;"><input required type="text" name="timesheet[<?php echo $timesheet_row;?>][assigned_by]" value="" /></td>
						<td style="width:80px;"><input  type="text" name="timesheet[<?php echo $timesheet_row;?>][ticket_number]" value="" /></td>
						<td style="width:80px;"><input  type="text" name="timesheet[<?php echo $timesheet_row;?>][client_name]"  value="" /></td>
						<td style="width:80px;"> 
							<div class="bootstrap-timepicker">
								<input required type="number" name="timesheet[<?php echo $timesheet_row;?>][time]" value="" class="timesheet-time" id="timepicker-<?php echo $timesheet_row;?>">
							</div>
						</td>
						<td colspan="2">
							<textarea required class="timesheet-desc" name="timesheet[<?php echo $timesheet_row;?>][description]"></textarea>
							<?php /* ?>							
								<?php if(empty($timesheets)){?>	
								<a class="btn btn-danger btn-xs" href="javascript:void(0);" onclick="remove_timesheet(<?php echo $timesheet_row;?>);"> Remove</a> 			
								<?php }elseif(!empty($timesheets) && $timesheets[0]['submit'] == 1) { ?>				
								<a class="btn btn-danger btn-xs" href="javascript:void(0);" onclick="remove_timesheet(<?php echo $timesheet_row;?>);"> Remove</a>
								<?php }elseif(!empty($timesheets) && $timesheets[0]['submit'] == 2) { ?>	
								<a class="btn btn-success btn-xs" href="javascript:void(0);"> Saved</a> 
								<?php } ?>
							<?php */ ?>							
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
			</div>
			
			<div class="box-footer">
			  <div class="pull-left">
				
			  </div>   

				<div class="total-time"><i class="fa fa-clock-o"></i> Total Time : <span id="total_time"><?php echo $total_time;?></span> Minutes </div>
				<div class="pull-right">
				
				<?php if(empty($timesheets)){?>
					<a class="btn btn-success" href="javascript:void(0);" onclick="add_timesheet();"> Add More </a> 
				<?php }elseif(!empty($timesheets) && $timesheets[0]['submit'] == 1) { ?>
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
	html+=	'<td style="text-align:center;">#'+parseInt(timesheet_row+1)+'</td>';
	html+=	'<td><input required type="text"  name="timesheet['+timesheet_row+'][assigned_by]" value="" /></td>';
	html+=	'<td><input  type="text"  name="timesheet['+timesheet_row+'][ticket_number]" value="" /></td>';
	html+=	'<td><input  type="text"  name="timesheet['+timesheet_row+'][client_name]"  value="" /></td>';
	html+=	'<td>'; 
	html+=		'<div class="bootstrap-timepicker">';
	//html+=			'<div class="form-group">';
	//html+=			  '<div class="input-group">';
	html+=					'<input required type="number" name="timesheet['+timesheet_row+'][time]" value="" class="ts" onkeypress="javascript:void(0);" id="timepicker_'+timesheet_row+'" id="timepicker-"'+timesheet_row+'">';
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

function valid_time(event){
	var time = event.value;
	if($.isNumeric(time) && (time % 1 === 0) ){
		return true;
	}else{
		alert("Please enter numeric and integer value only");
		event.value = "";
		
		$('.ts').val('');
	}
}

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