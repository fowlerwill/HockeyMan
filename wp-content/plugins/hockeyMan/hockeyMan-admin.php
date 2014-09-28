<?php
/*
 * HockeyMan Admin Page
 * @author Will Fowler
 */
 echo '<h1>Welcome to HockeyMan!</h1><p>please give me capability...</p>';
 $pluginUrl = plugins_url().'/hockeyMan/';
?>
<form name="addPlayer" method="POST">
	<h2>Add Player Form</h2>
<?php
$playerDetails = array(
	'First Name' => 	'fname',
	'Last Name' 	=>	'lname',
	'Phone Number'	=>	'phone',
	'Email'			=>	'email',
	'Address'		=>	'address',
	'Team'			=>	'team',
	'Position'		=>	'position');

foreach ($playerDetails as $key => $value) {
	hockeyMan_build_text_input($key, $value);
}
global $current_user;
    get_currentuserinfo();
?>

<label>Team ID</label><input type="text" name="teamid" value="<?= $current_user->ID ?>"> 

<?php 

$player = new HockeyManPlayer();
echo var_dump($player->returnRow(1));

?>

<input type="submit">
</form>




<?php



 function hockeyMan_build_text_input ( $label, $name ) {
 	printf('<input value="%s" type="text" name="%s">', $label, $name);
 }

 class HockeyManPlayer
{
    // property declaration
    public $playerDetails = array(
	'First Name' => 	'fname',
	'Last Name' 	=>	'lname',
	'Phone Number'	=>	'phone',
	'Email'			=>	'email',
	'Address'		=>	'address',
	'Team'			=>	'team',
	'Position'		=>	'position');

    // method declaration
    public function returnRow($id) {
    	echo 'hmm';
    	$sql = 'SELECT * FROM `wp35_hockeyManPlayers` WHERE `id` = '.$id;
    	global $wpdb;
        return $wpdb->get_row($sql, ARRAY_A);
    }
}
