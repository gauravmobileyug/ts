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
	.custom-td-color{
		background-color: #17794c;
		border-radius: 20px;
	}
	.fc-event-container{
		/*display:none !important;*/
	}
	.fc-day-grid-event{
		background-color: rgb(0, 80, 43) !important;
		border-color: rgb(0, 80, 43) !important;
		text-align: center;
	}
.fc-content{

    position: absolute;
    bottom: -1px;
    right: -2px;
    float: left;
    /* overflow: hidden; */
    width: 16px;
    height: 16px;

}
.fc-title{
    position: absolute;
    /* top: 0; */
    left: 0;
    /* display: inline-block; */
    margin-left: -1px;
    width: 0;
    height: 0;
    border-bottom: 16px solid #00502b;
    border-left: 16px solid transparent;
}
.fc-day-grid-event{
	border:0px;
}
.fc-event-container:hover thead td{
	background-color : red;
}
.bg-green-gradient{
	color: #050505;
	background: white !important;
}
.fc-state-default{
	color: #090808 !important;
}
.box.box-solid[class*='bg']>.box-header {
	color: #090808 !important;
}
.fc-button:hover, .fc-button:active, .fc-button.hover {
    background-color: rgba(34, 45, 50, 0.12) !important;
}
	</style>
	
	
	
<div class="col-md-4">



	<div id="caledar-events" class="modal fade" role="dialog">	
		<form name="emp-of-month" action="" id="feedback_form" method="POST" enctype="multipart/form-data">	
			<div class="modal-dialog">	
				<div class="modal-content" style="width: 718px;">	
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h4 class="modal-title">Calendar Event Description</h4>	
					</div>			  		
					<div class="modal-body" style="height: auto; width: 715px;">
					
						<p id="event-title"></p>		
				
						</form>	
					</div>	
					<div class="modal-footer">	
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>	
					</div>		
				</div>	
			</div>	
		</form>
	</div>




  <div class="box box-solid bg-green-gradient">
	<div class="box-header with-border" style="    background: #242a30!important;">
		  <i class="fa fa-calendar" style="color:white;"></i>

		  <h3 class="box-title" style="color:white">Calendar</h3>
		  
		  <!-- <div class="box-tools pull-right">
			<button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
			</button>
		 
			<button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
  </div> -->
	</div>
  
  
	<div class="box-body no-padding">
	  <!-- THE CALENDAR -->
	  <div id="calendar"></div>
	</div>
	<!-- /.box-body -->
  </div>
  <!-- /. box -->
</div>

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
				success: function(response){
					json_events = response;
				}
			});

			/* $('#calendar').fullCalendar({
				//events: JSON.parse(json_events)
			}); */
		  
		}

		ini_events($('#external-events div.external-event'));
	  
		
		$('#calendar').fullCalendar({
		  header: {
		   // left: 'prevYear,nextYear',
		    center: 'title'
		   // right: 'month,agendaWeek,agendaDay'
		  },
		  buttonText: {
			today: 'today',
			month: 'month',
			week: 'week',
			day: 'day'
		  //  prevYear: 'Prev Year',
		  //  nextYear: 'Next Year'
		  },
		   //Random default events
		  events:JSON.parse(json_events),
		});
	 });	
	 
	 </script>
	 
	 <script>
	function call_me( index ,title){
		$('#event-title').text( title );
		$('#caledar-events').modal('show');
	}
	$(document).ready(function(){
		
		
		
		$('.fc-corner-right,.fc-corner-left').click(function(){
			$('.fc-title').each(function( index ) {
				var title = $( this ).text();
				title = title.replace(/'/g, "\\'");
				$( this ).text('');
				$( this ).attr("onclick" , "call_me('"+index+"','"+title+"')");
				//$( this ).attr("data-placement" , "top");
				$( this ).css("cursor" , "pointer");
				$( this ).attr("title" , title);
			});
			
			$('.fc-day-grid-event').each(function( index ) {
				//var title = $( this ).text();
				//$( this ).text('');
				//$( this ).attr("data-toggle" , "tooltip");
				//$( this ).attr("data-placement" , "top");
				//$( this ).css("cursor" , "pointer");
				//$( this ).attr("title" , title);
			});
		});
		
		
		
		$('.fc-title').each(function( index ) {
			var title = $( this ).text();
			title = title.replace(/'/g, "\\'");
			$( this ).text('');
			$( this ).attr("onclick" , "call_me('"+index+"','"+title+"')");
			//$( this ).attr("data-placement" , "top");
			$( this ).css("cursor" , "pointer");
			$( this ).attr("title" , title);
		});
		
		$('.fc-day-grid-event').each(function( index ) {
			//var title = $( this ).text();
			//$( this ).text('');
			//$( this ).attr("data-toggle" , "tooltip");
			//$( this ).attr("data-placement" , "top");
			//$( this ).css("cursor" , "pointer");
			//$( this ).attr("title" , title);
		});
		
		
		
		/* 
		
		$('.fc-day-grid-event').attr("data-toggle" , "tooltip");
		$('.fc-day-grid-event').attr("data-placement" , "top");
		$('.fc-title').attr("data-toggle" , "tooltip");
		$('.fc-title').attr("data-placement" , "top");
		$('.fc-title').css("cursor" , "pointer");
		$('.fc-day-grid-event').attr("title" , title);
		$('.fc-title').attr("title" , title);
		 */
		
	});
		
	</script>
	 
	