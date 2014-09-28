
/**
 * TeamManager Calendar Object
 */
var TeamManagerCalendar = function() {
	var $ = jQuery;
	var cal = $('#tm_eventsCal');
	var dateNames = {
		days : [ 'Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday' ],
		dayabbrs : [ 'Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat' ],
		months : [ 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December' ],
		monthabbrs : [ 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec' ]
	}
	var inst = this;
	var common = new TeamManagerCommon();

	this.init = function() {
		this.eventsList = this.getEvents();	
		var today = new Date();
		this.defineMonthAndBuildIt(today);
		
	}

	this.defineMonthAndBuildIt = function(theDate) {

		var startOfMonth = new Date(theDate.getFullYear(), theDate.getMonth());
		var endOfMonth = new Date(theDate.getFullYear(), theDate.getMonth()+1);

		endOfMonth.setDate(endOfMonth.getDate() -1 );

		var beginningOfFirstWeek = inst.findBeginningOfWeek(startOfMonth);
		var endOfLastWeek = inst.findEndOfWeek(endOfMonth);

		inst.buildMonth(beginningOfFirstWeek, endOfLastWeek, theDate);
	}

	this.buildHeader = function(thisMonth) {
		var monthRow = this.buildRow();
		var month = dateNames.months[thisMonth.getMonth()];
		var year = thisMonth.getFullYear();
		var monthLabel = $(document.createElement('div'));
		monthLabel.addClass('col-md-16 text-center')
		monthLabel.append('<h2>'+month+' '+year+'</h2>');
		monthRow.append(monthLabel);

		var buttonGroup = $(document.createElement('div'));
		buttonGroup.addClass('btn-group');

		var prevMonthButton = common.buildButton("xs btn-default", "Prev Month", inst.defineMonthAndBuildIt, new Date(thisMonth.getFullYear(), thisMonth.getMonth()-1));
		var nextMonthButton = common.buildButton("xs btn-default", "Next Month", inst.defineMonthAndBuildIt, new Date(thisMonth.getFullYear(), thisMonth.getMonth()+1));

		buttonGroup.append(prevMonthButton, nextMonthButton);

		cal.append(monthRow, buttonGroup);

		var daysRow = this.buildRow();
		for(var i = 0; i < 7; i++) {
			dayLabel = $(document.createElement('div'));
			dayLabel.addClass('tm_label col-md-2 text-center hidden-xs hidden-sm');
			if(i === 0)
				dayLabel.addClass('col-md-offset-1');
			dayLabel.append(dateNames.days[i]);
			daysRow.append(dayLabel);
		}

		cal.append(daysRow);

	}

	this.buildMonth = function(beginningOfFirstWeek, endOfLastWeek, thisMonth) {
		cal.empty();
		var i = 0;
		this.buildHeader(thisMonth);
		var row = this.buildRow();
		for( var d = beginningOfFirstWeek; d.getTime() <= endOfLastWeek.getTime(); d.setDate(d.getDate() + 1)) {
			if(i%7===0 && i > 0) {
				cal.append(row);
				row = this.buildRow();
			} 
			var day = this.buildDay(d);
			if(d.getMonth() != thisMonth.getMonth())
				day.addClass('tm_otherMonth  hidden-xs hidden-sm');
			if( i % 7 === 0  || i === 0 )
				day.addClass('col-md-offset-1');
			row.append( day );
			i++;
		}
		if(!row.is(':empty'))
			cal.append(row);
	}

	this.findEndOfWeek = function(date) {
		var thisDate = new Date(date);
		thisDate.setDate(thisDate.getDate() + 6 - thisDate.getDay() );
		return thisDate;
	}

	this.findBeginningOfWeek = function(date) {
		var thisDate = new Date(date);
		thisDate.setDate(thisDate.getDate() - thisDate.getDay());
		return thisDate;
	}

	this.buildRow = function() {
		var row = $(document.createElement('div'));
		row.addClass('row');
		return row;
	}

	this.getEvents = function() {
		var events = [];
		for(id in teams) { if(teams.hasOwnProperty(id)) {
			var eventList = teams[id].events;
			for(var i=0; i<eventList.length; i++) {
				eventList[i].team_id = id;
				events.push(eventList[i]);
			}
		}}
		return events;
	}

	this.viewEvent = function(theEvent) {
		var eventModal;
		if($('#'+theEvent.id).length > 0)
			eventModal = $('#'+theEvent.id);
		else
			eventModal = common.buildModal(theEvent.id, "<h3>"+theEvent.description+"</h3>", "<div class='eventBody'></div>", common.buildButton("default btn-primary", "Do Something", "", "") );

		eventModal.modal();
		$.ajax({
			type : "post",
			dataType : "json",
			url : myAjax.ajaxurl,
			beforeSend : function() {
			    $('#'+theEvent.id).find('.eventBody').html("Loading...");
			},
			data : {
				action: "get_event", 
				id 	: theEvent.id
			},
			success: function(response) { 
				//console.log(theEvent.team_id);
				var dateTime = new Date(response.datetimeStart*1000);

				var rowTime = inst.buildRow();
				
				var timeLabel = $(document.createElement('div'));
				timeLabel.addClass('col-xs-4 text-right');
				timeLabel.append('<h3><small>Time</small></h3>');
				var timeValue = $(document.createElement('div'));
				timeValue.addClass('col-xs-12');
				timeValue.append('<h3>'+inst.formatJustTime(dateTime)+'</h3>');
				rowTime.append(timeLabel, timeValue);

				var rowDate = inst.buildRow();
				var dateLabel = $(document.createElement('div'));
				dateLabel.addClass('col-xs-4 text-right');
				dateLabel.append('<h3><small>Date</small></h3>');
				var dateValue = $(document.createElement('div'));
				dateValue.addClass('col-xs-12');
				dateValue.append('<h3>'+inst.formatJustDate(dateTime)+'</h3>');
				rowDate.append(dateLabel, dateValue);

				var rowLocation = inst.buildRow();
				var locationLabel = $(document.createElement('div'));
				locationLabel.addClass('col-xs-4 text-right');
				locationLabel.append('<h3><small>Location</small></h3>');
				var locationValue = $(document.createElement('div'));
				locationValue.addClass('col-xs-12');
				locationValue.attr('style', 'padding-top: 27px;');
				locationValue.append('<strong>'+response.details.location+'</strong>');
				rowLocation.append(locationLabel, locationValue);

				var rowNotes = inst.buildRow();
				var notesLabel = $(document.createElement('div'));
				notesLabel.addClass('col-xs-4 text-right');
				notesLabel.append('<h3><small>Notes</small></h3>');
				var notesValue = $(document.createElement('div'));
				notesValue.addClass('col-xs-12');
				notesValue.attr('style', 'padding-top: 27px;');
				notesValue.append('<strong>'+response.details.notes+'</strong>');
				rowNotes.append(notesLabel, notesValue);

				var rowAttendance = inst.buildRow();
				rowAttendance
				var attendanceLabel = $(document.createElement('div'));
				attendanceLabel.addClass('col-xs-4 text-right');
				attendanceLabel.append('<h3><small>Invitation Information</small></h3>');
				var attendanceValue = $(document.createElement('div'));
				attendanceValue.addClass('col-xs-12');
				var inviteEmailSendTime = new Date(dateTime.getTime() - (teams[theEvent.team_id].settings.invitation_delay*1000));
				//console.log('dateTime of event: ' + dateTime.getTime() + ' invite email time: ' + inviteEmailSendTime.getTime());
				var summaryEmailSendTime = new Date(dateTime.getTime() - (teams[theEvent.team_id].settings.summary_delay*1000));
				var now = new Date();

				if(now.getTime() > inviteEmailSendTime.getTime()){
					var countIn=0, countOut=0, countNR=0;
					for(var id in response.attendance){ if(response.attendance.hasOwnProperty(id)) {
						switch (response.attendance[id]) {
							case 0:
								countOut++;
								break;
							case 1:
								countIn++;
								break;
							case 2:
								countNR++;
								break;
						}

					}} 
					attendanceValue.append('<h3><small>Confirmed In:</small> '+countIn+'</h3>');
					attendanceValue.append('<h3><small>Confirmed Out:</small> '+countOut+'</h3>');
					attendanceValue.append('<h3><small>No Response:</small> '+countNR+'</h3>');
					
					if(now.getTime() < summaryEmailSendTime.getTime()) {
						var summaryEmail = inst.buildRow();
						summaryEmail.append('<strong>Summary will be sent at: '+inst.formatJustTime(summaryEmailSendTime)+' '+inst.formatJustDate(summaryEmailSendTime)+'</strong>');
						attendanceValue.append(summaryEmail);
					}
					
				} else {
					attendanceValue.attr('style', 'padding-top: 27px');
					attendanceValue.append('<strong style="margin-top:27px;">Invite will be sent at: '+inst.formatJustTime(inviteEmailSendTime)+' '+inst.formatJustDate(inviteEmailSendTime)+'</strong>');
				}

				rowAttendance.append(attendanceLabel, attendanceValue);

				//if the invitation has been sent
				//	list the numbers in / out / no response
				//else
				//	list the time that the invitation will be sent 
				//	teams[theEvent.team_id].settings.invitation_delay

				//attendees.append('<h3></h3>');
				

				$('#'+theEvent.id).find('.eventBody').empty().append(rowTime, rowDate, rowLocation, rowNotes, rowAttendance);


			    //$('#'+theEvent.id).find('.eventBody').html("<h3>Date/Time of the Event: "+dateTime+"</h3><h3>Notes</h3>"+response.details.notes+"<h3>Members Invited: "+response.attendance.length+"</h3>");
			},
			error: function(data) {	console.log("Error Retrieving Event "); }
		}).fail(function( jqXHR, textStatus ) { alert( "Error making Request "+textStatus ); });

		//console.log(thisEvent);
	}

	this.formatJustTime = function(dateTime) {
		var hr = dateTime.getHours();
		var amPm = 'AM';
		if(hr >= 12) {
			if(hr != 12)
				hr = (hr - 12);
			amPm = 'PM';
		} else {
			if(hr == 0)
				hr = '00';
		}
		return hr+':'+((dateTime.getMinutes() == 0) ? '00': dateTime.getMinutes())+' '+amPm;
	}

	this.formatJustDate = function(dateTime) {
		return dateTime.getDate()+' '+dateNames.months[dateTime.getMonth()]+', '+dateTime.getFullYear();
	}

	this.buildDay = function(date) {
		var today = new Date();
		var beginningOfToday = new Date(today.getFullYear(), today.getMonth(), today.getDate());
		
		//console.log(beginningOfToday);
		var date = new Date(date);

		var beginningOfNextDay = new Date(date.getFullYear(), date.getMonth(), date.getDate());
		beginningOfNextDay.setDate(beginningOfNextDay.getDate()+1);

		var day = $(document.createElement('div'));
		if(beginningOfToday.getTime() === date.getTime())
			day.addClass('tm_today');
		day.addClass('tm_day');
		day.addClass('col-md-2');
		day.attr('data-date', date.getTime());
		day.append(date.getDate());

		for(var i=0; i<inst.eventsList.length; i++) {
			//console.log('day: ' + beginningOfToday.getTime()/1000 +' vs '+inst.eventsList[i].datetimeStart);

			if(inst.eventsList[i].datetimeStart > date.getTime()/1000 &&
				inst.eventsList[i].datetimeStart < beginningOfNextDay.getTime()/1000) {
				day.append(common.buildButton("xs btn-default tm_viewEventButton", inst.eventsList[i].description, inst.viewEvent, inst.eventsList[i]))
			}
		}

		day.on({
			mouseenter: function() {
				var addEventButton = common.buildButton("sm btn-default tm_addEventButton", "<span class='glyphicon glyphicon-plus'></span>", inst.dispAddEvent, date)

				$(this).append(addEventButton);
			},
			mouseleave: function() {
				$(this).children('.tm_addEventButton').remove();
			},
			touchstart: function(e) {
				if($(e.target).hasClass('glyphicon')) {
					e.stopPropagation;
					console.log('success');
				}
				else
					$(this).children('.tm_addEventButton').remove();
			},
			touchend: function() {
				var addEventButton = common.buildButton("sm btn-default tm_addEventButton", "<span class='glyphicon glyphicon-plus'></span>", inst.dispAddEvent, date)

				$(this).append(addEventButton);
			},
		});
		return day;
	}

	this.buildInputMonth = function(monthNumber) {
		var formGroup = $(document.createElement('div'));
		formGroup.addClass('form-group col-sm-5');
		var label = $(document.createElement('label'));
		label.attr({
			class: "control-label",
			for: "monthInput"
		});
		label.append('Month: ');
		var monthInput = $(document.createElement('select'));
		monthInput.addClass('form-control');
		monthInput.attr('id', 'monthInput');
		for(var i=0; i<12; i++) {
			var option = $(document.createElement('option'));
			option.attr('value', i);
			if(i == monthNumber)
				option.attr('selected', 'selected');
			option.append(dateNames.months[i]);
			monthInput.append(option);
		}
		formGroup.append(label, monthInput);

		monthInput.change(function() {
			var dayInput = $('#dayInput');
			dayInput.empty();
			var monthSelected = $('#monthInput').find(":selected").attr('value');
			var selectedMonth = new Date(2014, monthSelected);
			var i = 1;
			while(monthSelected == selectedMonth.getMonth()) {
				var option = $(document.createElement('option'));
				option.attr('value', i);
				option.append(i);
				dayInput.append(option);
				i++;
				selectedMonth.setDate(selectedMonth.getDate() + 1)
			}
		});

		return formGroup;
	}

	this.buildInputDay = function(theDate) {
		var formGroup = $(document.createElement('div'));
		formGroup.addClass('form-group col-sm-5');
		var label = $(document.createElement('label'));
		label.attr({
			class: "control-label",
			for: "dayInput"
		});
		label.append('Day: ');
		var dayInput = $(document.createElement('select'));
		dayInput.addClass('form-control');
		dayInput.attr('id', 'dayInput');
		var selectedMonth = parseInt(theDate.getMonth());
		var i = 1;
		var d = new Date(theDate.getFullYear(), selectedMonth);
		while(d.getMonth() == selectedMonth) {
			var option = $(document.createElement('option'));
			option.attr('value', i);
			if(i == theDate.getDate())
				option.attr('selected', 'selected');
			option.append(i);
			dayInput.append(option);
			d.setDate(d.getDate() + 1);
			i++;
		}
		formGroup.append(label, dayInput);
		return formGroup;
	}

	this.buildInputYear = function(theDate) {
		theDate = new Date(theDate.getTime());
		var formGroup = $(document.createElement('div'));
		formGroup.addClass('form-group col-sm-5');
		var label = $(document.createElement('label'));
		label.attr({
			class: "control-label",
			for: "yearInput"
		});
		label.append('Year: ');
		var yearInput = $(document.createElement('select'));
		yearInput.addClass('form-control');
		yearInput.attr('id', 'yearInput');
		for(var i = 1; i < 3; i++) {
			var option = $(document.createElement('option'));
			option.attr('value', theDate.getFullYear());
			if(i == theDate.getFullYear())
				option.attr('selected', 'selected');
			option.append(theDate.getFullYear());
			yearInput.append(option);
			theDate.setDate(theDate.getDate() + 365);
		}
		formGroup.append(label, yearInput);
		return formGroup;
	}

	this.buildInputHour = function() {
		var formGroup = $(document.createElement('div'));
		formGroup.addClass('form-group col-sm-5');
		var label = $(document.createElement('label'));
		label.attr({
			class: "control-label",
			for: "hourInput"
		});
		label.append('Hour: ');
		var hourInput = $(document.createElement('select'));
		hourInput.addClass('form-control');
		hourInput.attr('id', 'hourInput');
		for(var i=1; i<13; i++) {
			var option = $(document.createElement('option'));
			option.attr('value', i);
			option.append(i);
			hourInput.append(option);
		}
		formGroup.append(label, hourInput);
		return formGroup;
	}

	this.buildInputMinute = function() {
		var formGroup = $(document.createElement('div'));
		formGroup.addClass('form-group col-sm-5');
		var label = $(document.createElement('label'));
		label.attr({
			class: "control-label",
			for: "minuteInput"
		});
		label.append('Minute: ');
		var minuteInput = $(document.createElement('select'));
		minuteInput.addClass('form-control');
		minuteInput.attr('id', 'minuteInput');
		for(var i=0; i<60; i+=15) {
			var option = $(document.createElement('option'));
			if(i == 0) {
				option.append("00");
				option.attr('value', "00");
			}
			else {
				option.append(i);
				option.attr('value', i);
			}
			minuteInput.append(option);
		}
		formGroup.append(label, minuteInput);
		return formGroup;
	}
	
	this.buildInputAmPm = function() {
		var formGroup = $(document.createElement('div'));
		formGroup.addClass('form-group col-sm-5');

		var amLabel = $(document.createElement('label'));
		amLabel.attr({
			class: "radio",
			for: "amInput"
		});
		amLabel.append('am');
		var amInput = $(document.createElement('input'));
		amInput.attr({
			id: 'amInput',
			name: 'amPmInput',
			type: 'radio',
			value: 'am'});
		amLabel.append(amInput);

		var pmLabel = $(document.createElement('label'));
		pmLabel.attr({
			class: "radio",
			for: "pmInput"
		});
		pmLabel.append('pm');
		var pmInput = $(document.createElement('input'));
		pmInput.attr({
			id: 'pmInput',
			name: 'amPmInput',
			type: 'radio',
			checked: 'checked',
			value: 'pm'});
		pmLabel.append(pmInput);

		formGroup.append(amLabel, pmLabel);
		return formGroup;
	}

	this.buildInputText = function(name) {
		var formGroup = $(document.createElement('div'));
		formGroup.addClass('form-group');
		var label = $(document.createElement('label'));
		label.attr({
			class: "control-label",
			for: name
		});
		label.append(name.charAt(0).toUpperCase()+name.slice(1)+': ');
		var input = $(document.createElement('input'));
		input.attr({
			type: "text",
			id: name+"Input",
			name: name,
			class: "form-control"
		});
		formGroup.append(label, input);
		return formGroup;
	}

	this.buildInputTeam = function() {
		
		var formGroup = $(document.createElement('div'));
		formGroup.addClass('form-group col-sm-5');
		var label = $(document.createElement('label'));
		label.attr({
			class: "control-label",
			for: 'teamInput'
		});
		label.append('Team: ');
		var teamInput = $(document.createElement('select'));
		teamInput.addClass('form-control');
		teamInput.attr('id', 'teamInput');
		for(var id in teams) { if(teams.hasOwnProperty(id)) {
			var option = $(document.createElement('option'));
			option.attr('value', id);
			var name = teams[id]['settings']['name'];
			option.append(name);
			teamInput.append(option);
		}}
		formGroup.append(label, teamInput);
		return formGroup;
	}

	this.dispAddEvent = function(theDate) {
		

		var inputForm = $(document.createElement('form'));
		inputForm.attr('id', 'addEventForm');
		var formInputs = [];
		//okay let's build the date and time input forms.
		formInputs['year'] = inst.buildInputYear(theDate);
		formInputs['month'] = inst.buildInputMonth(theDate.getMonth());
		formInputs['day'] = inst.buildInputDay(theDate);

		formInputs['hour'] = inst.buildInputHour();
		formInputs['minute'] = inst.buildInputMinute();
		formInputs['ampm'] = inst.buildInputAmPm();

		formInputs['description'] = inst.buildInputText('description');
		formInputs['description'].addClass('col-sm-10');
		formInputs['team'] = inst.buildInputTeam();
		formInputs['location'] = inst.buildInputText('location');

		var notesInput = $(document.createElement("textarea"));
			notesInput.attr({
				rows: 4,
				name: "notes",
				id: "notesInput",
				class: "form-control" 
			});
		var formGroup = $(document.createElement('div'));
		formGroup.addClass('form-group');
		var label = $(document.createElement('label'));
		label.attr({
			class: "control-label",
			for: name
		});
		label.append('Event Notes: ');
		formGroup.append(label, notesInput);

		formInputs['notes'] = formGroup;

		formInputs['teamid'] = $(document.createElement("input"));
			formInputs['teamid'].attr({
				type: "hidden",
				name: "teamid" 
			});

		for (var input in formInputs) {	if (formInputs.hasOwnProperty(input)) { 
				inputForm.append(formInputs[input]);
			}}

		var title = "<h3>Add event on "+dateNames.days[theDate.getDay()]+ ", " +dateNames.months[theDate.getMonth()] +" "+ theDate.getDate()+"</h3>";
		$('body').append(common.buildModal(theDate.getTime(), title, inputForm, common.buildButton("default btn-primary", "Save Changes", inst.addEvent, theDate.getTime())));
    	$('#'+theDate.getTime()).modal();
	}

	this.formatDateTime = function(year, month, day, hour, minute, amPm) {
		
		if(amPm == "am") {
			if(hour == 12)
				hour = "00";
			else if(hour < 10) {
				hour = "0"+hour;
			}
		} else if(hour != 12) {
			hour = 12 + parseInt(hour);
		}
		return new Date(year, month, day, hour, minute);
	} 

	/**
	 * Add a game.
	 * @param {[type]} data [description]
	 */
	this.addEvent = function(theId) {
		event.stopPropagation();
		//event.preventDefault();

		var data = [];

		var year 	= $('#yearInput').val();
		var month 	= $('#monthInput').val();
		var day 	= $('#dayInput').val();
		var hour 	= $('#hourInput').val();
		var minute 	= $('#minuteInput').val();
		var amPm 	= $('input[name="amPmInput"]:checked').val();

		var date = inst.formatDateTime(year, month, day, hour, minute, amPm);

		data.dateTime 	= date.toUTCString();
		data.teamid 	= $('#teamInput').val();
		data.description= $('#descriptionInput').val();
		data.location 	= $('#locationInput').val();
		data.notes 		= $('#notesInput').val();

		$.ajax({
			type : "post",
			dataType : "json",
			url : myAjax.ajaxurl,
			data : {
				action: "add_event", 
				dateTime 	: data.dateTime, 
				location 	: data.location,
				description : data.description,
				notes 		: data.notes,
				teamid 		: data.teamid
			},
			success: function(response) {
				$('#'+theId).find('.modal-body').empty().append('<h1 class="text-center">Event Saved</h1>');
				window.setTimeout(hideModal, 1500);
				function hideModal() {
					$('#'+theId).modal('hide');
				}
				teams[data.teamid].events.push(response);
				var dayOfEvent = inst.formatDateTime(year, month, day, '00', '00', 'am');
				$("[data-date='"+dayOfEvent.toUTCString()+"']").append(common.buildButton("xs btn-default tm_viewEventButton", response.description, inst.viewEvent, response.id));

			},
			error: function(data) {
				console.log("Error Adding Event "+data);
			}
		}).fail(function( jqXHR, textStatus ) { alert( "Error making Request "+textStatus ); });
	}

}

var TeamManagerCommon = function() {

	var $ = jQuery;

	this.buildModal = function(theId, theTitle, body, affirmButton) {

		var modal = $(document.createElement('div'));
		modal.attr({ 
			class: "modal fade",
			id: theId,
			tabindex: "-1",
			role: "dialog",
			"aria-labelledby": "myModalLabel",
			"aria-hidden": "true"
		 });
		var modalDialog = $(document.createElement('div'));
		modalDialog.addClass('modal-dialog');
		var modalContent = $(document.createElement('div'));
		modalContent.addClass('modal-content');
		var modalHeader = $(document.createElement('div'));
		modalHeader.addClass('modal-header');
		var dismissButton = $(document.createElement('button'));
		dismissButton.attr({
			type: "button",
			class: "close",
			"data-dismiss": "modal",
			"aria-hidden": "true",
		});
		dismissButton.append('&times;');
		var title = '<h4 class="modal-title" id="myModalLabel">'+theTitle+'</h4>';
		modalHeader.append(dismissButton, title);
		var modalBody = $(document.createElement('div'));
		modalBody.addClass('modal-body');
		modalBody.append(body);
		var modalFooter = $(document.createElement('div'));
		modalFooter.addClass('modal-footer');
		var closeButton = $(document.createElement('button'));
		closeButton.attr({
			type: "button",
			class: "btn btn-default",
			"data-dismiss": "modal",
		});
		closeButton.append('Close');
		var saveButton =  affirmButton;

		modalFooter.append(closeButton, saveButton);
		modalContent.append(modalHeader, modalBody, modalFooter);
		modalDialog.append(modalContent);
		modal.append(modalDialog);
		return modal;
	}

	this.buildButton = function(size, contents, buttonFunction, param) {
		var button = $(document.createElement('button'));
		button.addClass('btn btn-'+size);
		button.attr('type', 'button');
		button.append(contents);
		button.on('click touchend', function() { 
			buttonFunction(param); 
		});
		return button;
	}
}

/**
 * TeamManager Team Object
 */
var TeamManagerTeam = function() {
	var inst = this;
	var $ = jQuery;
	var common = new TeamManagerCommon();

	this.init = function() {
		for(var teamId in teams){ if(teams.hasOwnProperty(teamId)) {
			$('#tm_teamsPlace').append(inst.buildCollapsable(teamId, teams[teamId]));
		}}
	}

	this.buildTeamTable = function(teamId, teamMembers) {
		var tableDiv = $(document.createElement('div'));
		tableDiv.addClass('table-responsive');

		var table = $(document.createElement('table'));
		table.attr({
			class: 'table table-condensed table-hover',
			id: teamId+'-members'
		});
		tableDiv.append(table);
		
		var thead = $(document.createElement('thead'));
		var theadRow = $(document.createElement('tr'));
		theadRow.append('<td colspan="2">Name</td><td>Phone</td><td>Email</td><td>Position</td>');
		thead.append(theadRow);
		table.append(thead);

		for(var i=0; i<teamMembers.length; i++) {
			var row = $(document.createElement('tr'));
			row.attr('id', teamMembers[i].id);
			var fname = $(document.createElement('td'));
			fname.append(teamMembers[i].details['fname']);
			var lname = $(document.createElement('td'));
			lname.append(teamMembers[i].details['lname']);
			var phone = $(document.createElement('td'));
			phone.append(teamMembers[i].details['phone']);
			var email = $(document.createElement('td'));
			email.append(teamMembers[i].details['email']);
			var position = $(document.createElement('td'));
			position.append(teamMembers[i].details['position']);

			if(teamMembers[i].details['emailConfirm'] == 2)
				row.addClass('danger');
			else if(teamMembers[i].details['emailConfirm'] != 1)
				row.addClass('warning');
			row.append(fname, lname, phone, email, position);
			table.append(row);
		}
		return tableDiv;
	}

	this.buildCollapsable = function(teamId, theTeam) {
		var panel = $(document.createElement('div'));
		panel.addClass('panel panel-default');
		var panelHeading = $(document.createElement('div'));
		panelHeading.addClass('panel-heading');
		var panelTitle = $(document.createElement('h3'));
		panelTitle.append('<a data-toggle="collapse" data-parent="#tm_teamsPlace" href="#collapse'+teamId+'">'+theTeam.settings.name+'</a>');
		
		//Add some buttons for settings & add player.
		var settingsButton = common.buildButton("btn btn-default", '<span class="glyphicon glyphicon-cog"></span>', inst.viewSettings, teamId);
		var addMemberButton = common.buildButton("btn btn-default", 'Add Member', inst.addMember, teamId);

		panelTitle.append(settingsButton, addMemberButton);

		panelHeading.append(panelTitle);
		var panelCollapse = $(document.createElement('div'));
		panelCollapse.attr({
			id: 'collapse'+teamId,
			class: 'panel-collapse collapse in'
		});
		var panelBody = $(document.createElement('div'));
		panelBody.addClass('panel-body');
		panelBody.append(inst.buildTeamTable(teamId, theTeam.members));
		panelCollapse.append(panelBody);
		panel.append(panelHeading, panelCollapse);
		return panel;
	}

	this.addMember = function() {
		
	}

	this.viewSettings = function(teamId) {

		$('#'+teamId).remove();

		var modalBody = $(document.createElement('form'));
		modalBody.attr({
			class: 'form-horizontal',
			role: 'form',
			'data-teamId': teamId
		});

		var nameRow = $(document.createElement('div'));
		nameRow.addClass('form-group');
		var nameLabel = $(document.createElement('label'));
		nameLabel.addClass('col-xs-4 control-label');
		nameLabel.attr('for', teamId+'name');
		nameLabel.append('Team Name:');
		var nameValue = $(document.createElement('div'));
		nameValue.addClass('col-xs-12');
		nameValue.append('<input type="text" class="form-control" id="'+teamId+'name" value="'+teams[teamId].settings.name+'">');
		nameRow.append(nameLabel, nameValue);
		modalBody.append(nameRow);

		var timezoneRow = $(document.createElement('div'));
		timezoneRow.addClass('form-group');
		var timezoneLabel = $(document.createElement('label'));
		timezoneLabel.addClass('col-xs-4 control-label');
		timezoneLabel.attr('for', teamId+'timezoneDropdown');
		timezoneLabel.append('Timezone:');

		var timezoneValue = $(document.createElement('div'));
		timezoneValue.addClass('col-xs-12');
		timezoneDropdown = $(document.createElement('select'));
		timezoneDropdown.attr({
			class: 'form-control col-xs-12',
			id: teamId+'timezoneDropdown',
			name: teamId+'timezoneDropdown'
		});
		$.ajax({
			type : "post",
			dataType : "json",
			url : myAjax.ajaxurl,
			data : {
				action: "get_timezones"
			},
			success: function(response) {
				var timezonesList = response;
				for(var i=0; i<timezonesList.length; i++) {
					var tzOption = $(document.createElement('option'));
					tzOption.attr('value', timezonesList[i].value);
					if(teams[teamId].settings.timezone == timezonesList[i].value)
						tzOption.attr('selected', 'selected');
					tzOption.append(timezonesList[i].eng);
					timezoneDropdown.append(tzOption);
				}
			}
		}).done(function() {
			timezoneDropdown.combobox();
		});
		timezoneValue.append(timezoneDropdown);
		timezoneRow.append(timezoneLabel, timezoneValue);
		modalBody.append(timezoneRow);
		//timezoneDropdown.combobox();

		var invitationDelayRow = $(document.createElement('div'));
		invitationDelayRow.addClass('form-group');
		var invitationDelayLabel = $(document.createElement('label'));
		invitationDelayLabel.addClass('col-xs-4 control-label');
		invitationDelayLabel.attr('for', teamId+'invitationDelay');
		invitationDelayLabel.append('Invitation Sent:');
		var invitationDelayValue = $(document.createElement('div'));
		invitationDelayValue.addClass('col-xs-2');
		invitationDelayValue.append('<input type="text" class="form-control" id="'+teamId+'invitationDelay" value="'+teams[teamId].settings.invitation_delay/60/60+'">');
		var invitationDelayInfo = $(document.createElement('div'));
		invitationDelayInfo.addClass('col-xs-10');
		invitationDelayInfo.append('<h3 class="control-label" style="text-align:left;"><small>hours before event</small></h3>');
		invitationDelayRow.append(invitationDelayLabel, invitationDelayValue, invitationDelayInfo);
		modalBody.append(invitationDelayRow);

		var summaryDelayRow = $(document.createElement('div'));
		summaryDelayRow.addClass('form-group');
		var summaryDelayLabel = $(document.createElement('label'));
		summaryDelayLabel.addClass('col-xs-4 control-label');
		summaryDelayLabel.attr('for', teamId+'invitationDelay');
		summaryDelayLabel.append('Summary Sent:');
		var summaryDelayValue = $(document.createElement('div'));
		summaryDelayValue.addClass('col-xs-2');
		summaryDelayValue.append('<input type="text" class="form-control" id="'+teamId+'summaryDelay" value="'+teams[teamId].settings.summary_delay/60/60+'">');
		var summaryDelayInfo = $(document.createElement('div'));
		summaryDelayInfo.addClass('col-xs-10');
		summaryDelayInfo.append('<h3 class="control-label" style="text-align:left;"><small>hours before event</small></h3>');
		summaryDelayRow.append(summaryDelayLabel, summaryDelayValue, summaryDelayInfo);
		modalBody.append(summaryDelayRow);

		var maxMembersRow = $(document.createElement('div'));
		maxMembersRow.addClass('form-group');
		var maxMembersLabel = $(document.createElement('label'));
		maxMembersLabel.addClass('col-xs-4 control-label');
		maxMembersLabel.attr('for', teamId+'minMembers');
		maxMembersLabel.append('Max # Per Event:');
		var maxMembersValue = $(document.createElement('div'));
		maxMembersValue.addClass('col-xs-2');
		maxMembersValue.append('<input type="text" class="form-control" id="'+teamId+'maxMembers" value="'+teams[teamId].settings.max_members+'">');
		maxMembersRow.append(maxMembersLabel, maxMembersValue);
		modalBody.append(maxMembersRow);

		var minMembersRow = $(document.createElement('div'));
		minMembersRow.addClass('form-group');
		var minMembersLabel = $(document.createElement('label'));
		minMembersLabel.addClass('col-xs-4 control-label');
		minMembersLabel.attr('for', teamId+'minMembers');
		minMembersLabel.append('Min # Per Event:');
		var minMembersValue = $(document.createElement('div'));
		minMembersValue.addClass('col-xs-2');
		minMembersValue.append('<input type="text" class="form-control" id="'+teamId+'minMembers" value="'+teams[teamId].settings.min_members+'">');
		minMembersRow.append(minMembersLabel, minMembersValue);
		modalBody.append(minMembersRow);

		var modal = common.buildModal(teamId, '<h3>'+teams[teamId].settings.name+'</h3>', modalBody, common.buildButton("default btn-primary", "Save Changes", inst.saveTeam, modalBody));
		$('body').append(modal);
		modal.modal();
	}

	this.saveTeam = function(form) {
		var teamId = form.attr('data-teamId');
		//first thing to do is to collect the data from each input:
		var teamName, timezone, invitationDelay, summaryDelay, maxMembers, minMembers;
		teamName = form.children().find('#'+teamId+'name').val();
		timezone = form.children().find('#'+teamId+'timezoneDropdown').val();
		invitationDelay = form.children().find('#'+teamId+'invitationDelay').val();
		summaryDelay = form.children().find('#'+teamId+'summaryDelay').val();
		maxMembers = form.children().find('#'+teamId+'maxMembers').val();
		minMembers = form.children().find('#'+teamId+'minMembers').val();

		$.ajax({
			type : "post",
			dataType : "json",
			url : myAjax.ajaxurl,
			data : {
				action: "save_team_settings",
				teamId: teamId, 
				teamName: teamName,
				timezone: timezone,
				invitationDelay: invitationDelay,
				summaryDelay: summaryDelay,
				maxMembers: maxMembers,
				minMembers: minMembers
			},
			success: function(response) {
				console.log(response);
				if(response['response'] == "Success") {
					$('#myModalLabel').empty().after('<div class="progress progress-striped active"><div class="progress-bar"  role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div></div>');
					$('#'+teamId).find('.modal-body').empty().append('<h1 class="text-center">Team Settings Saved</h1>');
					var hm = function hideModal() {
						$('#'+teamId).modal('hide');
					}
					window.setTimeout(hm, 1500);
				
					$('#'+teamId).on('hidden.bs.modal', function () {
					    location.reload();
					});
				} else {
					form.after('<div class="alert alert-danger"><p>'+response['response']+'</p></div>');
				}
			},
			error: function(data) {
				console.log("Error Saving Team "+data);
			}
		}).fail(function( jqXHR, textStatus ) { alert( "Error making Request "+textStatus ); });

				
	}
}

jQuery( document ).ready(function( $ ) {

	if($('#tm_eventsCal').length > 0 ) {
		var calendar = new TeamManagerCalendar();
		calendar.init();
	}	
	if($('#tm_teamsPlace').length > 0 ) {
		var theTeams = new TeamManagerTeam();
		theTeams.init();
	}
    // -- Might be better somewhere else???
	$('#defaultMessageClose').click(function() {
		$('.defaultMessage').fadeOut('fast');
	});

});

