<?php

/**
 * Ajax Malarky found herein...
 */

/**
 * Deleting a game
 */
add_action("wp_ajax_delete_game", "wp_ajax_delete_the_game");
add_action("wp_ajax_nopriv_delete_game", "wp_ajax_nopriv_delete_the_game");
function wp_ajax_delete_the_game() {

	if ( !wp_verify_nonce( $_REQUEST['nonce'], "hockeyMan_nonce"))
    	header("Location: http://i.imgur.com/65goE8v.gif");

   	$game = HockeyManGame::buildGameByID($_REQUEST['gameid']);
	$game->getAttendees();
	if( $game->deleteGame($game->attendees) )
		$result = $game->id;
	else
		$result = -1;

   	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
		echo $result;
   	else
    	header("Location: ".$_SERVER["HTTP_REFERER"]);
    die();
}
function wp_ajax_nopriv_delete_the_game() {
	echo "You must log in to do that";
	die();
}

/**
 * Adding a Game
 */
add_action("wp_ajax_add_game", "wp_ajax_add_the_game");
function wp_ajax_add_the_game() {

	if ( !wp_verify_nonce( $_REQUEST['nonce'], "hockeyMan_nonce"))
    	header("Location: http://i.imgur.com/65goE8v.gif");


	global $current_user;
	get_currentuserinfo();


	$userid 		= $current_user->ID;
	$datetimein		= $_REQUEST['dateTime'];
	$location 		= $_REQUEST['location'];
	$description 	= $_REQUEST['description'];
	$teamid 		= $_REQUEST['teamid'];	


	$datetime = new DateTime($datetimein, new DateTimeZone(get_the_author_meta('t_zone',$userid)) );
	$datetime->setTimezone(new DateTimeZone('UTC'));
	
	$game = new HockeyManGame($datetime->format('Y-m-d H:i:s'), $description, $location, $userid, "");


	if( $game->saveGame() == 0 ){
		//Here is a new game. 
		//all players need to be set up as unconfirmed in the attendance table
		$gameInstance = new HockeyMan();
		$game->addNewPlayers($gameInstance->players);
	}
		

    //DEFINE THE RESULT
   	$result = json_encode($game);

   	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
		echo $result;
   	else
    	header("Location: ".$_SERVER["HTTP_REFERER"]);
    die();
}

/**
 * Adding a Player
 */
add_action("wp_ajax_add_player", "wp_ajax_add_the_player");
function wp_ajax_add_the_player() {

	if ( !wp_verify_nonce( $_REQUEST['nonce'], "hockeyMan_nonce"))
    	header("Location: http://i.imgur.com/65goE8v.gif");

    global $current_user;
	get_currentuserinfo();

    $id 		= $_REQUEST['id'];
	$fname 		= $_REQUEST['fname'];
	$lname 		= $_REQUEST['lname'];
	$phone 		= $_REQUEST['phone'];
	$email 		= $_REQUEST['email'];
	$emailconfirm = $_REQUEST['emailconfirm'];
	$address 	= $_REQUEST['address'];
	$position 	= $_REQUEST['position'];

	$teamid 	= $current_user->ID; // << TO DO: make multiple teams a thing.
	//$teamid 	= $_REQUEST['teamid'];

	$player = new HockeyManPlayer($id, $fname, $lname, $phone, $email, $emailconfirm, $address, $position, $teamid);

	$player->save();

	if(is_null($id)) {
		HockeyMan::sendConfirmationEmail($player);
	}

	$result = json_encode($player);

   	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
		echo $result;
   	else
    	header("Location: ".$_SERVER["HTTP_REFERER"]);
    die();

}