/**
 * HockeyMan Javascript Object to store shit for DOM
 */
var HockeyMan = function() {

	//adds a row to the player table that has the appropriate forms and whatnot.
	this.renderNewPlayerRow = function(userID) {
		var r;
		r = '<tr class="newPlayerRow">' +
			'<div class="newPlayerRowDiv">' +
			'<td>New Player</td>' +
			'<td><input type="hidden" name="id[]" value=""><input style="display:block;" type="text" name="fname[]" value="First Name"></td>' +
			'<td><input style="display:block;" type="text" name="lname[]" value="Last Name"></td>' + 
			'<td><input style="display:block;" type="text" name="phone[]" value="(xxx) xxx-xxxx"></td>' +
			'<td><input style="display:block;" type="text" name="email[]" value="name@example.com"><input type="hidden" name="emailconfirm[]" value="0"></td>' +
			'<td><input style="display:block;" type="text" name="address[]" value="123 Fake RD."></td>' +
			'<td><input style="display:block;" type="text" name="position[]" value="Position"><input type="hidden" name="teamid[]" value="'+userID+'"></td>' +
			'</div>' +
			'</tr>';
		return r;
	}

	// renders a row to add
	this.renderEmptyRow = function() {
		return '<tr><td class="blankRow" colspan="7"></td></td>';
	}

	// renders a form to send a confirmation email
	this.renderEmailConfirmation = function(playerID) {
		var r = '';
		r = '<form id="playerAction-'+playerID+'" method="POST">'+
				'<input type="hidden" name="playerid" value="'+playerID+'">'+
				'<input type="hidden" name="resend" value="1">'+
				'<input type="submit" value="Resend Confirmation">'+
			'</form>';
		return r;
	}

	// Render a delete player button
	this.renderDeletePlayer = function(playerID) {
		s = '<input id="playerAction-'+playerID+'" type="button" onclick="confirmPlayerDelete('+playerID+')" value="Delete Player">';
		return s;
	}

	// Render a delete game button
	this.renderDeleteGame = function(gameID) {
		s = '<input id="gameAction-'+gameID+'" type="button" onclick="confirmGameDelete('+gameID+')" value="Delete Game">';
		return s;
	}
}
//todo bind to clicks
function confirmPlayerDelete(playerID) {
		if (confirm("Delete Account?"))
                 location.href = document.URL+'&reallyDelete=1&playerid='+playerID;
	}

function confirmGameDelete(gameID) {
		if (confirm("Delete Game?"))
                 location.href = document.URL+'&reallyDelete=1&gameid='+gameID;
	}

jQuery( document ).ready(function( $ ) {

	function alignPlayerAction(playerID, parentElement) {
		var pos = parentElement.offset();
		$('#playerAction-'+playerID).css({
			position: "absolute",
	        top: pos.top + "px",
	        left: pos.left + "px"
		});
	}

	//herein, let's do some jquery magic...
	var hm = new HockeyMan();

	//Swap first td to say Edit on Row hover
	var rowNum = '';
	$('#playerTable tr, #gameTable tr').slice(1).hover(function() {
		rowNum = $(this).children('td:first-child').html();
		if(!$(this).hasClass('editing')) 
			$(this).children('td:first-child').html("edit");
	}, function() {
		$(this).children('td:first-child').html(rowNum);
	});

	//click edit to replace text with forms
	$('#playerTable tr, #gameTable tr').slice(1).click(function(event) {
		$(this).hover(function(event) {	event.preventDefault();	});

		var toolRow = hm.renderEmptyRow();
		$(this).before(toolRow).hide().show('400');
		$(this).addClass('editing');
		$('#savePlayers').fadeIn();
		$(this).children('td').each(function() {
			 $(this).children('p').hide();
			 $(this).children('input, select').fadeIn();
		});
		var playerID = $(this).children('td').children('.playerID').val();
		$('body').append(hm.renderDeletePlayer(playerID));
		var gameID = $(this).children('td').children('.gameID').val();
		$('body').append(hm.renderDeleteGame(gameID));

		alignPlayerAction(playerID, $(this).prev());

	});

	//Players with unconfirmed emails.
	$('input[name="emailconfirm[]"]').each(function() {
		if( $(this).val() == '1' ) {
			$(this).parent('td').addClass('emailConfirmed');
		} else if( $(this).val() == 'NO' ) {
			$(this).parent('td').addClass('emailUndesired');
		} else {
			$(this).parent('td').addClass('emailUnconfirmed');
			$('body').append(hm.renderEmailConfirmation($(this).parent('td').siblings().children('.playerID').val()));
		}
	});

	//add new player row when addPlayer clicked
	$('#addPlayer').click(function(event) {
		var userID = $('#playerTable').attr('data-user');
		$('#playerTable').append( hm.renderNewPlayerRow(userID) );
		$('#savePlayers').fadeIn();
	});

	//Close defaultMessage modals
	$('#defaultMessageClose').click(function() {
		$('.defaultMessage').fadeOut('fast');
	});

	$( ".datepicker" ).datepicker({ dateFormat: "yy-mm-dd" });

});