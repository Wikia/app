<?php

$wgExtensionFunctions[] = 'wfSpecialUserHome';
$wgSpecialPageGroups['UserActivity'] = 'users';

function wfSpecialUserHome(){
	global $wgUser,$IP;
	include_once("includes/SpecialPage.php");


	class UserHome extends SpecialPage {
	
		function UserHome(){
			SpecialPage::SpecialPage("UserActivity");
		}
		
		function execute(){
			
			global $wgUser, $wgOut, $wgRequest, $IP, $wgSitename, $wgStyleVersion, $wgMessageCache, $wgUploadPath;
		
			require_once ( "$IP/extensions/wikia/UserHome/UserActivity.i18n.php" );
			foreach( efWikiaUserActivity() as $lang => $messages ){
				$wgMessageCache->addMessages( $messages, $lang );
			}
		
			$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"/extensions/wikia/UserHome/UserActivity.css?{$wgStyleVersion}\"/>\n");
		
			$wgOut->setPagetitle( wfMsg("useractivity_title") );
			
			require_once("$IP/extensions/wikia/UserActivity/UserActivityClass.php");
		 
			$this_title = Title::makeTitle( NS_SPECIAL, "UserActivity");
			
			$output = "";
		
			$rel_type = $wgRequest->getVal('rel_type');
			$item_type = $wgRequest->getVal('item_type');
			
	
			if(!$rel_type)$rel_type=1;
			if(!$item_type)$item_type="all";
			
			if( $item_type=="edits" || $item_type=="all" )$edits=1;
			if( $item_type=="votes" || $item_type=="all" )$votes=0;
			if( $item_type=="comments" || $item_type=="all" )$comments=1;
			if( $item_type=="gifts" || $item_type=="all" )$gifts=1;
			if( $item_type=="relationships" || $item_type=="all" )$relationships=1;
			if( $item_type=="advancements" || $item_type=="all" )$messages=1;
			if( $item_type=="awards" || $item_type=="all" )$system_gifts=1;
			if( $item_type=="messages" || $item_type=="all" )$messages_sent=1;
			if( $item_type=="thoughts" || $item_type=="all" )$network_updates=1;
			
			/*
			$output .= "<div class=\"user-home-links-container\">
			<h2>" . wfMsg("useractivity_filter") . "</h2>
			<div class=\"user-home-links\">";
			
			$lines = explode( "\n", wfMsgForContent( 'friendsactivity_filter' ) );
			foreach ($lines as $line) {
				
				if (strpos($line, '*') !== 0){
					continue;
				}else{
					$line = explode( '|' , trim($line, '* '), 3 );
					$filter = $line[0];
					$link_text = $line[1];
					$link_image = $line[2];
					$output .= "<a href=\"" . $this_title->escapeFullURL("item_type={$filter}") . "\"><img src=\"{$wgUploadPath}/common/" . UserActivity::getTypeIcon($link_image) . "\"/>{$link_text}</a>";

				}
			}
			  
				$output .= "<a href=\"".$this_title->escapeFullURL()."\">" . wfMsg("useractivity_all") . "</a>
				</div>
			 </div>
			*/ 
			
			$output .= "<div class=\"user-home-feed\">";
	
			$rel = new UserActivity($wgUser->getName(),(($rel_type==1)?"friends":"foes"),50);
			$rel->setActivityToggle("show_edits",$edits);
			$rel->setActivityToggle("show_votes",$votes);
			$rel->setActivityToggle("show_comments",$comments);
			$rel->setActivityToggle("show_gifts_rec",$gifts);
			$rel->setActivityToggle("show_relationships",$relationships);
			$rel->setActivityToggle("show_system_messages",$messages);
			$rel->setActivityToggle("show_system_gifts",$system_gifts);
			$rel->setActivityToggle("show_messages_sent",$messages_sent);
			
			if($wgSitename=="ArmchairGM"){
				$rel->setActivityToggle("show_network_updates",$network_updates);
			}
			
			/*
			Get all relationship activity
			*/
			$activity = $rel->getActivityListGrouped();
		 
			if($activity){
				$x = 1;
				
				foreach ($activity as $item) {
					
					if ($x<40) {
						
						if (((count($activity)>40)&&($x==39))||((count($activity)<40)&&($x==(count($activity)-1)))) {
							$border_fix="border-fix";
						}
						
						$output .= "<div class=\"user-home-activity {$border_fix}\">
							<img src=\"{$wgUploadPath}/common/".UserActivity::getTypeIcon($item["type"])."\" alt=\"\" border=\"0\" />
							{$item["data"]}
						</div>";
						$x++;
					}
				}
			}
			
			$output .= "</div>
			<div class=\"cleared\"></div>
			";
			$wgOut->addHTML($output);
			
		}

	}

	SpecialPage::addPage( new UserHome );
	global $wgMessageCache,$wgOut;
	$wgMessageCache->addMessage( 'useractivity', 'Friend\'s Activity' );
}

?>
