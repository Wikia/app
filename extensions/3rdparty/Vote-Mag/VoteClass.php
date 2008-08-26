<?php

class Vote{
    var $PageID = 0;
    var $Userid = 0;
    var $Username = NULL;
    var $VoteValue = NULL;
    var $VoteTotal = 0;
    
    function Vote($pageid){
        $this->PageID = $pageid;
    }
    
    function setUser($user_name,$user_id){
        $this->Username =  addslashes ($user_name);
        $this->Userid =  $user_id;
    }
    
    function count(){
        $dbr =& wfGetDB( DB_MASTER );
        $iPollVotes = 0;
        $sql = "SELECT count(*) as VoteCount FROM Vote WHERE vote_page_id = " . $this->PageID;
        $res = $dbr->query($sql);
        $row = $dbr->fetchObject( $res );
        if($row){
            $iPollVotes = $row->VoteCount;
        }
        return $iPollVotes;
    }
    
    function getAverageVote(){
        $dbr =& wfGetDB( DB_SLAVE );
        $VoteAvg = 0;
        $sql = "SELECT AVG(vote_value) as VoteAvg FROM Vote WHERE vote_page_id = " . $this->PageID;
        $res = $dbr->query($sql);
        $row = $dbr->fetchObject( $res );
        if($row){
            $VoteAvg = $row->VoteAvg;
        }
        return number_format($VoteAvg,2);
    }
    
    function delete(){
        $dbr =& wfGetDB( DB_MASTER );
        $sql = "DELETE FROM `Vote` WHERE vote_page_id = ". $this->PageID . " AND username = '". $this->Username . "'";
        $res = $dbr->query($sql);
        $this->updateStats();
    }
    
    function updateStats(){
        //update stats
            $dbr =& wfGetDB( DB_MASTER );
            $sql = "SELECT * from page_stats where ps_page_id =  " . $this->PageID;
            $res = $dbr->query($sql);
            $row = $dbr->fetchObject( $res );
            if(!$row){
                    $sql = "INSERT INTO `page_stats` "
                                       ."( `ps_page_id`, `vote_count`,`vote_avg`,"
                                       ." `comment_count`)\n"
                                       ."\tVALUES ( ". $this->PageID . ", " . $this->count() . " ," . $this->getAverageVote() . ","
                                       ."0)";
            } else{
                 $sql = "update page_stats set vote_count = " . $this->count() . ", vote_avg = " . $this->getAverageVote() . " where ps_page_id = " . $this->PageID;
             }
            $res = $dbr->query($sql);
    }
    
    function insert($VoteValue){
        $dbr =& wfGetDB( DB_MASTER );
         if($this->UserAlreadyVoted() == false){
            $sql = "INSERT INTO `Vote` "
                                        ."( `username`,`vote_user_id` , `vote_page_id`,"
                                        ." `vote_value`, `vote_date`, `vote_ip`)\n"
                                        ."\tVALUES ( '". $this->Username . "', " . $this->Userid . " ," . $this->PageID . " ,"
                                        ." " . $VoteValue . ", '".date("Y-m-d H:i:s")."', '". $_SERVER['REMOTE_ADDR'] ."')";
            $res = $dbr->query($sql);
            $this->updateStats();
         }
    }
    
      function UserAlreadyVoted(){
	      return false;
	      global $wgUser;
        if( in_array('staff',($wgUser->getGroups())) )return false;
        $dbr =& wfGetDB( DB_MASTER );
        $sql = "SELECT vote_value FROM Vote  WHERE vote_page_id = " . $this->PageID . " AND username =  '" . $this->Username . "'";
        $res = $dbr->query($sql);
        $row = $dbr->fetchObject( $res );
        if(!$row)
            return false;
        else
            return $row->vote_value;
     }
     
     function display(){
        $this->votekey = md5($this->PageID . 'pants' . $this->Username );
         $output = '<table border="0" cellspacing="0" cellpadding="0" width="50" >
                            <tr>
                                <td height="50" valign="middle" align="center" class="votebox"><span id="PollVotes">' . $this->count() .'</span></td>
                            </tr>
                        </table>
                        <table border="0" cellpadding="0" cellspacing="0" width="50" >';
                        $output .= '<tr><td align="center" height="25"><span id="Answer">';
                        if($this->UserAlreadyVoted() == false){
                            $output .= '<a class="votebutton" href=\'javascript:clickVote(1,' . $this->PageID . ',"' .  $this->votekey . '")\'>vote</a>';
                        }else{
                            $output .= '<a class="votebutton" href=\'javascript:unVote(' . $this->PageID . ',"' .  $this->votekey . '")\'>unvote</a>';
                        }
                        $output .= '</span></td></tr>';
                        $output .= '</table>';
        return $output;
     }
}


Class VoteStars extends Vote {
     
     var $maxRating = 5;
     
     function display(){
        $this->votekey = md5($this->PageID . 'pants' . $this->Username );
         $output = '<div id="rating">';
		 $output .= '<table border="0" cellspacing="0" cellpadding="0" style="margin-bottom:10px;" width="100%">';
         $output .= '<tr>';
         $output .= '<td align="center">';
         $output .= '<table width="40" height="40" cellpadding="0" cellspacing="0">';
		 $output .= '<tr>';
         $output .= '<td align="center" class="votebox">';
		 $output .= '<span class="rating-avg">' . $this->getAverageVote() . '</span>';
         $output .= '</td>';
         $output .= '</tr>';
         $output .= '</table>';
         $output .= '</td>';
         $output .= '<td width="10"></td>';
         $output .= '<td>'; 
		 $output .= $this->displayRating($this->getAverageVote());
		 $output .= '<br>';
		 $output .= '<span class="rating-total">avg based on ' . $this->count() .' review(s)</span>';
         $output .= '</td>';
         $output .= '</tr>';
         $output .= '</table>';
         $output .= '<table border="0" cellspacing="0" cellpadding="0">';
         $output .= '<tr>';
         $output .= '<td class="rating-title">rate this!</td>';
         $output .= '</tr>';
         $output .= '<tr>';
         $output .= '<td valign="top">';
		 $output .= '<span class="rating-voted">';
         $AlreadyVoted = $this->UserAlreadyVoted();
           if($AlreadyVoted  == false){
             $output .= $this->displayForm();
           } else {
             $output .= "you gave this a " . $AlreadyVoted . ' <a class=votebutton href=javascript:unVoteStars(' . $this->PageID . ',"' . $this->votekey . '")>remove</a>' ;
           }
         $output .= '</span>';
		 $output .= '</td>';
		 $output .= '</tr>';
		 $output .= '</table>';
	     $output .= '</div>';
        
		 return $output;
     }
     
           function UserAlreadyVoted(){
	      global $wgUser;
        //if( in_array('staff',($wgUser->getGroups())) )return false;
        $dbr =& wfGetDB( DB_MASTER );
        $sql = "SELECT vote_value FROM Vote  WHERE vote_page_id = " . $this->PageID . " AND username =  '" . $this->Username . "'";
        $res = $dbr->query($sql);
        $row = $dbr->fetchObject( $res );
        if(!$row)
            return false;
        else
            return $row->vote_value;
     }
     
     function displayForm(){
         $output = '<table  cellpadding="0" cellspacing="0">
                    <tr>
                        <td>';
                        for($x=1;$x<=$this->maxRating;$x++){
                            $output .= '<a href="javascript:;" onclick="javascript:clickVoteStars(' . $x . ',' . $this->PageID . ',\'' . $this->votekey . '\');" onmouseover="javascript:updateRating(' . $x . ');" onmouseout="javascript:startClearRating();"><img src=images/star_off.gif id=rating_' . $x . ' border=0 ></a>';
                        }
                    $output .= '</td></tr>
                </table>';
        return $output;
     }
     
     function displayRating($rating){
         $output = "";
	 //echo "rating:" . $rating;
         for($x=1;$x<=$this->maxRating;$x++){
            //echo "x:" . $x . ";x-1=" . ($x-1) . "; rating=" . $rating . "<br>";
            $output .= "<img src=\"images/star_";
            switch (TRUE) {
            case $rating >= $x:
                $output .= "on";
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
        //exit();
        return $output;
     }

}
?>
