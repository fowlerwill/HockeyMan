<?php 

class TeamManagerEvent {
	public $id;
	private $details = array(
		"description"	=> "Short Game Description",
		"notes" 	    => "Long Game Notes",
		"datetimeStart" => "",
		"length"		=> "",
		"location" 		=> "Address");
	private $attendance = array();

	/**
	 * Default Constructor Method
	 * @param String $id Identifier for Team
	 */
	public function __construct($description, $notes, $datetimeStart, $location) {
		$this->id = uniqid('e');
		$this->setDescription($description);
		$this->setNotes($notes);
		$this->setDateTimeStart($datetimeStart);
		//$this->setLength($length); - Removed for now, make sure to add to parameters if put back in.
		$this->setLocation($location);
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
		$eventResult = $wpdb->get_row('SELECT `eventobj` FROM '.EVENTS_TABLE.' WHERE `eventid`="'.$id.'"');

		if($eventResult)
			return unserialize($eventResult->eventobj);
		else
			return false;
	}

	/**
	 * Saves the current object
	 * @return [type] [description]
	 */
	public function save() {
		global $wpdb;
		if(TEAMMANAGER_DEBUG_MODE) $wpdb->show_errors();

		return $wpdb->replace( EVENTS_TABLE, 
			array('eventid' => $this->id, 'eventobj' => serialize($this))
			);
	}

	/* = GETTERS AND SETTERS
	-------------------------------------------------------------------------*/
	public function getDescription() 	{ return $this->details['description']; }
	public function getNotes() 			{ return $this->details['notes']; }
	public function getDateTimeStart() 	{ return $this->details['datetimeStart']; }
	public function getDateTimeStartUTC() { 
		return $this->details['datetimeStart']->format('U'); 
	}

	public function getLength() 		{ return $this->details['length']; }
	public function getLocation() 		{ return $this->details['location']; }

	//setters
	public function setDescription($desc) {
		if( strlen($desc) <= 140 )
			$this->details['description'] = $desc;
		else
			return false;
	}
	public function setNotes($notes) {
		$this->details['notes'] = $notes;
	}
	//MUST be a UTC timestamp
	public function setDateTimeStart($datetime) {
		if( $datetime instanceof DateTime )
			$this->details['datetimeStart'] = $datetime;
		else
			return false;
	}
	public function setLength($length) {
		if( is_int($length) && $length > 300 )
			$this->details['length'] = $length;
		else
			return false;
	}
	public function setLocation($loc) {
		$this->details['location'] = $loc;
	}

	/**
	 * Initial set up for the attendees of the event.
	 * @param Array $attendeeList array of member ids that will be emailed.
	 */
	public function setUpAttendees($attendeeList) {
		foreach ($attendeeList as $id) {
			$this->addNewAtendee($id);
		}
		$this->save();
	}

	public function addNewAtendee($id) {
		$this->attendance[$id] = 2;
	}
	public function updateAttendee($id, $status) {
		if( array_key_exists($id, $this->attendance) && $status >= 0 && $status < 3)
			$this->attendance[$id] = $status;
		else 
			return false;
	}

	/* = VIEWS
	-------------------------------------------------------------------------*/

	public function getAllDetails() {
		return $this->details;
	}

	public function getAllDetailsAndAttendance() {
		$r = array(
			'attendance' => $this->attendance,
			'details'	=> $this->details,
			'datetimeStart' => $this->getDateTimeStartUTC());
		return $r;
	}

	/*
	 * Returns just enough for the calendar view.
	 */
	public function getShortDetails() {
		$det = array(
			'description' => $this->getDescription(),
			'datetimeStart' => $this->getDateTimeStartUTC(),
			'id' => $this->id
			);
		return $det;
	}

}