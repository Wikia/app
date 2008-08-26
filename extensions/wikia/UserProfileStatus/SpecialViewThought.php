<?php

$wgExtensionFunctions[] = 'wfSpecialViewThought';

function wfSpecialViewThought(){
  global $wgUser,$IP;
  include_once("includes/SpecialPage.php");


class ViewThought extends SpecialPage {

	
	function ViewThought(){
		UnlistedSpecialPage::UnlistedSpecialPage("ViewThought");
	}
	
	function execute(){
		global $wgRequest, $IP, $wgOut, $wgUser;
		
		require_once("$IP/extensions/wikia/UserStatus/UserStatusClass.php");
		
		$messages_show = 25;
		$output = "";
		$us_id = $wgRequest->getVal('id');
		$page =  $wgRequest->getVal('page');

		if(!$us_id  || !is_numeric($us_id ) ){
			$wgOut->addHTML( wfMsgForContent( 'us_invalid_link' ) );
			return false;	
		}
		
		/*/
		/* Config for the page
		/*/			
		$per_page = $messages_show;
		if(!$page)$page=1;
		
 
		
		$s = new UserStatus();
		$message = $s->getStatusMessage($us_id);
		$user_name = $message["user_name"];
		$user =  Title::makeTitle( NS_USER  , $user_name  );
		
		if (!($wgUser->getName() == $user_name)) {
			$wgOut->setPagetitle( wfMsgForContent('us_user_thoughts', "{$user_name}") );
		} else {
			$wgOut->setPagetitle( wfMsgForContent('us_your_thoughts') );
		}
		
		//style
		$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"extensions/wikia/UserStatus/ViewThought.css?{$wgStyleVersion}\"/>\n");
		
		$output .= "<div class=\"view-thought-links\">
			<a href=\"{$user->getFullURL()}\">" . wfMsgForContent('us_user_profile', $user_name) . "</a>
		</div>";
		$output .= "<div class=\"user-status-container\">";
		$output .= "<div class=\"user-status-row\">
	
					<div class=\"user-status-logo\">
					
						<a href=\"" .SportsTeams::getNetworkURL($message["sport_id"],$message["team_id"])  . "\">" .SportsTeams::getLogo($message["sport_id"],$message["team_id"],"m") . "</a> 
					
					</div>
					
					<div class=\"user-status-message\">
					
						{$message["text"]}
					
						<div class=\"user-status-date\">
							".get_time_ago($message["timestamp"])." " . wfMsgForContent( 'us_ago' ) . "
						</div>
						
					</div>
					
					<div class=\"cleared\"></div>
					
		</div>
		</div>";
			 
		$output .= "<div class=\"who-agrees\">";
		$output .= "<h1>" . wfMsgForContent( 'us_who_agrees' ) . "</h1>";
		$voters = $s->getStatusVoters($us_id);
		if($voters){
			foreach ($voters as $voter) {
				$user =  Title::makeTitle( NS_USER  , $voter["user_name"]  );
				$avatar = new wAvatar($voter["user_id"],"m");
		
				$output .= "<div class=\"who-agrees-row\">
					<a href=\"{$user->getFullURL()}\">{$avatar->getAvatarURL()}</a>
					<a href=\"{$user->getFullURL()}\">{$voter["user_name"]}</a>
				</div>";
			}
		}else{
			$output .= "<p>" . wfMsgForContent( 'us_nobody_agrees' ) . "</p>";
		
		}
		$output .= "</div>";
			
	 
		
		$wgOut->addHTML($output);
	
	}
  
}

SpecialPage::addPage( new ViewThought );

}

?>