<?php
require_once 'HockeyManConstants.php';

class HockeyManGame {
	public $date = "";
	public $desc = "";
	public $loc = "";
	public $attendees = array();
	public $creator = '';
	public $id = '';
	public $initialEmailTimeDelay = 19800;
	public $finalEmailTimeDelay = 7200; 
	
	/**
	 * Should probably change creator to teamid at some point...
	 * @param [type] $aDate   [description]
	 * @param [type] $desc    [description]
	 * @param [type] $loc     [description]
	 * @param [type] $creator [description]
	 * @param [type] $id      [description]
	 */
	public function __construct($aDate, $desc, $loc, $creator, $id) {
		$this->date = strtotime($aDate);
		$this->desc = $desc;
		$this->loc = $loc;
		$this->creator = $creator;
		if($id == "0" || $id == null)
			$this->id = date("U", $this->date) + $this->creator;
		else
			$this->id = $id;
	}

	/**
	 * [buildGameByID description]
	 * @param  String $id gameID
	 * @return HockeyManGame
	 */
	public function buildGameByID($id) {
		global $wpdb;
		$gameResult = $wpdb->get_results($wpdb->prepare("
			SELECT * 
			FROM ".GAMES_TABLE." 
			WHERE id= %s",$id), ARRAY_A);

		return new HockeyManGame($gameResult[0]['datetime'],
								 $gameResult[0]['desc'],
								 $gameResult[0]['loc'],
								 $gameResult[0]['userid'],
								 $gameResult[0]['id']);
	}

	/**
	 * Returns the date in the specified format
	 * @param  Date and Time Format $format @see http://ca3.php.net/manual/en/datetime.formats.php
	 * @return string Date in specified format
	 */
	public function getDate($format) {
		$datetime = new DateTime( date('c', $this->date) );
		$datetime->setTimezone(new DateTimeZone( get_the_author_meta( 't_zone', $this->creator ) ));
		return $datetime->format($format);
	}

	/**
	 * Add New Players adds the players from the appropriate team to the 
	 * game's attendance table.
	 * @param Array of HockeyManPlayers $listOfPlayers [description]
	 */
	public function addNewPlayers($listOfPlayers) {
		global $wpdb;
		foreach ($listOfPlayers as $player) {
			//add them as potential players to the game.
			$wpdb->query( $wpdb->prepare( "
				INSERT INTO `".ATTENDANCE_TABLE."` (`playerid`, `gameid`, `1n0ut`) 
				VALUES (%s, %s, '2')
				",
				$player->playerDetails['id'],
				$this->id ));
			$playerIDs[] = $player->playerDetails['id'];
		}

		$gameInfoForEmail = array(
			'id'	=> $this->id,
			'date' 	=> $this->getDate("g:ia l, d F Y"),
			'desc' 	=> $this->desc,
			'loc'	=> $this->loc);

		//shedule the initial email to go out. 14400 = 4 hrs
		wp_schedule_single_event( $this->date-$this->initialEmailTimeDelay, 'hockeyMan_send_game_conf', array($gameInfoForEmail, $playerIDs) );
		wp_schedule_single_event( $this->date-$this->finalEmailTimeDelay, 'hockeyMan_send_game_summ', array($gameInfoForEmail, $playerIDs) );
		//$this->scheduleGameConfirmationEmails($listOfPlayers);
		
	}

	/**
	 * GetAttendees from the attendance table (might be done better somehow?)
	 * adds to $attendees array
	 */
	public function getAttendees() {
		global $wpdb;
		$players = $wpdb->get_results( $wpdb->prepare( "
			SELECT `playerid` 
			FROM `".ATTENDANCE_TABLE."`
			WHERE `gameid` = %s",
			$this->id), ARRAY_N);

		foreach ($players as $playerid) {
			$this->addAttendee($playerid[0]);
		}
	}

	/**
	 * Returns the response for the given player id
	 */
	public function getAttendeeResponse($gameid, $playerid) {
		global $wpdb;
		$playerResponse = $wpdb->get_results( $wpdb->prepare( "
			SELECT `1n0ut` 
			FROM `".ATTENDANCE_TABLE."`
			WHERE `gameid` = %s AND `playerid` = %s",
			$gameid,
			$playerid), ARRAY_N);

		return $playerResponse[0];
	}
	

	public function addAttendee($attendeeid) {
		$this->attendees[] = $attendeeid;
	}

	public function saveGame() {
		global $wpdb;

		$isNew = $wpdb->query("
			SELECT * 
			FROM ".GAMES_TABLE." 
			WHERE id=".$this->id
			);

		$wpdb->query( $wpdb->prepare( 
			"
				INSERT INTO ".GAMES_TABLE."(`id`, `userid`, `datetime`, `desc`, `loc`) 
				VALUES (%s,%s,%s,%s,%s)
				ON DUPLICATE KEY
				UPDATE 
					id=VALUES(id),
					userid=VALUES(userid),
					datetime=VALUES(datetime), 
					`desc`=VALUES(`desc`),
					loc=VALUES(`loc`)
			", 
			$this->id,
			$this->creator, 	
			date("Y-m-d H:i:s", $this->date), 	
			$this->desc, 	
			$this->loc
			));

		//if isNew is 0, that means the game is new, 1 if not.
		return $isNew;
	}

	public function deleteGame($playerIDs) {
		global $wpdb;		

		$gameInfoForEmail = array(
			'id'	=> $this->id,
			'date' 	=> $this->getDate("g:ia l, d F Y"),
			'desc' 	=> $this->desc, 
			'loc'	=> $this->loc);

		//echo "<pre>".print_r($playerIDs)."</pre>"; hockeyMan_send_game_canc

		wp_unschedule_event( $this->date-$this->initialEmailTimeDelay, 'hockeyMan_send_game_conf', array($gameInfoForEmail, $playerIDs) );

		if( time() > $this->date-$this->initialEmailTimeDelay ) 
			wp_schedule_single_event( time(), 'hockeyMan_send_game_canc', array($gameInfoForEmail, $playerIDs) );

		//Delete Attendance entries
		$attendance = $wpdb->query( 
			$wpdb->prepare( "
				DELETE FROM `".ATTENDANCE_TABLE."`
				WHERE `gameid` = %s
				",
				$this->id ));

		//Delete the Game entry
		
		return $wpdb->query(
			$wpdb->prepare( "
				DELETE FROM `".GAMES_TABLE."`
				WHERE `id` = %s
				",
				$this->id ));

	}

	/* = Form Rendering Shit
	-------------------------------------------------------------------------*/

	public function renderform_id() {
		return '<input class="gameID" type="hidden" name="id[]" value="'.$this->id.'">';
	}
	public function renderform_date() {
		return '<input type="text" class="datepicker" name="date[]" value="'.date("Y-M-d", $this->date).'"/>';
	}
	public function renderform_timeHR() {
		/*
		$hr = date("h", $this->date);					
		$r .= '<select name="timeHR[]" />';
			for($d = 1; $d < 13; $d++) {
				$t = 0;
				if($d < 10)
					$t = '0'.$d;
				else
					$t = $d;
				$r .= '<option value="'.$t.'" ';
				if($hr == $d)
					$r .= 'selected="selected" ';
				$r .='>'.$t.'</option>';
			}
			
			
		$r .= '</select>';
		*/
		$r = '<input type="text" size="2" name="timeHR[]">';
		return $r;
	}
	public function renderform_timeMN() {
		/*
		$mn = date("i", $this->date);
		$r .= '<select name="timeMN[]" />';
			for( $d=0; $d<60; $d+=15) {
				$t = 0;
				if($d < 10)
					$t = '0'.$d;
				else
					$t = $d;
				$r .= '<option value="'.$t.'" ';
				if($mn == $d)
					$r .= 'selected="selected" ';
				$r .='>'.$t.'</option>';

			}
		$r .= '</select>';
		*/
		$r = '<input type="text" size="2" name="timeMN[]">';

		//am/pm
		$r .= '<input type="radio" name="ampm[]" value="AM">AM
				<input type="radio" name="ampm[]" value="PM">PM';
		return $r;
	}
	public function renderform_desc() {
		return '<input type="text" name="description[]" value="'.$this->desc.'" />';
	}
	public function renderform_location() {
		return '<input type="text" name="location[]" value="'.$this->loc.'" />';
	}
	public function renderform_creator() {
		global $current_user;
    	get_currentuserinfo();
		return '<input type="hidden" name="creator[]" value="'.$current_user->ID.'">';
	}
		

	public function buildForm() {
		$r = '';
		$r .= '<form method="POST">';
			$r .= $this->renderform_id();
			$r .= $this->renderform_date();
			$r .= $this->renderform_timeHR();
			$r .= $this->renderform_timeMN();
			$r .= $this->renderform_desc();
			$r .= $this->renderform_location();
			$r .= $this->renderform_creator();
			$r .= '<input type="submit" value="Submit">';
		$r .= '</form>';
		return $r;
	}



}