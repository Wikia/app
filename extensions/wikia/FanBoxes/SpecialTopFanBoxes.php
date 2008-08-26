<?php

$wgExtensionFunctions[] = 'wfSpecialTopFanBoxes';


function wfSpecialTopFanBoxes(){
	global $wgUser,$IP;
	include_once("includes/SpecialPage.php");


	class TopFanBoxes extends SpecialPage {
		
		function TopFanBoxes(){
			SpecialPage::SpecialPage("TopUserboxes");
		}
		
		function execute(){
			global $IP, $wgOut, $wgUser, $wgTitle, $wgRequest, $wgContLang, $wgMessageCache, $wgStyleVersion, 
			$wgFanBoxScripts, $wgUploadPath;


			require_once ( "FanBox.i18n.php" );
			foreach( efWikiaFantag() as $lang => $messages ){
				$wgMessageCache->addMessages( $messages, $lang );
			}

		
			$wgOut->addScript("<script type=\"text/javascript\" src=\"{$wgFanBoxScripts}/FanBoxes.js\"></script>\n");
			$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"{$wgFanBoxScripts}/FanBoxes.css\"/>\n");

			$topfanboxid = $wgRequest->getVal("id");
			$topfanboxcategory = $wgRequest->getVal("cat");
						
			
		

			if($topfanboxid == fantag_date){
				$wgOut->setPageTitle("Most Recent Userboxes");
				$topfanboxes = $this->getTopFanboxes('fantag_date');

			}
			
			else {
				$wgOut->setPageTitle("Top Userboxes");
				$topfanboxes = $this->getTopFanboxes('fantag_count');
			}

			
			$output = "";
			
			//make top right nav bar
			$top_title = Title::makeTitle(NS_SPECIAL,"TopUserboxes");
			
			$output .= "<div class=\"fanbox-nav\">
				<h2>" . wfMsgForContent("fanbox_nav_header") . "</h2>
				<p><a href=\"{$top_title->escapeFullURL()}\">" . wfMsgForContent("top_fanboxes_link") . "</a></p>
				<p><a href=\"" . $top_title->escapeFullURL("id=fantag_date") . "\">" . wfMsgForContent("most_recent_fanboxes_link") . "</a><p>
			</div>";

		if (!$topfanboxcategory){
			
			$x = 1;

				$output .= "<div class=\"top-fanboxes\">";

				$tagParser = new Parser();

				foreach($topfanboxes as $topfanbox){
					
					$check_user_fanbox = $this->checkIfUserHasFanbox($topfanbox["fantag_id"]);
					
					if( $topfanbox["fantag_image_name"]){
						$fantag_image_width = 45;
						$fantag_image_height = 53;
						$fantag_image = Image::newFromName( $topfanbox["fantag_image_name"] );
						$fantag_image_url = $fantag_image->createThumb($fantag_image_width, $fantag_image_height);
						$fantag_image_tag = '<img alt="" src="' . $fantag_image_url . '"/>';
					};
					
					if ($topfanbox["fantag_left_text"] == ""){
						$fantag_leftside = $fantag_image_tag;
					}
					else {
						$fantag_leftside = $topfanbox["fantag_left_text"];
						$fantag_leftside  = $tagParser->parse($fantag_leftside, $wgTitle, $wgOut->parserOptions(), false );
						$fantag_leftside  = $fantag_leftside->getText();
					}
					
					if ($topfanbox["fantag_left_textsize"] == "mediumfont"){
						$leftfontsize= "14px";
					}
					if ($topfanbox["fantag_left_textsize"] == "bigfont"){
						$leftfontsize= "20px";
					}
					
					if ($topfanbox["fantag_right_textsize"] == "smallfont"){
						$rightfontsize= "12px";
					}
					if ($topfanbox["fantag_right_textsize"] == "mediumfont"){
						$rightfontsize= "14px";
					}

							
					//get permalink
					$fantag_title =  Title::makeTitle( NS_FANTAG  , $topfanbox["fantag_title"]  );
					
					//get creator
					$userftusername = $topfanbox["fantag_user_name"];
					$userftuserid = $topfanbox["fantag_user_id"];				
					$user_title = Title::makeTitle( NS_USER, $topfanbox["fantag_user_name"] );
					$avatar = new wAvatar($topfanbox["fantag_user_id"],"m");
					
					$right_text = $topfanbox["fantag_right_text"];
					$right_text  = $tagParser->parse($right_text, $wgTitle, $wgOut->parserOptions(), false );
					$right_text  = $right_text->getText();
					
					$output .= "
					<div class=\"top-fanbox-row\">
					<span class=\"top-fanbox-num\">{$x}.</span><span class=\"top-fanbox\">
					
					<div class=\"fanbox-item\">
								
					<div class=\"individual-fanbox\" id=\"individualFanbox".$topfanbox["fantag_id"]."\">
						<div class=\"show-message-container\" id=\"show-message-container".$topfanbox["fantag_id"]."\">
							<div class=\"permalink-container\">
							<a class=\"perma\" style=\"font-size:8px; color:".$topfanbox["fantag_right_textcolor"]."\" href=\"".$fantag_title->escapeFullURL()."\" title=\"{$topfanbox["fantag_title"]}\">perma</a>
							<table  class=\"fanBoxTable\" onclick=\"javascript:openFanBoxPopup('fanboxPopUpBox{$topfanbox["fantag_id"]}', 'individualFanbox{$topfanbox["fantag_id"]}')\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" >
							<tr>
								<td id=\"fanBoxLeftSideOutput\" style=\"color:".$topfanbox["fantag_left_textcolor"]."; font-size:$leftfontsize\" bgcolor=\"".$topfanbox["fantag_left_bgcolor"]."\">".$fantag_leftside."</td> 
								<td id=\"fanBoxRightSideOutput\" style=\"color:".$topfanbox["fantag_right_textcolor"]."; font-size:$rightfontsize\" bgcolor=\"".$topfanbox["fantag_right_bgcolor"]."\">".$right_text."</td>
							</tr>
							</table>
							</div>
						</div>
					</div>";
					
					if($wgUser->isLoggedIn()){
						if ($check_user_fanbox == 0){
							$output .= "
						<div class=\"fanbox-pop-up-box\" id=\"fanboxPopUpBox".$topfanbox["fantag_id"]."\">
						<table cellpadding=\"0\" cellspacing=\"0\" width=\"258px\"><tr><td align=\"center\">". wfMsgForContent( 'fanbox_add_fanbox' ) ."<tr><td align=\"center\">
						<input type=\"button\" value=\"Add\" size=\"20\" onclick=\"closeFanboxAdd('fanboxPopUpBox{$topfanbox["fantag_id"]}', 'individualFanbox{$topfanbox["fantag_id"]}'); showAddRemoveMessageUserPage(1, {$topfanbox["fantag_id"]}, 'show-addremove-message')\" />
						<input type=\"button\" value=\"Cancel\" size=\"20\" onclick=\"closeFanboxAdd('fanboxPopUpBox{$topfanbox["fantag_id"]}', 'individualFanbox{$topfanbox["fantag_id"]}')\" />
						</td></table>
						</div>";
						}
						else{
							$output .= "
						<div class=\"fanbox-pop-up-box\" id=\"fanboxPopUpBox".$topfanbox["fantag_id"]."\">
						<table cellpadding=\"0\" cellspacing=\"0\" width=\"258px\"><tr><td align=\"center\">". wfMsgForContent( 'fanbox_remove_fanbox' ) ."<tr><td align=\"center\">
						<input type=\"button\" value=\"Remove\" size=\"20\" onclick=\"closeFanboxAdd('fanboxPopUpBox{$topfanbox["fantag_id"]}', 'individualFanbox{$topfanbox["fantag_id"]}'); showAddRemoveMessageUserPage(2, {$topfanbox["fantag_id"]}, 'show-addremove-message')\" />
						<input type=\"button\" value=\"Cancel\" size=\"20\" onclick=\"closeFanboxAdd('fanboxPopUpBox{$topfanbox["fantag_id"]}', 'individualFanbox{$topfanbox["fantag_id"]}')\" />
						</td></table>
						</div>";
						}
					};
				
					if($wgUser->getID() == 0 ){
						$login =  Title::makeTitle( NS_SPECIAL  , "UserLogin"  );
						$output .= "<div class=\"fanbox-pop-up-box\" id=\"fanboxPopUpBox".$topfanbox["fantag_id"]."\">
						<table cellpadding=\"0\" cellspacing=\"0\" width=\"258px\"><tr><td align=\"center\">". wfMsgForContent( 'fanbox_add_fanbox_login' ) ."<a href=\"{$login->getFullURL()}\">". wfMsgForContent( 'fanbox_login' ) ."</a><tr><td align=\"center\">
						<input type=\"button\" value=\"Cancel\" size=\"20\" onclick=\"closeFanboxAdd('fanboxPopUpBox{$topfanbox["fantag_id"]}', 'individualFanbox{$topfanbox["fantag_id"]}')\" />
						</td></table>
						</div>";
					};
					
	
					
					$output .= "</div></span>";			
					$output .= "<span class=\"top-fanbox-users\"><table><td class=\"centerheight\"><b><a href=\"".$fantag_title->escapeFullURL()."\">" .$topfanbox["fantag_count"]. " members</a></b></table></span>";
					$output .= "<div class=\"cleared\"></div>";
					$output .= "</div>";

					$x++;

				
				};
					$output .= "</div><div class=\"cleared\"></div>";

			
		}
		
			if ($topfanboxcategory){
				$x = 1;

				$output .= "<div class=\"top-fanboxes\">";

				
				foreach($categoryfanboxes as $categoryfanbox){
					
					$check_user_fanbox = $this->checkIfUserHasFanbox($categoryfanbox["fantag_id"]);
					
					if( $categoryfanbox["fantag_image_name"]){
						$fantag_image_width = 45;
						$fantag_image_height = 53;
						$fantag_image = Image::newFromName( $categoryfanbox["fantag_image_name"] );
						$fantag_image_url = $fantag_image->createThumb($fantag_image_width, $fantag_image_height);
						$fantag_image_tag = '<img alt="" src="' . $fantag_image_url . '"/>';
					};
					
					if ($categoryfanbox["fantag_left_text"] == ""){
						$fantag_leftside = $fantag_image_tag;
					}
					else {
						$fantag_leftside = $categoryfanbox["fantag_left_text"];
					}
					
					if ($categoryfanbox["fantag_left_textsize"] == "mediumfont"){
						$leftfontsize= "14px";
					}
					if ($categoryfanbox["fantag_left_textsize"] == "bigfont"){
						$leftfontsize= "20px";
					}
					
					if ($categoryfanbox["fantag_right_textsize"] == "smallfont"){
						$rightfontsize= "12px";
					}
					if ($categoryfanbox["fantag_right_textsize"] == "mediumfont"){
						$rightfontsize= "14px";
					}

							
					//get permalink
					$fantag_title =  Title::makeTitle( NS_FANTAG  , $categoryfanbox["fantag_title"]  );
					
					//get creator
					$userftusername = $categoryfanbox["fantag_user_name"];
					$userftuserid = $categoryfanbox["fantag_user_id"];				
					$user_title = Title::makeTitle( NS_USER, $categoryfanbox["fantag_user_name"] );
					$avatar = new wAvatar($categoryfanbox["fantag_user_id"],"m");
					
					
					$output .= "
					<div class=\"top-fanbox-row\">
					<span class=\"top-fanbox-num\">{$x}.</span><span class=\"top-fanbox\">
					
					<div class=\"fanbox-item\">
								
					<div class=\"individual-fanbox\" id=\"individualFanbox".$categoryfanbox["fantag_id"]."\">
					<div class=\"show-message-container\" id=\"show-message-container".$categoryfanbox["fantag_id"]."\">
						<div class=\"permalink-container\">
						<a class=\"perma\" style=\"font-size:8px; color:".$categoryfanbox["fantag_right_textcolor"]."\" href=\"".$fantag_title->escapeFullURL()."\" title=\"{$categoryfanbox["fantag_title"]}\">perma</a>
						<table  class=\"fanBoxTable\" onclick=\"javascript:openFanBoxPopup('fanboxPopUpBox{$categoryfanbox["fantag_id"]}', 'individualFanbox{$categoryfanbox["fantag_id"]}')\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\" >
						<tr><td id=\"fanBoxLeftSideOutput\" style=\"color:".$categoryfanbox["fantag_left_textcolor"]."; font-size:$leftfontsize\" bgcolor=\"".$categoryfanbox["fantag_left_bgcolor"]."\">".$fantag_leftside."</td> 
						<td id=\"fanBoxRightSideOutput\" style=\"color:".$categoryfanbox["fantag_right_textcolor"]."; font-size:$rightfontsize\" bgcolor=\"".$categoryfanbox["fantag_right_bgcolor"]."\">".$categoryfanbox["fantag_right_text"]."</td>
						</table>
						</div>
					</div>
					</div>";
					
					if($wgUser->isLoggedIn()){
						if ($check_user_fanbox == 0){
							$output .= "
						<div class=\"fanbox-pop-up-box\" id=\"fanboxPopUpBox".$categoryfanbox["fantag_id"]."\">
						<table cellpadding=\"0\" cellspacing=\"0\" width=\"258px\"><tr><td align=\"center\">". wfMsgForContent( 'fanbox_add_fanbox' ) ."<tr><td align=\"center\">
						<input type=\"button\" value=\"Add\" size=\"20\" onclick=\"closeFanboxAdd('fanboxPopUpBox{$categoryfanbox["fantag_id"]}', 'individualFanbox{$categoryfanbox["fantag_id"]}'); showAddRemoveMessageUserPage(1, {$categoryfanbox["fantag_id"]}, 'show-addremove-message')\" />
						<input type=\"button\" value=\"Cancel\" size=\"20\" onclick=\"closeFanboxAdd('fanboxPopUpBox{$categoryfanbox["fantag_id"]}', 'individualFanbox{$categoryfanbox["fantag_id"]}')\" />
						</td></table>
						</div>";
						}
						else{
							$output .= "
						<div class=\"fanbox-pop-up-box\" id=\"fanboxPopUpBox".$categoryfanbox["fantag_id"]."\">
						<table cellpadding=\"0\" cellspacing=\"0\" width=\"258px\"><tr><td align=\"center\">". wfMsgForContent( 'fanbox_remove_fanbox' ) ."<tr><td align=\"center\">
						<input type=\"button\" value=\"Remove\" size=\"20\" onclick=\"closeFanboxAdd('fanboxPopUpBox{$categoryfanbox["fantag_id"]}', 'individualFanbox{$categoryfanbox["fantag_id"]}'); showAddRemoveMessageUserPage(2, {$categoryfanbox["fantag_id"]}, 'show-addremove-message')\" />
						<input type=\"button\" value=\"Cancel\" size=\"20\" onclick=\"closeFanboxAdd('fanboxPopUpBox{$categoryfanbox["fantag_id"]}', 'individualFanbox{$categoryfanbox["fantag_id"]}')\" />
						</td></table>
						</div>";
						}
					};
				
					if($wgUser->getID() == 0 ){
						$login =  Title::makeTitle( NS_SPECIAL  , "UserLogin"  );
						$output .= "<div class=\"fanbox-pop-up-box\" id=\"fanboxPopUpBox".$categoryfanbox["fantag_id"]."\">
						<table cellpadding=\"0\" cellspacing=\"0\" width=\"258px\"><tr><td align=\"center\">". wfMsgForContent( 'fanbox_add_fanbox_login' ) ."<a href=\"{$login->getFullURL()}\">". wfMsgForContent( 'fanbox_login' ) ."</a><tr><td align=\"center\">
						<input type=\"button\" value=\"Cancel\" size=\"20\" onclick=\"closeFanboxAdd('fanboxPopUpBox{$categoryfanbox["fantag_id"]}', 'individualFanbox{$categoryfanbox["fantag_id"]}')\" />
						</td></table>
						</div>";
					};
					
	
					
					$output .= "</div></span>";
					$output .= "<span class=\"top-fanbox-creator\"><table><td class=\"centerheight\"> <b> created by: <b> <td class=\"centerheight\"> <b> <a href=\"".$user_title->escapeFullURL()."\"><img src=\"{$wgUploadPath}/avatars/{$avatar->getAvatarImage()}\" alt=\"\" border=\"0\" /></a></b> </table></span>";			
					$output .= "<span class=\"top-fanbox-users\"><table><td class=\"centerheight\"><b><a href=\"".$fantag_title->escapeFullURL()."\">" .$categoryfanbox["fantag_count"]. " members. </a></b></table></span>";
					$output .= "<div class=\"cleared\"></div>";
					$output .= "</div>";

					$x++;

				
				};
					$output .= "</div><div class=\"cleared\"></div>";

			}
		
			$wgOut->addHTML($output);


		}

	
	function getTopFanboxes($orderby){
		$dbr =& wfGetDB( DB_MASTER );
				
		$sql = "SELECT fantag_id, fantag_title, fantag_pg_id, fantag_left_text, fantag_left_textcolor, fantag_left_bgcolor, fantag_right_text, fantag_right_textcolor, fantag_right_bgcolor, fantag_image_name, fantag_left_textsize, fantag_right_textsize, fantag_count, fantag_user_id, fantag_user_name, fantag_date FROM fantag ORDER BY {$orderby} DESC LIMIT 0,50;";
		
		$res = $dbr->query($sql);
		$topfanboxes = array();
		while ($row = $dbr->fetchObject( $res ) ) {
			 $topfanboxes[] = array(
				 "fantag_id" => $row->fantag_id, 
				 "fantag_title" => $row->fantag_title, 
				 "fantag_pg_id" => $row->fantag_pg_id, 				 
				 "fantag_left_text" => $row->fantag_left_text, 
				 "fantag_left_textcolor" => $row->fantag_left_textcolor, 
				 "fantag_left_bgcolor" => $row->fantag_left_bgcolor, 
				 "fantag_right_text" => $row->fantag_right_text, 
				 "fantag_right_textcolor" => $row->fantag_right_textcolor, 
				 "fantag_right_bgcolor" => $row->fantag_right_bgcolor,
				 "fantag_image_name" => $row->fantag_image_name,
				 "fantag_left_textsize" => $row->fantag_left_textsize,
				 "fantag_right_textsize" => $row->fantag_right_textsize,
				 "fantag_count" => $row->fantag_count,
				 "fantag_user_id" => $row->fantag_user_id,
				 "fantag_user_name" => $row->fantag_user_name,
				 "fantag_date" => $row->fantag_date,
				 
				 );
		}
		
		return $topfanboxes;
	}

	
	function checkIfUserHasFanbox($userft_fantag_id){
		global $wgUser;
		$dbr =& wfGetDB( DB_MASTER );
		$sql = "SELECT count(*) as count
			FROM user_fantag
			WHERE userft_user_name = '{$wgUser->getName()}' && userft_fantag_id = {$userft_fantag_id}";
		$res = $dbr->query($sql);
		$row = $dbr->fetchObject( $res );
		if($row){
			$check_fanbox_count=$row->count;
		}
		return $check_fanbox_count;		
	}
	
	
	public function getFanBoxByCategory ($category){
		$dbr =& wfGetDB( DB_MASTER );
				
		$sql = "SELECT fantag_id, fantag_title, fantag_pg_id, fantag_left_text, fantag_left_textcolor, fantag_left_bgcolor, fantag_right_text, fantag_right_textcolor, fantag_right_bgcolor, fantag_image_name, fantag_left_textsize, fantag_right_textsize, fantag_count, fantag_user_id, fantag_user_name FROM fantag INNER JOIN categorylinks ON cl_from=fantag_pg_id WHERE cl_to = '$category' ORDER BY fantag_count DESC";
		
		$res = $dbr->query($sql);
		$categoryfanboxes = array();
		while ($row = $dbr->fetchObject( $res ) ) {
			 $categoryfanboxes[] = array(
				 "fantag_id" => $row->fantag_id, 
				 "fantag_title" => $row->fantag_title, 
				 "fantag_pg_id" => $row->fantag_pg_id, 				 
				 "fantag_left_text" => $row->fantag_left_text, 
				 "fantag_left_textcolor" => $row->fantag_left_textcolor, 
				 "fantag_left_bgcolor" => $row->fantag_left_bgcolor, 
				 "fantag_right_text" => $row->fantag_right_text, 
				 "fantag_right_textcolor" => $row->fantag_right_textcolor, 
				 "fantag_right_bgcolor" => $row->fantag_right_bgcolor,
				 "fantag_image_name" => $row->fantag_image_name,
				 "fantag_left_textsize" => $row->fantag_left_textsize,
				 "fantag_right_textsize" => $row->fantag_right_textsize,
				 "fantag_count" => $row->fantag_count,
				 "fantag_user_id" => $row->fantag_user_id,
				 "fantag_user_name" => $row->fantag_user_name,
				 );
		}
		
		return $categoryfanboxes;
	}

	
	
	
	
		
}

	SpecialPage::addPage( new TopFanBoxes );
	global $wgMessageCache;
	$wgMessageCache->addMessage( 'topuserboxes', 'Top UserBoxes' );
}

?>