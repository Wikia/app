<?php
$wgExtensionFunctions[] = 'wfSpecialChallengeHistory';


function wfSpecialChallengeHistory(){
	global $wgUser,$IP;
	include_once("includes/SpecialPage.php");


	class ChallengeHistory extends SpecialPage {
	
		function ChallengeHistory(){
			SpecialPage::SpecialPage("ChallengeHistory");
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
		
		function getRate($ratetype,$userid){
			$dbr =& wfGetDB( DB_MASTER );
			$sql = "SELECT COUNT(*) AS total FROM challenge_rate WHERE challenge_rate_user_id = " . $userid . " and challenge_rate_score = " . $ratetype;
			$res = $dbr->query( $sql, $fname );
			$pageRow = $dbr->fetchObject( $res );
			$total = $pageRow->total;
			return $total;
		}
		
		function execute(){
			global $wgUser, $wgOut, $wgRequest;
			$out = "";
			$dbr =& wfGetDB( DB_SLAVE );
			$sql = " SELECT challenge.challenge_id, challenge_username1, challenge_username2, challenge_info, challenge_description, challenge_event_date, challenge_status, challenge_winner_username,challenge_winner_user_id,
			challenge_rate_score, challenge_rate_comment
			FROM challenge LEFT JOIN challenge_rate ON challenge_rate.challenge_id=challenge.challenge_id WHERE 1=1 ";
			if($_GET["user"]){
				$title1 = Title::newFromDBkey($_GET["user"] );
				$dbr =& wfGetDB( DB_SLAVE );
				$s = $dbr->selectRow( 'user', array( 'user_id' ), array( 'user_name' => $title1->getText() ), $fname );
				if ( $s === false ) {
					$userid = 0;
				} else {
					$userid = $s->user_id;
					$avatar = new wAvatar($title1->getText(),"l");
					$pos = $this->getRate(1,$userid);
					$neg = $this->getRate(-1,$userid);
					$neu = $this->getRate(0,$userid);
					$total = ($pos + $neg + $neu);
					$percent = 0;
					if($pos)$percent = $pos / $total * 100;
					$out .=  "<br><table cellpadding=3 cellspacing=0><tr><td>
					<img src='images/avatars/" . $avatar->getAvatarImage(). "'>
					</td>";
					$out .= "<td><span class=pagetitle>" . $title1->getText() . " Challenge History</span></td></tr></table>";
					
					$out .= "<b>Overall Record</b>: (" . $this->getRecord($userid) . ")<br><br>";
					$out .= "<b>Ratings When Loser</b>: <br>";
					$out .= "<span class=challenge-rate-positive>Positive</span>: " . $pos . " (" . $percent . "%)<br>";
					$out .= "<span class=challenge-rate-negative>Negative</span>: " . $neg . "<br>";
					$out .= "<span class=challenge-rate-neutral>Neutral</span>: " . $neu . "<br><br>";
					
				}
				$sql  .= " and (challenge_user_id_1 = " . $userid . " OR challenge_user_id_2 = " . $userid . ") ";
			}else{
				$sql  .= " and challenge_status <> -2 ";
				$out .= "<br><span class=pagetitle>Recent ArmchairGM Challenges</span><br><br>";
			}
			if(isset($_GET["status"])){
				$sql  .= " and challenge_status = " . $_GET["status"];
			}
			$sql .= " order by challenge_date DESC limit 0,50";
			if($title1){
			if($title1->getText()&& $title1->getText() != $wgUser->mName)$out .= '<input type="button" class="createbox" value="Challenge This User"  style="color:#78BA5D;padding-right:3px;" onclick=window.location="index.php?title=Special:ChallengeUser&user=' . $_GET["user"] . '" />  &nbsp;';
			}
			$out .= "filter:
			<select style='font-size:10px' name=status-filter onChange=changeFilter('" . $_GET["user"] . "',this.value)>
			<option value='' " . ($_GET["status"] == "" && strlen($_GET["status"]) == 0 ? "selected":"") . ">All</option>
			<option value=0 " . ($_GET["status"] == 0 && strlen($_GET["status"]) == 1 ? "selected":"") . ">Awaiting Acceptance</option>
			<option value=1 " . ($_GET["status"] == 1 ? "selected":"") . ">In progress</option>
			<option value=-1 " . ($_GET["status"] == -1 ? "selected":"") . ">Rejected</option>
			<option value=3 " . ($_GET["status"] == 3 ? "selected":"") . ">Completed</option>
			</select><br><br>
			
			<table cellpadding=3 cellspacing=0 border=0><tr>
			<td class=challenge-history-title>event</td>
			<td class=challenge-history-title>challenger description</td>
			<td class=challenge-history-title>challenger</td>
			<td class=challenge-history-title>target</td>
			<td class=challenge-history-title>status</td>
			
			<td class=challenge-history-title>loser's rating</td>
			</tr>";
			$res = $dbr->query($sql);
			 while ($row = $dbr->fetchObject( $res ) ) {
			 	$avatar1 = new wAvatar($row->challenge_username1,"s");
				$avatar2 = new wAvatar($row->challenge_username2,"s");
				$title1 = Title::makeTitle( NS_USER  , $row->challenge_username1  );
				$title2 = Title::makeTitle( NS_USER  , $row->challenge_username2  );
				$user1Info = "";
				$user2Info = "";
				$user1Icon = "";
				$user2Icon = "";
				if($row->challenge_winner_user_id!=0){
				if($row->challenge_username1 == $row->challenge_winner_username){
					$user1Info = " style='font-weight:800'";
					$user1Icon = "<img src=http://www.development.wikiscripts.org/images/winner-check.gif align=absmiddle>";
				}else{
					$user2Info = " style='font-weight:800'";
					$user2Icon = "<img src=http://www.development.wikiscripts.org/images/winner-check.gif align=absmiddle>";
				}
				}
				
			 	$out .= "<tr>
							<td class=challenge-data><a href=index.php?title=Special:ChallengeView&id=" . $row->challenge_id . ">" . $row->challenge_info . " [" . $row->challenge_event_date . "]</a></td>
							<td class=challenge-data width=200>" . $row->challenge_description . "</td>
							<td class=challenge-data " . $user1Info . "><img src='images/avatars/" . $avatar1->getAvatarImage(). "'  align=absmiddle><a href=index.php?title=Special:ChallengeHistory&user=" . $title1->getDbKey() . ">" . $row->challenge_username1 . "</a> " . $user1Icon . "</td>
							<td class=challenge-data " . $user2Info . "><img src='images/avatars/" . $avatar2->getAvatarImage(). "'  align=absmiddle><a href=index.php?title=Special:ChallengeHistory&user=" . $title2->getDbKey() . ">" .  $row->challenge_username2 . "</a> " . $user2Icon . "</td>
							<td class=challenge-data>";
							
						switch ($row->challenge_status) {
						case -1:
						   $out .=  "<span class=challenge-rejected>rejected</span>";
						   break;
						case -2:
						   $out .=  "<span class=challenge-rejected>removed</span>";
						   break;
						case 0:
						   $out .=  "awaiting acceptance";
						   break;
						case 1:
							if(1==2){
						    	$out .=  "accepted";
							}else{
								$out .=  "in progress";
							}
						   break;
						case 3:
						  $out .=  "<span style='font-weight:800' class=challenge-status-complete>completed</span>";
						   break;
						}
							
	
							$out .= "</td><td class=challenge-data>";
							if($row->challenge_rate_score == NULL){
								$out .= "-";
							}else{
							switch ($row->challenge_rate_score) {
								case 0:
								   $out .=  "<span class=challenge-rate-neutral>neutral</span>";
								   break;
								case 1:
								 	$out .=  "<span class=challenge-rate-positive>positive</span>";
								   break;
								case -1:
								  $out .=  "<span class=challenge-rate-negative>negative</span>";
								   break;
								 
							}}

							$out .= "</td>
						</tr>";
			 }
			 $out.= "</table>";
			 $wgOut->addScript("<script type=\"text/javascript\" src=\"extensions/Challenge/Challenge.js\"></script>\n");
			$wgOut->addHTML($out);
		}
	}

	SpecialPage::addPage( new ChallengeHistory );
	global $wgMessageCache,$wgOut;
	$wgMessageCache->addMessage( 'challengehistory', 'Challenge History' );
}

?>