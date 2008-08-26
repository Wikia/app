<?php

$wgExtensionFunctions[] = 'wfSpecialViewFanBoxes';


function wfSpecialViewFanBoxes(){
	global $wgUser,$IP;
	include_once("includes/SpecialPage.php");


	class ViewFanBoxes extends SpecialPage {
		
		function ViewFanBoxes(){
			SpecialPage::SpecialPage("ViewUserBoxes");
		}
		
		function execute(){
			global $IP, $wgOut, $wgUser, $wgTitle, $wgRequest, $wgContLang, $wgMessageCache, $wgStyleVersion, $wgFanBoxScripts;

			require_once ( "FanBox.i18n.php" );
			foreach( efWikiaFantag() as $lang => $messages ){
				$wgMessageCache->addMessages( $messages, $lang );
			}

			$tagParser = new Parser();
			$wgOut->addScript("<script type=\"text/javascript\" src=\"{$wgFanBoxScripts}/FanBoxes.js\"></script>\n");
			$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"{$wgFanBoxScripts}/FanBoxes.css\"/>\n");

			$wgOut->setPageTitle("Userboxes");
	
			//code for viewing fanboxes for each user			
			$output = "";
			$user_name = $wgRequest->getVal('user');
			$page =  $wgRequest->getVal('page');
		
			 
			// Redirect Non-logged in users to Login Page
		
			if($wgUser->getID() == 0 && $user_name==""){
			$login =  Title::makeTitle(NS_SPECIAL,"UserLogin");
			$wgOut->redirect( $login->escapeFullURL('returnto=Special:ViewUserBoxes'));
			return false;
			}
			
			// If no user is set in the URL, we assume its the current user
			
			if(!$user_name)$user_name = $wgUser->getName();
			$user_id = User::idFromName($user_name);
			$user =  Title::makeTitle( NS_USER  , $user_name  );
			$user_safe = urlencode($user_name);
		
			// Error message for username that does not exist (from URL)
					
			if($user_id == 0){
				$wgOut->setPagetitle('Woops, you took a wrong turn!');
				$wgOut->addHTML('The user you are trying to view does not exist.');
				return false;
			}
	  
		
			// Config for the page
		
			$per_page = 30;
			if(!$page||!is_numeric($page) )$page=1;
			
			
			//Get all FanBoxes for this user into the array 
			//calls the FanBoxesClass file
			$userfan = new UserFanBoxes($user_name);
			$userfanboxes = $userfan->getUserFanboxes(0,$per_page,$page);
			$total = $userfan->getFanBoxCountByUsername($user_name);
			$per_row = 3;


			//page title and top part
			
			$output .= $wgOut->setPagetitle( wfMsg("f-list-title", $userfan->user_name) );
			
			$output .= "<div class=\"back-links\">
				".wfMsg("f-back-link", $user->getFullURL(), $userfan->user_name)."
			</div>
			<div class=\"fanbox-count\">
				".wfMsgExt("f-count", "parsemag", $userfan->user_name, $total)."
			</div>
			
			<div class=\"view-fanboxes-container clearfix\">";
					
			if ($userfanboxes) {
		
				$x = 1;

				foreach($userfanboxes as $userfanbox){
					
					$check_user_fanbox = $userfan->checkIfUserHasFanbox($userfanbox["fantag_id"]);
					
					if( $userfanbox["fantag_image_name"]){
						$fantag_image_width = 45;
						$fantag_image_height = 53;
						$fantag_image = Image::newFromName( $userfanbox["fantag_image_name"] );
						$fantag_image_url = $fantag_image->createThumb($fantag_image_width, $fantag_image_height);
						$fantag_image_tag = '<img alt="" src="' . $fantag_image_url . '"/>';
					};
					
					if ($userfanbox["fantag_left_text"] == ""){
						$fantag_leftside = $fantag_image_tag;
			
					}
					else {
						$fantag_leftside = $userfanbox["fantag_left_text"];
						$fantag_leftside  = $tagParser->parse($fantag_leftside, $wgTitle, $wgOut->parserOptions(), false );
						$fantag_leftside  = $fantag_leftside->getText();
					}

					if ($userfanbox["fantag_left_textsize"] == "mediumfont"){
						$leftfontsize= "14px";
					}
					if ($userfanbox["fantag_left_textsize"] == "bigfont"){
						$leftfontsize= "20px";
					}
					
					if ($userfanbox["fantag_right_textsize"] == "smallfont"){
						$rightfontsize= "12px";
					}
					if ($userfanbox["fantag_right_textsize"] == "mediumfont"){
						$rightfontsize= "14px";
					}
					
					//get permalink
					$fantag_title =  Title::makeTitle( NS_FANTAG  , $userfanbox["fantag_title"]  );
										
					$right_text = $userfanbox["fantag_right_text"];
					$right_text  = $tagParser->parse($right_text, $wgTitle, $wgOut->parserOptions(), false );
					$right_text  = $right_text->getText();
					//output fanboxes
						
					$output .= "<span class=\"top-fanbox\"><div class=\"fanbox-item\">
					<div class=\"individual-fanboxtest\" id=\"individualFanbox".$userfanbox["fantag_id"]."\">
					<div class=\"show-message-container\" id=\"show-message-container".$userfanbox["fantag_id"]."\">
					<div class=\"permalink-container\">
					<a class=\"perma\" style=\"font-size:8px; color:".$userfanbox["fantag_right_textcolor"]."\" href=\"".$fantag_title->escapeFullURL()."\" title=\"{$userfanbox["fantag_title"]}\">perma</a>
					<table  class=\"fanBoxTable\" onclick=\"javascript:openFanBoxPopup('fanboxPopUpBox{$userfanbox["fantag_id"]}', 'individualFanbox{$userfanbox["fantag_id"]}')\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" >
					<tr><td id=\"fanBoxLeftSideOutput\" style=\"color:".$userfanbox["fantag_left_textcolor"]."; font-size:$leftfontsize\" bgcolor=\"".$userfanbox["fantag_left_bgcolor"]."\">".$fantag_leftside."</td> 
					<td id=\"fanBoxRightSideOutput\" style=\"color:".$userfanbox["fantag_right_textcolor"]."; font-size:$rightfontsize\" bgcolor=\"".$userfanbox["fantag_right_bgcolor"]."\">".$right_text."</td>
					</table>
					</div>
					</div>
					</div>
					";
					
					if($wgUser->isLoggedIn()){
						if ($check_user_fanbox == 0){
							$output .= "
						<div class=\"fanbox-pop-up-box\" id=\"fanboxPopUpBox".$userfanbox["fantag_id"]."\">
						<table cellpadding=\"0\" cellspacing=\"0\" width=\"258px\"><tr><td align=\"center\">". wfMsgForContent( 'fanbox_add_fanbox' ) ."<tr><td align=\"center\">
						<input type=\"button\" value=\"Add\" size=\"20\" onclick=\"closeFanboxAdd('fanboxPopUpBox{$userfanbox["fantag_id"]}', 'individualFanbox{$userfanbox["fantag_id"]}'); showAddRemoveMessageUserPage(1, {$userfanbox["fantag_id"]}, 'show-addremove-message')\" />
						<input type=\"button\" value=\"Cancel\" size=\"20\" onclick=\"closeFanboxAdd('fanboxPopUpBox{$userfanbox["fantag_id"]}', 'individualFanbox{$userfanbox["fantag_id"]}')\" />
						</td></table>
						</div>";
						}
						else{
							$output .= "
						<div class=\"fanbox-pop-up-box\" id=\"fanboxPopUpBox".$userfanbox["fantag_id"]."\">
						<table cellpadding=\"0\" cellspacing=\"0\" width=\"258px\"><tr><td align=\"center\">". wfMsgForContent( 'fanbox_remove_fanbox' ) ."<tr><td align=\"center\">
						<input type=\"button\" value=\"Remove\" size=\"20\" onclick=\"closeFanboxAdd('fanboxPopUpBox{$userfanbox["fantag_id"]}', 'individualFanbox{$userfanbox["fantag_id"]}'); showAddRemoveMessageUserPage(2, {$userfanbox["fantag_id"]}, 'show-addremove-message')\" />
						<input type=\"button\" value=\"Cancel\" size=\"20\" onclick=\"closeFanboxAdd('fanboxPopUpBox{$userfanbox["fantag_id"]}', 'individualFanbox{$userfanbox["fantag_id"]}')\" />
						</td></table>
						</div>";
						}
					};
				
					if($wgUser->getID() == 0 ){
						$login =  Title::makeTitle( NS_SPECIAL  , "UserLogin"  );
						$output .= "<div class=\"fanbox-pop-up-box\" id=\"fanboxPopUpBox".$userfanbox["fantag_id"]."\">
						<table cellpadding=\"0\" cellspacing=\"0\" width=\"258px\"><tr><td align=\"center\">". wfMsgForContent( 'fanbox_add_fanbox_login' ) ."<a href=\"{$login->getFullURL()}\">". wfMsgForContent( 'fanbox_login' ) ."</a><tr><td align=\"center\">
						<input type=\"button\" value=\"Cancel\" size=\"20\" onclick=\"closeFanboxAdd('fanboxPopUpBox{$userfanbox["fantag_id"]}', 'individualFanbox{$userfanbox["fantag_id"]}')\" />
						</td></table>
						</div>";
					};
					
	
					$output .= "</div></span>";
					
					if($x==count($userfanboxes) || $x!=1 && $x%$per_row ==0)$output .= "<div class=\"cleared\"></div>";
					$x++;	
				};
			
			}
			

			$output .= "</div>";

			
			//BUILD NEXT/PREV NAV
			$numofpages = $total / $per_page; 
			
			$page_link = Title::makeTitle(NS_SPECIAL,"ViewUserBoxes");
			
			if($numofpages>1) {
				$output .= "<div class=\"page-nav\">";
				if($page>1) { 
					$output .= "<a href=\"".$page_link->escapeFullURL('user='.$user_name.'&page='.($page-1))."\">Prev</a> ";
				}
				
				
				if(($total % $per_page) != 0)$numofpages++;
				if($numofpages >=9 && $page < $total)$numofpages=9+$page;
				if($numofpages >= ($total / $per_page) )$numofpages = ($total / $per_page)+1;
				
				for($i = 1; $i <= $numofpages; $i++){
					if($i == $page) {
					    $output .=($i." ");
					} else {
					    $output .="<a href=\"".$page_link->escapeFullURL('user='.$user_name.'&page='.$i)."\">$i</a> ";
					}
				}
		
				if(($total - ($per_page * $page)) > 0){
					$output .=" <a href=\"".$page_link->escapeFullURL('user='.$user_name.'&page='.($page+1))."\">Next</a>"; 
				}
				$output .= "</div>";
			}
			
			//BUILD NEXT/PREV NAV
			
			$wgOut->addHTML($output);

			$wgOut->addHTML( $this->popUpDiv() );

		}

	function popUpDiv() {
		
	$output .= " <script type='text/javascript'> 
	
	function openFanBoxPopup(popupbox, fanbox) {
			popupbox = document.getElementById(popupbox);
			fanbox = document.getElementById(fanbox);		
			popupbox.style.display = (popupbox.style.display == 'block') ? 'none' : 'block';
			fanbox.style.display = (fanbox.style.display == 'none') ? 'block' : 'none';	
	}
	
		
	function closeFanboxAdd(popupbox, fanbox) {
		popupbox = document.getElementById(popupbox);
		fanbox = document.getElementById(fanbox);		
		popupbox.style.display = 'none';
		fanbox.style.display = 'block';	
		
	}
	
	</script>";
	return $output;
	}
	
	
		
}

	SpecialPage::addPage( new ViewFanBoxes );
	global $wgMessageCache;
	$wgMessageCache->addMessage( 'viewuserboxes', 'View UserBoxes' );
}

?>