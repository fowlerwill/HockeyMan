<?php 

class TeamManagerMember {
	public $id;
	private $details = array(
		"fname" 		=> "First Name",
		"lname"			=> "Last Name",
		"phone" 		=> "",
		"email"			=> "",
		"emailConfirm"	=> "",
		"position"		=> "" );
	
	/**
	 * Default Constructor Method
	 * @param String $id Identifier for Team
	 */
	public function __construct($fname, $lname, $phone, $email, $position) {
		$this->id = uniqid('m');
		$this->setFName($fname);
		$this->setLName($lname);
		$this->setPhone($phone);
		$this->setEmail($email);
		$this->setPosition($position);

		$this->setEmailConfirm();
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
		$memeberResult = $wpdb->get_row('SELECT `memberobj` FROM '.MEMBERS_TABLE.' WHERE `memberid`="'.$id.'"');

		if($memeberResult)
			return unserialize($memeberResult->memberobj);
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

		return $wpdb->replace( MEMBERS_TABLE, 
			array('memberid' => $this->id, 'memberobj' => serialize($this))
			);
	}

	/* = GETTERS AND SETTERS
	-------------------------------------------------------------------------*/

	public function getFName() 			{ return $this->details['fname']; }
	public function getLName() 			{ return $this->details['lname']; }
	public function getPhone() 			{ return $this->details['phone']; }
	public function getPhoneNANPFormatted() {
		$p = $this->getPhone();
		$pf = "+".substr($p,0,1)."(".substr($p,1,3).") ".substr($p,4,3)."-".substr($p,7);
		return $pf;
	}
	public function getEmail() 			{ return $this->details['email']; }
	public function getEmailConfirm() 	{ return $this->details['emailConfirm']; }
	public function getPosition() 		{ return $this->details['position']; }

	public function getAllDetails() { 
		$r = array(
			'id' => $this->id,
			'details' => $this->details);
		return $r; 
	}

	public function setFName($name) {
		$this->details['fname'] = $name;
	}
	public function setLName($name) {
		$this->details['lname'] = $name;
	}
	public function setPhone($phone) {
		$phone = preg_replace('/[^0-9]/s', '', $phone);
		$this->details['phone'] = $phone;
	}
	public function setEmail($email) {
		if( filter_var($email, FILTER_VALIDATE_EMAIL) )
			$this->details['email'] = $email;
		else
			return false;
	}
	public function setEmailConfirm($value = false) {
		if(!$value)
			$this->details['emailConfirm'] = substr(md5(uniqid(rand(), true)), 16, 16);
		else {
			if( $value == 0 || $value == 1 )
				$this->details['emailConfirm'] = $value;
			else 
				return false;
		}
	}
	public function setPosition($position) {
		$this->details['position'] = $position;
	}

	/* = VIEWS
	-------------------------------------------------------------------------*/
}