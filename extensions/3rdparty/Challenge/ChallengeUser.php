<?php

$wgExtensionFunctions[] = 'wfSpecialChallengeUser';


function wfSpecialChallengeUser(){
	global $wgUser,$IP;
	include_once("includes/SpecialPage.php");


	class ChallengeUser extends SpecialPage {
	
		function ChallengeUser(){
			SpecialPage::SpecialPage("ChallengeUser");
		}
		
		function execute(){
			
			global $wgUser, $wgOut, $wgRequest;
			
			$this->setUser2($_GET["user"]);
			
			if($wgUser->mId == $this->challenge_user_id_2){
				$wgOut->addHTML("You cannot challenge yourself!  Sicko");
			}else{
			if($wgUser->mId == 0){
				$wgOut->addHTML("You must be logged in to issue challenges.");
			}else{
				
		 		if(count($_POST) && $_SESSION["alreadysubmitted"] == false){
					$_SESSION["alreadysubmitted"] = true;
					//$wgOut->setArticleBodyOnly(true);
					$this->setInfo($_POST["info"]);
					$this->setDescription($_POST["description"]);
					$this->setWinTerms($_POST["win"]);
					$this->setLoseTerms($_POST["lose"]);
					$this->setEventDate($_POST["date"]);
					$this->addChallenge( );
					$out = "<br><span class=title>Your Challenge Has Been Sent</span><br><br>";
					$out .= "<a href=index.php?title=Special:ChallengeView&id=" . $this->challenge_id . ">You can view the status of your challenge here</a><br><br>";
					$out .= "<a href=index.php?title=Special:ChallengeHistory&user=" . $wgUser->mName . ">You can view your challenge history here</a><br>";
					
					$wgOut->addHTML($out);
				}else{
					$_SESSION["alreadysubmitted"] = false;
					if($_GET["user"]){
						$wgOut->addScript("<script type=\"text/javascript\" src=\"extensions/Challenge/Challenge.js\"></script>\n");
						$wgOut->addScript("<script type=\"text/javascript\" src=\"extensions/Challenge/ValidateDate.js\"></script>\n");
						$wgOut->addHTML($this->displayForm());
					}else{
						$wgOut->addHTML("No user selected.  Please challenge a user through the correct link.");
					}
				}
				
			}
			}
		}
		
		function setUser2($username){ 
		
			$title1 = Title::newFromDBkey($username  );
			$this->challenge_username2 = $title1->getText();
			$dbr =& wfGetDB( DB_SLAVE );
			$s = $dbr->selectRow( 'user', array( 'user_id' ), array( 'user_name' => $this->challenge_username2 ), $fname );
			if ( $s === false ) {
				$this->challenge_user_id_2 = 0;
			} else {
				$this->challenge_user_id_2 = $s->user_id;
			}
		}
		
		function setInfo($info){ $this->challenge_info = $info;}
		function setDescription($desc){ $this->challenge_description = $desc;}
		function setWinTerms($win){ $this->challenge_win_terms = $win;}
		function setLoseTerms($lose){ $this->challenge_lose_terms = $lose;}
		function setEventDate($date){ $this->challenge_event_date = $date;}
		
		
		function addChallenge() {
			global $wgUser;
			$fname = 'ChallengeUser::addToDatabase';
			$dbw =& wfGetDB( DB_MASTER );
			$dbw->insert( '`challenge`',
				array(
					'challenge_user_id_1' => $wgUser->mId,
					'challenge_username1' => $wgUser->mName,
					'challenge_user_id_2' => $this->challenge_user_id_2,
					'challenge_username2' => $this->challenge_username2,
					'challenge_info' =>  $this->challenge_info ,
					'challenge_description' => $this->challenge_description,
					'challenge_win_terms' => $this->challenge_win_terms,
					'challenge_lose_terms' => $this->challenge_lose_terms,
					'challenge_status' => 0,
					'challenge_date' => date("Y-m-d H:i:s"),
					'challenge_event_date'  => $this->challenge_event_date
				), $fname
			);
			$this->challenge_id = $dbw->insertId();
		}
		
		function addChallengeMessage(){
			$preloadTitle = Title::newFromText( "User_talk:" . $this->challenge_username2 );
			$rev=Revision::newFromTitle($preloadTitle);
		}
		
		function getRate($ratetype,$userid){
			$dbr =& wfGetDB( DB_MASTER );
			$sql = "SELECT COUNT(*) AS total FROM challenge_rate WHERE challenge_rate_user_id = " . $userid . " and challenge_rate_score = " . $ratetype;
			$res = $dbr->query( $sql, $fname );
			$pageRow = $dbr->fetchObject( $res );
			$total = $pageRow->total;
			return $total;
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
		function displayForm(){
			$pos = $this->getRate(1,$this->challenge_user_id_2);
			$neg = $this->getRate(-1,$this->challenge_user_id_2);
			$neu = $this->getRate(0,$this->challenge_user_id_2);
			$total = ($pos + $neg + $neu);
		   $form =  '
		   <br><span class=pagetitle>Challenge User <b>' . $this->challenge_username2 . '</b></span>';
		    $form .= "<br><br><table cellpadding=8 bgcolor=#eeeeee cellspacing=0 style='border:1px solid #666666'><tr><td>record: <b>" . $this->getRecord($this->challenge_user_id_2) . "</b><br>";
		   $form .= "<span class=user-feedback>feedback score: <b>" . $total . "</b> (" . $pos . " positive | " . $neg . " negative | " . $neu . " neutral)<br><a href=index.php?title=Special:ChallengeHistory&user=" . $this->challenge_username2 . " style='font-size:10px'>View Complete Challenge History</a><br></span></td></tr></table>";
		 
		
		   $form .= '<a href="index.php?title=Help:Community_Challenges">Please read rules and stuff</a><br><br>
		   <span class=title>Challenge Info</b></span><br><form action=index.php?title=Special:ChallengeUser&user=' . $_GET["user"] . ' method=post enctype="multipart/form-data" name=form1>
	      <table border="0" cellpadding="3" cellspacing="0" width="500">
		  <tr>
		    <td  class="challenge-form"><span class=req>*</span>the event (ex: Giants vs. Eagles)<br>
			 <input type="text" class="createbox" size="35" name=info id=info value="'. $this->challenge_info . '"/></td>
		  </tr>
		  <tr>
		    <td class="challenge-form"><span class=req>*</span>the event date (mm/dd/yyyy)<br>
			<input type="text" class="createbox" size="10" name=date id=date value="'. $this->challenge_event_date . '"/></td>
		  </tr>
		  <tr>
		    <td class="challenge-form">description (ex: I\'m taking the Eagles w/ the spread (+3))<br>
			<textarea class="createbox" name=description id=description rows=1 cols=50>'. $this->challenge_description . '</textarea></td>
		  </tr>
		  <tr>
		    <td width="200" class="challenge-form"><span class=req>*</span>win terms (ex: My opponent must fill out the 1991 roster page)<br>
			<textarea class="createbox" name=win id=win rows=2 cols=50>'. $this->challenge_win_terms . '</textarea></td>
		  </tr>
		  <tr>
		    <td class="challenge-form"><span class=req>*</span>lose terms (ex: I am willing to edit the 2005 team results page)<br>
			<textarea class="createbox" name=lose id=lose rows=2 cols=50>'. $this->challenge_lose_terms . '</textarea></td>
		  </tr>
		  <tr>
		    <td colspan="2">
			<input type=hidden name=id value=' . $this->challenge_id . '>
			<input type="button" class="createbox" value="submit" size="20" onclick=challengeSend() />
			</td>
		  </tr>
		  </table>
	</form>';
	return $form;
	}
	}

	SpecialPage::addPage( new ChallengeUser );
	global $wgMessageCache,$wgOut;
	$wgMessageCache->addMessage( 'challengeuser', 'Challenge a User' );
}

?>