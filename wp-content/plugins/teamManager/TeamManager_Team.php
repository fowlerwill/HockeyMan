<?php

require_once 'TeamManager_Constants.php';

/**
 * Team Manager Plugin Team
 */
class TeamManagerTeam {
	public $id;
	private $settings 	= array(
		'name' 				=> "New Team",
		'timezone' 			=> "America/Edmonton",
		'invitation_delay' 	=> 259200,
		'summary_delay' 	=> 86400,
		'max_members'		=> 50,
		'min_members' 		=> 1);
	private $members 	= array();
	private $events 	= array();
	const MAX_TOTAL_MEMBERS = 50;

	/**
	 * Default Constructor Method
	 * @param String $id Identifier for Team
	 */
	public function __construct() {
		$this->id = uniqid('t');
		$this->save();
	}

	/**
	 * Alternate constructor for when the ID is given
	 * @param  String $id ID of the Team.
	 */
	public static function buildExisting($id) {
		global $wpdb;
		if(TEAMMANAGER_DEBUG_MODE) $wpdb->show_errors();

		$id = esc_sql($id);
		$teamResult = $wpdb->get_row('SELECT `teamobj` FROM '.TEAMS_TABLE.' WHERE `teamid`="'.$id.'"');

		if($teamResult)
			return unserialize($teamResult->teamobj);
		else
			return false;

	}
/*
	public function __wakeup() {
		$memberObjList = array();
		foreach ($this->members as $id) {
			$memberObjList[$id] = TeamManagerMember::buildExisting($id);
		}
		$this->members = $memberObjList;
	}

	public function __sleep() {
		$memberIDList = array();
		foreach ($this->members as $id => $member) {
			$memberIDList[] = $id;
		}
		$this->members = $memberIDList;
		return array('id', 'settings', 'members', 'events');
	}
*/

	/**
	 * Saves the current object
	 * @return [type] [description]
	 */
	public function save() {
		global $wpdb;
		if(TEAMMANAGER_DEBUG_MODE) $wpdb->show_errors();

		return $wpdb->replace( TEAMS_TABLE, 
			array('teamid' => $this->id, 'teamobj' => serialize($this))
			);
	}

	/* = GETTERS/SETTERS
	-------------------------------------------------------------------------*/
	public function getName() 				{ return $this->settings['name']; }
	public function getTimezone() 			{ return $this->settings['timezone']; }
	public function getInvitationDelay() 	{ return $this->settings['invitation_delay']; }
	public function getSummaryDelay() 		{ return $this->settings['summary_delay']; }
	public function getMaxMembers()			{ return $this->settings['max_members']; }
	public function getMinMembers()			{ return $this->settings['min_members']; }
	public function getAllSettings()		{ return $this->settings; }
	public function getEvents()				{ return $this->events; }
	public function getMembers()			{ return $this->members; }
	
	/*
	 * Build each members for retrival
	 */
	public function getMemberObjects() { 
		$memArray = array();
		foreach ($this->members as $memberId) {
		 	$member = TeamManagerMember::buildExisting($memberId);
		 	$memArray[] = $member->getAllDetails();
		}
		return $memArray;
	}

	public function getEventObjects()	{ 
		$eventArray = array();
		foreach ($this->events as $eventId) {
		 	$event = TeamManagerEvent::buildExisting($eventId);
		 	$eventArray[$eventId] = $event;
		}
		return $eventArray;
	}

	public function getShortEvents() {
		$shortEvents = array();
		$events = $this->getEventObjects();
		foreach ($events as $event) {
			$shortEvents[] = $event->getShortDetails();
		}
		return $shortEvents;
	}

	/*
	 * TODO: VALIDATE SET VALUES BETTER
	 */
	public function setName($name) {
			$this->settings['name'] = $name;
			return $this->save();
	}
	public function setTimezone($timezone) {
		try {
			new DateTimeZone($timezone);
			$this->settings['timezone'] = $timezone;
			return $this->save();
		} catch (Exception $e) {
			return false;
		}
	}
	public function setInvitationDelay($delay) {
		$delay = (int)$delay;
		if( $delay > 0) {
			$this->settings['invitation_delay'] = $delay;
			return $this->save();
		}
		else
			return false;
	}
	public function setSummaryDelay($delay) {
		$delay = (int)$delay;
		if( $delay > 0 && $delay < $this->getInvitationDelay() ) {
			$this->settings['summary_delay'] = $delay;
			return $this->save();
		}
		else
			return false;
	}
	public function setMaxMembers($max) {
		$max = (int)$max;
		if( $max <= self::MAX_TOTAL_MEMBERS && $max > 1 ) {
			$this->settings['max_members'] = $max;
			return $this->save();
		}
		else
			return false;
	}
	public function setMinMembers($min) {
		$min = (int)$min;
		if( $min >= 1 && $min < $this->getMaxMembers() ) {
			$this->settings['min_members'] = $min;
			return $this->save();
		}
		else
			return false;
	}

	/**
	 * Sets all settings for the team
	 * TODO: This could use far fewer save actions to reduce db accesses
	 * TODO: reschudle invitation & summary emails if different
	 * @param [type] $teamName        [description]
	 * @param [type] $timezone        [description]
	 * @param [type] $invitationDelay [description]
	 * @param [type] $summaryDelay    [description]
	 * @param [type] $maxMembers      [description]
	 * @param [type] $minMembers      [description]
	 */
	public function setAllSettings($teamName, $timezone, $invitationDelay, $summaryDelay, $maxMembers, $minMembers) {
		$rescheduleInvitations = false;
		$rescheduleSummaries = false;

		if($this->getInvitationDelay() != $invitationDelay)
			$rescheduleInvitations = true;
		if($this->getSummaryDelay() != $summaryDelay)
			$rescheduleSummaries = true;

		$this->setName($teamName);
		if(!$this->setTimezone($timezone))
			return "Timezone Error";
		if(!$this->setInvitationDelay($invitationDelay))
			return "Invitation Time Error";
		if(!$this->setSummaryDelay($summaryDelay))
			return "Summary Time Error";
		if(!$this->setMaxMembers($maxMembers))
			return "Max Members Error";
		if(!$this->setMinMembers($minMembers))
			return "Min Members Error";

		if($rescheduleInvitations)
			$this->rescheduleInvitations();
		else if($rescheduleSummaries)
			$this->rescheduleSummaries();

		return "Success";
	}

	private function rescheduleSummaries() {
		//Gimme something to do
	}
	private function rescheduleInvitations() {
		//Gimme somethging to do
	}

	/*
	 * You don't really set members & events so you add and remove them
	 */
	public function addMember($member) {
		if( $member instanceof TeamManagerMember &&
		sizeof($this->members) < $this->getMaxMembers() &&
		sizeof($this->members) < self::MAX_TOTAL_MEMBERS) {
			$this->members[] = $member->id;
			$this->save();
			return $member;
		}
		else
			return false;
	}
	public function addEvent($event) {
		if( $event instanceof TeamManagerEvent ) {
			$this->events[] = $event->id;
			$event->setUpAttendees($this->getMembers());
			$this->save();
		}
		else
			return false;
	}
	public function removeMember($id) {
		if( array_key_exists($id, $this->members) ) {
			unset($this->members[$id]);
			$this->save();
		}
		else
			return false;
	}
	public function removeEvent($id) {
		if( array_key_exists($id, $this->events) ) {
			unset($this->events[$id]);
			$this->save();
		}
		else
			return false;
	}


	/* = VIEWS
	-------------------------------------------------------------------------*/

	/**
	 * Display the Team Events without reliance on Javascript
	 * @return HTML
	 */
	public function getNoScriptTeamEvents() {
		//TODO return HTML of the events in a no script way
		return "No Script Version Coming Soon";
	}

	/**
	 * Display the Team Events
	 * @return HTML
	 */
	public function getScriptTeamEvents() {
		return json_encode($this->getEvents());
	}

	/**
	 * Display the Team Members without reliance on Javascript
	 * @return HTML
	 */
	public function getNoScriptTeamMembers() {
		//TODO return HTML of the team info + Members no scripty way
		return "No Script Version Coming Soon";
	}

	/**
	 * Display the Team Members
	 * @return HTML
	 */
	public function getScriptTeamMembers() {
		//TODO return HTML of the team info + Members scripty way.
		$r[$this->id]['settings'] = $this->getAllSettings();
		$r[$this->id]['members'] = $this->getMembers();
		return json_encode($r);
	}

	/**
	 * Display the Team Members
	 * @return HTML
	 */
	public function getTeamEventsMembersAndSettings() {
		//TODO return HTML of the team info + Members scripty way.
		$r['settings'] = $this->getAllSettings();
		//$r['members'] = $this->getMembers();
		$r['members'] = $this->getMemberObjects();
		$r['events'] = $this->getShortEvents();
		return $r;
	}

}