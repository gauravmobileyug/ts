
	<form method="GET" action="<?php echo site_url('report/leave_reports');?>">
		<table class="table no-margin">
			<tbody>
			
				<tr>
				  
				  <td><input type="text" class="form-control" name="search[from_date]" id="from_date"  value="<?php echo isset($search_params['from_date']) ? $search_params['from_date']:''?>" placeholder="From Date" autocomplete="off"/></td>
				  
				  
				  <td><input type="text" class="form-control" name="search[to_date]" id="to_date"  value="<?php echo isset($search_params['to_date']) ? $search_params['to_date']:''?>" placeholder="To Date" autocomplete="off"/></td>
				  
				  
				  <td><input type="text" class="form-control" name="search[name]" id="name" placeholder="Employee Name"  value="<?php echo isset($search_params['name']) ? $search_params['name']:''?>" autocomplete="off" /></td>
				  
				  <td><button type="submit" name="submit" value="1" class="btn btn-primary  pull-right"><i class="fa   fa-search"></i>  Search</button></td>
				</tr>
			
			</tbody>
		</table>
	</form>
	
	

<script src="<?php echo base_url('assets/dist/js/moment.min.js');?>"></script>
<script src="<?php echo base_url('assets/plugins/datepicker/bootstrap-datepicker.js');?>"></script>

<script>
$(function(){	
	$('#from_date , #to_date').datepicker({
	  autoclose: true,
	  format: 'yyyy-mm-dd',
	});

});
</script>