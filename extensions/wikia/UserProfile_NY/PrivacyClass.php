<?php
/**
 *
 */
class ProfilePrivacy {

	static $privacy_types = array(
		0 => "Nobody",
		1 => "Friends",
		//2 => "Networks",
		3 => "Users",
		4 => "Everyone"
	);

	static $privacy_checks = array(
		1 => "VIEW_FULL",
		2 => "VIEW_BASIC_PROFILE",
		3 => "VIEW_PERSONAL_PROFILE",
		4 => "VIEW_WORK_PROFILE",
		7 => "VIEW_WHITEBOARD",
		8 => "POST_WHITEBOARD",
		9 => "VIEW_FRIENDS",
		10 => "VIEW_BULLETINS",
		//11 => "VIEW_PHOTOS",
		13 => "VIEW_STATUS_HISTORY",
		14 => "POKE"
	);
	
	/**
	 * Constructor
	 * @private
	 */
	/* private */ function __construct() {
		
	}
	
	public function loadPrivacyForUser( $user_name ){
		global $wgUser;
		if( $wgUser->getName() != $user_name ){
			$user = User::newFromName($user_name);
			if( $user ){
				$this->groups = $this->getPrivacyGroups( $user->getID() );
				$this->user_list = $this->getPrivacyList( $user->getName() );
			}
		}
	}
	
	public function getPrivacyCheckForUser( $check ){
		if( $this->user_list[$check] ){
			return $this->groups[ $this->user_list[$check] ];
		}	
		return true;
	}
	
	public function getPrivacyGroups( $user_id_to ){
		global $wgUser;
		
		$profile_rel = UserRelationship::getUserRelationshipByID( $user_id_to , $wgUser->getID() );
		 
		$privacy_user_groups = array(
				"Users" => $wgUser->isLoggedIn(),
				"Everyone" => true,
				"Friends" => $profile_rel
		);
		return $privacy_user_groups;
	}
	
	public function setPrivacy( $check, $type ){
		global $wgUser;
		
		$dbr =& wfGetDB( DB_MASTER );
		
		//clear if old
		$dbr->delete( 'user_profile_privacy',array( 'p_user_id' =>  $wgUser->getID(), 'p_check' => $check ),__METHOD__ );
		$dbr->commit();
		
		$dbr->insert( '`user_profile_privacy`',
		array(
			'p_user_id' => $wgUser->getID(),
			'p_user_name' => $wgUser->getName(),
			'p_check' => $check,
			'p_type' => $type
			), __METHOD__
		);
		$dbr->commit();
		
		//clear memcache
		global $wgMemc;
		$key = wfMemcKey( 'user', 'profile', 'privacy', $wgUser->getID() );
		$data = $wgMemc->delete( $key );
	}
	
	
	static function getPrivacyList( $user_name ){
		
		$user_id = User::idFromName( $user_name );
		
		global $wgMemc;
		$key = wfMemcKey( 'user', 'profile', 'privacy', $user_id );
		$data = $wgMemc->get( $key );
		
		if( is_array( $data ) ){
			$privacy = $data;
		}else{
			$dbr =& wfGetDB( DB_MASTER );
			$res = $dbr->select( '`user_profile_privacy`', 
					array( 'p_type', 'p_check' ),
				array( 'p_user_id' => $user_id ), __METHOD__, 
				$params
			);
			
			$privacy = array();
			while ($row = $dbr->fetchObject( $res ) ) {
				$privacy[self::$privacy_checks[ $row->p_check ]] = self::$privacy_types[ $row->p_type ];
				
			}
			$wgMemc->set( $key, $privacy );
		}
			
		return $privacy;
	}

}
	


?>