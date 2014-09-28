
/**
 * HockeyManGamesPage
 * An object to deal with all of the things that we'll need to do with the games objects
 */
var HockeyManGamesPage = function(incomingGames, incomingStage) {

	/* Games have the following properties:
		-attendees
		-creator
		-date
		-desc
		-id
		-initialEmailTimeDelay
		-loc
	*/
	var games = incomingGames;
	var stage = incomingStage;
	var inst = this;
	var $ = jQuery;
	var hockeyManCommon = new HockeyManCommonActions(games, stage);

	/**
	 * Constructor Function - must be called explicitly because JS is whack
	 * @return none
	 */
	this.init = function() {
		stage.before(
			hockeyManCommon.buildButton("showAsTable", "Show as Table", this.displayTable, ""),
			hockeyManCommon.buildButton("showAsCards", "Show as Cards", this.displayCards, ""),
			hockeyManCommon.buildButton("addGame", "Add a Game", this.displayAddGameModal, "")
		);
	}

	/**
	 * PRIVATE Format the date/time to be reasonable.
	 * @param  Date date the date obj in UTC 
	 * @return Array 	[0] - Date formatted as day/month/year
	 *                  [1] - Time formatted for AM/PM
	 */
	function formatDate(date) {
		date = new Date(date * 1000);
		var r = [];
		var monthList = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
		r[0] = date.getDate() + "/" + monthList[date.getMonth()] + "/" + date.getFullYear();
		var hrs = date.getHours();
		var ampm;
		if( hrs >= 12 ) {
			ampm = 'PM';
			if( hrs > 12 )
				hrs -= 12;
		}
		else {
			ampm = 'AM';
			if(hrs == 0)
				hrs = 12;
		}
		var min = date.getMinutes();
		if(min == 0)
			min = "00";
		r[1] = hrs + ":" + min + " " + ampm;
		return r;
	}

	function handleActions(incomingStuff) {
		$(incomingStuff).on({
		    mouseenter: function() {
				var delButton = hockeyManCommon.buildButton("deleteGame", "Delete Game", inst.deleteGame, $(this));
		        $(this).children('.actionsCell').append(delButton);
		    },
		    mouseleave: function() {
		        $(this).children('.actionsCell').empty();
		    },
		    click: function(e) {
		        console.log('game clicked - reveal attendees eventually');
		    }
		}, "tr.gameRow, div.gameCard");
	}

	/**
	 * Delete Game
	 */
	this.deleteGame = function(theGameRow) {
		event.stopPropagation();
		var gameid = theGameRow.attr('id');

		$.ajax({
			type : "post",
			dataType : "json",
			url : myAjax.ajaxurl,
			data : {
				action: "delete_game", 
				gameid : gameid, 
				nonce: nonce
			},
			success: function(response) {
				if( response > 0 ) {
				   	for (var i = games.length - 1; i >= 0; i--) {
					   	if(games[i].id == response) {
					   		games = games.splice(i, 1);
					   		$('#'+response).fadeOut('400', function() {
					   			$(this).remove();
					   		});
					   	}
				   	}
			   	} else
				   alert('Error deleting game');
			}
		}).fail(function( jqXHR, textStatus ) { alert( "Error making Request" ); });
	}

	/**
	 * Add a game.
	 * @param {[type]} data [description]
	 */
	this.addGame = function(form) {
		event.stopPropagation();
		//event.preventDefault();

		var data = [];

		data.dateTime 	= $('input[name="dateTime"]').val();
		data.location 	= $('input[name="location"]').val();
		data.description= $('input[name="description"]').val();
		data.teamid 	= $('input[name="teamid"]').val();

		$.ajax({
			type : "post",
			dataType : "json",
			url : myAjax.ajaxurl,
			data : {
				action: "add_game", 
				dateTime 	: data.dateTime, 
				location 	: data.location,
				description : data.description,
				teamid 		: data.teamid,   
				nonce		: nonce
			},
			success: function(response) {
				if( !$.isEmptyObject(response) ) {
					var drawTable = true
					if($("#gamesTable").length === 0)
						drawTable = false;

					stage.empty();
					games.push(response);
					if(drawTable)
						inst.displayTable();
					else
						inst.displayCards();

					hockeyManCommon.closeModal();
				}
			},
			error: function(data) {
				console.log("Error Adding Game "+data);
			}

		}).fail(function( jqXHR, textStatus ) { alert( "Error making Request "+textStatus ); });
	}

	this.displayAddGameModal = function() {

		var inputForm = $(document.createElement('form'));
		inputForm.attr('id', 'addGameForm');

		var formInputs = [];

		formInputs['dateTime'] = $(document.createElement("input"));
			formInputs['dateTime'].attr({
				type: "text",
				name: "dateTime" 
			});
			formInputs['dateTime'].datetimepicker({
				dateFormat: "yy-mm-dd",
				timeFormat: "hh:mm tt"
			});
		formInputs['location'] = $(document.createElement("input"));
			formInputs['location'].attr({
				type: "text",
				name: "location" 
			});
		formInputs['description'] = $(document.createElement("input"));
			formInputs['description'].attr({
				type: "text",
				name: "description" 
			});
		formInputs['teamid'] = $(document.createElement("input"));
			formInputs['teamid'].attr({
				type: "hidden",
				name: "teamid" 
			});
		var submitButton 	= hockeyManCommon.buildButton("submit", "Submit", inst.addGame, inputForm);
		var closeButton 	= hockeyManCommon.buildButton("close", "Close", hockeyManCommon.closeModal, "");

		for (var input in formInputs) {	if (formInputs.hasOwnProperty(input)) { 

				var div = $(document.createElement('div'))
				div.addClass('modalInputRow');
				var text = "";
				switch (input) {
					case 'dateTime':
						text = "Date/Time: ";
						break;
					case 'location':
						text = "Location: ";
						break;
					case 'description':
						text = "Description: ";
						break;
				}
				div.append(text, formInputs[input]);
				inputForm.append(div);
			}}
		var div = $(document.createElement('div'));
		div.addClass('modalActions');
		div.append(submitButton, closeButton);
		inputForm.append(div);

		$(document.createElement('div'))
			.addClass('defaultMessage')
			.append(inputForm).prependTo( "body" );
	}

	/**
	 * organizes the game into cards for display
	 * @return {[type]} [description]
	 */
	this.displayCards = function() {
		var cards = document.createElement('div');
		cards.id = 'gameCards';
		for (var i = games.length - 1; i >= 0; i--) {
			var gameDate = formatDate(new Date(games[i].date));
			var div = document.createElement('div');
			div.className = 'gameCard';
			div.id = games[i].id;
			div.innerHTML = '<h3>'+gameDate[0]+'<br>'+gameDate[1]+'</h3>'+
				'<p>'+games[i].desc+'</p>'+
				'<p>'+games[i].loc+'</p><div class="actionsCell"></div>';
			cards.appendChild(div);
		}
		hockeyManCommon.changeStage(cards);
		handleActions(cards);
	}

	/**
	 * organizes each game into a row in the table
	 * @return {[type]} [description]
	 */
	this.displayTable = function() {
		var table = document.createElement('table');
		table.id = 'gamesTable';
		table.innerHTML = "<thead><tr><td>Date</td><td>Description</td><td>Location</td><td></td></thead></tr><tbody>";
		for (var i = games.length - 1; i >= 0; i--) {
			var gameDate = formatDate(new Date(games[i].date));
			tr = document.createElement('tr');
			tr.id = games[i].id;
			tr.className = "gameRow";
			tr.innerHTML += "<td>"+gameDate[0]+"<br>"+gameDate[1]+"</td>";
			tr.innerHTML += "<td>"+games[i].desc+"</td>";
			tr.innerHTML += "<td>"+games[i].loc+"</td>";
			tr.innerHTML += "<td class='actionsCell'></td>";
			table.appendChild(tr);
		};
		table.innerHTML += "</tbody>";
		hockeyManCommon.changeStage(table);
		handleActions(table);
	}

	
}

/**
 * Common Actions required by both games and pages.
 * @param {[type]} incomingStuff [description]
 * @param {[type]} incomingStage [description]
 */
var HockeyManCommonActions = function(incomingStuff, incomingStage) {
	var stuff = incomingStuff;
	var stage = incomingStage;
	var inst = this;
	var $ = jQuery;

	/**
	 * Hides everything currently in the stage and animates the incomingStuff into being.
	 * @param  DOM Element incomingStuff
	 */
	this.changeStage = function(incomingStuff) {
		stage.empty();
		stage.append(incomingStuff).hide().slideDown('800');
	}

	/**
	 * Closes ye old Modal Popup
	 * @return {[type]} [description]
	 */
	this.closeModal = function() {
		$('.defaultMessage').fadeOut('400', function() {
			$(this).remove();
		});
	}

	/**
	 * Builds a generic button
	 * @param  String 	name 		Button Name		
	 * @param  String 	text        Text for Button to Display
	 * @param  function functionToRun the function for the button to perform
	 * @return DOMElement <button>
	 */
	this.buildButton = function(name, text, functionToRun, functionParam) {
		var button = document.createElement('button');
		button.type = 'button';
		button.value = name;
		button.innerHTML = text;
		button.onclick = function() { functionToRun(functionParam); }
		return button;
	}
}

/**
 * HockeyManPlayersPage
 * An object to deal with all of the things that we'll need to do with the players objects
 */
var HockeyManPlayersPage = function(incomingPlayers, incomingStage) {
	/* Players have the following properties:
		-id
		-fname
		-lname
		-phone
		-email
		-emailconfirm
		-address
		-position
		-teamid
	*/
	var players = incomingPlayers;
	var stage = incomingStage;
	var inst = this;
	var $ = jQuery;
	var hockeyManCommon = new HockeyManCommonActions(players, stage);

	/**
	 * Constructor Function - must be called explicitly because JS is whack
	 * @return none
	 */
	this.init = function() {
		stage.before(
			hockeyManCommon.buildButton("showAsTable", "Show as Table", this.displayTable, ""),
			hockeyManCommon.buildButton("showAsCards", "Show as Cards", this.displayCards, ""),
			hockeyManCommon.buildButton("addPlayer", "Add a Player", this.displayPlayerModal, "")
		);
	}



	/**
	 * handles the mousey stuff for the playertable
	 * @param  {[type]} incomingStuff [description]
	 * @return {[type]}               [description]
	 */
	this.handleActions = function(incomingStuff) {
		$(incomingStuff).on({
		    mouseenter: function() {
				var delButton = hockeyManCommon.buildButton("deletePlayer", "Delete Player", inst.deletePlayer, $(this));
				var editButton = hockeyManCommon.buildButton("editPlayer", "Edit Player", inst.editPlayer, $(this)[0].id);
		        $(this).children('.actionsCell').append(delButton, editButton);
		    },
		    mouseleave: function() {
		        $(this).children('.actionsCell').empty();
		    },
		    click: function(e) {
		        console.log('Player clicked - Do something?');
		    }
		}, "tr.playerRow, div.playerCard");
	}

	/**
	 * Add a game.
	 * @param {[type]} data [description]
	 */
	this.addPlayer = function(form) {
		event.stopPropagation();
		//event.preventDefault();

		var data = [];

		data.id 	= $('input[name="id"]').val();
		data.fname 	= $('input[name="fname"]').val();
		data.lname 	= $('input[name="lname"]').val();
		data.phone 	= $('input[name="phone"]').val();
		data.email 	= $('input[name="email"]').val();
		data.emailconfirm 	= "";
		data.address 	= "";
		data.position 	= $('input[name="position"]').val();
		data.teamid 	= $('input[name="teamid"]').val();

		$.ajax({
			type : "post",
			dataType : "json",
			url : myAjax.ajaxurl,
			data : {
				action: "add_player", 
				id 			: data.id,
				fname 		: data.fname,
				lname 		: data.lname,
				phone 		: data.phone,
				email 		: data.email,
				emailconfirm : data.emailconfirm,
				address 	: data.address,
				position 	: data.position,
				teamid 		: data.teamid,
				nonce		: nonce  
			},
			success: function(response) {
				if( !$.isEmptyObject(response) ) {
					var drawTable = true;
					if($("#playersTable").length == 0) {
						console.log("table does not exist");
						drawTable = false;
					}

					stage.empty();
					var playerAdded = false;
					for (var i = players.length - 1; i >= 0; i--) {
						if(players[i]['playerDetails'].id == response['playerDetails'].id) {
							playerAdded = true;
							players[i] = response;
						}
					}
					if(!playerAdded)
						players.push(response);
					if(drawTable)
						inst.displayTable();
					else
						inst.displayCards();

					hockeyManCommon.closeModal();
				}
			},
			error: function(data) {
				console.log("Error Adding Player "+data);
			}

		});//.fail(function( jqXHR, textStatus ) { alert( "Error making Request "+textStatus ); });
	}

	/**
	 * add the player modal & fill it with the info from the existing player
	 * @param  {[type]} id [description]
	 * @return {[type]}    [description]
	 */
	this.editPlayer = function(id) {
		var playerToEdit;
		for (var i = players.length - 1; i >= 0; i--) {
			if(players[i]['playerDetails'].id == id)
				playerToEdit = players[i];
		};
		inst.displayPlayerModal(playerToEdit);

	}

	this.displayPlayerModal = function(existingPlayer) {

		var inputForm = $(document.createElement('form'));
		inputForm.attr('id', 'addPlayerForm');

		var formInputs = [];

		formInputs['id'] = $(document.createElement("input"));
			formInputs['id'].attr({
				type: "hidden",
				name: "id" 
			});
		formInputs['fname'] = $(document.createElement("input"));
			formInputs['fname'].attr({
				type: "text",
				name: "fname" 
			});
		formInputs['lname'] = $(document.createElement("input"));
			formInputs['lname'].attr({
				type: "text",
				name: "lname" 
			});
		formInputs['phone'] = $(document.createElement("input"));
			formInputs['phone'].attr({
				type: "text",
				name: "phone" 
			});
		formInputs['email'] = $(document.createElement("input"));
			formInputs['email'].attr({
				type: "text",
				name: "email" 
			});
		formInputs['position'] = $(document.createElement("input"));
			formInputs['position'].attr({
				type: "text",
				name: "position" 
			});
		formInputs['teamid'] = $(document.createElement("input"));
			formInputs['teamid'].attr({
				type: "hidden",
				name: "teamid" 
			});

		if(!$.isEmptyObject(existingPlayer)) {
			formInputs['id'].val(existingPlayer['playerDetails'].id);
			formInputs['fname'].val(existingPlayer['playerDetails'].fname);
			formInputs['lname'].val(existingPlayer['playerDetails'].lname);
			formInputs['phone'].val(existingPlayer['playerDetails'].phone);
			formInputs['email'].val(existingPlayer['playerDetails'].email);
			formInputs['position'].val(existingPlayer['playerDetails'].position);
			formInputs['teamid'].val(existingPlayer['playerDetails'].teamid);
		}
		var submitButton 	= hockeyManCommon.buildButton("submit", "Submit", inst.addPlayer, inputForm);
		var closeButton 	= hockeyManCommon.buildButton("close", "Close", hockeyManCommon.closeModal, "");

		for (var input in formInputs) {	if (formInputs.hasOwnProperty(input)) { 

				var div = $(document.createElement('div'))
				div.addClass('modalInputRow');
				var text = "";
				switch (input) {
					case 'fname':
						text = "First Name: ";
						break;
					case 'lname':
						text = "Last Name: ";
						break;
					case 'phone':
						text = "Phone: ";
						break;
					case 'email':
						text = "Email: ";
						break;
					case 'position':
						text = "Position: ";
						break;
				}
				div.append(text, formInputs[input]);
				inputForm.append(div);
			}}
		var div = $(document.createElement('div'));
		div.addClass('modalActions');
		div.append(submitButton, closeButton);
		inputForm.append(div);

		$(document.createElement('div'))
			.addClass('defaultMessage')
			.append(inputForm).prependTo( "body" );
	}



	/**
	 * organizes the players into cards for display
	 * @return {[type]} [description]
	 */
	this.displayCards = function() {
		var cards = $(document.createElement('div'));
		cards.attr('id','gameCards');
		for (var i = players.length - 1; i >= 0; i--) {

			var div = $(document.createElement('div'));
			div.addClass('playerCard');
			div.attr('id', players[i]['playerDetails'].id);

			var name = $(document.createElement('h3'));
			name.html(players[i]['playerDetails'].fname + "<br>" + players[i]['playerDetails'].lname);

			var phone = $(document.createElement('p'));
			phone.text(players[i]['playerDetails'].phone);

			var email = $(document.createElement('p'));
			email.text(players[i]['playerDetails'].email);
			if(players[i]['playerDetails'].emailconfirm == '1')
				email.addClass('emailConfirmed');
			else if(players[i]['playerDetails'].emailconfirm == 'NO')
				email.addClass('emailUndesired');
			else
				email.addClass('emailUnconfirmed');

			var position = $(document.createElement('p'));
			position.text(players[i]['playerDetails'].position);



			div.append(name, phone, email, position,'<div class="actionsCell"></div>');
			cards.append(div);
		}
		hockeyManCommon.changeStage(cards);
		inst.handleActions(cards);
	}

	/**
	 * organizes each Player into a row in the table
	 * @return {[type]} [description]
	 */
	this.displayTable = function() {
		var table = $(document.createElement('table'));
		table.attr('id', 'playersTable');
		table.append("<thead><tr><td>First Name</td><td>Last Name</td><td>Phone</td><td>Email</td><td>Position</td><td></td></thead></tr><tbody>");
		for (var i = players.length - 1; i >= 0; i--) {
			tr = $(document.createElement('tr'));
			tr.attr('id', players[i]['playerDetails'].id);
			tr.addClass("playerRow");

			var fname = $(document.createElement('td'))
			fname.text(players[i]['playerDetails'].fname);
			var lname = $(document.createElement('td'))
			lname.text(players[i]['playerDetails'].lname);
			var phone = $(document.createElement('td'))
			phone.text(players[i]['playerDetails'].phone);

			var email = $(document.createElement('td'))
			email.text(players[i]['playerDetails'].email);
			if(players[i]['playerDetails'].emailconfirm == '1')
				email.addClass('emailConfirmed');
			else if(players[i]['playerDetails'].emailconfirm == 'NO')
				email.addClass('emailUndesired');
			else
				email.addClass('emailUnconfirmed');

			var position = $(document.createElement('td'))
			position.text(players[i]['playerDetails'].position);

			tr.append(fname, lname, phone, email, position, "<td class='actionsCell'></td>");
			table.append(tr);
		};
		table.innerHTML += "</tbody>";
		hockeyManCommon.changeStage(table);
		inst.handleActions(table);
	}
}

jQuery( document ).ready(function( $ ) {

	/* = Main Switch	
	-------------------------------------------------------------------------*/
	if (typeof games != 'undefined') {
		//GAMES PAGE
		if(games.length == 1)
			$('#GamesStage').append("<h2>You have no events scheduled! Click 'Add Game' above to start!");
    	
    	var gamesPage = new HockeyManGamesPage(games, $('#GamesStage'));
    	gamesPage.init();
    	gamesPage.displayTable();

    } else if ( typeof players != 'undefined' ) {
    	//PLAYERS PAGE
    	if(players.length == 1)
			$('#PlayersStage').append("<h2>You have no Players! Click 'Add Player' above to start!");
    	
    	var playersPage = new HockeyManPlayersPage(players, $('#PlayersStage'));
    	playersPage.init();
    	playersPage.displayTable();
    }

    // -- Might be better somewhere else???
	$('#defaultMessageClose').click(function() {
		$('.defaultMessage').fadeOut('fast');
	});

});

