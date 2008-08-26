<?php
class ViewSystemGift extends SpecialPage {

	function ViewSystemGift(){
		UnlistedSpecialPage::UnlistedSpecialPage("ViewSystemGift");
	}
	
	function execute(){
		
		global $wgUser, $wgOut, $wgRequest, $wgMessageCache, $wgUploadPath, $IP, $wgSystemGiftsScripts;

		$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"{$wgSystemGiftsScripts}/SystemGift.css?{$wgStyleVersion}\"/>\n");

		//language messages
		require_once ( "SystemGift.i18n.php" );
		foreach( efWikiaSystemGift() as $lang => $messages ){
			$wgMessageCache->addMessages( $messages, $lang );
		}
		
		$output = "";
		
		$gift_id =  $wgRequest->getVal('gift_id');
		if(!$gift_id || !is_numeric($gift_id) ){
			$wgOut->setPageTitle(wfMsg("ga-error-title"));
			$wgOut->addHTML(wfMsg("ga-error-message-invalid-link"));
			return false;	
		}
		
		if(!$user_name)$user_name = $wgUser->getName();
		$gift = UserSystemGifts::getUserGift($gift_id);
		$id=User::idFromName($user_name);
		
		$user_safe = urlencode($gift["user_name"]);
		
		///db stuff
		$dbr =& wfGetDB( DB_MASTER );
		
		if ($gift) {
				
			if ($gift["status"] == 1) {
				if( $gift["user_name"] == $wgUser->getName() ){
					$g = new UserSystemGifts( $gift["user_name"] );
					$g->clearUserGiftStatus($gift["id"]);
					$g->decNewSystemGiftCount( $wgUser->getID() );
				}		
			}
			$sql = "SELECT DISTINCT sg_user_name, sg_user_id, sg_gift_id, sg_date FROM user_system_gift WHERE sg_gift_id={$gift["gift_id"]} and sg_user_name<>'" . addslashes($gift["user_name"]) . "' GROUP BY sg_user_name ORDER BY sg_date DESC LIMIT 0,6";
			$res = $dbr->query($sql);
		
			$output .= $wgOut->setPagetitle( wfMsg("ga-gift-title", $gift["user_name"], $gift["name"]) );
		
			$output .= "<div class=\"back-links\">
				".wfMsg("ga-back-link", Title::makeTitle(NS_USER, $gift["user_name"])->escapeFullURL(), $gift["user_name"])."
			</div>";
		
			$message = $wgOut->parse( trim($gift["description"]), false );
			$output .= "<div class=\"ga-description-container\">";
			
				$gift_image = "<img src=\"{$wgUploadPath}/awards/" . SystemGifts::getGiftImage($gift["gift_id"],"l") . "\" border=\"0\" alt=\"\"/>";
			
				$output .= "<div class=\"ga-description\">
					{$gift_image}
					<div class=\"ga-name\">{$gift["name"]}</div>
					<div class=\"ga-timestamp\">({$gift["timestamp"]})</div>
					<div class=\"ga-description-message\">\"{$message}\"</div>";
					$output .= "<div class=\"cleared\"></div>
				</div>";		
		
				$output .= "<div class=\"ga-recent\">
					<div class=\"ga-recent-title\">".wfMsg("ga-recent-recipients-award")."</div>
					<div class=\"ga-gift-count\">".wfMsgExt('ga-gift-given-count', 'parsemag', $gift["gift_count"])."</div>";
		
					while ($row = $dbr->fetchObject($res)) {
					
						$user_to_id = $row->sg_user_id;
						$avatar = new wAvatar($user_to_id,"ml");
						$user_name_link = Title::makeTitle(NS_USER,$row->sg_user_name);
			
						$output .= "<a href=\"".$user_name_link->escapeFullURL()."\">
							{$avatar->getAvatarURL()}
						</a>";
			
					}
		
					$output .= "<div class=\"cleared\"></div>
				</div>
			</div>";
			
			$wgOut->addHTML($output);
			
		} else {
			$wgOut->setPageTitle(wfMsg("ga-error-title"));
			$wgOut->addHTML(wfMsg("ga-error-message-invalid-link"));
		}
		
		
		
	}
}


?>