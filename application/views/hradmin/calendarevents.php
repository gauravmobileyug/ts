<link rel="stylesheet" href="<?php echo base_url('assets/plugins/fullcalendar/fullcalendar.min.css');?>">
<link rel="stylesheet" href="<?php echo base_url('assets/plugins/fullcalendar/fullcalendar.print.css');?>" media="print">
<div class="content-wrapper">
	<section class="content-header">
		<h1>       Add Events On Calendar    </h1>
		<ol class="breadcrumb">
			<li><a href="<?php echo site_url();?>"><i class="fa fa-dashboard"></i> Home</a>
			</li>
			<li class="active">Calendar Events</li>
		</ol>
	</section>
	<!-- Main content -->
	<section class="content">
	<div class="row">
	 <!-- Main content -->
	<section class="content">
	  <div class="row">

		<div class="col-md-3">
		  <div class="box box-solid">
			<div class="box-header with-border">
			  <h4 class="box-title">Draggable Events</h4>
			</div>
			<div class="box-body">
			  <!-- the events -->
			  <div id="external-events">
				<div class="external-event bg-green">Lunch</div>
				<div class="external-event bg-yellow">Go home</div>
				<div class="external-event bg-aqua">Do homework</div>
				<div class="external-event bg-light-blue">Work on UI design</div>
				<div class="external-event bg-red">Sleep tight</div>
				<div class="checkbox">
				  <label for="drop-remove">
					<input type="checkbox" id="drop-remove">
					remove after drop
				  </label>
				</div>
			  </div>
			</div>
			<!-- /.box-body -->
		  </div>
		  <!-- /. box -->
		  <div class="box box-solid">
			<div class="box-header with-border">
			  <h3 class="box-title">Create Event</h3>
			</div>
			<div class="box-body">
			  <div class="btn-group" style="width: 100%; margin-bottom: 10px;">
				<!--<button type="button" id="color-chooser-btn" class="btn btn-info btn-block dropdown-toggle" data-toggle="dropdown">Color <span class="caret"></span></button>-->
				<ul class="fc-color-picker" id="color-chooser">
				  <li><a class="text-aqua" href="#"><i class="fa fa-square"></i></a></li>
				  <li><a class="text-blue" href="#"><i class="fa fa-square"></i></a></li>
				  <li><a class="text-light-blue" href="#"><i class="fa fa-square"></i></a></li>
				  <li><a class="text-teal" href="#"><i class="fa fa-square"></i></a></li>
				  <li><a class="text-yellow" href="#"><i class="fa fa-square"></i></a></li>
				  <li><a class="text-orange" href="#"><i class="fa fa-square"></i></a></li>
				  <li><a class="text-green" href="#"><i class="fa fa-square"></i></a></li>
				  <li><a class="text-lime" href="#"><i class="fa fa-square"></i></a></li>
				  <li><a class="text-red" href="#"><i class="fa fa-square"></i></a></li>
				  <li><a class="text-purple" href="#"><i class="fa fa-square"></i></a></li>
				  <li><a class="text-fuchsia" href="#"><i class="fa fa-square"></i></a></li>
				  <li><a class="text-muted" href="#"><i class="fa fa-square"></i></a></li>
				  <li><a class="text-navy" href="#"><i class="fa fa-square"></i></a></li>
				</ul>
			  </div>
			  <!-- /btn-group -->
			  <div class="input-group">
				<input id="new-event" type="text" class="form-control" placeholder="Event Title">

				<div class="input-group-btn">
				  <button id="add-new-event" type="button" class="btn btn-primary btn-flat">Add</button>
				</div>
				<!-- /btn-group -->
			  </div>
			  <!-- /input-group -->
			</div>
		  </div>
		</div>
		<!-- /.col -->
		<div class="col-md-9">
		  <div class="box box-primary">
			<div class="box-body no-padding">
			  <!-- THE CALENDAR -->
			  <div id="calendar"></div>
			</div>
			<div class="box-footer clearfix">
             
			</div>
			<!-- /.box-body -->
		  </div>
		  <!-- /. box -->
		</div>
		<!-- /.col -->
	  </div>
	  <!-- /.row -->
	</section>
	<!-- /.content -->
	</div>
	</section>
	<!-- /.content -->
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

    /* initialize the calendar
     -----------------------------------------------------------------*/
    //Date for the calendar events (dummy data)
	var zone = "05:30";
    var date = new Date();
    var d = date.getDate(),
        m = date.getMonth(),
        y = date.getFullYear();
	var copiedEventObject = null;	
    $('#calendar').fullCalendar({
      header: {
        left: 'prevYear,nextYear',
        center: 'title'
       // right: 'month,agendaWeek,agendaDay'
      },
      buttonText: {
        today: 'today',
        month: 'month',
        week: 'week',
        day: 'day',
        prevYear: 'Prev Year',
        nextYear: 'Next Year'
      },
       //Random default events
	  events:JSON.parse(json_events),
	  /*
      events: [
        {
          title: 'All Day Event',
          start: new Date(y, m, 1),
          backgroundColor: "#f56954", //red
          borderColor: "#f56954" ,
		  eventStartEditable: true, // this allows things to be dropped onto the calendar !!!
		  eventDurationEditable: true
        },
        {
          title: 'Long Event',
          start: new Date(y, m, d - 5),
          end: new Date(y, m, d - 2),
          backgroundColor: "#f39c12", //yellow
          borderColor: "#f39c12", //yellow
		  allDay: false,
		  eventStartEditable: true, // this allows things to be dropped onto the calendar !!!
		  eventDurationEditable: true
        },
        
      ], */
      editable: true,
      droppable: true, // this allows things to be dropped onto the calendar !!!
      eventStartEditable: true, // this allows things to be dropped onto the calendar !!!
      eventDurationEditable: true, // this allows things to be dropped onto the calendar !!!
	  eventResize: function(event, delta, revertFunc) {
		
			alert(event.title + " end is now " + event.end.format());

			if (!confirm("is this okay?")) {
				revertFunc
				return;
			}
			
			var calendar_params = {
				'enddate'	:event.end.format(),
				'id'	:event.id,
				'type'	:'U'
			};
			
			
			$.ajax({
					url 		: customjs.base_url+"/otheractivity/calendar_event",
					data 		: {calendar_params:calendar_params},
					method 		: 'POST',
					dataType	: "JSON",
					beforeSend:function(){
						active();
					},
					success		:	function(response){
						if(parseInt(response.status) == 1){ 
							event.id = response.event_id; 
							$('#calendar').fullCalendar('renderEvent', event, true);
						}
						inactive();
					}
				});
			
		},
		eventDrop: function(event, delta, revertFunc) {
			var title = event.title;
			var start = event.start.format();
			var end = (event.end == null) ? start : event.end.format();
			
			var calendar_params = {
				'enddate'	:end,
				'startdate'	:start,
				'id'	:event.id,
				'type'	:'U'
			};
			
			
			
			$.ajax({
				url 		: customjs.base_url+"/otheractivity/calendar_event",
				data 		: {calendar_params:calendar_params},
				method 		: 'POST',
				dataType	: "JSON",
				beforeSend:function(){
					active();
				},
				success		:	function(response){
					if(parseInt(response.status) == 1){ 
						event.id = response.event_id; 
						$('#calendar').fullCalendar('renderEvent', event, true);
					}
					inactive();
				}
			});
			
		},
		eventRender: function(event, element) {
            element.append( "<span class='closeon'>X</span>" );
            element.find(".closeon").click(function() {
			if (!confirm("Are you sure to delete this event?")) {
				//revertFunc
				return;
			}	
            $('#calendar').fullCalendar('removeEvents',event._id);
			
			var calendar_params = {
				'id'	:event.id,
				'type'	:'D'
			};
			
			$.ajax({
				url 		: customjs.base_url+"/otheractivity/calendar_event",
				data 		: {calendar_params:calendar_params},
				method 		: 'POST',
				dataType	: "JSON",
				beforeSend:function(){
					active();
				},
				success		:	function(response){
					inactive();
				}
			});
			   
            });
        },
		eventClick: function(event, jsEvent, view) {
			var title = prompt('Event Title:', event.title);
			
			
			var calendar_params = {
				'title'	:title,
				'id'	:event.id,
				'type'	:'U'
			};
			//var originalEventObject = event.data('eventObject');
			//console.log( event );
			if(title){
				event.title = title;
				$.ajax({
					url 		: customjs.base_url+"/otheractivity/calendar_event",
					data 		: {calendar_params:calendar_params},
					method 		: 'POST',
					dataType	: "JSON",
					beforeSend:function(){
						active();
					},
					success		:	function(response){
						if(parseInt(response.status) == 1){ 
							event.id = response.event_id; 
							$('#calendar').fullCalendar('renderEvent', event, true);
						}
						inactive();
					}
				});
			}
			
			$(this).css('border-color', 'red');
		},
		drop: function (date, allDay) { 
			// this function is called when something is dropped
			// retrieve the dropped element's stored Event Object
			var originalEventObject = $(this).data('eventObject');

			
			// we need to copy it, so that multiple events don't have a reference to the same object
			copiedEventObject = $.extend({}, originalEventObject);

			// assign it the date that was reported
			//copiedEventObject.start = date;
			copiedEventObject.date = date.format("YYYY-MM-DD");;
			//copiedEventObject.allDay = allDay;
			copiedEventObject.backgroundColor = $(this).css("background-color");
			copiedEventObject.borderColor = $(this).css("border-color");
			
			//console.log(originalEventObject);
			
			//var id = calendar_event(copiedEventObject);
			
			
			copiedEventObject.type = 'A';
			//console.log(cp);
			$.ajax({
				url 		: customjs.base_url+"/otheractivity/calendar_event",
				data 		: {calendar_params:copiedEventObject},
				method 		: 'POST',
				dataType	: "JSON",
				beforeSend:function(){
					active();
				},
				success		:	function(response){
					if(parseInt(response.status) == 1){ 
						copiedEventObject.id =  response.event_id; 
						$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
					}
					inactive();
				}
			}); 
			
			// render the event on the calendar
			// the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
			//$('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
			
			// is the "remove after drop" checkbox checked?
			if ($('#drop-remove').is(':checked')) {
			  // if so, remove the element from the "Draggable Events" list
			  $(this).remove();
			}
		}
    });

    /* ADDING EVENTS */
    var currColor = "#3c8dbc"; //Red by default
    //Color chooser button
    var colorChooser = $("#color-chooser-btn");
    $("#color-chooser > li > a").click(function (e) {
      e.preventDefault();
      //Save color
      currColor = $(this).css("color");
      //Add color effect to button
      $('#add-new-event').css({"background-color": currColor, "border-color": currColor});
    });
    $("#add-new-event").click(function (e) {
      e.preventDefault();
      //Get value and make sure it is not null
      var val = $("#new-event").val();
      if (val.length == 0) {
        return;
      }

      //Create events
      var event = $("<div />");
      event.css({"background-color": currColor, "border-color": currColor, "color": "#fff"}).addClass("external-event");
      event.html(val);
      $('#external-events').prepend(event);

      //Add draggable funtionality
      ini_events(event);

      //Remove event from text input
      $("#new-event").val("");
    });
  });
</script>