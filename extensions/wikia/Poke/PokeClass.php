<?php
/**
 *
 */
class Poke {

	/**
	 * All member variables should be considered private
	 * Please use the accessor functions
	 */

	 /**#@+
	 * @private
	 */
	
	
	/**
	 * Constructor
	 * @private
	 */
	/* private */ function __construct() {

		//language messages
		global $wgMessageCache;
		require_once ( "Poke.i18n.php" );
		foreach( efWikiaPoke() as $lang => $messages ){
			$wgMessageCache->addMessages( $messages, $lang );
		}
		
	}
	
	public function poke($user_name,$is_pokeback=0){
		global $wgUser, $wgMemc;
		if ($wgUser->isLoggedIn()) {
			$poke_from = $wgUser->getName();
			$poke_from_id = $wgUser->getID();
			$user_to_obj = User::newFromName($user_name);
			if ($user_to_obj) {
				$poke_to = $user_to_obj->getName();
				$poke_to_id = $user_to_obj->getID();
			}
			else {
				return "No Valid User Specified";
			}
			
			$poke_date = date("Y-m-d H:i:s");
			if ($is_pokeback) {
				$is_pokebackforsql = 1;
			}
			else {
				$is_pokebackforsql = 0;
			}
			
			$dbr =& wfGetDB( DB_MASTER );
			$dbr->insert( '`poke`',
			array(
				'poke_from' => $poke_from,
				'poke_from_id' => $poke_from_id,
				'poke_to' => $poke_to,
				'poke_to_id' => $poke_to_id,
				'poke_ack' => 0,
				'poke_back' => 0,
				'poke_is_pokeback' => $is_pokebackforsql,
				'poke_date' => $poke_date,
				), __METHOD__
			);
			$dbr->commit();
			
			$return_val = $dbr->insertId();
			
			if($is_pokeback) {
				$dbr->update( '`poke`',
				array( 
					'poke_ack'=>1,
					'poke_back'=>1,
					'poke_back_date'=>$poke_date,
				),
				array( 'poke_id' => $is_pokeback ),
				__METHOD__ );
				$dbr->commit();
				
				//$b = new UserBulletin();
				//$b->addBulletin($poke_from,"pokeback",$poke_to);
			}
			else {
				//$b = new UserBulletin();
				//$b->addBulletin($poke_from,"poke",$poke_to);
			}
			
			$key = wfMemcKey( 'user', 'nudges', $poke_to );
			$key_2 = wfMemcKey( 'user', 'nudges', $poke_from );
			$key_3 = wfMemcKey( 'user', 'nudges', $poke_to, $poke_from );
			$key_4 = wfMemcKey( 'user', 'nudges', $poke_from, $poke_to );
			$wgMemc->delete($key);
			$wgMemc->delete($key_2);
			$wgMemc->delete($key_3);
			$wgMemc->delete($key_4);
			
			$return_val = $this->sendPokeEmail($poke_from,$poke_to_id,$is_pokeback);
			
			return $return_val;
		}
	}
	
		public function remove_poke($poke_id){
		global $wgUser, $wgMemc;
		if ($wgUser->isLoggedIn()) {
			
			if($poke_id) {
				$dbr =& wfGetDB( DB_MASTER );
				$dbr->update( '`poke`',
				array( 
					'poke_ack'=>1,
				),
				array( 'poke_id' => $poke_id ),
				__METHOD__ );
				$dbr->commit();
				
				$user_name = $wgUser->getName();
				$key = wfMemcKey( 'user', 'nudges', $user_name);
				$data = $wgMemc->get( $key );
				if ($data) {
					$r_user_name = false;
					for($i=0; $i<sizeof($data); $i++) {
						if ($data[$i]["id"]=$poke_id) {
							$r_user_name = $data[$i]["poke_from"];
							if ($r_user_name == $user_name) $r_user_name = $data[$i]["poke_to"];
						}
					}
				}
				$wgMemc->delete($key);
				$key = wfMemcKey( 'user', 'nudges', $user_name, $r_user_name );
				$wgMemc->delete($key);
				$key = wfMemcKey( 'user', 'nudges', $r_user_name, $user_name );
				$wgMemc->delete($key);
				
				
			}
			
			return true;
		}
	}

	
	
	public function getOutstanding($user_name, $r_user_name) {
		
		global $wgMemc;
		
		if ($r_user_name) {
			$key = wfMemcKey( 'user', 'nudges', $user_name, $r_user_name );
			$key_2 = wfMemcKey( 'user', 'nudges', $r_user_name, $user_name );
		}
		else {
			$key = wfMemcKey( 'user', 'nudges', $user_name);
			$key_2 = false;
		}
		
		$pokes = array();
		$data = $wgMemc->get( $key );
		if($key_2 && !$data) {
			$data = $wgMemc->get( $key_2 );
		}
			if( $data ){
				wfDebug( "Cache Hit - Got education list ({$key}) from cache (size: " .sizeof($data). ")\n" );
				$pokes = $data;
			}else{
				
				wfDebug( "Cache Miss - Got education list ({$key}) from db\n" );
				
				$dbr =& wfGetDB( DB_SLAVE );
				$sql = "SELECT poke_id, poke_from, poke_from_id, poke_to, poke_to_id, poke_is_pokeback,
					poke_back, poke_ack, UNIX_TIMESTAMP(poke_date) as poke_date, UNIX_TIMESTAMP(poke_back_date) as poke_back_date
					FROM poke WHERE poke_to='{$user_name}' " . ($r_user_name ? " AND poke_from='{$r_user_name}' " : "") . "and poke_ack=0";
				
				$res = $dbr->query($sql);
				
				
				while($row = $dbr->fetchObject( $res )){
					$poke = array();
					$poke["id"]= $row->poke_id;
					$poke["from"]= $row->poke_from;
					$poke["from_id"]= $row->poke_from_id;
					$poke["to"]= $row->poke_to;
					$poke["to_id"]= $row->poke_to_id;	
					$poke["ack"]= $row->poke_ack;
					$poke["date"]= $row->poke_date;
					$poke["isback"] = $row->poke_is_pokeback;
					$poke["back"] = $row->poke_back;
					$poke["back_date"] = $row->poke_back_date;
					$poke["which"] = 1;
					
					$p = new ProfilePhoto( $poke["from_id"] );	
					$poke["avatar"] = $p->getProfileImageURL("l");
					$poke["avatar_img_s"] = $p->getProfileImageURL("s");
					
					
					//get username display
					$und = $row->poke_from_id;
					$und = User::newFromId( $und );
					$und->load();
					$und_full = $und->getRealName();
					$und_parts = split(" ", $und_full);
					$und_first = $und_parts[0];
					$und_last = $und_parts[1];
					$und_display = (($und_first&&$und_last)?ucwords(addslashes($und_first)." ".addslashes($und_last)):addslashes($row->poke_from));
					$poke["user_name_display"] = $und_display;
					
					
					$pokes[] = $poke;
				}
				
				if ($r_user_name && !sizeof($pokes)) {
					$sql = "SELECT poke_id, poke_from, poke_from_id, poke_to, poke_to_id, poke_is_pokeback,
					poke_back, poke_ack, UNIX_TIMESTAMP(poke_date) as poke_date, UNIX_TIMESTAMP(poke_back_date) as poke_back_date
					FROM poke WHERE poke_to='{$r_user_name}'  AND poke_from='{$user_name}' and poke_ack=0";
				
					$res = $dbr->query($sql);
					
					$pokes = array();
					while($row = $dbr->fetchObject( $res )){
						$poke = array();
						$poke["id"]= $row->poke_id;
						$poke["from"]= $row->poke_from;
						$poke["from_id"]= $row->poke_from_id;
						$poke["to"]= $row->poke_to;
						$poke["to_id"]= $row->poke_to_id;	
						$poke["ack"]= $row->poke_ack;
						$poke["date"]= $row->poke_date;
						$poke["isback"] = $row->poke_is_pokeback;
						$poke["back"] = $row->poke_back;
						$poke["back_date"] = $row->poke_back_date;
						$poke["which"] = 0;
						
						$p = new ProfilePhoto( $poke["to_id"] );	
						$poke["avatar"] = $p->getProfileImageURL("l");
						
						$pokes[] = $poke;
					}
					
				}
				
				//return $pokes;
				$wgMemc->set( $key, $pokes );
				if ($key_2) $wgMemc->set( $key_2, $pokes );
			}
			
			return $pokes;
	}
	
	public function sendPokeEmail($user_from,$user_id_to,$is_pokeback){
		global $wgProfileJSONPath;
		$user = User::newFromId($user_id_to);
		$user->loadFromDatabase();
		
		$user_from_obj = User::newFromName($user_from);
		if( is_object( $user_from_obj ) ){
			$user_from_obj->load();
			$user_from_display =  trim($user_from_obj->getRealName());
		}
		if( !$user_from_display ){
			$user_from_display = $user_from;
		}
			
		//if(  $user->getEmail() && $user->getIntOption("notifyfriendrequest",1) ){ //if($user->isEmailConfirmed()  && $user->getIntOption("notifyfriendrequest",1)){
		if(  $user->getEmail() ){
			$request_link = "{$wgProfileJSONPath}profile.html";
			$update_profile_link = "{$wgProfileJSONPath}editprofile.html";
			if($is_pokeback){
				$subject = wfMsgExt( 'poke_back_subject', 'parsemag',
					$user_from,
					$user_from_display
				 );
				$body = wfMsgExt( 'poke_back_body', 'parsemag',
					(( trim($user->getRealName()) )?$user->getRealName():$user->getName()),
					$user_from,
					$request_link,
					$update_profile_link,
					$user_from_display
				);
			}else{
				$subject = wfMsgExt( 'poke_subject', 'parsemag',
					$user_from,
					$user_from_display 
				 );
				$body = wfMsgExt( 'poke_body', 'parsemag',
					(( trim($user->getRealName()) )?$user->getRealName():$user->getName()),
					$user_from,
					$request_link,
					$update_profile_link,
					$user_from_display 
				);			
			}
			$user->sendMail($subject, $body );
			return "yes";
		}
		return "no";
	}
}

?>
