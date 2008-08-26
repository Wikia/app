<?php
/**
 *
 */
class UserRelationshipActivity {

	/**
	 * All member variables should be considered private
	 * Please use the accessor functions
	 */

	 /**#@+
	 * @private
	 */
	var $user_id;           	# Text form (spaces not underscores) of the main part
	var $user_name;			# Text form (spaces not underscores) of the main part
	var $items;           	# Text form (spaces not underscores) of the main part
	var $rel_type;
	var $show_edits = 1;
	var $show_votes = 1;
	var $show_comments = 1;
	var $show_relationships = 1;
	var $show_gifts_sent = 1;
	var $show_gifts_rec = 1;
	/**
	 * Constructor
	 * @private
	 */
	/* private */ function __construct($username,$rel_type, $item_max) {
		$title1 = Title::newFromDBkey($username  );
		$this->user_name = $title1->getText();
		$this->user_id = User::idFromName($this->user_name);
		$this->rel_type = $rel_type;
		$this->item_max = $item_max;
	}
	
	
    
	public function setActivityToggle($name,$value){
		$this->$name = $value;    
	}
    
	private function setEdits(){
		$dbr =& wfGetDB( DB_MASTER );
		$sql = "SELECT  UNIX_TIMESTAMP( rc_timestamp) as item_date, rc_title, rc_user, rc_user_text, rc_comment, rc_id,rc_minor, rc_new,rc_namespace,rc_cur_id,rc_this_oldid,rc_last_oldid FROM {$dbr->tableName( 'recentchanges' )}  where rc_user in (select r_user_id_relation from user_relationship where r_user_id={$this->user_id} and r_type={$this->rel_type}) ORDER BY rc_id DESC LIMIT 0," . $this->item_max;
		$res = $dbr->query( $sql );
		while ($row = $dbr->fetchObject( $res ) ) {
			$this->items[] = array("id"=>0,"type"=>"edit","timestamp"=>($row->item_date ) ,"pagetitle"=>$row->rc_title,"namespace"=>$row->rc_namespace,"username"=>$row->rc_user_text, "userid"=>$row->rc_user, "comment"=>$this->fixItemComment($row->rc_comment) , "minor"=>$row->rc_minor, "new"=>$row->rc_new);
		}
	}
	
	private function setVotes(){
		$dbr =& wfGetDB( DB_MASTER );
		$sql = "SELECT  UNIX_TIMESTAMP( vote_date) as item_date, username, page_title, vote_count, comment_count, vote_ip,vote_user_id FROM Vote v, {$dbr->tableName( 'page' )} p, page_stats ps  WHERE v.vote_page_id=p.page_id and p.page_id=ps_page_id  and vote_user_id in (select r_user_id_relation from user_relationship where r_user_id={$this->user_id} and r_type={$this->rel_type}) ORDER BY vote_date DESC LIMIT 0," . $this->item_max;
		$res = $dbr->query($sql);
		while ($row = $dbr->fetchObject( $res ) ) {
			$username = $row->username;
			$this->items[] = array("id"=>0,"type"=>"vote","timestamp"=>$row->item_date ,"pagetitle"=>$row->page_title,"namespace"=>$row->page_namespace,"username"=>$username, "userid"=>$row->vote_user_id, "comment"=>"-","new"=>"0","minor"=>0);
		}
	}
	
	private function setComments(){
		$dbr =& wfGetDB( DB_MASTER );
		$sql = "SELECT  UNIX_TIMESTAMP( comment_date) as item_date, Comment_Username, Comment_IP, page_title, vote_count, comment_count, Comment_Text, Comment_user_id, page_namespace, CommentID FROM Comments c, {$dbr->tableName( 'page' )} p, page_stats ps  WHERE c.comment_page_id=p.page_id and p.page_id=ps_page_id and Comment_user_id in (select r_user_id_relation from user_relationship where r_user_id={$this->user_id} and r_type={$this->rel_type}) ORDER BY comment_date DESC LIMIT 0," . $this->item_max;
		$res = $dbr->query($sql);
		while ($row = $dbr->fetchObject( $res ) ) {

			$username = $row->Comment_Username;
			$this->items[] = array("id"=>$row->CommentID,"type"=>"comment","timestamp"=>$row->item_date ,"pagetitle"=>$row->page_title,"namespace"=>$row->page_namespace,"username"=>$username,"userid"=>$row->Comment_user_id,"comment"=>$this->fixItemComment($row->Comment_Text),"new"=>"0","minor"=>0 );
		}
	}
	
	private function setGiftsSent(){
		$dbr =& wfGetDB( DB_MASTER );
		$sql = "SELECT ug_id, ug_user_id_from, ug_user_name_from, ug_user_id_to, ug_user_name_to, UNIX_TIMESTAMP(ug_timestamp) as item_date,gift_name
			FROM user_gift INNER JOIN gift ON gift_id = ug_gift_id 
			WHERE ug_user_id_to in (select r_user_id_relation from user_relationship where r_user_id={$this->user_id})
			ORDER BY ug_id DESC LIMIT 0,{$this->item_max}
			";
		$res = $dbr->query($sql);
		while ($row = $dbr->fetchObject( $res ) ) {
			$this->items[] = array("id"=>$row->ug_id,"type"=>"gift-sent","timestamp"=>$row->item_date ,"pagetitle"=>"","namespace"=>"","username"=>$row->ug_user_name_from,"userid"=>$row->ug_user_id_from,"comment"=>$row->ug_user_name_to,"new"=>"0","minor"=>0 );
		}
	}
	
	private function setGiftsRec(){
		$dbr =& wfGetDB( DB_MASTER );
		$sql = "SELECT ug_id, ug_user_id_from, ug_user_name_from, ug_user_id_to, ug_user_name_to, UNIX_TIMESTAMP(ug_timestamp) as item_date,gift_name, gift_id
			FROM user_gift INNER JOIN gift ON gift_id = ug_gift_id 
			WHERE ug_user_id_to in (select r_user_id_relation from user_relationship where r_user_id={$this->user_id} and r_type={$this->rel_type})
			ORDER BY ug_id DESC LIMIT 0,{$this->item_max}
			";
		$res = $dbr->query($sql);
		while ($row = $dbr->fetchObject( $res ) ) {
			$this->items[] = array("id"=>$row->ug_id,"type"=>"gift-rec","timestamp"=>$row->item_date ,"pagetitle"=>$row->gift_name,"namespace"=>$row->gift_id,"username"=>$row->ug_user_name_to,"userid"=>$row->ug_user_id_to,"comment"=>$row->ug_user_name_from,"new"=>"0","minor"=>0 );
		}
	}

	private function setRelationships(){
		$dbr =& wfGetDB( DB_MASTER );
		$sql = "SELECT r_id, r_user_id, r_user_name, r_user_id_relation, r_user_name_relation, r_type, UNIX_TIMESTAMP(r_timestamp) as item_date
			FROM user_relationship
			WHERE r_user_id in (select r_user_id_relation from user_relationship where r_user_id={$this->user_id} and r_type={$this->rel_type})
			ORDER BY r_id DESC LIMIT 0,{$this->item_max}
			";
		$res = $dbr->query($sql);
		while ($row = $dbr->fetchObject( $res ) ) {
			if($row->r_type==1){
				$r_type = "friend";
			}else{
				$r_type = "foe";
			}
			$this->items[] = array("id"=>$row->r_id,"type"=>$r_type,"timestamp"=>$row->item_date ,"pagetitle"=>"","namespace"=>"","username"=>$row->r_user_name,"userid"=>$row->r_user_id_to,"comment"=>$row->r_user_name_relation,"new"=>"0","minor"=>0 );
		}
	}
	
	public function getEdits(){
		$this->setEdits();
		return $this->items;
	}
	
	public function getVotes(){
		$this->setVotes();
		return $this->items;
	}
	
	public function getComments(){
		$this->setComments();
		return $this->items;
	}
  
	public function getGiftsSent(){
		$this->setGiftsSent();
		return $this->items;
	}
	
	public function getGiftsRec(){
		$this->setGiftsRec();
		return $this->items;
	}	

	public function getRelationships(){
		$this->setRelationships();
		return $this->items;
	}	
	
	public function getActivityList(){
		if($this->show_edits)$this->setEdits();
		if($this->show_votes)$this->setVotes();
		if($this->show_comments)$this->setComments();
		//if($this->show_gifts_sent)$this->setGiftsSent();
		if($this->show_gifts_rec)$this->setGiftsRec();
		if($this->show_relationships)$this->setRelationships();
		usort($this->items, '_sort_activity');
		return $this->items;
	}
	
	static function getTypeIcon($type){	
		switch ($type) {
			case "edit":
				return "16-em-pencil.png";
			case "vote":
				return "arrow_up.gif";
			case "comment":
				return "comment.gif";
			case "gift-sent":
				return "icon_package.gif";
			case "gift-rec":
				return "icon_package_get.gif";
			case "friend":
				return "icon_user.gif";
			case "foe":
				return "icon_user.gif";
		}
	}
	
	function fixItemComment($comment){
		if(!$comment){
			return "";
		}else{
			$comment = str_replace ("<", "&lt;",$comment);
			$comment = str_replace (">", "&gt;",$comment);
			$comment = str_replace ("&", "%26", $comment );
			$comment = str_replace ("%26quot;","\"",$comment );
		}
		$preview = substr($comment,0,75);
		if($preview != $comment){
			$preview .= "...";
		}
		return stripslashes($preview) ;
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
	
function _sort_activity($x, $y){
	if ( $x["timestamp"] == $y["timestamp"] )
	 return 0;
	else if ( $x["timestamp"] > $y["timestamp"] )
	 return -1;
	else
	 return 1;
}
?>
