<?php
$wgExtensionFunctions[] = "wfUserBoxesHook";

function wfUserBoxesHook() {
    global $wgParser, $wgOut;
    $wgParser->setHook( "userboxes", "UserBoxesHook" );
}

function UserBoxesHook( $input, $args, &$parser ){	
		global $wgOut, $IP, $wgParser, $wgUser, $wgTitle, $wgMemc, $wgMessageCache, $wgFanBoxScripts, $wgFanBoxDirectory, $wgUploadPath;
		global $wgStyleVersion;

		$parser->disableCache();

		$wgFanBoxDirectory = "$IP/extensions/wikia/FanBoxes";
		
		require_once("{$wgFanBoxDirectory}/FanBoxesClass.php");
		$wgOut->addScript("<script type=\"text/javascript\" src=\"{$wgFanBoxScripts}/FanBoxes.js?{$wgStyleVersion}\"></script>\n");
		$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"{$wgFanBoxScripts}/FanBoxes.css?{$wgStyleVersion}\"/>\n");
		
		require_once ( "{$wgFanBoxDirectory}/FanBox.i18n.php" );
			foreach( efWikiaFantag() as $lang => $messages ){
				$wgMessageCache->addMessages( $messages, $lang );
			}
		
		
		$user_name = "Roblefko";

		$limit = $args["limit"];
		if(!$limit)$limit = 10;

		$f = new UserFanBoxes($user_name);
		$user_safe = ($user_name);
		
		//try cache
		//$key = wfMemcKey( 'user', 'profile', 'fanboxes', "{$f->user_id}" );
		//$data = $wgMemc->get( $key );
		
		//if( !$data ){
		//	wfDebug( "Got profile gifts for user {$user_name} from db\n" );
		//	$fanboxes = $f->getUserFanboxes(0,$limit);
		//	$wgMemc->set( $key, $fanboxes );
		//} else {
		//	wfDebug( "Got profile gifts for user {$user_name} from cache\n" );
		//	$fanboxes = $data;
		//}
		
		$fanboxes = $f->getUserFanboxes(0,$limit);
		
		$fanbox_count = $f->getFanBoxCountByUsername($user_name);
		$fanbox_link = Title::Maketitle(NS_SPECIAL, "ViewUserBoxes");
		$per_row = 1;
	
		if ($fanboxes) {
			
			$output .= "<div class=\"clearfix\"><div class=\"user-fanbox-container\">";
			
				$x = 1;
				$tagParser = new Parser();
				foreach ($fanboxes as $fanbox) {

					$check_user_fanbox = $f->checkIfUserHasFanbox($fanbox["fantag_id"]);
					
					if( $fanbox["fantag_image_name"]){
						$fantag_image_width = 45;
						$fantag_image_height = 53;
						$fantag_image = Image::newFromName( $fanbox["fantag_image_name"] );
						$fantag_image_url = $fantag_image->createThumb($fantag_image_width, $fantag_image_height);
						$fantag_image_tag = '<img alt="" src="' . $fantag_image_url . '"/>';
					};
					
					if ($fanbox["fantag_left_text"] == ""){
						$fantag_leftside = $fantag_image_tag;
			
					}
					else {
						$fantag_leftside = $fanbox["fantag_left_text"];
						$fantag_leftside  = $tagParser->parse($fantag_leftside, $wgTitle, $wgOut->parserOptions(), false );
						$fantag_leftside  = $fantag_leftside->getText();
					}
					
					if ($fanbox["fantag_left_textsize"] == "mediumfont"){
						$leftfontsize= "11px";
					}
					if ($fanbox["fantag_left_textsize"] == "bigfont"){
						$leftfontsize= "15px";
					}
					
					if ($fanbox["fantag_right_textsize"] == "smallfont"){
						$rightfontsize= "10px";
					}
					if ($fanbox["fantag_right_textsize"] == "mediumfont"){
						$rightfontsize= "11px";
					}

					
					//get permalink
					$fantag_title =  Title::makeTitle( NS_FANTAG  , $fanbox["fantag_title"]  );
					
					$right_text = $fanbox["fantag_right_text"];
					$right_text  = $tagParser->parse($right_text, $wgTitle, $wgOut->parserOptions(), false );
					$right_text  = $right_text->getText();
					
					//output fanboxes
					
					$output .= "<span class=\"top-fanbox\"><div class=\"fanbox-item\">
					<div class=\"individual-fanbox\" id=\"individualFanbox".$fanbox["fantag_id"]."\">
					<div class=\"show-message-container-profile\" id=\"show-message-container".$fanbox["fantag_id"]."\">
						<div class=\"relativeposition\">
						<a class=\"perma\" style=\"font-size:8px; color:".$fanbox["fantag_right_textcolor"]."\" href=\"".$fantag_title->escapeFullURL()."\" title=\"{$fanbox["fantag_title"]}\">perma</a>
						<table  class=\"fanBoxTableProfile\" onclick=\"javascript:openFanBoxPopup('fanboxPopUpBox{$fanbox["fantag_id"]}', 'individualFanbox{$fanbox["fantag_id"]}')\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" >
						<tr><td id=\"fanBoxLeftSideOutputProfile\" style=\"color:".$fanbox["fantag_left_textcolor"]."; font-size:$leftfontsize\" bgcolor=\"".$fanbox["fantag_left_bgcolor"]."\">".$fantag_leftside."</td> 
						<td id=\"fanBoxRightSideOutputProfile\" style=\"color:".$fanbox["fantag_right_textcolor"]."; font-size:$rightfontsize\" bgcolor=\"".$fanbox["fantag_right_bgcolor"]."\">".$right_text."</td>
						</table>
						</div>
					</div>
					</div>";
					
					if($wgUser->isLoggedIn()){
						if ($check_user_fanbox == 0){
							$output .= "
						<div class=\"fanbox-pop-up-box-profile\" id=\"fanboxPopUpBox".$fanbox["fantag_id"]."\">
						<table cellpadding=\"0\" cellspacing=\"0\" ><tr><td style=\"font-size:10px\" align=\"center\">". wfMsgForContent( 'fanbox_add_fanbox' ) ."<tr><td align=\"center\">
						<input type=\"button\" value=\"Add\" size=\"10\" onclick=\"closeFanboxAdd('fanboxPopUpBox{$fanbox["fantag_id"]}', 'individualFanbox{$fanbox["fantag_id"]}'); showAddRemoveMessageUserPage(1, {$fanbox["fantag_id"]}, 'show-addremove-message-half')\" />
						<input type=\"button\" value=\"Cancel\" size=\"10\" onclick=\"closeFanboxAdd('fanboxPopUpBox{$fanbox["fantag_id"]}', 'individualFanbox{$fanbox["fantag_id"]}')\" />
						</td></table>
						</div>";
						}
						else{
							$output .= "
						<div class=\"fanbox-pop-up-box-profile\" id=\"fanboxPopUpBox".$fanbox["fantag_id"]."\">
						<table cellpadding=\"0\" cellspacing=\"0\" ><tr><td style=\"font-size:10px\" align=\"center\">". wfMsgForContent( 'fanbox_remove_fanbox' ) ."<tr><td align=\"center\">
						<input type=\"button\" value=\"Remove\" size=\"10\" onclick=\"closeFanboxAdd('fanboxPopUpBox{$fanbox["fantag_id"]}', 'individualFanbox{$fanbox["fantag_id"]}'); showAddRemoveMessageUserPage(2, {$fanbox["fantag_id"]}, 'show-addremove-message-half')\" />
						<input type=\"button\" value=\"Cancel\" size=\"10\" onclick=\"closeFanboxAdd('fanboxPopUpBox{$fanbox["fantag_id"]}', 'individualFanbox{$fanbox["fantag_id"]}')\" />
						</td></table>
						</div>";
						}
					};
				
					if($wgUser->getID() == 0 ){
						$login =  Title::makeTitle( NS_SPECIAL  , "UserLogin"  );
						$output .= "<div class=\"fanbox-pop-up-box-profile\" id=\"fanboxPopUpBox".$fanbox["fantag_id"]."\">
						<table cellpadding=\"0\" cellspacing=\"0\" ><tr><td style=\"font-size:10px\" align=\"center\">". wfMsgForContent( 'fanbox_add_fanbox_login' ) ."<a href=\"{$login->getFullURL()}\">". wfMsgForContent( 'fanbox_login' ) ."</a><tr><td align=\"center\">
						<input type=\"button\" value=\"Cancel\" size=\"10\" onclick=\"closeFanboxAdd('fanboxPopUpBox{$fanbox["fantag_id"]}', 'individualFanbox{$fanbox["fantag_id"]}')\" />
						</td></table>
						</div>";
					};
				
					$output .= "</div></span><div class=\"cleared\"></div>";
					//if($x==count($fanboxes) || $x!=1 && $x%$per_row ==0)$output .= "<div class=\"cleared\"></div>";
					$x++;	


				}
			
			$output .= "</div></div>";
		} 
		
		return $output;
	
}

?>
