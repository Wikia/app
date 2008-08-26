<?php
/**
 *
 */

function wfGetRelDBName() {
	global $wgSharedUserProfile, $wgSharedDB, $wgDBname;
	return ($wgSharedUserProfile)?$wgSharedDB:$wgDBname;
}

class UserRelationship {

	/**
	 * All member variables should be considered private
	 * Please use the accessor functions
	 */

	 /**#@+
	 * @private
	 */
	var $user_id;           	# Text form (spaces not underscores) of the main part
	var $user_name;			# Text form (spaces not underscores) of the main part
	var $friend_count;           	# Text form (spaces not underscores) of the main part
	var $foe_count;           	# Text form (spaces not underscores) of the main part
	
	var $from_email; 

	/**
	 * Constructor
	 * @private
	 */
	/* private */ function __construct($username) 
	{
		global $wgMessageCache;
		global $wgSharedDB, $wgDBname, $wgShareUserProfile;

		$title1 = Title::newFromDBkey($username  );
		$this->user_name = $title1->getText();
		$this->user_id = User::idFromName($this->user_name);
		#---
		require_once ( dirname( __FILE__ ) . '/UserRelationship.i18n.php' );
		foreach( efSpecialUserReplationship() as $lang => $messages ) 
		{
			$wgMessageCache->addMessages( $messages, $lang );
		}
		$this->from_email = "friends@wikia.com";
	}
	
	public function addRelationshipRequest($user_to,$type,$message) {
		$db_name = wfGetRelDBName();
		#---
		$user_id_to = User::idFromName($user_to);
		$dbr =& wfGetDB( DB_MASTER );
		$fname = 'user_relationship_request::addToDatabase';
		$dbr->insert( "`{$db_name}`.`user_relationship_request`",
		array(
			'ur_user_id_from' => $this->user_id,
			'ur_user_name_from' => $this->user_name,
			'ur_user_id_to' => $user_id_to,
			'ur_user_name_to' => $user_to,
			'ur_type' => $type,
			'ur_message' => $message,
			'ur_date' => date("Y-m-d H:i:s")
			), $fname
		);
		$this->sendRelationshipRequestEmail($user_id_to,$this->user_name,$type);		
	}
	
	public function sendRelationshipRequestEmail($user_id_to,$user_from,$type) 
	{
		global $wgMessageCache;

		#---
		$user = User::newFromId($user_id_to);
		$user->loadFromDatabase();
		if ( $user->isEmailConfirmed()  && $user->getIntOption("notifyfriendrequest",1) ) 
		{
			$request_link = Title::makeTitle( NS_SPECIAL , "ViewRelationshipRequests" );
			$update_profile_link = Title::makeTitle( NS_SPECIAL , "UpdateProfile" );
			if ( $type==1 ) {
				$subject = wfMsg( 'friend_request_subject', $user_from );
				$body = wfMsg( 'friend_request_body', $user->getName(), $user_from, $request_link->getFullURL(), $update_profile_link->getFullURL() );
			} 
			/*
			 * FOE OFF !
			else {
				$subject = wfMsg( 'foe_request_subject', $user_from );
				$body = wfMsg( 'foe_request_body', $user->getName(), $user_from, $request_link->getFullURL(), $update_profile_link->getFullURL() );				
			}
			*/
			$user->sendMail($subject, $body, $this->from_email);
		}
	}
	
	public function sendRelationshipAcceptEmail($user_id_to, $user_from, $type)
	{
		global $wgMessageCache;
		
		#---
		$user = User::newFromId($user_id_to);
		$user->loadFromDatabase();
		if ( $user->isEmailConfirmed() && $user->getIntOption("notifyfriendrequest",1) ) 
		{
			$user_link = Title::makeTitle( NS_USER ,  $user_from );
			$update_profile_link = Title::makeTitle( NS_SPECIAL , "UpdateProfile" );
			if ( $type==1 ) {
				$subject = wfMsg( 'friend_accept_subject', $user_from );
				$body = wfMsg( 'friend_accept_body', $user->getName(), $user_from, $user_link->getFullURL(), $update_profile_link->getFullURL() );
			}
			/*
			 * FOE OFF !
			else{
				$subject = wfMsg( 'foe_accept_subject', $user_from );
				$body = wfMsg( 'foe_accept_body', $user->getName(), $user_from, $user_link->getFullURL(), $update_profile_link->getFullURL() );
			}*/
			$user->sendMail($subject, $body, $this->from_email);
		}		
	}

	public function sendRelationshipRemoveEmail($user_id_to, $user_from, $type) {
		global $wgMessageCache;

		#---
		$user = User::newFromId($user_id_to);
		$user->loadFromDatabase();
		if ( $user->isEmailConfirmed() && $user->getIntOption("notifyfriendrequest",1) ) {
			$user_link = Title::makeTitle( NS_USER ,  $user_from  );
			$update_profile_link = Title::makeTitle( NS_SPECIAL , "UpdateProfile"  );
			if($type==1){
				$subject = wfMsg( 'friend_removed_subject', $user_from );
				$body = wfMsg( 'friend_removed_body', $user->getName(), $user_from, $user_link->getFullURL(), $update_profile_link->getFullURL() );
			}
			/*
			 * FOE OFF !
			else{
				$subject = wfMsg( 'foe_removed_subject', $user_from );
				$body = wfMsg( 'foe_removed_body', $user->getName(), $user_from, $user_link->getFullURL(), $update_profile_link->getFullURL() );
			}*/
			$user->sendMail($subject, $body, $this->from_email);
		}
	}
	
	public function addRelationship($relationship_request_id) {
		global $wgMemc;
		#---
		$fname = "UserRelationship:addRelationship";
		#---
		$db_name = wfGetRelDBName();
		#---
		$dbr =& wfGetDB( DB_MASTER );
		$s = $dbr->selectRow( "`{$db_name}`.`user_relationship_request`", 
				array( 'ur_user_id_from','ur_user_name_from','ur_type'),
				array( 'ur_id' => $relationship_request_id ), $fname 
		);
		if ( $s == true ) {
			$ur_user_id_from = $s->ur_user_id_from;
			$ur_user_name_from = $s->ur_user_name_from;
			$ur_type = $s->ur_type;
			
			$fname = 'user_relationship::addToDatabase';
			$dbr->insert( "`{$db_name}`.`user_relationship`",
			array(
				'r_user_id' => $this->user_id,
				'r_user_name' => $this->user_name,
				'r_user_id_relation' => $ur_user_id_from,
				'r_user_name_relation' => $ur_user_name_from,
				'r_type' => $ur_type,
				'r_date' => date("Y-m-d H:i:s")
				), $fname
			);
			
			$fname = 'user_relationship::addToDatabase';
			$dbr->insert( "`{$db_name}`.`user_relationship`",
			array(
				'r_user_id' => $ur_user_id_from,
				'r_user_name' => $ur_user_name_from,
				'r_user_id_relation' => $this->user_id,
				'r_user_name_relation' => $this->user_name,
				'r_type' => $ur_type,
				'r_date' => date("Y-m-d H:i:s")
				), $fname
			);
			
			$this->updateUserStats($this->user_id,$this->user_name);
			$this->updateUserStats($ur_user_id_from,$ur_user_name_from);
			$this->sendRelationshipAcceptEmail($ur_user_id_from,$this->user_name,$ur_type);
			
			$wgMemc->delete( wfMemcKey( 'relationship', 'profile', "{$this->user_id}-{$ur_type}") );
			$wgMemc->delete( wfMemcKey( 'relationship', 'profile', "{$ur_user_id_from}-{$ur_type}") );
		
			return true;
		} else {
			return false;
		}
	}
	
	public function removeRelationshipByUserID($user1,$user2) {
		global $wgUser, $wgMemc;
		#---
		$db_name = wfGetRelDBName();
		
		if ($user1!=$wgUser->getID() && $user2!=$wgUser->getID()) {
			return false; //only logged in user should be able to delete
		}
		//must delete record for each user involved in relationship
		$dbr =& wfGetDB( DB_MASTER );
		$sql = "DELETE FROM `{$db_name}`.`user_relationship` WHERE r_user_id={$user1} AND r_user_id_relation={$user2}";
		$res = $dbr->query($sql);
		$sql = "DELETE FROM `{$db_name}`.`user_relationship` WHERE r_user_id={$user2} AND r_user_id_relation={$user1}";
		$res = $dbr->query($sql);
		
		$wgMemc->delete( wfMemcKey( 'relationship', 'profile', "{$user1}-1") );
		$wgMemc->delete( wfMemcKey( 'relationship', 'profile', "{$user2}-1" ) );
			
		$wgMemc->delete( wfMemcKey( 'relationship', 'profile', "{$user1}-2" ) );
		$wgMemc->delete( wfMemcKey( 'relationship', 'profile', "{$user2}-2" ) );
		
		$this->updateUserStats($user1,"");
		$this->updateUserStats($user2,"");
	}
	
	public function deleteRequest($id) {
		$db_name = wfGetRelDBName();
		#---
		$dbr =& wfGetDB( DB_MASTER );
		$sql = "DELETE FROM `{$db_name}`.`user_relationship_request` WHERE ur_id={$id}";
		$res = $dbr->query($sql);
	}	
	
	public function updateRelationshipRequestStatus($relationship_request_id, $status){
		$db_name = wfGetRelDBName();
		#---
		$dbw =& wfGetDB( DB_MASTER );
		$dbw->update( "`{$db_name}`.`user_relationship_request`", array( 'ur_status' => $status ), array( 'ur_id' => $relationship_request_id ), "");
	}
	
	public function verifyRelationshipRequest($relationship_request_id) {
		$fname = "UserRelationship:verifyRelationshipRequest";
		#---
		$db_name = wfGetRelDBName();
		#---
		$dbr =& wfGetDB( DB_MASTER );
		$s = $dbr->selectRow( "`{$db_name}`.`user_relationship_request`", array( 'ur_user_id_to' ), array( 'ur_id' => $relationship_request_id ), $fname );
		if ( $s !== false ) {
			if ($this->user_id == $s->ur_user_id_to) {
				return true;
			}
		}
		return false;
	}
	
	static function getUserRelationshipByID($user1,$user2){
		$fname = "UserRelationship:getUserRelationshipByID";
		#---
		$db_name = wfGetRelDBName();
		#---
		$dbr =& wfGetDB( DB_MASTER );
		$s = $dbr->selectRow( "`{$db_name}`.`user_relationship`", array( 'r_type' ), array( 'r_user_id' => $user1, 'r_user_id_relation' => $user2 ), $fname );
		if ( $s !== false ) {
			return $s->r_type;
		} else {
			return false;
		}
	}
	
	static function userHasRequestByID($user1,$user2){
		$fname = "UserRelationship:userHasRequestByID";
		#---
		$db_name = wfGetRelDBName();
		#---
		$dbr =& wfGetDB( DB_MASTER );
		$s = $dbr->selectRow( "`{$db_name}`.`user_relationship_request`", array( 'ur_type' ), array( 'ur_user_id_to' => $user1, 'ur_user_id_from' => $user2, 'ur_status' => 0 ), $fname );
		if ( $s === false ) {
			return false;
		} else {
			return true;
		}
	}
	
	public function getRequest($id){
		$db_name = wfGetRelDBName();
		#---
		$dbr =& wfGetDB( DB_MASTER );
		
		#---
		$sql = "SELECT ur_id, ur_user_id_from, ur_user_name_from, ur_type, ur_message, ur_date FROM `{$db_name}`.`user_relationship_request`  WHERE ur_id = {$id}";
		$res = $dbr->query($sql);
		while ($row = $dbr->fetchObject( $res ) ) {
			if($row->ur_type==1){
				$type_name = wfMsg('friend_text');
			} 
			/*
			 * FOE OFF !
			else {
				$type_name = wfMsg('foe_text');
			}*/
			$request[] = array(
				 "id"=>$row->ur_id,"type"=>$type_name,"timestamp"=>($row->ur_date ) ,
				 "user_id_from"=>$row->ur_user_id_from,"user_name_from"=>$row->ur_user_name_from
			);
		}
		return $request;
	}
	
	public function getRequestList($status,$limit=0)
	{
		$db_name = wfGetRelDBName();
		#---
		$dbr =& wfGetDB( DB_MASTER );
		#---
		$limit_sql = "";
		if ($limit>0) {
			$limit_sql = " LIMIT 0,{$limit} ";
		}
		
		$sql = "SELECT ur_id, ur_user_id_from, ur_user_name_from, ur_type, ur_message, ur_date
		FROM `{$db_name}`.`user_relationship_request` 
		WHERE ur_user_id_to = {$this->user_id} AND ur_status = {$status}
		{$limit_sql}
		ORDER BY ur_id DESC";
		
		$res = $dbr->query($sql);
		
		while ($row = $dbr->fetchObject( $res ) ) 
		{
			if($row->ur_type==1){
				$type_name = wfMsg('friend_text');
			} 
			/*
			 * FOE OFF !
			else {
				$type_name = wfMsg('foe_text');
			}*/
			$requests[] = array(
				 "id"=>$row->ur_id,"type"=>$type_name,"message"=>$row->ur_message,"timestamp"=>($row->ur_date ) ,
				 "user_id_from"=>$row->ur_user_id_from,"user_name_from"=>$row->ur_user_name_from
			);
		}
		return $requests;
	}
	
	static function getOpenRequestCount($user_id, $rel_type)
	{
		$db_name = wfGetRelDBName();
		$fname = "UserRelationship::getOpenRequestCount";
		#---
		$dbr =& wfGetDB( DB_MASTER );
		$request_count = 0;
		$s = $dbr->selectRow( "`{$db_name}`.`user_relationship_request`", array( 'count(*) as count' ), array( 'ur_user_id_to' => $user_id, 'ur_status' => 0, 'ur_type' => $rel_type ), $fname );
		if ( $s !== false )$request_count = $s->count;	
		return $request_count;
	}
	
	public function getRelationshipList($type,$limit=0,$page=0)
	{
		$db_name = wfGetRelDBName();
		#---
		$dbr =& wfGetDB( DB_MASTER );
		#---
		$limit_sql = "";
		if ($limit>0) {
			$limitvalue = 0;
			if($page)$limitvalue = $page * $limit - ($limit); 
			$limit_sql = " LIMIT {$limitvalue},{$limit} ";
		}
		
		$sql = "SELECT r_id, r_user_id_relation, r_user_name_relation, r_date
			FROM `{$db_name}`.`user_relationship`
			WHERE r_user_id = {$this->user_id} AND r_type = {$type}
			ORDER BY r_user_name_relation
			{$limit_sql}";
		
		$res = $dbr->query($sql);
		$requests = array();
		while ($row = $dbr->fetchObject( $res ) ) 
		{
			$requests[] = array
			(
				"id"=>$row->r_id,"timestamp"=>($row->r_date ) ,
				"user_id"=>$row->r_user_id_relation,"user_name"=>$row->r_user_name_relation
			);
		}
		
		return $requests;
	}
	
	static function getRelationshipCountByUsername($user_name)
	{
		#---
		$db_name = wfGetRelDBName();
		#---
		$dbr =& wfGetDB( DB_MASTER );
		$user_id = User::idFromName($user_name);
		$sql = "SELECT rs_friend_count, rs_foe_count FROM `{$db_name}`.`user_relationship_stats` WHERE rs_user_id = {$user_id} LIMIT 0,1";
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );
		$friend_count = 0;
		$foe_count = 0;
		if($row){
			$friend_count=$row->rs_friend_count;
			$foe_count=$row->rs_foe_count;
		}
		$stats["friend_count"]= $friend_count;
		$stats["foe_count"]= $foe_count;
		return $stats;		
	}
	
	public function updateUserStats($user_id,$user_name){
		#---
		$fname = "UserRelationship:updateUserStats";
		#---
		$db_name = wfGetRelDBName();
		#---
		$dbr =& wfGetDB( DB_MASTER );
     	
	    $friend_count = 0;
	    $foe_count = 0;
	    
	    $s = $dbr->selectRow( "`{$db_name}`.`user_relationship`", array( 'count(*) as count' ), array( 'r_user_id' => $user_id, 'r_type' => 1 ), $fname );
	    if ( $s !== false )$friend_count = $s->count;
	    $s = $dbr->selectRow( "`{$db_name}`.`user_relationship`", array( 'count(*) as count' ), array( 'r_user_id' => $user_id, 'r_type' => 2 ), $fname );
	    if ( $s !== false )$foe_count = $s->count;
	    
	    $s = $dbr->selectRow( "`{$db_name}`.`user_relationship_stats`", array( 'rs_id' ), array( 'rs_user_id' => $user_id ), $fname );
	    if ( $s === false ) {
	    	$fname = 'user_relationship_stats::addToDatabase';
			$dbr->insert( "`{$db_name}`.`user_relationship_stats`",
							array(
								'rs_user_id' => $user_id,
								'rs_user_name' => $user_name,
								'rs_friend_count' => $friend_count,
								'rs_foe_count' => $foe_count
							), 
							$fname
						);
		} else {
		    $dbr->update( "`{$db_name}`.`user_relationship_stats`", array( 'rs_friend_count' => $friend_count, 'rs_foe_count' => $foe_count), array( 'rs_user_id' => $user_id ), "" );
	    }
    }

	public function getUserPageMenu($user_name) {
		global $wgUser;

	    $id = User::idFromName($user_name);
   	    $newUser = User::newFromId($id);
	    #---		
		$addImageUrl = ( ($wgUser->getID() == $id) && ( $id !=0 ) && ($wgUser->getID() != 0) ) ? "(<a class=\"user-add-image-menu\" href=\"javascript:void(0);\">".wfMsg('add_avatar')."</a>)" : "";
		#---

		if ( ($wgUser->getID() != $id) && ($wgUser->getID() != 0) )
		{
			$relationship = $this->getUserRelationshipByID($id,$wgUser->getID());
			
			if ((!($relationship==2)) && ($relationship == false)) {
				$menu .= '<a href="index.php?title=Special:AddRelationship&user='.$user_name.'&rel_type=1">'.wfMsg('friendme').'</a> - ';
			}
			/*
			 * FOE OFF !
			if (!($relationship==1) && ($relationship == false)) {
				$menu .= '<a href="index.php?title=Special:AddRelationship&user='.$user_name.'&rel_type=2">'.wfMsg('foeme').'</a> - ';
			}
			*/
			if ($relationship==true) {
				#---
				if ($relationship == 1) {
					$menu .= '<b>'.wfMsg('yourfriend').'</b> - ';
				}
				/*
				 * FOE OFF !
				if ($relationship == 2) {
					$menu .= '<b>'.wfMsg('yourfoe').'</b> - ';
				}
				*/
			}
			$menu .= '<a href="index.php?title=Special:GiveGift&user='.$user_name.'">'.wfMsg('giveusergift').'</a>';
			#---
			if ($wgUser->isLoggedIn() && $newUser->canSendEmail())
			{
				$menu .= ' - <a href="/wiki/Special:Emailuser/'.$user_name.'">'.wfMsg('sendmessage').'</a>';
			}
			else
			{
				$menu .= ' - <a href="index.php?title=User_talk&user='.$user_name.'">'.wfMsg('sendmessage').'</a>';
			}			
		}
		
		return $menu;
	}

}
	
?>
