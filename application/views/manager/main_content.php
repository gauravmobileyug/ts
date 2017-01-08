<link rel="stylesheet" href="<?php echo base_url('assets/plugins/fullcalendar/fullcalendar.min.css');?>">
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/fullcalendar/fullcalendar.print.css');?>" media="print">

<style>
	.fc-day-grid-container{height:auto!important;overflow:auto;}
	.box-header.with-border{border-width:0;}
	.fc-today-button{display:none;}
        .fc-left h2{display:none;}
        .fc-toolbar{margin-bottom:0;position:relative;padding-top:0;}
        .fc-toolbar .fc-right{float:none;}
        .fc-toolbar .fc-button-group{width:100%;    margin-left: 0;}
        .fc-state-default.fc-corner-right{float:right!important;}
        .fc-toolbar .fc-center{position:absolute;top:6px;left:35%;}
	.fc-center h2{font-size:15px;font-weight:bold;}
	.fc-widget-header, .fc-unthemed .fc-today{background: transparent;}
	.fc-ltr .fc-basic-view .fc-day-number{text-align: center;font-size: 14px;font-weight: 400;}
	.fc td, .fc th{border-width:0px;}
	.fc-basic-view tbody .fc-row{min-height:2em;}
	.fc-state-default{background-color: transparent;background-image: none;box-shadow: inset 0 0px 0 rgba(255,255,255,.2),0 0px 0px rgba(0,0,0,.05);color: #ffffff;border-color: transparent;}
	.fc-button:hover, .fc-button:active, .fc-button.hover{background:rgba(0,0,0,0.2)}
	</style>
	
<div class="content-wrapper">    <!-- Content Header (Page header) -->	<?php //fn_ems_debug($user_data); ?>    <section class="content-header">      <h1>        Dashboard      </h1>      <?php /* <ol class="breadcrumb">        <li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a></li>        <li class="active">Dashboard</li>      </ol>  */ ?>   </section>    <!-- Main content -->    <section class="content">      <div class="row">        <!-- <div class="col-md-3">                   <div class="box box-primary">            <div class="box-body box-profile">              <img class="profile-user-img img-responsive img-circle" src="<?php echo base_url($user_data['profile_pic']);?>" alt="User profile picture">              <h3 class="profile-username text-center"><?php echo ucfirst($user_data['firstname'].' '.$user_data['lastname']);?></h3>              <p class="text-muted text-center"><?php echo ucfirst($user_data['user_designation_description']);?></p>				           			            <a href="#" class="btn btn-primary btn-block" data-toggle="modal" data-target="#myModal"><b>Upload Profile Picture</b></a>            </div>                     </div>				<div id="myModal" class="modal fade" role="dialog">		  <div class="modal-dialog">						<div class="modal-content">							  <div class="modal-header">				<button type="button" class="close" data-dismiss="modal">&times;</button>				<h4 class="modal-title">Upload Profile Picture</h4>			  </div>			  			  <div class="modal-body" style="height: 85px;">				<form name="profile_pic" action="<?php echo site_url("user/upload_pic");?>" id="profile_form" method="POST" enctype="multipart/form-data">					<p style="float:left">						<input type="file"  id="profile_pic" name="profile_pic" class="file">									</p>					<p style="float:right">						<a href="#" class="btn btn-primary" onclick="$('#profile_form').submit();">							<i class="fa fa-upload"></i>							Upload						</a>					</p>				</form>			  </div>			  <div class="modal-footer">				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>			  </div>			</div>		  </div>		</div>		         </div> -->        <!-- /.col -->        <div class="col-md-12">         <div class="row">						<!-- Total Employees -->						<div class="col-lg-3 col-xs-6">			  <!-- small box -->			  <div class="small-box bg-yellow">				<div class="inner">				  <h3><?php echo $count_employees;?></h3>				  <p>Total Employees</p>				</div>				<div class="icon">				  <i class="fa fa-user"></i>				</div>				<a href="<?php echo site_url('user/list_employees');?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>			  </div>			</div>									<!-- Total Policies -->						<div class="col-lg-3 col-xs-6">			  <!-- small box -->			  <div class="small-box bg-green">				<div class="inner">				  <h3><?php echo $count_policies;?><sup style="font-size: 20px"></sup></h3>				  <p>Total Policies</p>				</div>				<div class="icon">				  <i class="fa fa-book"></i>				</div>				<a href="<?php echo site_url('policy/list_policy');?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>			  </div>			</div>																					<div class="col-lg-3 col-xs-6">			  <!-- small box -->			  <div class="small-box bg-red">				<div class="inner">				  <h3><?php echo $count_leaves;?><sup style="font-size: 20px"></sup></h3>				  <p>Leave Reports</p>				</div>				<div class="icon">				  <i class="fa fa-pie-chart"></i>				</div>				<a href="<?php echo site_url('user/list_manager_employees/'.$user_data['id']);?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>			  </div>			</div>															 <div class="col-lg-3 col-xs-6">
							
							<div class="small-box bg-aqua">
								<div class="inner">
									<h3><?php echo count($user_data['activities']);?><sup style="font-size: 20px"></sup></h3>
									<p>Activities</p>
								</div>
								<div class="icon"> <i class="fa fa-linux"></i> </div>
									<?php if(count($user_data['activities'])):?>
									<a href="<?php echo site_url('otheractivity/view_activity/'.$user_data['activities'][0]['id']);?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
									<?php else:?>
						<a href="<?php echo site_url('otheractivity/activities');?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
									<?php endif;?>
							</div>
						</div>								 </div>		 <!--		 <div class="row">			<div class="col-xs-12">				<?php //$this->load->view('other/search_employee'); ?>			</div>		</div>		-->        </div>      </div>
			<div class="row">
				<?php $this->load->view('common/thoughts') ;?>
				<?php $this->load->view('common/carousel') ;?>
			</div>
			
			<div class="row">
				<?php $this->load->view('common/emp_of_month') ;?>
				<?php $this->load->view('common/feedback_appraisal') ;?>	
				<?php $this->load->view('common/calendar') ;?>		
			</div>
			
			<div class="row">
				<?php $this->load->view('common/birthdays') ;?>
				<?php $this->load->view('common/todo') ;?>	
				
			</div> </section>  </div>


<script>
  $(function () {

    /* initialize the external events
     -----------------------------------------------------------------*/
    function ini_events(ele) {
      ele.each(function () {

        // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
        // it doesn't need to have a start or end
        var eventObject = {
          title: $.trim($(this).text()) // use the element's text as the event title
        };

        // store the Event Object in the DOM element so we can get to it later
        $(this).data('eventObject', eventObject);

        // make the event draggable using jQuery UI
        $(this).draggable({
          zIndex: 1070,
          revert: true, // will cause the event to go back to its
          revertDuration: 0  //  original position after the drag
        });

      });
	  
	  
		$.ajax({
			url: customjs.base_url+"/otheractivity/fetch_calendar_events",
			type: 'POST',
			data: 'type=fetch',
			async: false,
			beforeSend:function(response){
				active();
			},
			success: function(response){
				json_events = response;
				inactive();
			}
		});

		/* $('#calendar').fullCalendar({
			//events: JSON.parse(json_events)
		}); */
	  
    }

    ini_events($('#external-events div.external-event'));
  
	
    $('#calendar').fullCalendar({
      header: {
      //  left: 'prevYear,nextYear',
        center: 'title'
       // right: 'month,agendaWeek,agendaDay'
      },
      buttonText: {
        today: 'today',
        month: 'month',
        week: 'week',
        day: 'day',
      //  prevYear: 'Prev Year',
      //  nextYear: 'Next Year'
      },
       //Random default events
	  events:JSON.parse(json_events),
	});
 });
 
 </script>