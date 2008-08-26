<?php
/**
 * Class to access profile data for a user
 */
class UserProfile {
	var $user_id;
	var $user_name;
	var $profile;

	var $profile_fields_count;

	var $profile_fields = array(
		"real_name","location_city","hometown_city","birthday",
		"about","places_lived","websites","occupation","schools",
		"movies","tv","books","magazines","video_games","snacks","drinks",
		"custom_1","custom_2","custom_3","custom_4","email"
		);
	var $profile_missing = array();

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

		$key = wfMemcKey( 'user', 'profile', 'info', $user_id );
		$wgMemc->delete( $key );
	}

	public function getProfile(){
		global $wgMemc;

		//try cache first
		$key = wfMemcKey( 'user', 'profile', 'info', $this->user_id );
		$data = $wgMemc->get( $key );
		if ( $data ) {
			wfDebug( "Got user profile info for {$this->user_name} from cache\n" );
			$profile = $data;
		} else {
			wfDebug( "Got user profile info for {$this->user_name} from DB\n" );
			$dbr = wfGetDB( DB_SLAVE );
			$params['LIMIT'] = "5";
			$row = $dbr->selectRow( 'user_profile',
				"*",
				array( 'up_user_id' => $this->user_id ), __METHOD__,
				$params
			);

			if($row){
				$profile["user_id"]= $this->user_id;
			} else {
				$profile["user_page_type"] = 1;
				$profile["user_id"]= 0;
			}
			$profile["location_city"]= isset( $row->up_location_city ) ? $row->up_location_city : '';
			$profile["location_state"]= isset( $row->up_location_state ) ? $row->up_location_state : '';
			$profile["location_country"]= isset( $row->up_location_country ) ? $row->up_location_country : '';
			$profile["hometown_city"]= isset( $row->up_hometown_city ) ? $row->up_hometown_city : '';
			$profile["hometown_state"]= isset( $row->up_hometown_state ) ?  $row->up_hometown_state : '';
			$profile["hometown_country"]= isset( $row->up_hometown_country ) ? $row->up_hometown_country : '';
			$profile["birthday"]= $this->formatBirthday( isset( $row->up_birthday ) ? $row->up_birthday : '' );

			$profile["about"]= isset( $row->up_about ) ? $row->up_about : '';
			$profile["places_lived"]= isset( $row->up_places_lived ) ? $row->up_places_lived : '';
			$profile["websites"]= isset( $row->up_websites ) ? $row->up_websites : '';
			$profile["relationship"]= isset( $row->up_relationship ) ? $row->up_relationship : '';
			$profile["occupation"]= isset( $row->up_occupation ) ? $row->up_occupation : '';
			$profile["schools"]= isset( $row->up_schools ) ? $row->up_schools : '';
			$profile["movies"]= isset( $row->up_movies ) ? $row->up_movies : '';
			$profile["music"]= isset( $row->up_music ) ? $row->up_music : '';
			$profile["tv"]= isset( $row->up_tv ) ? $row->up_tv : '';
			$profile["books"]= isset( $row->up_books ) ? $row->up_books : '';
			$profile["magazines"]= isset( $row->up_magazines ) ? $row->up_magazines : '';
			$profile["video_games"]= isset( $row->up_video_games ) ? $row->up_video_games : '';
			$profile["snacks"]= isset( $row->up_snacks ) ? $row->up_snacks : '';
			$profile["drinks"]= isset( $row->up_drinks ) ? $row->up_drinks : '';
			$profile["custom_1"]= isset( $row->up_custom_1 ) ? $row->up_custom_1 : '';
			$profile["custom_2"]= isset( $row->up_custom_2 ) ? $row->up_custom_2 : '';
			$profile["custom_3"]= isset( $row->up_custom_3 ) ? $row->up_custom_3 : '';
			$profile["custom_4"]= isset( $row->up_custom_4 ) ? $row->up_custom_4 : '';
			$profile["custom_5"]= isset( $row->up_custom_5 ) ? $row->up_custom_5 : '';
			$profile["user_page_type"] = isset( $row->up_type ) ? $row->up_type : '';
			$wgMemc->set($key, $profile);
		}

		$user = User::newFromId($this->user_id);
		$user->loadFromId();
		$profile["real_name"]= $user->getRealName();
		$profile["email"]= $user->getEmail();

		return $profile;
	}

	function formatBirthday($birthday){
		global $wgLang;
		$dob = explode('-', $birthday);
		if(count($dob) == 3){
			$month = $dob[1];
			$day = $dob[2];
			return date("F jS", mktime(0, 0, 0, $month, $day));
			return $day . ' ' . $wgLang->getMonthNameGen( $month );
		}
		return $birthday;
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
		$avatar = new wAvatar($wgUser->getID(), "l");
		if (strpos($avatar->getAvatarImage(), 'default_') === false)$complete_count++;

		return round($complete_count / $this->profile_fields_count * 100);
	}

	static function getEditProfileNav( $current_nav ){
		$lines = explode( "\n", wfMsgForContent( 'update_profile_nav' ) );
		$output = "<div class=\"profile-tab-bar\">";
		foreach ($lines as $line) {

			if (strpos($line, '*') !== 0){
				continue;
			} else {
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
