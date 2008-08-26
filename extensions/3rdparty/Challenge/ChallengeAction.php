<?php
$wgExtensionFunctions[] = 'wfSpecialChallengeAction';


function wfSpecialChallengeAction(){
	global $wgUser,$IP;
	include_once("includes/SpecialPage.php");


	class ChallengeAction extends SpecialPage {
	
		function ChallengeAction(){
			SpecialPage::SpecialPage("ChallengeAction");
		}
		
		function setStatus($id, $status){
				$dbw =& wfGetDB( DB_MASTER );
				$dbw->update( '`challenge`',array( /* SET */'challenge_status' => $status ), array( /* WHERE */'challenge_id' => $id ), "");
				if($status==1)$dbw->update( '`challenge`',array( /* SET */'challenge_accept_date' => date("Y-m-d H:i:s") ), array( /* WHERE */'challenge_id' => $id ), "");
				if($status==3)$dbw->update( '`challenge`',array( /* SET */'challenge_complete_date' => date("Y-m-d H:i:s") ), array( /* WHERE */'challenge_id' => $id ), "");
		}
		
		function updateUserStandings($id){
			$dbr =& wfGetDB( DB_MASTER );
			$s = $dbr->selectRow( '`challenge`', array( 'challenge_user_id_1','challenge_username1','challenge_user_id_2','challenge_username2','challenge_info','challenge_event_date','challenge_description','challenge_win_terms','challenge_lose_terms','challenge_winner_user_id','challenge_winner_username','challenge_status'),
		
			array( 'challenge_id' => $id ), "" );
	
			if ( $s !== false ) {
				if( $s->challenge_winner_user_id != -1){ // if its not a tie
					if( $s->challenge_user_id_1 == $s->challenge_winner_user_id){
						$winner_id = $s->challenge_user_id_1;
						$loser_id = $s->challenge_user_id_2;
					}else{
						$winner_id = $s->challenge_user_id_2;
						$loser_id = $s->challenge_user_id_1;
					}
					$this->updateUser($winner_id,1);
					$this->updateUser($loser_id,-1);
				}else{
					$this->updateUser($s->challenge_user_id_1,0);
					$this->updateUser($s->challenge_user_id_2,0);
				} 	
			} 
		}
		
		function updateUser($id,$type){
			$dbr =& wfGetDB( DB_SLAVE );
			$s = $dbr->selectRow( 'user', array( 'user_name' ), array( 'user_id' => $id ), $fname );
			if ( $s === false ) {
				$username = "";
			} else {
				$username = $s->user_name;
			}
			$wins = 0;
			$losses = 0;
			$ties = 0;
			$sql = "SELECT challenge_wins, challenge_losses,challenge_ties FROM challenge_user_record  WHERE challenge_record_user_id =  " .  $id . " LIMIT 0,1";
			//echo $sql . "<BR>";
			$res = $dbr->query($sql);
			$row = $dbr->fetchObject( $res );
			if(!$row){
				switch ($type) {
					case -1:
					   $losses = 1;
					   break;
					case 0:
					  $ties = 1;
					   break;
					 case 1:
					  $wins = 1;
					   break;
				}
				$sql2 =  "INSERT INTO challenge_user_record (challenge_record_user_id,challenge_record_username,challenge_wins,challenge_losses,challenge_ties)
						VALUES (" . $id . ", '" .  addslashes($username) . "'," . $wins . "," . $losses . "," . $ties . ")";
			}else{
					
				   $wins =  $row->challenge_wins;
					$losses =  $row->challenge_losses;
					$ties =  $row->challenge_ties;
					switch ($type) {
					case -1:
					   $losses++;
					   break;
					case 0:
					  $ties++;
					   break;
					 case 1:
					  $wins++;
					   break;
					}
					$sql2 = "UPDATE `challenge_user_record` SET challenge_wins = " . $wins . ", challenge_losses=" . $losses . ",challenge_ties=" . $ties . " WHERE challenge_record_user_id = " . $id;
			}
			//echo $sql2 . "<BR>";
			$res2 = $dbr->query($sql2);
		}
		
		function execute(){
			global $wgUser, $wgOut, $wgRequest;
			
			switch ($_GET["action"]) {
			case 1:
			    $this->setStatus($_POST["id"], $_POST["status"]);
			   break;
			case 2:
			   if ( $wgUser->isAllowed('protect') ) {
			   $this->setStatus($_POST["id"], 3);
			   $dbr =& wfGetDB( DB_MASTER );
				$s = $dbr->selectRow( 'user', array( 'user_name' ), array( 'user_id' => $_POST["userid"] ), $fname );
				if ( $s === false ) {
					$username = "";
				} else {
					$username = $s->user_name;
				}
				$dbr->update( '`challenge`',
				array( /* SET */
					'challenge_winner_user_id' => $_POST["userid"],  'challenge_winner_username' => $username ), array( /* WHERE */
					'challenge_id' => $_POST["id"] ), ""
				);
				
				//update records
				$this->updateUserStandings( $_POST["id"]);
				
				}
			   break;
				case 3:
					$fname = 'ChallengeRate::addToDatabase';
					$dbw =& wfGetDB( DB_MASTER );
					$dbw->insert( '`challenge_rate`',
						array(
							'challenge_id' => $_POST["id"],
							'challenge_rate_submitter_user_id' => $wgUser->mId,
							'challenge_rate_submitter_username' => $wgUser->mName,
							'challenge_rate_user_id' => $_POST["loser_userid"],
							'challenge_rate_username' => $_POST["loser_username"],
							'challenge_rate_date' =>  date("Y-m-d H:i:s"),
							'challenge_rate_score' =>  $_POST["challenge_rate"],
							'challenge_rate_comment' =>  $_POST["rate_comment"]
						), $fname
					);
			   break;
			}
			$wgOut->setArticleBodyOnly(true);
		}
	}

	SpecialPage::addPage( new ChallengeAction );
	global $wgMessageCache,$wgOut;
	$wgMessageCache->addMessage( 'challengeaction', 'Challenge Standings' );
}

?>