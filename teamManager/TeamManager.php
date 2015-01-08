<?php

require_once 'TeamManager_Constants.php';

/**
 * Plugin Name: Team Manager
 * Plugin URI: http://teammanager.incitepromo.com
 * Description: A team manager for members and events.
 * @author: Will Fowler
 * Author URI: http://incitepromo.com
 * @package TeamManager	
 * @version 0.2
 */

/**
 * The main Team Manager Class
 */
class TeamManager {

	private $teams = array();
	private $user_id;
	private $user_meta_key = "teammanager_teams";

	public function __construct() {
		//get current user
		$userData = $this->getUserData();
   		$this->user_id = $userData['id'];

   		if ( is_user_logged_in() ) {
   			
   			$this->buildUserTeams();

			//Register the Scripts, styles, shortcodes 
			add_shortcode( 'TeamManagerTeams', array( $this, 'load_teamManagerTeams') );
			add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_styles' ) );
	        add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_scripts' ) );
	        add_filter('user_contactmethods', array( $this, 'modify_contact_methods') );
		} else {
			add_shortcode( 'TeamManagerTeams', array( $this, 'please_sign_up') );
		}
	}

	/**
	 * Builds the current users teams.
	 * @return [type] [description]
	 */
	private function buildUserTeams() {
		$teamIDs = get_user_meta($this->user_id, $this->user_meta_key, false);

		if ( !$teamIDs )
				$this->newMemberSetUp();
		else {
			foreach ($teamIDs as $teamID) {
				$curTeam = TeamManagerTeam::buildExisting($teamID);
				if(!$curTeam)
					$this->warningAlert("Error Loading Team");
				else
					$this->teams[] = $curTeam;
			}
		}
	}

	/**
	 * Function to get all the user data
	 * @return ARRAY_A user shiz
	 */
	private function getUserData() {
		global $current_user;
      	get_currentuserinfo();
      	$userData = array(
      	 'username' 	=> $current_user->user_login,
		 'email' 		=> $current_user->user_email,
		 'phone'		=> get_user_meta( $current_user->ID, 'phone', true ),
		 'fname' 		=> $current_user->user_firstname,
		 'lname' 		=> $current_user->user_lastname,
		 'display name' => $current_user->display_name,
		 'id' 			=> $current_user->ID);
      	return $userData;
	}

	/**
	 * New Member, build them a default team & add their info as the first player & save.
	 * @return [type] [description]
	 */
	private function newMemberSetUp() {
		$this->infoAlert("Welcome! Looks like you're new here, We'll set you up with a default team. Have fun!");
		$this->teams[0] = new TeamManagerTeam();

		$userData = $this->getUserData();
		$fname = $userData['fname'];
		$lname = $userData['lname'];
		$phone = $userData['phone'];
		$email = $userData['email'];
		$position = "Manager";
		$manager = new TeamManagerMember($fname, $lname, $phone, $email, $position);

		$manager = $this->teams[0]->addMember($manager);

		add_user_meta( $this->user_id, $this->user_meta_key, $this->teams[0]->id );
	}

	/**
	 * Display the please sign up shiz
	 * @return [type] [description]
	 */
	public function please_sign_up() {
		$this->infoAlert("You're not signed in, or not signed up, either way - head this way! <a href='"
			.site_url('/wp-login.php?action=register&redirect_to='.get_permalink()).
			"'>Login/Register</a>");
	}
	/**
	 * Display the please upgrade shiz
	 * @return [type] [description]
	 */
	public function please_upgrade() {
		$this->infoAlert("Please Upgrade Message");
	}

	/**
	 * Displays the Team Manager Teams Page
	 * @return HTML Team Manager Teams in NoScript and JS Happy Flavour
	 */
	public function load_teamManagerTeams() {
		return $this->noScriptWarning().$this->displayManager();
	}

	/**
	 * Registers the CSS for the Plugin
	 */
	public function register_plugin_styles() {
		wp_enqueue_style( 'teamManager', plugins_url( '/css/TeamManager.css' , __FILE__ ) ); 
	}

	/**
	 * Registers the JS for the Plugin
	 */
	public function register_plugin_scripts() {
		//in case I need jQuery
		//wp_enqueue_script( 'jQuery', '//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js', array(), '1.10.2', true );
		
		//jQuery UI for Calendar 
		wp_enqueue_script( 'jQueryui', '//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js', array(), '1.10.3', true );
	
		// Main Team Manager JS
		// Old
		//wp_enqueue_script( 'HockeyMan', plugins_url( '/js/HockeyMan.js' , __FILE__ ), array(), '1.0.0', true );
		// New Hotness
		wp_enqueue_script( 'bootstrap-combobox', plugins_url( '/js/bootstrap-combobox.js' , __FILE__ ), array(), '1.0.0', true );
		wp_enqueue_script( 'TeamManager', plugins_url( '/js/TeamManager.js' , __FILE__ ), array(), '1.0.0', true );
		wp_localize_script( 'TeamManager', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));  
	}

	public function modify_contact_methods($profile_fields) {

		// Add new fields
		$profile_fields['phone'] = 'Phone Number';

		// Remove old fields
		unset($profile_fields['aim']);
		unset($profile_fields['yim']);
		unset($profile_fields['jabber']);

		return $profile_fields;
	}

	/* = VIEWS
	-------------------------------------------------------------------------*/

	/**
	 * Default Message View
	 */
	function defaultMessage($title, $msg) {

		$r = '
		<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
		  Launch demo modal
		</button>
		<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="false">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="false">&times;</button>
						<h4 class="modal-title" id="myModalLabel">'.$title.'</h4>
					</div>
					<div class="modal-body">
						'.$msg.'
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
					</div>
				</div>
			</div>
		</div>
		';

		//echo '<div class="defaultMessage"><p>'.$msg.'</p><input id="defaultMessageClose" type="button" value="close" /></div>';
		echo $r;
	}
	/**
	 * Alert/Advertisement Message View
	 */
	function infoAlert($msg) {
		echo '<p class="alert alert-info">'.$msg.'<a class="close" data-dismiss="alert">×</a></p>';
	}
	/**
	 * Alert/Warning Message View
	 */
	function warningAlert($msg) {
		echo '<p class="alert alert-warning">'.$msg.'<a class="close" data-dismiss="alert">×</a></p>';
	}

	/**
	 * Returns the NoScript warning
	 * @return HTML NoScript Teams Listing
	 */
	public function noScriptWarning() {
		$return = "<noscript><h4>Sorry, this site currently requires Javascript to be enabled</h4></noscript>";
	}

	/**
	 * Returns the Script Teams for each Team.
	 * @return HTML Script Teams Listing
	 */
	public function displayManager() {
		$return = "<h3>Events</h3><div id='tm_eventsCal'></div>";

		if(pmpro_hasMembershipLevel('2')){
			$return .= "<h3>Teams</h3><div id='tm_teamsPlace'></div>";
			$allTeams = [];
			foreach ($this->teams as $team) {
				$allTeams[$team->id] = $team->getTeamEventsMembersAndSettings();
			}
			$return .= '<script type="text/javascript"> var teams = '.json_encode($allTeams).';  </script>';
			if(TEAMMANAGER_DEBUG_MODE) $return .= json_encode($allTeams);
		} else {
			$this->please_upgrade();
			$return .= "<h3>Team</h3>";
			$return .= $this->teams[0]->getTeamEventsMembersAndSettings();
		} 
		return $return;
	}

}

$theTeamManager = new TeamManager();