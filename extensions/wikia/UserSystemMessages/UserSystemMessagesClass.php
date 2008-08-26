<?php
/**
 *
 */
class UserSystemMessage {

	/**
	 * All member variables should be considered private
	 * Please use the accessor functions
	 */

	
	public function addMessage($user_name,$type,$message){	
		$user_id = User::idFromName($user_name);
		$dbr =& wfGetDB( DB_MASTER );
		$fname = 'user_system_messages::addToDatabase';
		$dbr->insert( '`user_system_messages`',
		array(
			'um_user_id' => $user_id,
			'um_user_name' => $user_name,
			'um_type' => $type,
			'um_message' => $message,
			'um_date' => date("Y-m-d H:i:s"),
			), $fname
		);
	}
		

	static function deleteMessage($um_id){
		$dbr =& wfGetDB( DB_MASTER );
		$sql = "DELETE FROM user_system_messages WHERE um_id={$um_id}";
		$res = $dbr->query($sql);
	}	

	
	public function getMessageList($type,$limit=0,$page=0){
		$dbr =& wfGetDB( DB_MASTER );
		
		if($limit>0){
			$limitvalue = 0;
			if($page)$limitvalue = $page * $limit - ($limit); 
			$limit_sql = " LIMIT {$limitvalue},{$limit} ";
		}
		
		$sql = "SELECT ug_id, ug_user_id_from, ug_user_name_from, ug_gift_id, ug_date, ug_status,
			gift_name, gift_description, gift_given_count
			FROM user_gift INNER JOIN gift ON ug_gift_id=gift_id 
			WHERE ug_user_id_to = {$this->user_id}
			ORDER BY ug_id DESC
			{$limit_sql}";
		
		$res = $dbr->query($sql);
		while ($row = $dbr->fetchObject( $res ) ) {
			 $requests[] = array(
				 "id"=>$row->ug_id,"gift_id"=>$row->ug_gift_id,"timestamp"=>($row->ug_date ) , "status"=>$row->ug_status,
				 "user_id_from"=>$row->ug_user_id_from,"user_name_from"=>$row->ug_user_name_from,
				 "gift_name"=>$row->gift_name, "gift_description"=>$row->gift_description, "gift_given_count" => $row->gift_given_count
				 );
		}
		return $requests;
	}
	
	public function sendAdvancementNotificationEmail($user_id_to,$level){
		global $IP, $wgMessageCache;
		require_once("$IP/extensions/wikia/UserStats/UserStats.i18n.php");
		foreach( efWikiaUserStats() as $lang => $messages ){
			$wgMessageCache->addMessages( $messages, $lang );
		}
		$user = User::newFromId($user_id_to);
		$user->loadFromDatabase();
		if($user->isEmailConfirmed() && $user->getIntOption("notifyhonorifics",1) ){
			$update_profile_link = Title::makeTitle( NS_SPECIAL , "UpdateProfile"  );
			$subject = wfMsgExt( 'level_advance_subject', "parsemag",
				$level
				 );
			$body = wfMsgExt( 'level_advance_body', "parsemag",
				(( trim($user->getRealName()) )?$user->getRealName():$user->getName()),
				$level,
				$update_profile_link->getFullURL()
			);
			$user->sendMail($subject, $body );
		}
	}
	
	
}
	
?>