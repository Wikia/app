<?php
$wgExtensionFunctions[] = 'wfSpecialChallengeStandings';


function wfSpecialChallengeStandings(){
	global $wgUser,$IP;
	include_once("includes/SpecialPage.php");


	class ChallengeStandings extends SpecialPage {
	
		function ChallengeStandings(){
			SpecialPage::SpecialPage("ChallengeStandings");
		}
		
		function execute(){
			global $wgUser, $wgOut, $wgRequest;
			//$wgOut->addHTML("Coming Soon");
			$out = "";
			$out .= "<br><span class=pagetitle>ArmchairGM Challenge Standings</span><br><br>";
			$out .= "<table cellpadding=3 cellspacing=0 border=0><tr>
			<td class=challenge-standings-title>#</td>
			<td class=challenge-standings-title>user</td>
			<td class=challenge-standings-title>W</td>
			<td class=challenge-standings-title>L</td>
			<td class=challenge-standings-title>T</td>
			<td class=challenge-standings-title>%</td>
			<td class=challenge-standings-title></td>
			</tr>";
			$dbr =& wfGetDB( DB_SLAVE );
			$sql = "SELECT challenge_record_username, challenge_wins, challenge_losses, challenge_ties, (challenge_wins / (challenge_wins + challenge_losses + challenge_ties) ) as winning_percentage FROM challenge_user_record ORDER BY (challenge_wins / (challenge_wins + challenge_losses + challenge_ties) ) DESC, challenge_wins DESC LIMIT 0,25";
			$res = $dbr->query($sql);
			$x = 1;
			 while ($row = $dbr->fetchObject( $res ) ) {
			 	$avatar1 = new wAvatar($row->challenge_record_username,"s");
			 	$out .= "<tr>
							<td class=challenge-standings>" . $x . "</td>
							<td class=challenge-standings><img src='images/avatars/" . $avatar1->getAvatarImage(). "'  align=absmiddle><a href=index.php?title=Special:ChallengeHistory&user=" . $row->challenge_record_username . " style='font-weight:bold;font-size:13px'>" . $row->challenge_record_username . "</a> " . $user1Icon . "</td>
							
							<td class=challenge-standings>" . $row->challenge_wins . "</td>
							<td class=challenge-standings>" . $row->challenge_losses . "</td>
							<td class=challenge-standings>" . $row->challenge_ties . "</td>
							<td class=challenge-standings>" . str_replace(".0",".",number_format($row->winning_percentage,3)) . "</td>";
							if($row->challenge_record_username!=$wgUser->mName){
							$out .= "<td class=challenge-standings><a href=index.php?title=Special:ChallengeUser&user=" . $row->challenge_record_username . " style='color:#666666'>challenge user</a></td>";
							}
				$out .= "</td>
				</tr>";
				$x++;
			 }
			$wgOut->addHTML($out);
		}
	}

	SpecialPage::addPage( new ChallengeStandings );
	global $wgMessageCache,$wgOut;
	$wgMessageCache->addMessage( 'challengestandings', 'Challenge Standings' );
}

?>