<?php 
require_once 'HockeyManConstants.php';

/*
 *	HockeyManPlayer Class for Hockey Manager
 *	@author Will Fowler
 *	@date 10/2013
 */
class HockeyManPlayer {

    public $playerDetails = array(
    	'id'	=>'',
		'fname'		=>'',
		'lname'		=>'',
		'phone'		=>'',
		'email'		=>'',
		'emailconfirm'	=>'',
		'address'	=>'',
		'position'	=>'',
		'teamid'	=>'');

	public function __construct($id = null, $fname, $lname, $phone, $email, $emailconfirm, $address, $position, $teamid)
	{
		$this->playerDetails['id'] = $id;
		$this->playerDetails['fname'] 	= $fname;
		$this->playerDetails['lname'] 	= $lname;
		$this->playerDetails['phone'] 	= $phone;
		$this->playerDetails['email'] 	= $email;

		if($emailconfirm == "0")
			$this->playerDetails['emailconfirm'] = md5($email.time());
		else
			$this->playerDetails['emailconfirm'] 	= $emailconfirm;

		$this->playerDetails['address'] = $address;
		$this->playerDetails['position'] = $position;
		$this->playerDetails['teamid'] 	= $teamid;
	}

	public function buildPlayerByID($id) {
		global $wpdb;
		//Build the players
		$playerSQL = 'SELECT * FROM `'.PLAYERS_TABLE.'` WHERE `id` = '.$id;
		$player = $wpdb->get_results($playerSQL, ARRAY_A);
		return new HockeyManPlayer(
		 $player[0]['id'], 
		 $player[0]['fname'], 
		 $player[0]['lname'], 
		 $player[0]['phone'],
		 $player[0]['email'],
		 $player[0]['emailconfirm'],
		 $player[0]['address'], 
		 $player[0]['position'], 
		 $player[0]['teamid']);

		}

	public function save() {
		global $wpdb;
		//$wpdb->insert('wp35_hockeyManPlayers', $this->playerDetails);
		//insert into table (id, name, age) values(1, "A", 19) on duplicate key update name=values(name), age=values(age)
		$wpdb->query( $wpdb->prepare( 
			"
				INSERT INTO ".PLAYERS_TABLE."(id, fname, lname, phone, email, emailconfirm, address, position, teamid)
				VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)
				ON DUPLICATE KEY
				UPDATE 
					id=VALUES(id),
					fname=VALUES(fname),
					lname=VALUES(lname),
					phone=VALUES(phone),
					email=VALUES(email),
					emailconfirm=VALUES(emailconfirm),
					address=VALUES(address),
					position=VALUES(position),
					teamid=VALUES(teamid)
			", 
			$this->playerDetails['id'], 
			$this->playerDetails['fname'], 	
			$this->playerDetails['lname'], 	
			$this->playerDetails['phone'], 	
			$this->playerDetails['email'], 	
			$this->playerDetails['emailconfirm'], 	
			$this->playerDetails['address'], 
			$this->playerDetails['position'], 
			$this->playerDetails['teamid']
			));
		$this->playerDetails['id'] = $wpdb->insert_id;
		//if($this->confirmEmail())
		//	echo 'sent?';
	}

	/**
	 * Sets a players email to confirmed
	 * @return [type] [description]
	 */
	public function confirmedEmailAddress() {
		global $wpdb;
		$sql = "
			UPDATE ".PLAYERS_TABLE."
			SET `emailconfirm`='1' 
			WHERE id=".$this->playerDetails['id']."
		";
		$wpdb->query($sql);
		//TODO: Make an unconfirm form!
	}

	// ID
	public function getid() { return $this->playerDetails['id'];	}
	public function getid_input() { return '<input class="playerID" type="hidden" name="id[]" value="'.$this->playerDetails['id'].'" >';
	}

	// FIRST NAME
	public function getfname() { return $this->playerDetails['fname'];	}
	public function getfname_input($val = null) { 
		if(!$val) 
			$val = $this->playerDetails['fname'];
		return '<input type="text" name="fname[]" value="'.$val.'" >';	
	}
	public function setfname($fname) { $this->playerDetails['fname'] = $fname;	}

	// LAST NAME
	public function getlname() { return $this->playerDetails['lname'];	}
	public function getlname_input($val = null) { 
		if(!$val) 
			$val = $this->playerDetails['lname'];
		return '<input type="text" name="lname[]" value="'.$val.'" >';	
	}
	public function setlname($lname) { $this->playerDetails['lname'] = $lname;	}

	// PHONE
	public function getphone() { return $this->playerDetails['phone'];	}
	public function getphone_input($val = null) { 
		if(!$val) 
			$val = $this->playerDetails['phone'];
		return '<input type="text" name="phone[]" value="'.$val.'" >';	
	}
	public function setphone($phone) { $this->playerDetails['phone'] = $phone;	}

	// EMAIL
	public function getemail() { return $this->playerDetails['email'];	}
	public function getemail_input($val = null) { 
		if(!$val) 
			$val = $this->playerDetails['email'];
		return '<input type="text" name="email[]" value="'.$val.'" >';	
	}
	public function setemail($email) { $this->playerDetails['email'] = $email;	}

	// EMAIL CONFIRM
	public function getemailconfirm() { return $this->playerDetails['emailconfirm'];	}
	public function getemailconfirm_input($val = null) { 
		if(!$val) 
			$val = $this->playerDetails['emailconfirm'];
		return '<input type="hidden" name="emailconfirm[]" value="'.$val.'" >';	
	}

	// ADDRESS
	public function getaddress() { return $this->playerDetails['address'];	}
	public function getaddress_input($val = null) { 
		if(!$val)
			$val = $this->playerDetails['address']; 
		return '<input type="text" name="address[]" value="'.$val.'" >';	
	}
	public function setaddress($address) { $this->playerDetails['address'] = $address;	}

	// POSITION
	public function getposition() { return $this->playerDetails['position'];	}
	public function getposition_input($val = null) { 
		if(!$val)
			$val = $this->playerDetails['position'];
		return '<input type="text" name="position[]" value="'.$val.'" >';	
	}
	public function setposition($position) { $this->playerDetails['position'] = $position;	}

	// TEAM ID
	public function getteamid() { return $this->playerDetails['teamid'];	}
	public function getteamid_input() { 
		$val =  $this->playerDetails['teamid'];
		return '<input type="hidden" name="teamid[]" value="'.$val.'" >';	
	}
	public function setteamid($teamid) { $this->playerDetails['teamid'] = $teamid;	}


	/**
	 * = Email Functions
	 * ------------------------------------------------------------------------
	 */
	public function confirmEmail($fname, $lname) {

		$email = new HockeyManEmail();

		$email->addFullWidthRow("You've been added to ".$fname."'s Team!", 
			$fname." ".$lname." is using ".PRODUCT_NAME." to manage their team events, and would like to send you email invites to confirm/deny your attendance. You will never recieve any advertisement emails whatsoever from us, only the invites that your team manager sends out for events. If you would like to receive these emails, please...");
		$email->addCallToActionButton("Confirm Your Email", "http://wordpresstest.incitepromo.com/?econfirm=".$this->playerDetails['emailconfirm']);
		$email->addFullWidthRow("Here's the information ".$fname." added about you",
			"<table width='100%'><tr><td align='center'><table border='1' cellpadding='3' style='border:1px solid #DDDDDD;'>
				<tr>
					<td style='text-align:right;background:#EEEEEE;'>First Name:</td>
					<td>".$this->getfname()."</td>
				</tr>
				<tr>
					<td style='text-align:right;background:#EEEEEE;'>Last Name:</td>
					<td>".$this->getlname()."</td>
				</tr>
				<tr>
					<td style='text-align:right;background:#EEEEEE;'>Phone:</td>
					<td>".$this->getphone()."</td>
				</tr>
				<tr>
					<td style='text-align:right;background:#EEEEEE;'>Address:</td>
					<td>".$this->getaddress()."</td>
				</tr>
				<tr>
					<td style='text-align:right;background:#EEEEEE;'>Position:</td>
					<td>".$this->getposition()."</td>
				</tr>
			</table></td></tr></table>");
		$email->addFullWidthRow("If you don't wish to recieve these emails", "Just don't click the button! You won't hear from us again :)");
		$email->addFooter();


		if(!$message = $email->returnEmail())
			echo HockeyMan::defaultMessage("Error Making Email");

		$headers = "Content-Type: text/html";

		wp_mail( $this->playerDetails['email'], $this->getfname().', '.$fname.' Has Added You To Their Team', $message, $headers );
	}

	public function sendGameCancellationEmail($gameInfo) {

		if($this->playerDetails['emailconfirm'] == "NO")
			return;

		$email = new HockeyManEmail();
		$email->addFullWidthRow("Heads Up!", "The following event has been <span style='font-weight:bold;'>cancelled</span><br>
			<table width='100%'><tr><td align='center'><table><table border='1' cellpadding='3' style='border:1px solid #DDDDDD;'>
				<tr>
					<td style='background:#EEEEEE;'>Date</td>
					<td style='background:#EEEEEE;'>Description</td>
					<td style='background:#EEEEEE;'>Location</td>
				</tr>
				<tr>
					<td>".$gameInfo['date']."</td>
					<td>".$gameInfo['desc']."</td>
					<td>".$gameInfo['loc']."</td>
				</tr>
			</table></td></tr></table>");
		$email->addFullWidthRow("For More information, contact your team manager", "");
		$email->addFooter();
		if(!$message = $email->returnEmail())
			echo HockeyMan::defaultMessage("Error Making Email");

		$headers = "Content-Type: text/html";

		wp_mail( $this->playerDetails['email'], $gameInfo['desc'].' Event Cancelled', $message, $headers );

	}

	public function sendGameSummaryEmail($gameInfo, $playersList) {

		/*if($this->playerDetails['emailconfirm'] == "NO")
			return;
			*/

		$email = new HockeyManEmail();
		$email->addFullWidthRow("Upcoming Event", "Here's what's happening with the following event:<br>
			<table width='100%'><tr><td align='center'><table><table border='1' cellpadding='3' style='border:1px solid #DDDDDD;'>
				<tr>
					<td style='background:#EEEEEE;'>Date</td>
					<td style='background:#EEEEEE;'>Description</td>
					<td style='background:#EEEEEE;'>Location</td>
				</tr>
				<tr>
					<td>".$gameInfo['date']."</td>
					<td>".$gameInfo['desc']."</td>
					<td>".$gameInfo['loc']."</td>
				</tr>
			</table></td></tr></table>");

		$responseListIn = "<ol>";
		$responseListOut = "<ul>";
		$responseListNR = "<ul>";
		foreach ($playersList as $player) {

			if($player['response'][0] == "1")
				$responseListIn .= "<li>".$player['name'].": ".$player['position']."</li>";
			else if($player['response'][0] == "0")
				$responseListOut .= "<li>".$player['name'].": ".$player['position']."</li>";
			else
				$responseListNR .= "<li>".$player['name'].": ".$player['position']."</li>";
		}
		$responseListIn .= "</ol>";
		$responseListNR .= "</ul>";
		$responseListOut .= "</ul>";

		$email->addFullWidthRow("Player Info", "Attending: ".$responseListIn. "<br>Not Attending: ".$responseListOut. "<br>No Reply: ".$responseListNR);
		$email->addFooter();
		if(!$message = $email->returnEmail())
			echo HockeyMan::defaultMessage("Error Making Email");

		$headers = "Content-Type: text/html";

		wp_mail( $this->playerDetails['email'], $gameInfo['desc'].' Event Summary', $message, $headers );

	}

	public function sendGameConfirmationEmail($gameInfo) {

		if($this->playerDetails['emailconfirm'] == "NO")
			return;

		$email = new HockeyManEmail();
		$email->addFullWidthRow("Hey ".$this->getfname(),"You've been invited to the following event<br>
			<table width='100%'><tr><td align='center'><table><table border='1' cellpadding='3' style='border:1px solid #DDDDDD;'>
				<tr>
					<td style='background:#EEEEEE;'>Date</td>
					<td style='background:#EEEEEE;'>Description</td>
					<td style='background:#EEEEEE;'>Location</td>
				</tr>
				<tr>
					<td>".$gameInfo['date']."</td>
					<td>".$gameInfo['desc']."</td>
					<td>".$gameInfo['loc']."</td>
				</tr>
			</table></td></tr></table>");

		$baselink = '?gameid='.$gameInfo['id'].'&playerid='.$this->playerDetails['id'].'&inout=';

		$email->addTwoColumnRow("Are you out?", 
			'<table width="100%"><tr><td align="center"><table>
			  <tr>
			    <td align="center" width="130" bgcolor="#ff0000" style="background: #ff0000; padding-top: 20px; padding-right: 20px; padding-bottom: 20px; padding-left: 20px; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; color: #fff; font-weight: bold; text-decoration: none; font-family: Helvetica, Arial, sans-serif; display: block;"><a href="http://wordpresstest.incitepromo.com/'.$baselink.'0" style="color: #ffffff; font-size:24px; font-weight: bold; font-family: Helvetica, Arial, sans-serif; text-decoration: none; line-height:100%; width:100%; display:inline-block">OUT</a></td>
			  </tr>
			</table></td></tr></table>', 
			"...Or are you in?", 
			'<table width="100%"><tr><td align="center"><table>
			  <tr>
			    <td align="center" width="130" bgcolor="#00ff00" style="background: #00ff00; padding-top: 20px; padding-right: 20px; padding-bottom: 20px; padding-left: 20px; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; color: #fff; font-weight: bold; text-decoration: none; font-family: Helvetica, Arial, sans-serif; display: block;"><a href="http://wordpresstest.incitepromo.com/'.$baselink.'1" style="color: #ffffff; font-size:24px; font-weight: bold; font-family: Helvetica, Arial, sans-serif; text-decoration: none; line-height:100%; width:100%; display:inline-block">IN</a></td>
			  </tr>
			</table></td></tr></table>');
		$email->addFullWidthRow("Click Either link to let your team know if you're coming!", "");
		$email->addFooter();
		if(!$message = $email->returnEmail())
			echo HockeyMan::defaultMessage("Error Making Email");

		$headers = "Content-Type: text/html";

		wp_mail( $this->playerDetails['email'], $this->getfname().', please confirm your attendance', $message, $headers );

	}

}