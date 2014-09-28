<?php
require_once 'HockeyManConstants.php';

/**
 * @package HockeyMan	
 * @version 0.1
 */
/*
Plugin Name: Hockey Manager
Plugin URI: http://incitepromo.com
Description: A game manager for hockey games and teams.
Author: Will Fowler
Version: 0.1
Author URI: http://willfowlerdesign.wordpress.com
*/

/**
 * 	HockeyMan Class
 *	Performs Meta-actions for games and players.
 */
class HockeyMan 
{
	public $players = array();
	public $games = array();

	function __construct($buildPlayers = true, $buildGames = true)
	{
		//get current user
		global $current_user;
    	get_currentuserinfo();
   		$id = $current_user->ID;

   		if ( is_user_logged_in() ) {

			//Build the players
			if($buildPlayers)
				$this->buildPlayers($id);

			//build the games.
			if($buildGames)
				$this->buildGames($id);
		}

		function sortGames($a, $b) {
			return $b->date - $a->date;
		}
		usort($this->games, "sortGames");
	}

	public function buildGames($id) {
		global $wpdb;
		//build the games
		$gamesSQL = 'SELECT * FROM `'.GAMES_TABLE.'` WHERE `userid` = '.$id;
		$games = $wpdb->get_results($gamesSQL, ARRAY_A);

		foreach ($games as $game) {
			$this->games[] = new hockeyManGame(
				$game['datetime'],
				$game['desc'],
				$game['loc'],
				$game['userid'],
				$game['id']
				);
		}
	}

	public function buildPlayers($id) {
		global $wpdb;
		//Build the players
		$playerSQL = 'SELECT * FROM `'.PLAYERS_TABLE.'` WHERE `teamid` = '.$id;
		$players = $wpdb->get_results($playerSQL, ARRAY_A);
		
		foreach ($players as $player) {
			$this->players[] = new HockeyManPlayer(
				$player['id'],
				$player['fname'],
				$player['lname'],
				$player['phone'],
				$player['email'],
				$player['emailconfirm'],
				$player['address'],
				$player['position'],
				$player['teamid']);
		}
	}

	function jsonGames() {
		return json_encode($this->games);
	}

	function jsonPlayers() {
		return json_encode($this->players);
	}

	/*
	 *	Show all Games including submission form.
	 */
	function showGames() {
		$date = getdate();
		global $current_user;
    	get_currentuserinfo();

    	//wrap whole table in form.
		$r = '<form method="POST">'; 
			$r .= '<table id="gameTable">';
				$r .= '<tr>
					<td>Game ID</td>
					<td>Date/Time</td>
					<td>Description</td>
					<td>Location</td>
					</tr>';

				//Loop through games and add each as a row
				$i = 1;
				foreach ($this->games as $game) {

					//Show dates from last year only
					$passed = date("U", $game->date) > $date[0];
					if( date("U", $game->date) > strtotime(date('Y-m-d', $date[0])." -1 year") ){
						$r .= '<tr>
							<td>'.$i.'</td>
							<td>'.$game->getDate("Y-M-d g:i A").'<br>';
								$r .= $game->renderform_id();
								$r .= $game->renderform_date();
								$r .= $game->renderform_timeHR();
								$r .= $game->renderform_timeMN();
						$r .= '</td><td>'.$game->desc;
							$r.= $game->renderform_desc();
						$r .= '</td><td>'.$game->loc;
							$r.= $game->renderform_location();
							$r .= $game->renderform_creator();
						$r .= '</td></tr>';
						$i++;
					}
				}
			$r .= '</table>';
		$r .= '<input type="submit" value="Save Games"></form>';

		//Adding a form for adding an new game.
		$blankGame = new HockeyManGame(date("Y-M-d h:i:s", $date[0]),"Description","Location","","","","");
		$r .= $blankGame->buildForm();

		//TODO: 
		//$r .= json_encode($this->games);

		return $r;
	}

	/*
	 * return all players in a table
	 */
	function tabularPlayers() {
		global $current_user;
    	get_currentuserinfo();

		$r = '<form method="POST">';
		$r .= '<table id="playerTable" data-user='.$current_user->ID.'>';
		$r .=	'<tr>
					<td></td>
					<td>First Name</td>
					<td>Last Name</td>
					<td>Phone</td>
					<td>Email</td>
					<td>Address</td>
					<td>Position</td>
				</tr>';

		//existing Players
		$i = 0;
		foreach ($this->players as $player) {
			$i++;
			$r .= '<tr>';
				$r .= '<td>'.$i.'</td>';
				$r .= '<td>'.$player->getid_input().'<p>'.$player->getfname().'</p>'.$player->getfname_input().'</td>';
				$r .= '<td><p>'.$player->getlname().'</p>'.$player->getlname_input().'</td>';
				$r .= '<td><p>'.$player->getphone().'</p>'.$player->getphone_input().'</td>';
				$r .= '<td><p>'.$player->getemail().'</p>'.$player->getemail_input().$player->getemailconfirm_input().'</td>';
				$r .= '<td><p>'.$player->getaddress().'</p>'.$player->getaddress_input().'</td>';
				$r .= '<td><p>'.$player->getposition().'</p>'.$player->getposition_input().'<input class="userID" type="hidden" name="teamid[]" value="'.$current_user->ID.'"></td>';
			$r .= '</tr>';
		}
		$r .= '</table>';
		$r .= '<input id="savePlayers" type="submit" value="Save All"></form>';
		$r .= '<button id="addPlayer">Add Player</button>';
		return $r;
	}

	/**
	 * Default Message View
	 */
	function defaultMessage($msg) {
		return '<div class="defaultMessage"><p>'.$msg.'</p><input id="defaultMessageClose" type="button" value="close" /></div>';
	}

	/**
	 * Get's the user's time zone
	 */
	function getUserTimeZone() {
		global $current_user;
    	get_currentuserinfo();
    	return get_the_author_meta( 't_zone', $this->creator );
	}

	/**
	 * [sendConfirmationEmail description]
	 * @return [type] [description]
	 */
	function sendConfirmationEmail($player) {
		global $current_user;
		get_currentuserinfo();
		$fname = $current_user->user_firstname;
		$lname = $current_user->user_lastname;
		$player->confirmEmail($fname, $lname);
	}
}

/**
 * = Wordpress Hooks
 * ----------------------------------------------------------------------------
 */

/*
* Add menu to backend
*	TODO: Make this a meta function only available to admin & to show all teams, etc.
*/
function addHockeyManMenu() {
    add_menu_page( 'Hockey Manager By Will Fowler', 'Hockey Manager', 'manage_options', 'hockeyMan/hockeyMan-admin.php', '', plugins_url( 'myplugin/images/icon.png' ), 6 );
}
add_action( 'admin_menu', 'addHockeyManMenu' );

/*
* Function to add the manage players tag to page
*/
function load_hockeyManPlayers( ) {
    $hockeyMan = new HockeyMan();
	//return $hockeyMan->tabularPlayers();
	return "<div id='PlayersStage'></div><script type='text/javascript'>var players = ".$hockeyMan->jsonPlayers()."; var nonce = '".wp_create_nonce("hockeyMan_nonce")."';</script>";
}
add_shortcode( 'hockeyManPlayers', 'load_hockeyManPlayers' );

/*
* Function to add the manage games tag to page
*/
function load_hockeyManGames( ) {
    $hockeyMan = new HockeyMan();
	//return $hockeyMan->showGames();
	return "<div id='GamesStage'></div><script type='text/javascript'>var games = ".$hockeyMan->jsonGames()."; var nonce = '".wp_create_nonce("hockeyMan_nonce")."';</script>";
}
add_shortcode( 'hockeyManGames', 'load_hockeyManGames' );

/**
 * Add the scripts
 */
function hockeyMan_scripts() {
	//TODO: add style!
	wp_enqueue_style( 'hockeyMan', plugins_url( '/css/HockeyMan.css' , __FILE__ ) ); 

	//wp_enqueue_script( 'jQuery', '//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js', array(), '1.10.2', true );
	wp_enqueue_script( 'jQueryui', '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js', array(), '1.10.3', true );
	//wp_enqueue_script( 'HockeyMan', plugins_url( '/js/HockeyMan.js' , __FILE__ ), array(), '1.0.0', true );
	
	wp_enqueue_script( 'TimePicker', plugins_url( '/js/TimePicker.js' , __FILE__ ), array(), '1.4.3', true );

	wp_enqueue_script( 'HockeyManUI', plugins_url( '/js/HockeyManUI.js' , __FILE__ ), array(), '1.0.0', true );
	wp_localize_script( 'HockeyManUI', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));  
	
}

add_action( 'wp_enqueue_scripts', 'hockeyMan_scripts' );

function hockeyMan_sendGameConfirmation($gameInfo, $playerIDs) {

	foreach ($playerIDs as $id) {
		$player = HockeyManPlayer::buildPlayerByID($id);
		$player->sendGameConfirmationEmail($gameInfo);
	}
}

add_action( 'hockeyMan_send_game_conf', 'hockeyMan_sendGameConfirmation', 10, 2 );

function hockeyMan_sendGameCancellation($gameInfo, $playerIDs) {

	foreach ($playerIDs as $id) {
		$player = HockeyManPlayer::buildPlayerByID($id);
		$player->sendGameCancellationEmail($gameInfo);
	}
}

add_action( 'hockeyMan_send_game_canc', 'hockeyMan_sendGameCancellation', 10, 2 );

function hockeyMan_sendGameSummary($gameInfo, $playerIDs) {

	$somePlayers = array();
	$attendanceInfo = array();
	foreach ($playerIDs as $id) {
		$player = HockeyManPlayer::buildPlayerByID($id);
		$somePlayers[] = $player;
		$attendanceInfo[$id]['response'] = HockeyManGame::getAttendeeResponse($gameInfo['id'], $id);
	}

	foreach ($somePlayers as $player) {
		$attendanceInfo[$player->getid()]['name'] = $player->getfname()." ".$player->getlname();
		$attendanceInfo[$player->getid()]['position'] = $player->getposition();
	}

	foreach ($somePlayers as $player) {
		$player->sendGameSummaryEmail($gameInfo, $attendanceInfo);
	}

}
add_action( 'hockeyMan_send_game_summ', 'hockeyMan_sendGameSummary', 10, 2 );

/*
*	In case I need to build something when they login, here it goes
*/
function hockeyManInit() {
    // your code
}
add_action('wp_login', 'hockeyManInit');

/**
 * Add Timezone field to user options page
 */

add_action( 'show_user_profile', 'hockeyMan_show_timezone_input' );
add_action( 'edit_user_profile', 'hockeyMan_show_timezone_input' );
add_action( 'register_form','hockeyMan_show_timezone_input' );

function hockeyMan_show_timezone_input ( $user ) {
	?>
		<h3>Timezone</h3>
		<select name="t_zone">
	<?php 

	$tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
	foreach ($tzlist as $tz) {
		echo '<option value="'.$tz.'" ';
		if(esc_attr( get_the_author_meta( 't_zone', $user->ID ) ) == $tz)
			echo 'selected="selected"';
		echo '>'.$tz.'</option>';
	}
	?>
	</select>
	<?php

	
}


add_action ( 'personal_options_update', 'hockeyMan_save_user_timezone' );
add_action ( 'edit_user_profile_update', 'hockeyMan_save_user_timezone' );

function hockeyMan_save_user_timezone( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;
	/* Copy and paste this line for additional fields. Make sure to change 'twitter' to the field ID. */
	update_usermeta( $user_id, 't_zone', $_POST['t_zone'] );
}

/**
 * Add timezone field to registration form
 */

add_action('register_post','check_fields',10,3);
add_action('user_register', 'register_extra_fields');

function check_fields ( $login, $email, $errors )
{
	global $timezone;
	if ( $_POST['t_zone'] == '' )
	{
		$errors->add( 'empty_realname', "<strong>ERROR</strong>: Please Enter your timezone" );
	}
	else
	{
		$timezone = $_POST['t_zone'];
	}
}

function register_extra_fields ( $user_id, $password = "", $meta = array() )
{
	update_user_meta( $user_id, 't_zone', $_POST['t_zone'] );
}



/**
 * = Form Dealings
 * ----------------------------------------------------------------------------
 */
add_action('template_redirect', 'hockeyManCheckPost');

function hockeyManCheckPost(){

	/**
	 *	Saving/Adding players
	 */
	if(	isset($_POST['id']) &&
		isset($_POST['fname']) &&
		isset($_POST['lname']) &&
		isset($_POST['phone']) &&
		isset($_POST['email']) &&
		isset($_POST['emailconfirm']) &&
		isset($_POST['address']) &&
		isset($_POST['position']) &&
		isset($_POST['teamid']) ) {

		$id 		= $_POST['id'];
		$fname 		= $_POST['fname'];
		$lname 		= $_POST['lname'];
		$phone 		= $_POST['phone'];
		$email 		= $_POST['email'];
		$emailconfirm = $_POST['emailconfirm'];
		$address 	= $_POST['address'];
		$position 	= $_POST['position'];
		$teamid 	= $_POST['teamid'];

		foreach ($id as $key => $value) {
			$player = new HockeyManPlayer($id[$key], $fname[$key], $lname[$key], $phone[$key], $email[$key], $emailconfirm[$key], $address[$key], $position[$key], $teamid[$key]);
			$player->save();
			if($id[$key] == "") {
				HockeyMan::sendConfirmationEmail($player);
			}
		}

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	/**
	 * Resending Player Email Confirmation
	 */
	if( isset($_POST['playerid']) &&
		isset($_POST['resend'])) {
		$player = HockeyManPlayer::buildPlayerByID($_POST['playerid']);
		HockeyMan::sendConfirmationEmail($player);
		echo HockeyMan::defaultMessage("Thanks, an email was sent to ".$player->getfname().",<br> Please let them know to click on the link in the email so they receive your invites, (if it's not in their inbox, tell them to check their spam/junk folder)");
	}

	/**
	 * Saving Games
	 */
	if( isset($_POST['id']) &&
		isset($_POST['date']) &&
		isset($_POST['timeHR']) &&
		isset($_POST['timeMN']) &&
		isset($_POST['ampm']) &&
		isset($_POST['location']) &&
		isset($_POST['description']) &&
		isset($_POST['creator'])) {

		$id = $_POST['id'];
		global $current_user;
		get_currentuserinfo();


		foreach ($id as $key => $value) {

			//Deal with times after noon, or 12AM
			if( $_POST['ampm'][$key] == "PM" && $_POST['timeHR'][$key] != 12 )
				$_POST['timeHR'][$key] += 12;
			elseif ( $_POST['ampm'][$key] == "AM" && $_POST['timeHR'][$key] == 12 ) 
				$_POST['timeHR'][$key] -= 12;
			
			
			$date 			= $_POST['date'][$key] . ' ' . $_POST['timeHR'][$key] . ':' . $_POST['timeMN'][$key].':00 ';

			$datetime = new DateTime($date, new DateTimeZone(get_the_author_meta('t_zone',$current_user->ID)) );
			$datetime->setTimezone(new DateTimeZone('UTC'));

			$location 		= $_POST['location'][$key];
			$description 	= $_POST['description'][$key];
			$creator 		= $_POST['creator'][$key];

			$game 			= new HockeyManGame($datetime->format('Y-m-d H:i:s'), $description, $location, $creator, $id[$key]);

			if( $game->saveGame() == 0 ){
				//Here is a new game. 
				//all players need to be set up as unconfirmed in the attendance table
				$gameInstance = new HockeyMan();
				$game->addNewPlayers($gameInstance->players);
			}
			
		}

		header('Location: ' . $_SERVER['HTTP_REFERER']);
	}

	/**
	 * Confirming Player Attendance
	 */
	if(	isset($_GET['gameid']) &&
		isset($_GET['playerid']) &&
		isset($_GET['inout'])) {
		global $wpdb;
		$wpdb->query( $wpdb->prepare( "
			UPDATE ".ATTENDANCE_TABLE." 
			SET `1n0ut` = '%s' 
			WHERE `playerid` = %s 
			AND `gameid` = %s
			",
			$_GET['inout'],
			$_GET['playerid'],
			$_GET['gameid']));
		$player = HockeyManPlayer::buildPlayerByID($_GET['playerid']);
		echo HockeyMan::defaultMessage("Thanks, ".$player->getfname());
	}

	/**
	 * Confirming Player Email
	 */
	if( isset($_GET['econfirm']) ) {
		global $wpdb;
		$sql = "
			SELECT * 
			FROM ".PLAYERS_TABLE." 
			WHERE emailconfirm=%s
		";
		$playerRow = $wpdb->get_row( $wpdb->prepare($sql, $_GET['econfirm']), ARRAY_A );

		$player = HockeyManPlayer::buildPlayerByID($playerRow['id']);
		$player->confirmedEmailAddress();
		echo HockeyMan::defaultMessage("Thank you ".$player->playerDetails['fname']." for confirming your email, if you don't wish to recieve emails from this site, please click this link to unconfirm<br>");
	}

	/**
	 * Deleting a Player
	 */
	if (isset($_GET['reallyDelete']) &&
		isset($_GET['playerid'])) {
		$player = HockeyManPlayer::buildPlayerByID($_GET['playerid']);
		global $wpdb;

		$sql = "
			DELETE FROM ".ATTENDANCE_TABLE."
			WHERE playerid=%s
		";

		$wpdb->query($wpdb->prepare($sql, $_GET['playerid']));

		$sql = "
			DELETE FROM ".PLAYERS_TABLE."
			WHERE id=%s
		";
		if($wpdb->query($wpdb->prepare($sql, $_GET['playerid'])))
			echo HockeyMan::defaultMessage($player->getfname()." Deleted.");
	}

	/**
	 * Delete a Game
	 */
	if(isset($_GET['reallyDelete']) &&
		isset($_GET['gameid'])) {

/*
		global $wpdb;

		$playerIDList = $wpdb->get_results(
			$wpdb->prepare( "
				SELECT `playerid` FROM `".ATTENDANCE_TABLE."`
				WHERE `gameid` = %s
				",
				$_GET['gameid'] ), ARRAY_N);

		foreach ($playerIDList as $id) {
					$listOfPlayers[] = HockeyManPlayer::buildPlayerByID($id);
				}
*/

		$game = HockeyManGame::buildGameByID($_GET['gameid']);

		$game->getAttendees();
		/*
		foreach ($game->attendees as $playerid) {
			$listOfPlayers[] = HockeyManPlayer::buildPlayerByID($playerid);
		}
		*/

		//echo HockeyMan::defaultMessage(print_r($game));

		if( $game->deleteGame($game->attendees) )
			echo HockeyMan::defaultMessage($game->desc." Deleted.");
		else
			echo HockeyMan::defaultMessage("Game Unable to Be Deleted");

	}
}