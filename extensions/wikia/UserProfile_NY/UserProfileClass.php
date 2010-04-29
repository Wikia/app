<?php
/**
 *
 */
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

	var $profile_fields_count;

	var $profile_fields = array(
					"real_name","location_city","hometown_city","birthday", "gender",
					"about","places_lived","websites","occupation","schools",
					"movies","tv","books","magazines","video_games","snacks","drinks",
					"custom_1","custom_2","custom_3","custom_4","email"
					);
	var $profile_missing = array();
	static $profile_version = "006";

	/**
	 * Constructor
	 * @private
	 */
	/* private */ function __construct($username) {
		$title1 = Title::newFromDBkey($username);
		$this->user_name = $title1->getText();
		$this->user_id = User::idFromName($this->user_name);
	}


	static function clearCache( $user_id ){
		global $wgMemc;

		$key = wfMemcKey( 'user', 'profile',self::$profile_version, 'work', $user_id );
		$wgMemc->delete( $key );
		$key = wfMemcKey( 'user', 'profile',self::$profile_version, 'info', $user_id );
		$wgMemc->delete( $key );
	}

	public function getProfile(){
		global $wgMemc, $wgUserProfileDisplay;

		//try cache first
		$key = wfMemcKey( 'user', 'profile', self::$profile_version,  'info', $this->user_id );
		//$wgMemc->delete( $key );
		$data = $wgMemc->get( $key );
		$profile = array();
		if ( $data ) {
			wfDebug( "Got user profile info for {$this->user_name} from cache\n" );
			$profile = $data;
		}else{
			wfDebug( "Got user profile info for {$this->user_name} from db\n" );
			$dbr =& wfGetDB( DB_SLAVE );
			$params['LIMIT'] = "5";
			$row = $dbr->selectRow( 'user_profile',
				"*",
				array( 'up_user_id' => $this->user_id ), __METHOD__,
				$params
				);

			$profile["user_id"]= $this->user_id;
			if($row){
				$profile["gender"]= (isset($row->up_gender)) ? $row->up_gender : 0;
				$profile["location_city"]= $row->up_location_city;
				$profile["location_state"]= $row->up_location_state;
				$profile["location_country"]= $row->up_location_country;
				$profile["hometown_city"]= $row->up_hometown_city;
				$profile["hometown_state"]= $row->up_hometown_state;
				$profile["hometown_country"]= $row->up_hometown_country;
				$profile["birthday"]= $this->formatBirthday($row->up_birthday);
				$profile["birthyear"]= $this->getBirthdayYear($row->up_birthday);
				$profile["about"]= $row->up_about;
				$profile["places_lived"]= $row->up_places_lived;
				$profile["websites"]= $row->up_websites;
				$profile["relationship"]= $row->up_relationship;
				$profile["occupation"]= $row->up_occupation;
				$profile["schools"]= $row->up_schools;
				$profile["movies"]= $row->up_movies;
				$profile["music"]= $row->up_music;
				$profile["tv"]= $row->up_tv;
				$profile["books"]= $row->up_books;
				$profile["magazines"]= $row->up_magazines;
				$profile["video_games"]= $row->up_video_games;
				$profile["snacks"]= $row->up_snacks;
				$profile["drinks"]= $row->up_drinks;
				$profile["custom_1"]= $row->up_custom_1;
				$profile["custom_2"]= $row->up_custom_2;
				$profile["custom_3"]= $row->up_custom_3;
				$profile["custom_4"]= $row->up_custom_4;
				$profile["custom_5"]= $row->up_custom_5;
				$profile["user_page_type"] = $row->up_type;
				$wgMemc->set($key, $profile);
			}else{
				$profile["user_page_type"] = 1;
			}
		}

		//get work information

		if( isset($wgUserProfileDisplay['work']) && $wgUserProfileDisplay['work'] == true ){
			//try cache first
			if( $profile["user_id"] ){
				$key = wfMemcKey( 'user', 'profile',self::$profile_version, 'work', $this->user_id );
				//$wgMemc->delete( $key );
				$data = $wgMemc->get( $key );
				if ( $data ) {
					wfDebug( "Got user profile work for {$this->user_name} from cache\n" );
					$work = $data;
				}else{
					wfDebug( "Got user profile work for {$this->user_name} from db\n" );
					$dbr =& wfGetDB( DB_SLAVE );
					$params['ORDER_BY'] = "w_emp_from";
					$res = $dbr->select( 'user_profile_work',
						"*",
						array( 'w_user_id' => $this->user_id ), __METHOD__,
						$params
						);

					while( $row = $dbr->fetchObject($res) ) {

						$from = strtotime( $row->w_emp_from );

						if( $from !== false ){
							$from_month = date( "n", $from );
							$from_year = date("Y", $from);
						}

						$to = strtotime( $row->w_emp_to );

						if( $to !== false ){
							$to_month = date( "n", $to );
							$to_year = date( "Y", $to );
						}

						$work[] = array(
							"city" => $row->w_location_city,
							"state" => $row->w_location_state,
							"country" => $row->w_location_country,
							"employer" => $row->w_employer,
							"position" => $row->w_position,
							"description" => $row->w_description,
							"from" => $row->w_emp_from,
							"from_month" => $from_month,
							"from_year" => $from_year,
							"to_month" => $to_month,
							"to_year" => $to_year,
							"to" => $row->w_emp_to,
							"is_current" => $row->w_is_current,
							"id" => $row->w_id
						);
					}
					$profile["user_id"]= $this->user_id;
					$wgMemc->set($key, $work);
				}
				$profile["work"] = $work;
			}
		}

		$user = User::newFromId($this->user_id);
		$user->loadFromId();
		$profile["real_name"]= $user->getRealName();
		$profile["email"]= $user->getEmail();

		return $profile;
	}

	function formatBirthday($birthday){
		$dob = explode('-', $birthday);
		if(count($dob) == 3){
			$month = $dob[1];
			$day = $dob[2];
			$birthday_date = date("F jS", mktime(0,0,0,$month,$day));
		}
		else {
			$birthday_date = '';
		}
		return $birthday_date;
	}

	function getBirthdayYear($birthday){
		$dob = explode('-', $birthday);
		if(count($dob) == 3){
			return $dob[0];
		}
		return "00";
	}

	public function getProfileComplete(){
		global $wgUser, $wgSitename;

		$complete_count = 0;

		//check all profile fields
		$profile = $this->getProfile();
		foreach($this->profile_fields as $field){
			if($profile[$field]){
				$complete_count++;
			}
			$this->profile_fields_count++;
		}

		//check if avatar
		$this->profile_fields_count++;
		$avatar = new wAvatar($wgUser->getID(),"l");
		if (strpos($avatar->getAvatarImage(), 'default_') === false)$complete_count++;

		//if ArmchairGM, check if they have a favorite team/sport
		if($wgSitename == "ArmchairGM"){
			$this->profile_fields_count++;
			$favs = SportsTeams::getUserFavorites($wgUser->getID());
			if(count($favs) > 0)$complete_count++;
		}

		return round($complete_count / $this->profile_fields_count * 100);
	}

	static function getEditProfileNav( $current_nav ){
		$lines = explode( "\n", wfMsgForContent( 'update_profile_nav' ) );
		$output = "<div class=\"profile-tab-bar\">";
		foreach ($lines as $line) {

			if (strpos($line, '*') !== 0){
				continue;
			}else{
				$line = explode( '|' , trim($line, '* '), 2 );
				$page = Title::newFromText($line[0]);
				$link_text = $line[1];

				$output .= "<div class=\"profile-tab" . (($current_nav==$link_text)?"-on":"") . "\"><a href=\"" . $page->escapeFullURL() . "\">{$link_text}</a></div>";
			}
		}
		$output .= "<div class=\"cleared\"></div></div>";

		return $output;
	}

}



?>
