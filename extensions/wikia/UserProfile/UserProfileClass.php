<?php
/**
 *
 */
require_once "$IP/extensions/wikia/UserProfile/countries/countries.php";

function wfGetProfileDBName() {
	global $wgSharedUserProfile, $wgSharedDB, $wgDBname;
	return ($wgSharedUserProfile)?$wgSharedDB:$wgDBname;
}

class UserProfile {

	/**
	 * All member variables should be considered private
	 * Please use the accessor functions
	 */

	 /**#@+
	 * @private
	 */
	var $user_id;           	# Text form (spaces not underscores) of the main part
	var $user_name;			# Text form (spaces not underscores) of the main part
	var $profile;           	# Text form (spaces not underscores) of the main part
	
	
	/**
	 * Constructor
	 * @private
	 */
	/* private */ function __construct($username) {
		$title1 = Title::newFromDBkey($username  );
		$this->user_name = $title1->getText();
		$this->user_id = User::idFromName($this->user_name);
		
	}
	


	public function getProfile(){
		#---
		$fname = "UserProfile::getProfile";
		#---
		$profile = array("location_city" => '', "location_state" => '', "location_country" => '', "hometown_city" => '', "hometown_state" => '', "hometown_country" => '', "birthday" => '', "real_name" => '');
		#---
		$db_name = wfGetProfileDBName();
		#---
		$dbr =& wfGetDB( DB_MASTER );
		$sql = "SELECT up_location_city, up_location_state, up_location_country,
			up_hometown_city, up_hometown_state, up_hometown_country,
			up_birthday
			FROM `{$db_name}`.`user_profile`
			WHERE up_user_id = {$this->user_id}";
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );
		if($row){
			$profile["location_city"]= $row->up_location_city;	
			$profile["location_state"]= $row->up_location_state;	
			$profile["location_country"]= $row->up_location_country;
			$profile["hometown_city"]= $row->up_hometown_city;	
			$profile["hometown_state"]= $row->up_hometown_state;	
			$profile["hometown_country"]= $row->up_hometown_country;
			$profile["birthday"]= $this->formatBirthday($row->up_birthday);	
			
		}
		$s = $dbr->selectRow( 'user', array( 'user_real_name' ), array( 'user_id' => $this->user_id ), $fname );
		if ( $s !== false ) {
			$profile["real_name"]= $s->user_real_name;	
		}
		return $profile;
	}

	function formatBirthday($birthday){
		$dob = explode('-', $birthday);
		if(count($dob) == 3){
			$month = $dob[1];
			$day = $dob[2];
			$birthday_date = date("F jS", mktime(0,0,0,$month,$day, 4)); //  Year 4 is a leap year so Feb 29th will be allowed

			// '0000-00-00' comes from the DB if user set a wrong date
			if (('00' == $month) || ('00' == $day))
			{
				$birthday_date = '';
			}
		}
		return $birthday_date;
	}
	
	function get_ordinal_suffix ($number) {
	    $last_2_digits = substr (0, -2, $number);
	    if (($number % 10) == 1 && $last_2_digits != 11)
		return 'st';
	    if (($number % 10) == 2 && $last_2_digits != 12)
		return 'nd';
	    if (($number % 10) == 3 && $last_2_digits != 13)
		return 'rd';
	    return 'th'; //default suffix
	}
	
	function getStates() 
	{
		global $IP, $wgContLang, $wgLang;
		global $wgStateList;
		
		$langCode = (isset($wgContLang->mCode))?$wgContLang->mCode:$wgLang->mCode;
		$states = $wgStateList[$langCode];
		if (empty($states)) #defualt
		{
			$states = $wgStateList['en'];
		}
		
		return $states;	
	}
	
	function getCountries() 
	{
		global $IP, $wgContLang, $wgLang;
		global $wgCountriesList;

		#---
		$langCode = (isset($wgContLang->mCode))?$wgContLang->mCode:$wgLang->mCode;
		$countries = $wgCountriesList[$langCode];
		if (empty($countries)) #defualt
		{
			$countries = $wgCountriesList['en'];
		}
		
		return $countries;
	}
}
	
?>
