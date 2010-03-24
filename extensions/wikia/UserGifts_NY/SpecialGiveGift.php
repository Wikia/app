<?php
class GiveGift extends SpecialPage {

	function GiveGift(){
		SpecialPage::SpecialPage("GiveGift");
	}
	
	function execute(){
		
		global $wgUser, $wgOut, $wgRequest, $IP, $wgMemc, $wgMessageCache, $wgUploadPath, $wgUserGiftsScripts, $wgStyleVersion;
	
		$output = "";
		
		$wgOut->addScript("<script type=\"text/javascript\" src=\"{$wgUserGiftsScripts}/UserGifts.js\"></script>\n");
		$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"{$wgUserGiftsScripts}/UserGifts.css?{$wgStyleVersion}\"/>\n");
		
		//language messages
		require_once ( "UserGifts.i18n.php" );
		foreach( efWikiaUserGifts() as $lang => $messages ){
			$wgMessageCache->addMessages( $messages, $lang );
		}
		
		$usertitle = Title::newFromDBkey($wgRequest->getVal('user'));
		if (!$usertitle) {
			$wgOut->addHTML($wgOut->addHTML($this->displayFormNoUser()));
			return false;	
		}
		
		$user_title =  Title::makeTitle( NS_USER  , $wgRequest->getVal('user')  );
		$this->user_name_to = $usertitle->getText();
		$this->user_id_to = User::idFromName($this->user_name_to);
		$gift_id = $wgRequest->getVal('gift_id');
		
		if ($wgUser->getID()== $this->user_id_to) {
			
			$wgOut->setPagetitle( wfMsg("g-error-title") );
			$out .= wfMsg("g-error-message-to-yourself");
			$wgOut->addHTML($out);
			
		} else if ($wgUser->isBlocked()) {
			
			$wgOut->setPagetitle( wfMsg("g-error-title") );
			$out .= wfMsg('g-error-message-blocked');
			$wgOut->addHTML($out);
		
		} else if($this->user_id_to == 0) {
			
			$wgOut->setPagetitle( wfMsg("g-error-title") );
			$wgOut->addHTML(wfMsg("g-error-message-no-user"));
			
		} else if($wgUser->getID() == 0) {
			
			$wgOut->setPagetitle( wfMsg("g-error-title") );
			$out .= wfMsg("g-error-message-login");
			$wgOut->addHTML($out);
			
		} else {
			
			$gift = new UserGifts($wgUser->getName());
			
			if ($wgRequest->wasPosted() && $_SESSION["alreadysubmitted"] == false) {
		
				$_SESSION["alreadysubmitted"] = true;
				
				$ug_gift_id = $gift->sendGift($this->user_name_to,$wgRequest->getVal("gift_id"),0,$wgRequest->getVal("message"));
				
				//clear the cache for the user profile gifts for this user
				$wgMemc->delete( wfMemcKey( 'user', 'profile', 'gifts', $this->user_id_to ) );

				$key = wfMemcKey( 'gifts', 'unique', 4 );
				$data = $wgMemc->get( $key );		
					
				//check to see if this type of gift is in the unique list
				$last_unique_gifts = $data;
				$found = 1;
				
				if( is_array($last_unique_gifts) ){
					foreach($last_unique_gifts as $last_unique_gift) {
						if($wgRequest->getVal("gift_id")==$last_unique_gift["gift_id"])$found=0;
					}
				}
				
				if ($found) {
					
					//add new unique to array
					$last_unique_gifts[]=array(
						"id"=>$ug_gift_id,"gift_id"=>$wgRequest->getVal("gift_id")
						 );
					
					//remove oldest value
					if(count($last_unique_gifts)>4)array_shift($last_unique_gifts);

					//reset the cache
					$wgMemc->set( $key, $last_unique_gifts );
				
				}
				
				$sent_gift = UserGifts::getUserGift($ug_gift_id);
				$gift_image = "<img src=\"{$wgUploadPath}/awards/" . Gifts::getGiftImage($sent_gift["gift_id"],"l") . "\" border=\"0\" alt=\"\" />";
				
				$output .= $wgOut->setPagetitle(wfMsg("g-sent-title", $this->user_name_to));
				
				$output .= "<div class=\"back-links\">
					".wfMsg("g-back-link", $user_title->escapeFullURL(), $this->user_name_to)."
				</div>
				<div class=\"g-message\">
					".wfMsg('g-sent-message', $this->user_name_to)."
				</div>
				<div class=\"g-container\">
				    {$gift_image}
				<div class=\"g-title\">{$sent_gift["name"]}</div>";
					if ($sent_gift["message"])$output.="<div class=\"g-user-message\">\"{$sent_gift["message"]}\"</div>";
					$output .= "</div>
				<div class=\"cleared\"></div>
				<div class=\"g-buttons\">
					<input type=\"button\" class=\"site-button\" value=\"".wfMsg('g-main-page')."\" size=\"20\" onclick=\"window.location='" . Title::newMainPage()->getLocalURL() . "'\"/> 
					<input type=\"button\" class=\"site-button\" value=\"".wfMsg('g-your-profile')."\" size=\"20\" onclick=\"window.location='".$wgUser->getUserPage()->escapeFullURL() . "'\"/>
				</div>";
				
				$wgOut->addHTML($output);
				
			} else {
				
				$_SESSION["alreadysubmitted"] = false;
				
				if ($gift_id) {
					$wgOut->addHTML($this->displayFormSingle());
				} else {
					$wgOut->addHTML($this->displayFormAll());
				}
				
			}
			
		}
	}

	function displayFormSingle() {
		
		global $wgUser, $wgOut, $wgRequest, $wgUploadPath;
		
		$gift_id = $wgRequest->getVal('gift_id');
		
		if (!$gift_id || !is_numeric($gift_id) ) {
			
			$wgOut->setPagetitle( wfMsg("g-error-title") );
			$wgOut->addHTML(wfMsg("g-error-message-invalid-link"));
			return false;
							
		}
		
		$gift = Gifts::getGift($gift_id);
		if ( empty($gift) ) {
			return false;			
		}
		if( $gift["access"] == 1 && $wgUser->getID() != $gift["creator_user_id"] ){
			return $this->displayFormAll();
		}
		
		//safe titles
		$user=Title::makeTitle(NS_USER, $this->user_name_to);
		$give_gift_link=Title::makeTitle(NS_SPECIAL,"GiveGift");
		
		$wgOut->setPagetitle( wfMsg('g-give-to-user-title', $gift["gift_name"], $this->user_name_to) );
		
		$gift_image = "<img id=\"gift_image_{$gift["gift_id"]}\" src=\"{$wgUploadPath}/awards/" . Gifts::getGiftImage($gift["gift_id"],"l") . "\" border=\"0\" alt=\"\"/>";
			
		$output = "<form action=\"\" method=\"post\" enctype=\"multipart/form-data\" name=\"gift\">
			<div class=\"g-message\">
				".wfMsg("g-give-to-user-message", $this->user_name_to, $give_gift_link->escapeFullURL('user='.$this->user_name_to))."
			</div>
			<div id=\"give_gift_{$gift["gift_id"]}\" class=\"g-container\">
				{$gift_image}
				<div class=\"g-title\">{$gift["gift_name"]}</div>";
				if ($gift["gift_description"])$output .= "<div class=\"g-describe\">{$gift["gift_description"]}</div>";
			$output .= "</div>
			<div class=\"cleared\"></div>
			<div class=\"g-add-message\">".wfMsg("g-add-message")."</div>
			<textarea name=\"message\" id=\"message\" rows=\"4\" cols=\"50\"></textarea>
			<div class=\"g-buttons\">
				<input type=\"hidden\" name=\"gift_id\" value=\"{$gift_id}\">
				<input type=\"hidden\" name=\"user_name\" value=\"".addslashes($this->user_name_to)."\">
				<input type=\"button\" class=\"site-button\" value=\"".wfMsg("g-send-gift")."\" size=\"20\" onclick=\"document.gift.submit()\"/>
				<input type=\"button\" class=\"site-button\" value=\"".wfMsg("g-cancel")."\" size=\"20\" onclick=\"history.go(-1)\"/>
			</div>
		</form>";
		
					
		return $output;
	}
	
	function displayFormNoUser(){
		
		global $wgUser, $wgOut, $wgRequest, $wgFriendingEnabled, $IP;
		
		$output = $wgOut->setPagetitle( wfMsg("g-give-no-user-title") );
		
		$output =  "";
		$output .= "<form action=\"\" method=\"GET\" enctype=\"multipart/form-data\" name=\"gift\">
			<input type=\"hidden\" name=\"title\" value=\"".$wgRequest->getVal("title")."\">
			<div class=\"g-message\">".wfMsg("g-give-no-user-message")."</div>
			<div class=\"g-give-container\">";
			
			if ($wgFriendingEnabled) {
			
				require_once("$IP/extensions/wikia/UserRelationship_NY/UserRelationshipClass.php");
			
				$rel = new UserRelationship($wgUser->getName());
				$friends = $rel->getRelationshipList(1);
			
				if ($friends) {
					
					$output .= "<div class=\"g-give-title\">".wfMsg("g-give-list-friends-title")."</div>
					<div class=\"g-gift-select\">
						<select onchange=\"javascript:chooseFriend(this.value)\">
						<option value=\"#\" selected>".wfMsg("g-select-a-friend")."</option>";
					foreach ($friends as $friend) {
						$output .= "<option value=\"" . urlencode($friend["user_name"]) . "\">{$friend["user_name"]}</option>";
					}
					$output .= "</select>
					</div>
					<div class=\"g-give-separator\">".wfMsg("g-give-separator")."</div>";
				}
			}
		
		
			$output .= "<div class=\"g-give-title\">".wfMsg("g-give-enter-friend-title")."</div>
			<div class=\"g-give-textbox\">
				<input type=\"text\" width=\"85\" name=\"user\" value=\"\">
				<input class=\"site-button\" type=\"button\" value=\"".wfMsg("g-give-gift")."\" onclick=\"document.gift.submit()\">
			</div>
			</div></form>";
		
		return $output;
	}
	
	function displayFormAll() {
		
		global $wgUser, $wgOut, $wgRequest, $wgGiveGiftPerRow, $wgUploadPath;
		$user =  Title::makeTitle(NS_USER, $this->user_name_to  );
		
		$page =  $wgRequest->getVal('page');
		if(!$page || !is_numeric($page) )$page=1;
		
		$per_page = 24;
		$per_row = $wgGiveGiftPerRow;
		if( !$per_row ) $per_row = 3;
		
		$total = Gifts::getGiftCount();
		$gifts = Gifts::getGiftList($per_page,$page, "gift_name");
		$output = "";
		if ($gifts) {
			
			$wgOut->setPagetitle( wfMsg("g-give-all-title", $this->user_name_to));

			$output .= "<div class=\"back-links\">
				".wfMsg("g-back-link", $user->escapeFullURL(), $this->user_name_to)."
			</div>
			<div class=\"g-message\">
				".wfMsg('g-give-all', $this->user_name_to)."
			</div>
			<form action=\"\" method=\"post\" enctype=\"multipart/form-data\" name=\"gift\">";
			
			$x = 1;
			
			foreach ($gifts as $gift) {
				
				$gift_image = "<img id=\"gift_image_{$gift["id"]}\" src=\"{$wgUploadPath}/awards/" . Gifts::getGiftImage($gift["id"],"l") . "\" border=\"0\" alt=\"\" />";
				
				$output .= "<div onclick=\"selectGift({$gift["id"]})\" onmouseover=\"highlightGift({$gift["id"]})\" onmouseout=\"unHighlightGift({$gift["id"]})\" id=\"give_gift_{$gift["id"]}\" class=\"g-give-all\">
					{$gift_image}
					<div class=\"g-title g-blue\">{$gift["gift_name"]}</div>";
					if ($gift["gift_description"]) $output .= "<div class=\"g-describe\">{$gift["gift_description"]}</div>";
					$output .= "<div class=\"cleared\"></div>
				</div>";
				if($x==count($gifts) || $x!=1 && $x%$per_row ==0)$output .= "<div class=\"cleared\"></div>";
				$x++;
			}

			/**/
			/*BUILD NEXT/PREV NAV
			**/
			
			$give_gift_link=Title::makeTitle(NS_SPECIAL, "GiveGift");
			
			$numofpages = $total / $per_page; 
			$user_safe = urlencode($user->getText());
			if($numofpages>1){
				$output .= "<div class=\"page-nav\">";
				if ($page > 1) { 
					$output .= "<a href=\"".$give_gift_link->escapeFullURL('user='.$user_safe.'&page='.($page-1))."\">".wfMsg('g-previous')."</a> ";
				}


				if(($total % $per_page) != 0)$numofpages++;
				if($numofpages >=9)$numofpages=9+$page;
				for($i = 1; $i <= $numofpages; $i++){
					if ($i == $page) {
					    $output .=($i." ");
					} else {
					    $output .= "<a href=\"".$give_gift_link->escapeFullURL('user='.$user_safe.'&page='.$i)."\">$i</a> ";
					}
				}

				if (($total - ($per_page * $page)) > 0) {
					$output .= " <a href=\"".$give_gift_link->escapeFullURL('user='.$user_safe.'&page='.($page+1))."\">".wfMsg('g-next')."</a>"; 
				}
				$output .= "</div>";
			}
			/**/
			/*BUILD NEXT/PREV NAV
			**/

			$output .= "<div class=\"g-give-all-message-title\">".wfMsg("g-give-all-message-title")."</div>
				<textarea name=\"message\" id=\"message\" rows=\"4\" cols=\"50\"></textarea>
				<div class=\"g-buttons\">
					<input type=\"hidden\" name=\"gift_id\" value=\"0\">
					<input type=\"hidden\" name=\"user_name\" value=\"".addslashes($this->user_name_to)."\">
					<input type=\"button\" class=\"site-button\" value=\"".wfMsg("g-send-gift")."\" size=\"20\" onclick=\"sendGift()\"/>
					<input type=\"button\" class=\"site-button\" value=\"".wfMsg("g-cancel")."\" size=\"20\" onclick=\"history.go(-1)\"/>
				</div>
			</form>";
		} else {
			
			$wgOut->setPageTitle(wfMsg("g-error-title"));
			$wgOut->addHTML(wfMsg("g-error-message-invalid-link"));
		
		}
		
					
		return $output;
	}
}
?>
