<?php
$wgExtensionFunctions[] = 'wfSpecialChallengeView';


function wfSpecialChallengeView(){
	global $wgUser,$IP;
	include_once("includes/SpecialPage.php");


	class ChallengeView extends SpecialPage {
	
		function ChallengeView(){
			SpecialPage::SpecialPage("ChallengeView");
		}
		
		function execute(){
			global $wgUser, $wgOut, $wgRequest;
			purgePage();
			$id = $_GET["id"];
			if($id == ""){
				$wgOut->addHTML("No challenge specified");
			}else{
		 		$this->loadFromDatabase($id);
			}
		}
		
		function loadFromDatabase($id){
			global $wgOut;
			$dbr =& wfGetDB( DB_MASTER );
			$s = $dbr->selectRow( '`challenge`', array( 'challenge_user_id_1','challenge_username1','challenge_user_id_2','challenge_username2','challenge_info','challenge_event_date','challenge_description','challenge_win_terms','challenge_lose_terms','challenge_winner_user_id','challenge_winner_username','challenge_status'),
		
			array( 'challenge_id' => $id ), "" );
	
			if ( $s !== false ) {
				$this->challenge_id = $id;
				$this->challenge_user_id_1 = $s->challenge_user_id_1;
				$this->challenge_user_id_2 = $s->challenge_user_id_2;
				$this->challenge_username1 = $s->challenge_username1;
				$this->challenge_username2 = $s->challenge_username2;
				$this->challenge_info = $s->challenge_info;
				$this->challenge_event_date = $s->challenge_event_date;
				$this->challenge_description = $s->challenge_description;
				$this->challenge_win_terms = $s->challenge_win_terms;
				$this->challenge_lose_terms = $s->challenge_lose_terms;
				$this->challenge_winner_user_id = $s->challenge_winner_user_id;
				$this->challenge_winner_username = $s->challenge_winner_username;
				$this->challenge_status = $s->challenge_status;
				$wgOut->addScript("<script type=\"text/javascript\" src=\"extensions/Challenge/Challenge.js\"></script>\n");
				$wgOut->addHTML($this->displayChallenge());
			}else{
				$wgOut->addHTML("Invalid Challenge ID");
			}
		}
		
		function getRecord($userid){
			$dbr =& wfGetDB( DB_MASTER );
			$s = $dbr->selectRow( '`challenge_user_record`', array( 'challenge_wins', 'challenge_losses','challenge_ties'),
			array( 'challenge_record_user_id' => $userid ), "" );
			if ( $s !== false ) {
				return $s->challenge_wins . "-" . $s->challenge_losses . "-" . $s->challenge_ties;
			}else{
				return "0-0-0";
			}
		}
		
		function displayChallenge(){
			global $wgUser;
			$out = "<br><span class=pagetitle>ArmchairGM Challenge Info</span><br><br>";
			$avatar1 = new wAvatar($this->challenge_username1,"l");
			$avatar2 = new wAvatar($this->challenge_username2,"l");
			$title1 = Title::makeTitle( NS_USER  , $this->challenge_username1  );
			$title2 = Title::makeTitle( NS_USER  , $this->challenge_username2  );
			$out .=  "<table cellpadding=8 bgcolor=#eeeeee cellspacing=0 style='border:1px solid #666666'><tr><td>
			<img src='images/avatars/" . $avatar1->getAvatarImage(). "alt='' border=''>
			</td>";
			$out .= "<td><span class=challenge-user-title><a href=" . $title1->getFullURL() . " class=challenge-user-title>" . $title1->getText() . "</a></span> (" . $this->getRecord($this->challenge_user_id_1) . ")
				<b>vs.</b> ";
				
			$out .=  "</td><td><img src='images/avatars/" . $avatar2->getAvatarImage() . "alt='' border=''></td><td><span class=challenge-user-title>";
			$out .= "<a href=" . $title2->getFullURL() . " class=challenge-user-title>" . $title2->getText() . "</a> </span> (" . $this->getRecord($this->challenge_user_id_2) . ")</td></tr></table><br>";
			$out .= "<table ><tr><td><b>Event:</b> <span class=challenge-event>" . $this->challenge_info . " [" . $this->challenge_event_date . "]</span>";
			$out .= "<br><b>" . $this->challenge_username1 . "'s description: </b><span class=challenge-description>" . $this->challenge_description . "</span></td></tr></table>";
			
			 
			$out .= "</td></tr></table><br><table cellpadding=0 cellspacing=0 ><tr><td valign=top><span class=title>if " . $this->challenge_username1 . " wins, " . $this->challenge_username2 . " has to . . . </span>";
			$out .= "<table cellpadding=0 cellspacing=0 class=challenge-terms width=300><tr><td>" . $this->challenge_win_terms . "</td></tr></table><br>";
			$out .= "</td><td width=20>&nbsp;</td><td valign=top><span class=title>if " . $this->challenge_username2 .  " wins, " . $this->challenge_username1 . " has to . . . </span>";
			$out .= "<table cellpadding=0 cellspacing=0 class=challenge-terms width=300><tr><td>" . $this->challenge_lose_terms . "</td></tr></table>";
			$out .= "</td></tr></table>";
			
			if ( $wgUser->isAllowed('protect') && $this->challenge_user_id_2 != $wgUser->mId && $this->challenge_user_id_1 != $wgUser->mId) {
				$out .= "<a href=javascript:challengeCancel(" . $this->challenge_id . ") style='color:#990000'>Admin Cancel Challenge Due to Abuse</a>";
			}
			$out .= "<hr><span class=challenge-status>
				<span class=title>Challenge Status</span><br><span id=challange-status>
			";
			
			switch ($this->challenge_status) {
			case 0:
			   $out .=  $this->getStatusOpen();
			   break;
			case 1:
				if(1==2){
			    	$out .=  $this->getStatusAccepted();
				}else{
					$out .=  $this->getStatusAwaitingApproval();
				}
			   break;
			case -1:
			  $out .=  $this->getStatusRejected();
			   break;
			 case -2:
			  $out .=  "<span class=challenge-rejected>Removed due to violation of rules</span>";
			   break;
			case 3:
			  $out .=  $this->getStatusCompleted();
			   break;
			}

			$out .= "</span></span><span id=status2></span>";
			return $out;
		}
		
		function getStatusAwaitingApproval(){
			global $wgUser;
			 if ( !$wgUser->isAllowed('protect') || $this->challenge_user_id_1 == $wgUser->mId || $this->challenge_user_id_2 == $wgUser->mId) {
				$out = "<span class=challenge-status-completed>In Progress -- Awaiting Completion of Event and Admin Approval</span>";
			}else{
				$out = "You are an admin, so you can pick the winner if the Event has been completed<br>Who won the bet?<br><br><select id=challenge_winner_userid>
						<option value=" . $this->challenge_user_id_1 . ">" . $this->challenge_username1 . "</option>
						<option value=" . $this->challenge_user_id_2 . ">" . $this->challenge_username2 . "</option>
						<option value=-1>push</option>
						</select>
						<input type=hidden id=status value=" . $this->challenge_status . ">
						<input type=hidden id=challenge_id value=" . $this->challenge_id . ">
						<input type=button value=Submit onclick=javascript:challengeApproval()>";
			}
			return $out;
		}
		
		function getStatusOpen(){
			global $wgUser;
			if($wgUser->mId != $this->challenge_user_id_2){
				$out = "<span class=challenge-status-open>Awaiting Acceptance</span>";
			}else{
				$out = "This challenge has been sent to you.  Please choose your response<br><br><select id=challenge_action>
						<option value=1>Accept</option>
						<option value=-1>Reject</option>
						<soption value=2>Counter Terms</soption>
						</select>
						<input type=hidden id=status value=" . $this->challenge_status . ">
						<input type=hidden id=challenge_id value=" . $this->challenge_id . ">
						<input type=button value=Submit onclick=javascript:challengeResponse()>";
			}
			return $out;
		}
		
		function getStatusCompleted(){
			if($this->challenge_winner_user_id != -1){
				$out .= "Challenge won by <b>" . $this->challenge_winner_username . "</b><br><br>";
				$out .= $this->getChallengeRate();
			}else{
				$out .= "Challenge was a push!<br><br>";
			}
			
			return $out;
		}
		
		function getStatusAccepted(){
			$out = "Accepted";
			return $out;
		}
		
		function getStatusRejected(){
			$out = "<span class=challenge-rejected>Rejected</span>";
			return $out;
		}
		
		function getChallengeRate(){
			global $wgUser;
			$dbr =& wfGetDB( DB_MASTER );
			$s = $dbr->selectRow( '`challenge_rate`', array( 'challenge_rate_date', 'challenge_rate_score','challenge_rate_comment'),
		
			array( 'challenge_id' => $this->challenge_id ), "" );
	
			if ( $s !== false ) {
				 $out .= "<span class=title>Challenge Rating</span><br>";
				 $out .= " by <b>" . $this->challenge_winner_username . "</b> on " . $s->challenge_rate_date;
				 
				 $out .= "<br><br><b>rating</b>:";
				 switch ($s->challenge_rate_score) {
					case 0:
					   $out .=  "neutral";
					   break;
					case 1:
						$out .=  "positive";
					   break;
					case -1:
					  $out .=  "negative";
					   break;
					}
				 $out .= "<br><b>comment</b>:" . $s->challenge_rate_comment;
			}else{
				if( $wgUser->mId == $this->challenge_winner_user_id  ){
					$out = "<span class=challenge-won>You won the challenge!</span><br><br><span class=challenge-form>Please rate the loser's end of the bargain</span><br><select id=challenge_rate>
						<option value=1>Positive</option>
						<option value=-1>Negative</option>
						<option value=0>Neutral</option>
						</select>
						<input type=hidden id=status value=" . $this->challenge_status . ">
						<input type=hidden id=challenge_id value=" . $this->challenge_id . ">";
					if($this->challenge_winner_user_id == $this->challenge_user_id_1){
						$loser_id = $this->challenge_user_id_2;
						$loser_username = $this->challenge_username2;
					}else{
						$loser_id = $this->challenge_user_id_1;
						$loser_username = $this->challenge_username1;
					}
					$out .= "<input type=hidden id=loser_userid value=" . $loser_id. ">
					<input type=hidden id=loser_username value='" . $loser_username. "'>
					<br><br><span class=challenge-form>Additional Comments (ex: He did a lousy job completing the task)</span><br>
						<textarea class='createbox' rows=2 cols=50 id=rate_comment></textarea><br><br>
						<input type=button value=Submit onclick=javascript:challengeRate()>
						";
				}else{
					$out = "This challenge has not yet been rated by the winner";
				}
			}
			return $out;
		}
	}

	SpecialPage::addPage( new ChallengeView );
	global $wgMessageCache,$wgOut;
	$wgMessageCache->addMessage( 'challengeview', 'Challenge View' );
}

?>