//Delete Employee

var customjs = {
	base_url : "http://"+location.host+"/versetal_ems_bkp_02_nov_2016/index.php", 
}
function update_activity_status(status,activity_id){	$.ajax({			url 		: customjs.base_url+"/otheractivity/update_activity_status",			data 		: {status:status,id:activity_id},			method 		: 'POST',			dataType	: "JSON",			beforeSend:function(response){				active();			},			success		:	function(response){						alert(response.message);				inactive();				location.reload();			},		});}



function clear_editor(){
	
	
    for ( instance in CKEDITOR.instances ){
        CKEDITOR.instances[instance].updateElement();
    }
    CKEDITOR.instances[instance].setData('');
	
}


function delete_feedback(feedback_id) {
	$.ajax({
		url 		: customjs.base_url+"/otheractivity/delete_feedback/",
		data 		: {feedback_id:feedback_id},
		method 		: 'POST',
		dataType	: "JSON",
		beforeSend:function(response){
			active();
		},
		success		:	function(response){
			
			var e = '';
			
			if(response.status){
				
				e += '<div class="alert alert-success alert-dismissible custom-alerts">';
				e += ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button> ';
				e += ' 	<h4><i class="icon fa fa-check"></i> Success!</h4>';
				e += response.message;
				e += '</div>';
				
				
				
			}else{
				e += '<div class="alert alert-danger alert-dismissible custom-alerts">';
				e += ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button> ';
				e += ' 	<h4><i class="icon fa fa-check"></i> Alert!</h4>';
				e += response.message;
				e += '</div>';
				
				$('#'+field_type).val("");
				$('#'+field_type).focus();
				
			
			}
			$('.sidebar-mini').after( e );
			inactive();
			location.reload();
		},
	});		
}


function fn_del_Emp( emp_id ){
	
	if(confirm("Are you sure to delete employee id "+emp_id+" ? ") ) {
		$.ajax({
			
			url 		: customjs.base_url+"/user/delete",
			data 		: {emp_id:emp_id},
			method 		: 'POST',
			dataType	: "JSON",
			beforeSend:function(response){
				active();
			},
			success		:	function(response){
				
				alert(response.message);
				inactive();
				location.reload();
			},
		});	
	}else{
		return;
	}
}
$(document).ajaxStart(function() { Pace.restart(); });


$(document).ready(function(){
	
	setTimeout(function() {
		$('.custom-alerts').fadeOut('slow');
	}, 1000);
	
	
	var e = '';
	$('#employee_id,#official_email,#email').on('blur',function(event){
		if($(this).val() == ''){
			return;
		}
		validate_field($(this).val() , $(this).attr('id') ,$(this));
	});
	
	$('#employee_id2,#official_email2 ,#email2').on('blur',function(event){
		if($(this).val() == ''){
			return;
		}
		validate_field2($(this).val() , $(this).attr('id') ,$('#emp_id').val(),$(this));
	});
	
});


function validate_field(field_value ,field_type,event) {
	$.ajax({
		url 		: customjs.base_url+"/user/validate_field",
		data 		: {field_value:field_value,field_type:field_type},
		method 		: 'POST',
		dataType	: "JSON",
		beforeSend:function(response){
			active();
		},
		success		:	function(response){
			
			var e = '';
			
			if(response.status){
				
				
				
				
				e += '<div class="alert alert-success alert-dismissible custom-alerts">';
				e += ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button> ';
				e += ' 	<h4><i class="icon fa fa-check"></i> Success!</h4>';
				e += response.message;
				e += '</div>';
				
				if(field_type == 'employee_id'){
					$('#validate_emp_id').removeClass('hidden');
					$('#validate_emp_id').removeClass('fa-remove text-danger');
					$('#validate_emp_id').addClass('fa-check text-success');
				}
				if(field_type == 'official_email'){
					$('#validate_emp_off_id').removeClass('hidden');
					$('#validate_emp_off_id').removeClass('fa-remove text-danger');
					$('#validate_emp_off_id').addClass('fa-check text-success');
				}
				
				if(field_type == 'email'){
					$('#validate_email_id').removeClass('hidden');
					$('#validate_email_id').removeClass('fa-remove text-danger');
					$('#validate_email_id').addClass('fa-check text-success');
				}
				
				
			}else{
				e += '<div class="alert alert-danger alert-dismissible custom-alerts">';
				e += ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button> ';
				e += ' 	<h4><i class="icon fa fa-check"></i> Alert!</h4>';
				e += response.message;
				e += '</div>';
				
				if(field_type == 'employee_id'){
					$('#validate_emp_id').removeClass('hidden');
					$('#validate_emp_id').removeClass('fa-check text-success');
					$('#validate_emp_id').addClass('fa-remove text-danger');
				}
				if(field_type == 'official_email'){
					$('#validate_emp_off_id').removeClass('hidden');
					$('#validate_emp_off_id').removeClass('fa-remove text-success');
					$('#validate_emp_off_id').addClass('fa-remove text-danger');
				}
				
				if(field_type == 'email'){
					$('#validate_email_id').removeClass('hidden');
					$('#validate_email_id').removeClass('fa-remove text-success');
					$('#validate_email_id').addClass('fa-remove text-danger');
				}
				
				$('#'+field_type).val("");
				$('#'+field_type).focus();
				
			
			}
			//$('.sidebar-mini').after( e );
			inactive();
		},
	});		
}



function validate_field2(field_value ,field_type,emp_id , event) {
	
	if ($('#official_email2').val() == $('#email2').val()) {  
		$('#email2').val('');
		$('#official_email2').val('');
		
		alert("Official e-mail & Personal e-mail can't be same");
		$('#validate_email_id').removeClass('fa-check text-success');
		$('#validate_email_id').addClass('fa-remove text-danger');
		$('#validate_emp_off_id').removeClass('fa-check text-success');
		$('#validate_emp_off_id').addClass('fa-remove text-danger');
		return;
	}	
	
	
	$.ajax({
		url 		: customjs.base_url+"/user/validate_field2",
		data 		: {field_value:field_value,field_type:field_type ,emp_id:emp_id },
		method 		: 'POST',
		dataType	: "JSON",
		beforeSend:function(response){
			active();
		},
		success		:	function(response){
			
			var e = '';
			
			if(response.status){ 
				
		
				
				if(field_type == 'employee_id2'){
					$('#validate_emp_id').removeClass('hidden');
					$('#validate_emp_id').removeClass('fa-remove text-danger');
					$('#validate_emp_id').addClass('fa-check text-success');
				}
				if(field_type == 'official_email2'){
					$('#validate_emp_off_id').removeClass('hidden');
					$('#validate_emp_off_id').removeClass('fa-remove text-danger');
					$('#validate_emp_off_id').addClass('fa-check text-success');
				}
				if(field_type == 'email2'){
					$('#validate_email_id').removeClass('hidden');
					$('#validate_email_id').removeClass('fa-remove text-danger');
					$('#validate_email_id').addClass('fa-check text-success');
				}
				
				
				
			}else{
				
				
				if(field_type == 'employee_id2'){
					$('#validate_emp_id').removeClass('hidden');
					$('#validate_emp_id').removeClass('fa-check text-success');
					$('#validate_emp_id').addClass('fa-remove text-danger');
				}
				
				if(field_type == 'official_email2'){
					$('#validate_emp_off_id').removeClass('hidden');
					$('#validate_emp_off_id').removeClass('fa-remove text-success');
					$('#validate_emp_off_id').addClass('fa-remove text-danger');
				}
				if(field_type == 'email2'){
					$('#validate_email_id').removeClass('hidden');
					$('#validate_email_id').removeClass('fa-remove text-success');
					$('#validate_email_id').addClass('fa-remove text-danger');
				}
				
				$('#'+field_type).val("");
				$('#'+field_type).focus();
				
				$('#'+field_type).focus();
				
			
			}
			//$('.sidebar-mini').after( e );
			inactive();
		},
	});		
}




function resetpass(id) {
	
	var password = $('#reset_user_password').val();
	
	
	
	$.ajax({
		url 		: customjs.base_url+"/user/resetpass",
		data 		: {id:id,password:password},
		method 		: 'POST',
		dataType	: "JSON",
		beforeSend:function(response){
			active();
		},
		success		:	function(response){
			
			var e = '';
			
			if(response.status){
				
				e += '<div class="alert alert-success alert-dismissible custom-alerts">';
				e += ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button> ';
				e += ' 	<h4><i class="icon fa fa-check"></i> Success!</h4>';
				e += response.message;
				e += '</div>';
				
				
				
			}else{
				e += '<div class="alert alert-danger alert-dismissible custom-alerts">';
				e += ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button> ';
				e += ' 	<h4><i class="icon fa fa-check"></i> Alert!</h4>';
				e += response.message;
				e += '</div>';
			}
			$('.sidebar-mini').after( e );
			inactive();
			
			$('#reset_user_password').val('');
			
			$('.edit-close').trigger('click');
			$("html, body").animate({ scrollTop: 0 }, "slow");
		},
	});		
}


function delete_activity(id){
	
	
	if(confirm("Are you sure to delete Item id "+id+" ? ") ) {
	$.ajax({
			
			url 		: customjs.base_url+"/otheractivity/delete_misc",
			data 		: {id:id},
			method 		: 'POST',
			dataType	: "JSON",
			beforeSend:function(response){
				active();
			},
			success		:	function(response){
				
				var e = '';
				
				if(response.status){
					
					e += '<div class="alert alert-success alert-dismissible custom-alerts">';
					e += ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button> ';
					e += ' 	<h4><i class="icon fa fa-check"></i> Success!</h4>';
					e += response.message;
					e += '</div>';
					
					location.reload();
					
				}else{
					e += '<div class="alert alert-danger alert-dismissible custom-alerts">';
					e += ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button> ';
					e += ' 	<h4><i class="icon fa fa-check"></i> Alert!</h4>';
					e += response.message;
					e += '</div>';
				}
				$('.sidebar-mini').after( e );
				inactive();
			},
		});	
	}else{
		return;
	}
}

 


function change_timesheet_status(id,from){
	
	var to 		= '';
	var from_text 		= '';
	var to_text 		= '';
	if(from == 2){
		from_text = 'Submit';
		to_text 	= 'Save Only';
		to = 1;
	}else{
		from_text = 'Save';
		to_text 	= 'Submit';
		to = 2;
	}
	
	
	
	
	
	if(confirm("Are you sure to change status from "+from_text+" to "+ to_text +" ? ") ) {
	$.ajax({
			
			url 		: customjs.base_url+"/user/change_timesheet_status",
			data 		: {id:id,from:from,to:to},
			method 		: 'POST',
			dataType	: "JSON",
			beforeSend:function(response){
				active();
			},
			success		:	function(response){
				
				var e = '';
				
				if(response.status){
					
					e += '<div class="alert alert-success alert-dismissible custom-alerts">';
					e += ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button> ';
					e += ' 	<h4><i class="icon fa fa-check"></i> Success!</h4>';
					e += response.message;
					e += '</div>';
					
					location.reload();
					
				}else{
					e += '<div class="alert alert-danger alert-dismissible custom-alerts">';
					e += ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button> ';
					e += ' 	<h4><i class="icon fa fa-check"></i> Alert!</h4>';
					e += response.message;
					e += '</div>';
				}
				$('.sidebar-mini').after( e );
				inactive();
			},
		});	
	}else{
		return;
	}
}


function delete_policy(id){
	
	
	if(confirm("Are you sure to delete policy id "+id+" ? ") ) {
	$.ajax({
			
			url 		: customjs.base_url+"/policy/delete_policy",
			data 		: {id:id},
			method 		: 'POST',
			dataType	: "JSON",
			beforeSend:function(response){
				active();
			},
			success		:	function(response){
				
				var e = '';
				
				if(response.status){
					
					e += '<div class="alert alert-success alert-dismissible custom-alerts">';
					e += ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button> ';
					e += ' 	<h4><i class="icon fa fa-check"></i> Success!</h4>';
					e += response.message;
					e += '</div>';
					
					location.reload();
					
				}else{
					e += '<div class="alert alert-danger alert-dismissible custom-alerts">';
					e += ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button> ';
					e += ' 	<h4><i class="icon fa fa-check"></i> Alert!</h4>';
					e += response.message;
					e += '</div>';
				}
				$('.sidebar-mini').after( e );
				inactive();
			},
		});	
	}else{
		return;
	}
}


function appreciate(id){
	$.ajax({
			
			url 		: customjs.base_url+"/user/appreciate",
			data 		: {id:id},
			method 		: 'POST',
			dataType	: "JSON",
			beforeSend:function(response){
				active();
			},
			success		:	function(response){
				
				var e = '';
				
				if(response.status){
					
					e += '<div class="alert alert-success alert-dismissible custom-alerts">';
					e += ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button> ';
					e += ' 	<h4><i class="icon fa fa-check"></i> Success!</h4>';
					e += response.message;
					e += '</div>';
					
					location.reload();
					
				}else{
					e += '<div class="alert alert-danger alert-dismissible custom-alerts">';
					e += ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button> ';
					e += ' 	<h4><i class="icon fa fa-check"></i> Alert!</h4>';
					e += response.message;
					e += '</div>';
				}
				

				$('.sidebar-mini').after( e );
				
				
				inactive();
			},
		});	
}


function approve(user_id,leave_id){
	if(confirm("Are you sure to APPROVE this leave ?") ) {
		$.ajax({
			
			url 		: customjs.base_url+"/leave/approve",
			data 		: {user_id:user_id,leave_id:leave_id},
			method 		: 'POST',
			dataType	: "JSON",
			beforeSend:function(response){
				active();
			},
			success		:	function(response){
				
				var e = '';
				
				if(response.status){
					
					e += '<div class="alert alert-success alert-dismissible custom-alerts">';
					e += ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button> ';
					e += ' 	<h4><i class="icon fa fa-check"></i> Success!</h4>';
					e += response.message;
					e += '</div>';
					
					location.reload();
					
				}else{
					e += '<div class="alert alert-danger alert-dismissible custom-alerts">';
					e += ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button> ';
					e += ' 	<h4><i class="icon fa fa-check"></i> Alert!</h4>';
					e += response.message;
					e += '</div>';
				}
				

				$('.sidebar-mini').after( e );
				
				
				inactive();
			},
		});	
	}else{
		return;
	}
}
function disapprove(user_id,leave_id){
	if(confirm("Are you sure to DISAPPROVE this leave ?") ) {
		$.ajax({
			
			url 		: customjs.base_url+"/leave/disapprove",
			data 		: {user_id:user_id,leave_id:leave_id},
			method 		: 'POST',
			dataType	: "JSON",
			beforeSend:function(response){
				active();
			},
			success		:	function(response){
				
				var e = '';
				
				if(response.status){
					
					e += '<div class="alert alert-success alert-dismissible custom-alerts">';
					e += ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button> ';
					e += ' 	<h4><i class="icon fa fa-check"></i> Success!</h4>';
					e += response.message;
					e += '</div>';
					
					location.reload();
					
				}else{
					e += '<div class="alert alert-danger alert-dismissible custom-alerts">';
					e += ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button> ';
					e += ' 	<h4><i class="icon fa fa-check"></i> Alert!</h4>';
					e += response.message;
					e += '</div>';
				}
				

				$('.sidebar-mini').after( e );
				
				
				inactive();
			},
		});	
	}else{
		return;
	}
}



function calendar_event(new_event){
	new_event.type = 'add_event';
	var event_id = null;
	//console.log(cp);
	$.ajax({
		url 		: customjs.base_url+"/otheractivity/calendar_event",
		data 		: {calendar_params:new_event},
		method 		: 'POST',
		dataType	: "JSON",
		beforeSend:function(){
			active();
		},
		success		:	function(response){
			if(parseInt(response.status) == 1){ 
				event_id =  response.event_id; 
			}
		}
	}); 
	//console.log( event_id );
	return event_id;
}

function active(){
	$('.pace').removeClass("pace-inactive");
	$('.pace').addClass("pace-active");
}

function inactive(){
	$('.pace').addClass("pace-inactive");
	$('.pace').removeClass("pace-active");
}

$(document).ready(function(){
	
	
	$('.save-submit').click(function(event){
		
		if($('#timesheet_date').val() == ''){
			
			var e  = '<div class="alert alert-danger alert-dismissible custom-alerts">';
						e += ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button> ';
						e += ' 	<h4><i class="icon fa fa-check"></i> Alert!</h4>';
						e += 'Please select the time sheet date';
						e += '</div>';
						
			$('.sidebar-mini').after( e );
			$('#timesheet_date').focus();
			
			event.preventDefault();
			return;
		}
		
		
	});
	
	
	
	$('.email').blur(function() {
		
		if ($('#official_email').val() == $('#email').val()) {  
			$('#email').val('');
			$('#official_email').val('');
			$('.help-block').removeClass('hidden');
			$('.help-block').text("Official e-mail & Personal e-mail can't be same ");
			$('#validate_email_id').addClass('fa-remove text-danger');
			$('#validate_emp_off_id').addClass('fa-remove text-danger');
			
			
			$('.fg').addClass('has-error');
		} else { 	
			$('.help-block').addClass('hidden');
			$('.fg').removeClass('has-error');
		}
	});
	$('.email2_bkp').blur(function() {
		
		
		
		if ($('#official_email2').val() == $('#email2').val()) {  
			$('#email2').val('');
			$('#official_email2').val('');
			
			alert("Official e-mail & Personal e-mail can't be same");
			$('#validate_email_id').removeClass('fa-check text-success');
			$('#validate_email_id').addClass('fa-remove text-danger');
			$('#validate_emp_off_id').removeClass('fa-check text-success');
			$('#validate_emp_off_id').addClass('fa-remove text-danger');
			
		}	
	});
	
	$("#phone,#emergency_contact,#zipcode,.timesheet-time,.vms-phone,#account_number").keydown(function (e) {
		// Allow: backspace, delete, tab, escape, enter and .
		if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
			 // Allow: Ctrl+A, Command+A
			(e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
			 // Allow: home, end, left, right, down, up
			(e.keyCode >= 35 && e.keyCode <= 40)) {
				 // let it happen, don't do anything
				 return;
		}
		// Ensure that it is a number and stop the keypress
		if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
			e.preventDefault();
		}
	});
	
	$('.char-field').keydown(function(e){ 
		// Allow: backspace, delete, tab, escape, enter and .
		if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
			 // Allow: Ctrl+A, Command+A
			(e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 
			 // Allow: home, end, left, right, down, up
			(e.keyCode >= 35 && e.keyCode <= 40)) {
				 // let it happen, don't do anything
				 return;
		}
		// Ensure that it is a number and stop the keypress
		if ((e.shiftKey || ( (e.keyCode > 0 ) && (e.keyCode < 65) ) || (e.keyCode > 90 && e.keyCode < 97) || (e.keyCode >122)  )) {
			e.preventDefault();
		}
	});
	
	
	setTimeout(function() {      $('.close').trigger('click');    }, 3000);
	$('#pay-salary').click(function(){
	
		var emp_id 	= $('#emp_id').val();	
		var salary_id 	= $('#salary_id').val();
		
		$.ajax({
			url: customjs.base_url+'/salary/pay', // point to server-side PHP script 
			dataType: 'JSON',  // what to expect back from the PHP script, if anything
			data: {emp_id:emp_id,salary_id:salary_id},                         
			type: 'POST',
			beforeSend:function(response){
				active();
			},
			success: function(response){
				if(response.status == 1){
					location.reload();
				} else{
					var e  = '<div class="alert alert-danger alert-dismissible custom-alerts">';
						e += ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button> ';
						e += ' 	<h4><i class="icon fa fa-check"></i> Alert!</h4>';
						e += response.message;
						e += '</div>';
						
					$('.sidebar-mini').after( e );
				} 
		
				inactive();
				
			}
		});
	
	});
	
	
	$('#salary_slip_button').on('click', function() {
	
		//console.log("assd");
		
		var file_data = $('#salary_slip').prop('files')[0];   
		var form_data = new FormData();  

		var salary_month 	= $('#salary_month').val();	
		var salary_year 	= $('#salary_year').val();	
		var emp_id 			= $('#emp_id').val();	
		
		/* if(salary_month  == '' || salary_year == '' || file_data == ''){
			alert("Please Select Month And Year");
			return;
		} */
		
		
		form_data.append('file', file_data);
		form_data.append('salary_month', salary_month);
		form_data.append('salary_year', salary_year);
		form_data.append('emp_id', emp_id);
		
		
		
		
		$.ajax({
			url: customjs.base_url+'/salary/upload_salary_slip', // point to server-side PHP script 
			dataType: 'JSON',  // what to expect back from the PHP script, if anything
			cache: false,
			contentType: false,
			processData: false,
			data: form_data,                         
			type: 'POST',
			beforeSend:function(response){
				active();
			},
			success: function(response){
				if(response.status == 1){
					
					var s  = '<div class="alert alert-success alert-dismissible custom-alerts">';
						s += ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button> ';
						s += ' 	<h4><i class="icon fa fa-check"></i> Alert!</h4>';
						s += response.message;
						s += '</div>';
					$('.sidebar-mini').after( s );
					location.reload();
				} else{
					var e  = '<div class="alert alert-danger alert-dismissible custom-alerts">';
						e += ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button> ';
						e += ' 	<h4><i class="icon fa fa-check"></i> Alert!</h4>';
						e += response.message;
						e += '</div>';
						
					$('.sidebar-mini').after( e );
				} 

				inactive();
			}
		});
	});
});





$(document).ready(function(){
	$('.publish').click(function(){
		
		//var id = $('#id').val();
		
		//if(id){
			
		if(confirm("Are you sure to save publish this Policy ?")){
			$('#publish').val(1);
			$('#policy_form').submit();
		
		}else{
			return;
		}
		//}
		/* else{
			var e  = '<div class="alert alert-danger alert-dismissible custom-alerts">';
					e += ' <button type="button" class="close" data-dismiss="alert" aria-hidden="true">X</button> ';
					e += ' 	<h4><i class="icon fa fa-check"></i> Alert!</h4>';
					e += '  Please save the policy first !';
					e += '</div>';
					
				$('.sidebar-mini').after( e );
		} */
		
		
	});
	
	
});

$(document).ready(function(){
	$('.leave-class').keyup(function(){
		var yearly_leaves = $(this).val();
		var monthly_leaves = parseFloat(yearly_leaves/12).toFixed(2);
		
		var id = $(this).attr('alt');
		
		$('#leave_'+id).text(monthly_leaves);
		$('#eleave_'+id).val(monthly_leaves);
		
	});
});
  