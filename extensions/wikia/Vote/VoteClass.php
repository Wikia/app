<?php

class Vote{
    var $PageID = 0;
    var $Userid = 0;
    var $Username = NULL;

    
    function Vote($pageid){
	global $wgUser;
	
        $this->PageID = $pageid;
	$this->Username = $wgUser->getName();
        $this->Userid =  $wgUser->getID();
    }
    
    function setUser($user_name,$user_id){
        
    }
    
    function count(){
	global $wgMemc;
	$key = wfMemcKey( 'vote', 'count', $this->PageID );
	$data = $wgMemc->get( $key );
	
	//try cache
	if($data){
		wfDebug( "loading vote count for page {$this->PageID} from cache\n" );
		$vote_count = $data;
	}else{
		$dbr =& wfGetDB( DB_MASTER );
		$vote_count = 0;
		$sql = "SELECT count(*) as VoteCount FROM Vote WHERE vote_page_id = " . $this->PageID;
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );
		if($row){
		   $vote_count= $row->VoteCount;
		}
		$wgMemc->set( $key, $vote_count );
	}
        return $vote_count;
    }
    
    function getAverageVote(){
	global $wgMemc;
	$key = wfMemcKey( 'vote', 'avg', $this->PageID );
	$data = $wgMemc->get( $key );
	
	$VoteAvg = 0;
	if($data){
		wfDebug( "loading vote avg for page {$this->PageID} from cache\n" );
		$VoteAvg = $data;
	}else{
		$dbr =& wfGetDB( DB_MASTER );
		
		$sql = "SELECT AVG(vote_value) as VoteAvg FROM Vote WHERE vote_page_id = " . $this->PageID;
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );
		if($row){
		    $VoteAvg = $row->VoteAvg;
		}
		$wgMemc->set( $key, $VoteAvg );
	}
        return number_format($VoteAvg,2);
    }
    
    function clearCache(){
	global $wgUser, $wgMemc;
	
	//kill internal cache
	$wgMemc->delete( wfMemcKey(  'vote', 'count', $this->PageID ) );
	$wgMemc->delete( wfMemcKey(  'vote', 'avg', $this->PageID ) );
	
	//purge squid
	$page_title = Title::newFromID( $this->PageID);
	if( is_object( $page_title ) ){
		$page_title->invalidateCache();
		$page_title->purgeSquid();
	
		//kill parser cache
		$article = new Article( $page_title );
		$parserCache =& ParserCache::singleton();
		$parser_key = $parserCache->getKey( $article, $wgUser);
		$wgMemc->delete( $parser_key );
	}
    }
    
    function delete(){
	global $wgMemc, $IP;
	
        $dbr =& wfGetDB( DB_MASTER );
        $sql = "DELETE FROM `Vote` WHERE vote_page_id = ". $this->PageID . " AND username = '". $this->Username . "'";
        $res = $dbr->query($sql);
       
	$this->clearCache();
			
	$stats = new UserStatsTrack($this->Userid, $this->Username);
	$stats->decStatField("vote");
	
	$this->updateStats();
    }
    
	function updateStats(){
		//update stats
		$dbr =& wfGetDB( DB_MASTER );
		$sql = "SELECT * from wikia_page_stats where ps_page_id =  " . $this->PageID;
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );
		if(!$row){
		    $dbr->insert( '`wikia_page_stats`',
			array(
				'ps_page_id' => $this->PageID,
				'vote_count' => $this->count(),
				'vote_avg' => $this->getAverageVote() ,
				'comment_count' => 0
				), __METHOD__
			);
		} else{
		    $dbr->update( 'wikia_page_stats',
			array( 'vote_count'=>$this->count(), 'vote_avg'=>$this->getAverageVote()),
			array( 'ps_page_id' => $this->PageID ),
			__METHOD__ );
		
		}
	
	}
    
	function insert($VoteValue){
		global $wgMemc, $wgUser;
		
		$dbr =& wfGetDB( DB_MASTER );
		if($this->UserAlreadyVoted() == false){
			$dbr->insert( '`Vote`',
			array(
				'username' => $this->Username,
				'vote_user_id' => $this->Userid,
				'vote_page_id' => $this->PageID,
				'vote_value' => $VoteValue,
				'vote_date' => date("Y-m-d H:i:s"),
				'vote_ip' => $_SERVER['REMOTE_ADDR']
				), __METHOD__
			);
			
			
			$this->clearCache();
			
			$stats = new UserStatsTrack($this->Userid, $this->Username);
			$stats->incStatField("vote");
			$this->updateStats();
		}
	}
    
      function UserAlreadyVoted(){
	global $wgUser;

        $dbr =& wfGetDB( DB_MASTER );
	$s = $dbr->selectRow( '`Vote`', 
			array( 'vote_value' ), 
			array( 'vote_page_id'=>$this->PageID, "username" => $this->Username ), $fname );
        if($s === false)
            return false;
        else
            return $s->vote_value;
     }
     
     function display(){
	global $wgUser, $wgReadOnly, $wgAnonRedirect;

        $this->votekey = md5($this->PageID . 'pants' . $this->Username );
	$voted = $this->UserAlreadyVoted();
	
	$make_vote_box_clickable="";
	if($voted==false)$make_vote_box_clickable = "vote-clickable";

         $output = "<div class=\"vote-box {$make_vote_box_clickable}\" id=\"votebox\" onclick=\"clickVote(1,{$this->PageID},'{$this->votekey}')\">";
	 		$output .= "<span id=\"PollVotes\" class=\"vote-number\">{$this->count()}</span>";
		$output .= "</div>";
		$output .= "<div id=\"Answer\" class=\"vote-action\">";
			
			if (!$wgUser->isAllowed('vote')) {
				$login =  Title::makeTitle(NS_SPECIAL,"Login");
				$output .= "<a class=\"votebutton\" href=\"{$login->escapeFullURL()}\" rel=\"nofollow\">".wfMsg('vote_link')."</a>";
			} else {
				if (!$wgReadOnly) {
					if ($voted == false) {
					    $output .= "<a href=\"javascript:clickVote(1,{$this->PageID},'{$this->votekey}')\">".wfMsg('vote_link')."</a>";
					} else {
					    $output .= "<a href=\"javascript:unVote('{$this->PageID}', '{$this->votekey}')\">".wfMsg('vote_unvote_link')."</a>";
					}
				}
			}
        $output .= "</div>";
        
		return $output;
     }
}

Class VoteStars extends Vote {
     
     var $maxRating = 5;
     
     function display($voted=false){
	 global $wgReadOnly, $wgUser;
	 
	 $overall_rating = $this->getAverageVote();
	

	 if($voted){
		 $display_stars_rating = $voted;
	 }else{
		 $display_stars_rating = $this->getAverageVote();
	 }
	 
        $this->votekey = md5($this->PageID . 'pants' . $this->Username );
	 	$id = "";
	 
        $output =  '<div id="rating_' . $id . '" >';
	 		$output .= '<div class="rating-score">';
	 			$output .= '<div class="voteboxrate">' . $overall_rating . '</div>';
			$output .= '</div>';
         	$output .= '<div class="rating-section">'; 
	 			$output .= $this->displayStars( $id,  $display_stars_rating,$voted );
				$count = $this->count();
				if ($count) {
					$output .= " <span class=\"rating-total\">({$count} " .  wfMsgExt( 'vote_votes', 'parsemag', $count) . ")</span>";
				}
				$already_voted = $this->UserAlreadyVoted();
				if($already_voted && $wgUser->isLoggedIn() ){
					//$output .= "<div class=\"rating-voted\">" . wfMsg( 'vote_gave_this') . " {$already_voted}</div>";
					//<a href=\"javascript:unVoteStars({$this->PageID},'{$this->votekey }','{$id}')\">(remove)</a>
				}
				$output .= '</div>
				<div class="rating-clear">';
			$output .= '</div>';
	  
       
	 $output .= '</div>';
	 return $output;
     }
     
      
 
     
	function displayStars($id,$rating,$voted){
		global $wgUploadPath;
		if(!$rating)$rating = 0;
		$this->votekey = md5($this->PageID . 'pants' . $this->Username );
		if(!$voted)$voted = 0;
		$output = "";
		
		for($x=1;$x<=$this->maxRating;$x++){
			if(!$id){
				$action = 3;
			}else{
				$action = 5;
			}
			$output .= "<img onclick=\"javascript:clickVoteStars({$x},{$this->PageID},'{$this->votekey}','{$id}',$action);\" onmouseover=\"javascript:updateRating('{$id}',{$x},{$rating});\" onmouseout=\"javascript:startClearRating('{$id}','{$rating}',{$voted});\" id=\"rating_{$id}_{$x}\" src=\"{$wgUploadPath}/common/star_";
			switch (TRUE) {
				case $rating >= $x:
				    if($voted){
					    $output .= "voted";
				    }else{
					    $output .= "on";
				    }
				break;
				case ($rating > 0 && $rating < $x && $rating > ($x-1) )  :
					$output .= "half";
				break;
				case ($rating < $x ) :
					$output .= "off";
				break;
			}
			
			$output .= ".gif\" alt=\"\" />";
		}
		
		return $output;
	}
	
	function displayScore(){
		$count = $this->count();
		return wfMsg( 'vote_community_score') . ": <b>" . $this->getAverageVote()  . "</b> ({$count} " .  wfMsgExt( 'vote_ratings', 'parsemag', $count) . ")";
	}

}
?>
