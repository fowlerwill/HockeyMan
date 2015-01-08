<?php 

/* = EVENT ACTIONS
-----------------------------------------------------------------------------*/


/**
 * Adding an Event
 */
add_action("wp_ajax_add_event", "wp_ajax_add_the_event");
function wp_ajax_add_the_event() {

	//if ( !wp_verify_nonce( $_REQUEST['nonce'], "TeamManager_nonce"))
    	//die();

	$datetime		= DateTime::createFromFormat("D, d M Y H:i:s O", $_REQUEST['dateTime']);
	$location 		= $_REQUEST['location'];
	$description 	= $_REQUEST['description'];
	$notes 			= $_REQUEST['notes'];	
	$teamid 		= $_REQUEST['teamid'];	
	
	$team 	= TeamManagerTeam::buildExisting($teamid);
	$event 	= new TeamManagerEvent($description, $notes, $datetime, $location);
	$team->addEvent($event);		

    //DEFINE THE RESULT
   	$result = json_encode($event->getShortDetails());

   	//$result = json_encode($datetime);

   	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
		echo $result;
   	else
    	header("Location: ".$_SERVER["HTTP_REFERER"]);
    die();
}

/**
 * Retrieve Event Info
 */
add_action("wp_ajax_get_event", "wp_ajax_get_the_event");
function wp_ajax_get_the_event() {
	$eventId = $_REQUEST['id'];
	$event = TeamManagerEvent::buildExisting($eventId);

	$result = json_encode($event->getAllDetailsAndAttendance());
	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
		echo $result;
   	else
    	header("Location: ".$_SERVER["HTTP_REFERER"]);

    die();
}



/* = TEAM ACTIONS
-----------------------------------------------------------------------------*/

/**
 * Saving Team Settyings
 */
add_action("wp_ajax_save_team_settings", "wp_ajax_save_the_team_settings");
function wp_ajax_save_the_team_settings() {

	$teamId = $_REQUEST['teamId'];
	$teamName = $_REQUEST['teamName'];
	$timezone = $_REQUEST['timezone'];
	$invitationDelay = (int)$_REQUEST['invitationDelay'] * 3600;
	$summaryDelay = (int)$_REQUEST['summaryDelay'] * 3600;
	$maxMembers = $_REQUEST['maxMembers'];
	$minMembers = $_REQUEST['minMembers'];

	$team = TeamManagerTeam::buildExisting($teamId);
	$result = array();
	$result['response'] = $team->setAllSettings($teamName, $timezone, $invitationDelay, $summaryDelay, $maxMembers, $minMembers);

	$result['settings'] = $team->getAllSettings();

	if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
		echo json_encode($result);
   	else
    	header("Location: ".$_SERVER["HTTP_REFERER"]);

    die();
}

/* = COMMON ACTIONS
-----------------------------------------------------------------------------*/

/**
 * Retrieve List of timezones
 */
add_action("wp_ajax_get_timezones", "wp_ajax_get_the_timezones");
function wp_ajax_get_the_timezones() {
	function formatOffset($offset) {
	        $hours = $offset / 3600;
	        $remainder = $offset % 3600;
	        $sign = $hours > 0 ? '+' : '-';
	        $hour = (int) abs($hours);
	        $minutes = (int) abs($remainder / 60);

	        if ($hour == 0 AND $minutes == 0) {
	            $sign = ' ';
	        }
	        return $sign . str_pad($hour, 2, '0', STR_PAD_LEFT) .':'. str_pad($minutes,2, '0');
	}

	$utc = new DateTimeZone('UTC');
	$dt = new DateTime('now', $utc);
	$r = array();
	foreach(DateTimeZone::listIdentifiers() as $tz) {
	    $current_tz = new DateTimeZone($tz);
	    $offset =  $current_tz->getOffset($dt);
	    $transition =  $current_tz->getTransitions($dt->getTimestamp(), $dt->getTimestamp());
	    $abbr = $transition[0]['abbr'];

	    $r[] = array(
	    	'value'	=> $tz,
	    	'eng'	=> $tz.' ['.$abbr.' '.formatOffset($offset).']');
	}

	echo json_encode($r);

	die();
}