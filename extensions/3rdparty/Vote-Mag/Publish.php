<?php
class Publish{

	var $PageID = 0;
	var $VoteCount = 0;
	var $CommentCount = 0;
	var $PublishedType = 1;
	var $VoteFactor = 1;
	var $CommentFactor = .25;
	var $published_category = 0;
	var $UpdateRSS = false;
	
	function getDaysOld(){
		$iDaysOld = 1;
		$dbr =& wfGetDB( DB_MASTER );
		$sql = "select DATEDIFF(FROM_UNIXTIME(UNIX_TIMESTAMP()),FROM_UNIXTIME(UNIX_TIMESTAMP(rev_timestamp))) as DaysOld from {$dbr->tableName( 'revision' )} where rev_page=" . $this->PageID . " order by rev_timestamp asc limit 1 ";
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );
		if($row){
			$iDaysOld = $row->DaysOld;
		}
		if($iDaysOld == 0 || $iDaysOld == -1){
			$iDaysOld = 1;
		}else if($iDaysOld < 3){
			$iDaysOld = $iDaysOld;
		}else if($iDaysOld < 7){
			$iDaysOld = $iDaysOld + 2;
		}else if($iDaysOld >=7){
			$iDaysOld = $iDaysOld + 10;
		}
	
		return $iDaysOld;
	}
	
	
	function publish_page(){
		$dbr =& wfGetDB( DB_MASTER );
		if($this->PageID && $this->PublishedType){
			if($this->PublishedType == 1)$this->incOpinionsPublished();
			$sql = "INSERT INTO `published_page` "
	                                      ."( `published_page_id`, `published_type`,"
	                                      ." `published_date`, `published_category`)\n"
	                                      ."\tVALUES ( ". $this->PageID . ", " . $this->PublishedType . " ,"
	                                      ."  '".date("Y-m-d H:i:s")."',0)";
			$res = $dbr->query($sql);
		}
	}
	
	function incOpinionsPublished(){
		$dbr =& wfGetDB( DB_MASTER );
		$sql = "SELECT cl_to FROM " . $dbr->tableName( 'categorylinks' ) . "  WHERE cl_from=" . $this->PageID;
		$res = $dbr->query($sql);
		while ($row = $dbr->fetchObject( $res ) ) {
			$ctg = Title::makeTitle( 14, $row->cl_to);
			$ctgname = $ctg->getText();
			if( strpos(  strtoupper($ctgname),'OPINIONS BY USER' ) !== false ) {
				$user_name = trim(str_replace("Opinions by User","",$ctgname));
				$u = User::idFromName($user_name);
				if($u){
					$stats = new UserStatsTrack(1,$u, $user_name);
					$stats->incOpinionsPublished();
				}
			}
		}
	}
	
	function unpublish_page(){
		$dbr =& wfGetDB( DB_MASTER );
		if($this->PageID && $this->PublishedType){
			$sql = "DELETE FROM `published_Page` WHERE published_page_id =   " . $this->PageID . "'  AND published_type = ". $this->PublishedType ;
			$res = $dbr->query($sql);
		}
	}
	
	function already_published(){
		$dbr =& wfGetDB( DB_MASTER );
		$sql = "SELECT * FROM `published_page` WHERE published_page_id =   " . $this->PageID . "  AND published_type = ". $this->PublishedType ;
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );
		if(!$row)
			return false;
		else
			return true;
	}
	
	function check_score(){
		$dbr =& wfGetDB( DB_MASTER );
		$sql = "SELECT published_level_id,published_score FROM published_level ";
		$res = $dbr->query($sql);
		while ($row = $dbr->fetchObject( $res ) ) {
			$this->check_level($row->published_level_id,$row->published_score);
		}
		
	}
	
	function check_level($pubtype,$magic){
		$this->PublishedType = $pubtype;
		$page_score = ((($this->VoteCount * $this->VoteFactor) + ($this->CommentCount * $this->CommentFactor)) / $this->getDaysOld());
		//echo $page_score . "--" .  $magic  . " al:" . $this->already_published();
		if( $page_score >= $magic && $this->already_published()==false ){
			$this->publish_page();
			if($this->UpdateRSS == true){
				$rss = new RSS();
				$rss->PageID = $this->PageID;
				$rss->StaticXML = true;
				$rss->published = 1;
				$rss->update_rss_page_categories();
			}
		}else if($this->already_published()==true){
			//$this->unpublish_page();
			/*echo "test rss";
			$rss = new RSS();
				$rss->PageID = $this->PageID;
				$rss->StaticXML = true;
				$rss->published = 1;
				$rss->update_rss_page_categories();
			*/
		}
	}
	


}


?>