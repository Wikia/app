<?php
/**
 *
 */
class ProfileLink {


	static $link_types = array(
		-1 => "BLOCKED"
	);
	
	/**
	 * Constructor
	 * @private
	 */
	/* private */ function __construct() {
		
	}
	
	
	public function setLink( $user_id, $type ){
		global $wgUser;
		
		$dbr =& wfGetDB( DB_MASTER );
		
		//clear if old
		$dbr->delete( 'user_profile_link',array( 'pl_user_id' =>  $wgUser->getID(), 'pl_user_id_to' => $user_id ),__METHOD__ );
		$dbr->commit();
		
		$dbr->insert( '`user_profile_link`',
		array(
			'pl_user_id' => $wgUser->getID(),
			'pl_user_id_to' => $user_id,
			'pl_type' => $type
			), __METHOD__
		);
		$dbr->commit();
	}
	
	static function getLinkType( $user_id ){
		global $wgUser;
		$dbr =& wfGetDB( DB_MASTER );
		$s = $dbr->selectRow( '`user_profile_link`', 
				array( 'pl_type' ),
				array( 'pl_user_id' =>  $user_id , 'pl_user_id_to' => $wgUser->getID() ), __METHOD__, 
				""
		);
		if ( $s !== false ){
			return $s->pl_type;
		}else{
			return 0;
		}
	}
	
	static function getLinkList( $user_name ){
		
		$user_id = User::idFromName( $user_name );
		
		$dbr =& wfGetDB( DB_MASTER );
		$res = $dbr->select( '`user_profile_link`', 
				array( 'pl_user_id_to', 'pl_type' ),
			array( 'pl_user_id' => $user_id ), __METHOD__, 
			$params
		);
		
		$list = array();
		while ($row = $dbr->fetchObject( $res ) ) {
			
			$p = new ProfilePhoto( $row->pl_user_id_to );
		
			$user = User::newFromId( $row->pl_user_id_to );
			$user->load();
			
			$und_full = $user->getRealName();
			$und_parts = split(" ", $und_full);
			$und_first = $und_parts[0];
			$und_last = $und_parts[1];
			$und_display = (($und_first&&$und_last)?ucwords(addslashes($und_first)." ".addslashes($und_last)):addslashes($user->getName()));
			
			$user_name_blocked = $und_display;
			
			$list[] = array(
				"user_id" => $row->pl_user_id_to,
				"user_name" => $user->getName(),
				"user_name_display" => $user_name_blocked,
				"avatar" => $p->getPhotoImageTag("l"),
				"avatar_m"=> $p->getPhotoImageTag("m"),
				"type" => self::$link_types[ $row->pl_type ]
			);
			
		}
		
		return $list;
	}

}
	


?>