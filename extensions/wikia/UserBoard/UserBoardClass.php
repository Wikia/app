<?php
/**
 *
 */
class UserBoard {

	/**
	 * All member variables should be considered private
	 * Please use the accessor functions
	 */

	 /**#@+
	 * @private
	 */
	var $user_id;           	# Text form (spaces not underscores) of the main part
	var $user_name;			# Text form (spaces not underscores) of the main part
	
	/**
	 * Constructor
	 * @private
	 */
	/* private */ function __construct() {

		
	}
	
	public function sendBoardMessage($user_id_from,$user_name_from,$user_id_to,$user_name_to, $message, $message_type=0){	
		global $IP;
		$dbr =& wfGetDB( DB_MASTER );
		
		$user_name_from = stripslashes($user_name_from);
		$user_name_to = stripslashes($user_name_to);
		
		$dbr->insert( '`user_board`',
		array(
	
			'ub_user_id_from' => $user_id_from,
			'ub_user_name_from' => $user_name_from,
			'ub_user_id' => $user_id_to,
			'ub_user_name' => $user_name_to,
			'ub_message' => $message,
			'ub_type' => $message_type,
			'ub_date' => date("Y-m-d H:i:s"),
			), __METHOD__
		);
		
		
		$ub_gift_id = $dbr->insertId();
	
		$dbr->commit();
		
		//Send Email (if user is not writing on own board)
		if( $user_id_to > 0 && $user_id_from!=$user_id_to){
			$this->sendBoardNotificationEmail($user_id_to,$user_name_from);
			$this->incNewMessageCount($user_id_to);
		}else{
			$this->incNewMessageCount($user_name_to);
		}
		
		$stats = new UserStatsTrack($user_id_to, $user_name_to);
		if($message_type==0){
			//public message count
			$stats->incStatField("user_board_count");
		}else{
			//private message count
			$stats->incStatField("user_board_count_priv");
		}
	
		$stats = new UserStatsTrack($user_id_from, $user_name_from);
		$stats->incStatField("user_board_sent");
	
		global $wgUserBulletins;
		if( $wgUserBulletins["board"] == true && $message_type == 0 ){
			$b = new UserBulletin();
			$b->addBulletin($user_name_from,"wall",$user_name_to);
		}
		
		return $ub_gift_id;
	}
	
	public function sendBoardNotificationEmail($user_id_to,$user_from){
	
		$user = User::newFromId($user_id_to);
		$user->loadFromId();
		
		$user_from_obj = User::newFromName($user_from);
		if( is_object( $user_from_obj ) ){
			$user_from_obj->load();
			$user_from_display =  trim($user_from_obj->getRealName());
		}
		if( !$user_from_display ){
			$user_from_display = $user_from;
		}
		
		if($user->isEmailConfirmed() && $user->getIntOption("notifymessage",1) ){
			$board_link = Title::makeTitle( NS_SPECIAL , "UserBoard"  );
			$update_profile_link = Title::makeTitle( NS_SPECIAL , "UpdateProfile"  );
			$subject = wfMsgExt( 'message_received_subject',"parsemag",
				$user_from,
				$user_from_display
				 );
			$body = wfMsgExt( 'message_received_body', "parsemag",
				(( trim($user->getRealName()) )?$user->getRealName():$user->getName()),
				$user_from,
				$board_link->escapeFullURL(),
				$update_profile_link->escapeFullURL(),
				$user_from_display
			);
				
			$user->sendMail($subject, $body );
		}
	}
	
	public function incNewMessageCount($user_id){
		global $wgMemc;
		$key = wfMemcKey( 'user', 'newboardmessage', $user_id );
		$wgMemc->incr( $key );
		
	}
	
	static function clearNewMessageCount($user_id){
		global $wgMemc;
		$key = wfMemcKey( 'user', 'newboardmessage', $user_id );
		$wgMemc->set($key,0);
	}

	static function getNewMessageCountCache($user_id){
		global $wgMemc;
		$key = wfMemcKey( 'user', 'newboardmessage', $user_id );
		$data = $wgMemc->get( $key );
		if($data != ""){
			wfDebug( "Got new message count of $data for id $user_id from cache\n" );
			return $data;
		}
		
	}

	static function getNewMessageCountDB($user_id){
		wfDebug( "Got new message count for id $user_id from db\n" );
		
		global $wgMemc;
		$key = wfMemcKey( 'user', 'newboardmessage', $user_id );
		//$dbr =& wfGetDB( DB_MASTER );
		$new_count = 0;
		//$s = $dbr->selectRow( '`user_board`', array( 'count(*) as count' ), array( 'ug_user_id_to' => $user_id, 'ug_status' => 1 ), $fname );
		//if ( $s !== false )$new_gift_count = $s->count;	
		
		$wgMemc->set($key,$new_count);
		
		return $new_count;
	}

	static function getNewMessageCount($user_id){
		global $wgMemc;
		$data = self::getNewMessageCountCache($user_id);
		
		if( $data != "" ){
			$count = $data;
		}else{
			$count = self::getNewMessageCountDB($user_id);
		}	
		return $count;
	}
	
	public function doesUserOwnMessage($user_id, $ub_id){
		$dbr =& wfGetDB( DB_MASTER );
		$s = $dbr->selectRow( '`user_board`', array( 'ub_user_id' ), array( 'ub_id' => $ub_id ), $fname );
		if ( $s !== false ) {
			if($user_id == $s->ub_user_id){
				return true;
			}
		}
		return false;
	}
	
	public function didUserSendMessage($user_id, $ub_id){
		$dbr =& wfGetDB( DB_MASTER );
		$s = $dbr->selectRow( '`user_board`', array( 'ub_user_id_from' ), array( 'ub_id' => $ub_id ), $fname );
		if ( $s !== false ) {
			if($user_id == $s->ub_user_id_from){
				return true;
			}
		}
		return false;
	}

	public function deleteMessage($ub_id){
		if($ub_id){
			$dbr =& wfGetDB( DB_MASTER );
			$s = $dbr->selectRow( '`user_board`', array( 'ub_user_id','ub_user_name','ub_type' ), array( 'ub_id' => $ub_id ), $fname );
			if ( $s !== false ) {
				
				$sql = "DELETE FROM user_board WHERE ub_id={$ub_id}";
				$res = $dbr->query($sql);
			
				$stats = new UserStatsTrack($s->ub_user_id, $s->ub_user_name);
				if($s->ub_type==0){
					$stats->decStatField("user_board_count");
				}else{
					$stats->decStatField("user_board_count_priv");	
				}
			}
		}
	}
	
	public function getUserBoardMessages($user_id,$user_id_2=0,$limit=0,$page=0){
		global $wgUser, $wgOut, $wgTitle, $wgParser;
		$dbr =& wfGetDB( DB_MASTER );
		
		if($limit>0){
			$limitvalue = 0;
			if($page)$limitvalue = $page * $limit - ($limit); 
			$limit_sql = " LIMIT {$limitvalue},{$limit} ";
		}
		
		if($user_id_2){
			$user_sql = "( (ub_user_id={$user_id} and ub_user_id_from={$user_id_2}) OR 
					(ub_user_id={$user_id_2} and ub_user_id_from={$user_id}) )
					";
			if(! ($user_id == $wgUser->getID() || $user_id_2 == $wgUser->getID()) ){
				$user_sql .= " and ub_type = 0 ";
			}
		}else{
			$user_sql = "ub_user_id = {$user_id}";
			if($user_id != $wgUser->getID() ){
				$user_sql .= " and ub_type = 0 ";
			}
			if( $wgUser->isLoggedIn() ) {
				$user_sql .= " or (ub_user_id={$user_id} and ub_user_id_from={$wgUser->getID() }) ";
			}
		}
		
		$sql = "SELECT ub_id, ub_user_id_from, ub_user_name_from, ub_user_id, ub_user_name,
			ub_message,UNIX_TIMESTAMP(ub_date) as unix_time,ub_type
			FROM user_board   
			WHERE {$user_sql}
			ORDER BY ub_id DESC
			{$limit_sql}";
		
		$res = $dbr->query($sql);
		$messages = array();
		while ($row = $dbr->fetchObject( $res ) ) {
			$message_text = $wgParser->parse( $row->ub_message, $wgTitle, $wgOut->parserOptions(),true );
			$message_text = $message_text->getText();
		
			 $messages[] = array(
				 "id"=>$row->ub_id,"timestamp"=>($row->unix_time ) ,
				 "user_id_from"=>$row->ub_user_id_from,"user_name_from"=>$row->ub_user_name_from,
				 "user_id"=>$row->ub_user_id,"user_name"=>$row->ub_user_name,
				 "message_text"=>$message_text,"type"=>$row->ub_type
			
				 );
		}
		return $messages;
	}

	public function getAnonUserBoardMessages($user_name,$user_id_2=0,$limit=0,$page=0){
		global $wgUser, $wgOut, $wgTitle, $wgParser;
		$dbr =& wfGetDB( DB_MASTER );
		
		if($limit>0){
			$limitvalue = 0;
			if($page)$limitvalue = $page * $limit - ($limit); 
			$limit_sql = " LIMIT {$limitvalue},{$limit} ";
		}
		
		if($user_id_2){
			$user_sql = "( (ub_user_id={$user_id} and ub_user_id_from={$user_id_2}) OR 
					(ub_user_id={$user_id_2} and ub_user_id_from={$user_id}) )
					";
			if(! ($user_id == $wgUser->getID() || $user_id_2 == $wgUser->getID()) ){
				$user_sql .= " and ub_type = 0 ";
			}
		}else{
			$user_sql = "ub_user_name = '{$user_name}'";
			if($user_id != $wgUser->getID() ){
				$user_sql .= " and ub_type = 0 ";
			}
			if( $wgUser->isLoggedIn() ) {
				$user_sql .= " or (ub_user_name='{$user_name}' and ub_user_id_from={$wgUser->getID() }) ";
			}
		}
		
		$sql = "SELECT ub_id, ub_user_id_from, ub_user_name_from, ub_user_id, ub_user_name,
			ub_message,UNIX_TIMESTAMP(ub_date) as unix_time,ub_type
			FROM user_board   
			WHERE {$user_sql}
			ORDER BY ub_id DESC
			{$limit_sql}";
		
		$res = $dbr->query($sql);
		$messages = array();
		while ($row = $dbr->fetchObject( $res ) ) {
			$message_text = $wgParser->parse( $row->ub_message, $wgTitle, $wgOut->parserOptions(),true );
			$message_text = $message_text->getText();
		
			 $messages[] = array(
				 "id"=>$row->ub_id,"timestamp"=>($row->unix_time ) ,
				 "user_id_from"=>$row->ub_user_id_from,"user_name_from"=>$row->ub_user_name_from,
				 "user_id"=>$row->ub_user_id,"user_name"=>$row->ub_user_name,
				 "message_text"=>$message_text,"type"=>$row->ub_type
			
				 );
		}
		return $messages;
	}
	
	public function getUserBoardToBoardCount($user_id,$user_id_2){
		global $wgOut, $wgUser, $wgTitle;
		$dbr =& wfGetDB( DB_MASTER );
		
		$user_sql = " ( (ub_user_id={$user_id} and ub_user_id_from={$user_id_2}) OR 
					(ub_user_id={$user_id_2} and ub_user_id_from={$user_id}) )
					";
					
		if(! ($user_id == $wgUser->getID() || $user_id_2 == $wgUser->getID()) ){
				$user_sql .= " and ub_type = 0 ";
		}
		$sql = "SELECT count(*) as the_count
			FROM user_board   
			WHERE {$user_sql}
			";

		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );
		if($row){
			$count = $row->the_count;
		}
		return $count;
	}
	
	public function displayMessages($user_id,$user_id_2=0,$count=10,$page=0){
		global $wgUser,$max_link_text_length, $wgTitle;
		$messages = $this->getUserBoardMessages($user_id,$user_id_2,$count,$page);
		
		if ($messages) {
			
			foreach ($messages as $message) {
				$user =  Title::makeTitle( NS_USER  , $message["user_name_from"]  );
				$avatar = new wAvatar($message["user_id_from"],"m");
				
				$board_to_board ="";
				$board_link="";
				$message_type_label = "";
				$delete_link = "";
				if($wgUser->getName()!=$message["user_name_from"]){
					$board_to_board = "<a href=\"" . UserBoard::getUserBoardToBoardURL($message["user_name"],$message["user_name_from"])."\">Board-to-Board</a>";
					$board_link = "<a href=\"" . UserBoard::getUserBoardURL($message["user_name_from"])."\">Send {$message["user_name_from"]} A Message</a>";
				}
				if($wgUser->getName()==$message["user_name"]){
					$delete_link = "<span class=\"user-board-red\">
							<a href=\"javascript:void(0);\" onclick=\"javascript:delete_message({$message["id"]})\">delete</a>
						</span>";
				}
				if($message["type"] == 1){
					$message_type_label = "(private)";
				}
				
				$max_link_text_length = 50;
				$message_text = preg_replace_callback( "/(<a[^>]*>)(.*?)(<\/a>)/i",'cut_link_text',$message["message_text"]);
		
				$output .= "<div class=\"user-board-message\" >
					<div class=\"user-board-message-from\">
					<a href=\"{$user->escapeFullURL()}\" title=\"{$message["user_name_from"]}\">{$message["user_name_from"]}</a> {$message_type_label} 
					</div>	
					<div class=\"user-board-message-time\">
						posted " . get_time_ago($message["timestamp"]) . " ago
					</div>
					<div class=\"user-board-message-content\">
						<div class=\"user-board-message-image\">
							<a href=\"{$user->escapeFullURL()}\" title=\"{$message["user_name_from"]}\">{$avatar->getAvatarURL()}</a>
						</div>
						<div class=\"user-board-message-body\" >
							{$message_text}
						</div>
						<div class=\"cleared\"></div>
					</div>
					<div class=\"user-board-message-links\">
						{$board_link}
						{$board_to_board}
						{$delete_link}
					</div>
				</div>";
			}
		} else if ($wgUser->getName()==$wgTitle->getText()) {
			$output .= "<div class=\"no-info-container\">
				No board messages.
			</div>";
		
		}
		return $output;
	}
	
	static function getBoardBlastURL( ){
		$title = Title::makeTitle( NS_SPECIAL , "SendBoardBlast"  );
		return $title->escapeFullURL();
	}	
	
	static function getUserBoardURL($user_name){
		$title = Title::makeTitle( NS_SPECIAL , "UserBoard"  );
		$user_name = str_replace("&","%26",$user_name);
		return $title->escapeFullURL('user='.$user_name);
	}
	
	static function getUserBoardToBoardURL($user_name_1,$user_name_2){
		$title = Title::makeTitle( NS_SPECIAL , "UserBoard"  );
		$user_name_1 = str_replace("&","%26",$user_name_1);
		$user_name_2 = str_replace("&","%26",$user_name_2);
		return $title->escapeFullURL('user='.$user_name_1.'&conv='.$user_name_2);	
	}
	
	public function dateDiff($dt1, $dt2) {
		
		$date1 = $dt1; //(strtotime($dt1) != -1) ? strtotime($dt1) : $dt1;
		$date2 = $dt2; //(strtotime($dt2) != -1) ? strtotime($dt2) : $dt2;
		
		$dtDiff = $date1 - $date2;
	
		$totalDays = intval($dtDiff/(24*60*60));
		$totalSecs = $dtDiff-($totalDays*24*60*60);
		$dif['w'] = intval($totalDays/7);
		$dif['d'] = $totalDays;
		$dif['h'] = $h = intval($totalSecs/(60*60));
		$dif['m'] = $m = intval(($totalSecs-($h*60*60))/60);
		$dif['s'] = $totalSecs-($h*60*60)-($m*60);
		
		return $dif;
	}

	public function getTimeOffset($time,$timeabrv,$timename){
		if($time[$timeabrv]>0){
			$timeStr = $time[$timeabrv] . " " . $timename;
			if($time[$timeabrv]>1)$timeStr .= "s";
		}
		if($timeStr)$timeStr .= " ";
		return $timeStr;
	}
	
	public function getTimeAgo($time){
		$timeArray =  $this-> dateDiff(time(),$time  );
		$timeStr = "";
		$timeStrD = $this->getTimeOffset($timeArray,"d","day");
		$timeStrH = $this->getTimeOffset($timeArray,"h","hour");
		$timeStrM = $this->getTimeOffset($timeArray,"m","minute");
		$timeStrS = $this->getTimeOffset($timeArray,"s","second");
		$timeStr = $timeStrD;
		if($timeStr<2){
			$timeStr.=$timeStrH;
			$timeStr.=$timeStrM;
			if(!$timeStr)$timeStr.=$timeStrS;
		}
		return $timeStr;
	}
	
	
	
}
	
?>
