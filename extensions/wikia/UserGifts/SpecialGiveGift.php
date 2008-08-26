<?php

$wgExtensionFunctions[] = 'wfSpecialGiveGift';


function wfSpecialGiveGift(){
	global $wgUser,$IP,$wgOut;

	include_once("$IP/includes/SpecialPage.php");

	class GiveGift extends SpecialPage
	{
		function GiveGift()
		{
			global $wgMessageCache;
			global $wgGiftImageUploadPath, $wgGiftImagePath, $wgUploadDirectory, $wgUploadPath;

			SpecialPage::SpecialPage("GiveGift", "", false);

			require_once ( dirname( __FILE__ ) . '/UserGifts.i18n.php' );
			foreach( efSpecialUserGits() as $lang => $messages )
			{
				$wgMessageCache->addMessages( $messages, $lang );
			}

			if (empty($wgGiftImageUploadPath)) {
				wfDebug( __METHOD__.": wgGiftImageUploadPath is empty, taking default ".$wgUploadDirectory."/awards\n" );
				$wgGiftImageUploadPath = $wgUploadDirectory."/awards";
			}
			if (empty($wgGiftImagePath)) {
				wfDebug( __METHOD__.": wgGiftImagePath is empty, taking default ".$wgUploadPath."/awards\n" );
				$wgGiftImagePath = $wgUploadPath."/awards";
			}
		}

		function execute(){
			global $wgMessageCache, $wgGiftImagePath, $wgImageCommonPath, $wgStyleVersion;
			global $wgUser, $wgOut, $wgRequest, $IP, $wgMemc, $wgScriptPath, $wgEnableAjaxLogin;

			$wgOut->addScript("<script type=\"text/javascript\" src=\"/extensions/wikia/UserGifts/UserGifts.js\"></script>\n");

			require_once("$IP/extensions/wikia/UserGifts/UserGiftsClass.php");
			require_once("$IP/extensions/wikia/UserGifts/GiftsClass.php");
			require_once("$IP/extensions/wikia/UserRelationship/UserRelationshipClass.php");

			$text =	'<style type="text/css">/*<![CDATA[*/ @import "'.$wgScriptPath.'/extensions/wikia/UserGifts/css/usergifts.css?'.$wgStyleVersion.'"; /*]]>*/</style>'."\n";
			$wgOut->addScript($text);

			$usertitle = Title::newFromDBkey($wgRequest->getVal('user'));
			if(!$usertitle)
			{
				$wgOut->addHTML($wgOut->addHTML($this->displayFormNoUser()));
				return false;
			}

			$out = "";
			$this->user_name_to = $usertitle->getText();
			$this->user_id_to = User::idFromName($this->user_name_to);
			$gift_id = $wgRequest->getVal('gift_id');

			if ($wgUser->getID()== $this->user_id_to)
			{
				$out .= $wgOut->setPagetitle( wfMsg('woopserrormsg') );
				$out .= "<div class=\"give-gift-message\">".wfMsg('cannot_give_gift_yourself')."</div>";
				$out .= "<div class=\"give-gift-buttons\">";
				$out .= "<input type=\"button\" value=\"".wfMsg('home')."\" onclick=\"window.location='/index.php?title=Main_Page'\"/> ";
				$out .= "<input type=\"button\" value=\"".wfMsg('yourprofile')."\" onclick=\"window.location='" . Title::makeTitle(NS_USER_PROFILE, $wgUser->getName())->getLocalURL() . "'\"/> ";
				$out .= "<input type=\"button\" value=\"".wfMsg('your_user_page')."\" onclick=\"window.location='" . Title::makeTitle(NS_USER, $wgUser->getName())->getLocalURL() . "'\"/> ";
				$out .= "</div>";
				$wgOut->addHTML($out);
			}
			else if($this->user_id_to == 0)
			{
				$wgOut->addHTML("<p class=\"user-message\">".wfMsg('user_gift_not_exist')."</p>");
			}
			else if($wgUser->getID() == 0)
			{
				$login_href = "window.location='/index.php?title=Special:Userlogin&returnto=User:" . $this->user_name_to . "'";
				$out .= $wgOut->setPagetitle( wfMsg('woopserrormsg') );
				$out .= "<div class=\"give-gift-message\">".wfMsg('user_haveto_logged')."</div>";
				$out .= "<div class=\"give-gift-buttons\">";
				$out .= "<input type=\"button\" value=\"".wfMsg('home')."\" onclick=\"window.location='/index.php?title=Main_Page'\"/> ";
				$out .= "<input type=\"button\" value=\"".wfMsg('login')."\" onclick=\"".$login_href."\"/> ";
				$out .= "</div>";
				$wgOut->addHTML($out);
			}
			else
			{
				$gift = new UserGifts($wgUser->getName() );
		 		if($wgRequest->wasPosted() && $_SESSION["alreadysubmitted"] == false)
		 		{
		 			$_SESSION["alreadysubmitted"] = true;
					$ug_gift_id = $gift->sendGift($this->user_name_to,$wgRequest->getVal("gift_id"),0,$wgRequest->getVal("message"));

					//clear the cache for the user profile gifts for this user
					$wgMemc->delete( wfMemcKey( 'gifts', 'profile', $this->user_id_to ) );

					$sent_gift = UserGifts::getUserGift($ug_gift_id);
					$gift_image = "<img src=\"".$wgGiftImagePath."/" . Gifts::getGiftImage($sent_gift["gift_id"],"l") . "\" border=\"0\" alt=\"".wfMsg('gift')."\" />";

					$out = $wgOut->setPagetitle( wfMsg('yousentgift', $this->user_name_to) );
					$out .= "<div class=\"gift-links\">";
					$out .= "<a href=\"/index.php?title=User:{$this->user_name_to}\">< ".wfMsg('selected_user_page', $this->user_name_to)."</a>";
					$out .= "</div>";
					$out .= "<div class=\"give-gift-message\">".wfMsg('you_sent_few_gifts', $this->user_name_to)."</div>";
					$out .= "<div class=\"give-gift-image\">
					    	{$gift_image}
				        </div>
					<div class=\"give-gift-confirm-info\">
						<p class=\"give-gift-name\">{$sent_gift["name"]}</p>";
					if ($sent_gift["message"])
					{
						$out .= "<p class=\"give-gift-message\"><img src=\"".$wgImageCommonPath."/quoteIcon.png\" border=\"0\" alt=\"\"/> {$sent_gift["message"]} <img src=\"".$wgImageCommonPath."/endQuoteIcon.png\" border=\"0\" alt=\"\"/></p> ";
					}
					if ($sent_gift["description"])
					{
						$out .= "<p class=\"give-gift-description\">{$sent_gift["description"]}</p> ";
					}
					$out .= "</div>";
					$out .= "<div class=\"cleared\"></div>";

					$out .= "<div class=\"give-gift-buttons\">";
					$out .= "<input type=\"button\" value=\"".wfMsg('view_your_gifts')."\" onclick=\"window.location='/index.php?title=Special:ViewGifts&user={$wgUser->getName()}'\"/> ";
					$out .= "<input type=\"button\" value=\"".wfMsg('view_user_gifts', $this->user_name_to)."\" onclick=\"window.location='/index.php?title=Special:ViewGifts&user={$this->user_name_to}'\"/>";
					$out .= "</div>";

					$wgOut->addHTML($out);
				}
				else
				{
					$_SESSION["alreadysubmitted"] = false;
					if($gift_id)
					{
						$wgOut->addHTML($this->displayFormSingle());
					}
					else
					{
						$wgOut->addHTML($this->displayFormAll());
					}
				}
			}
		}

		function displayFormSingle()
		{
			global $wgUser, $wgOut, $wgRequest, $wgGiftImagePath;
			$user =  Title::makeTitle( NS_USER  , $this->user_name_to  );

			$gift_id = $wgRequest->getVal('gift_id');
			$gift = Gifts::getGift($gift_id);

			$wgOut->setPagetitle( wfMsg('send_gift_to_user', $gift["gift_name"], $this->user_name_to) );

			$gift_image = "<img id=\"gift_image_{$gift["gift_id"]}\" src=\"".$wgGiftImagePath."/" . Gifts::getGiftImage($gift["gift_id"],"l") . "\" border=\"0\" alt=\"".wfMsg('gift')."\" />";

			$output .= '<form action="" method="post" enctype="multipart/form-data" name="gift">
			<div class="give-gift-message">'.wfMsg('wanttogivegift', $this->user_name_to).' <a href="/index.php?title=Special:GiveGift&user=' . $this->user_name_to . '">'.wfMsg('click_here').'</a></div>
			';
			$output .= "<div id=\"give_gift_{$gift["id"]}\" class=\"give-gift\">
			<div class=\"give-gift-image\">{$gift_image}</div>
			<div class=\"give-gift-info\">
			<p class=\"give-gift-name\">{$gift["gift_name"]}</p>";
			if ($gift["gift_description"])
			{
				$output .= "<p class=\"give-gift-description\">{$gift["gift_description"]}</p> ";
			}
			$output .= "</div>
			<div class=\"cleared\"></div>
			</div><div class=\"cleared\"></div>";

			$output .= '<div class="request-message">'.wfMsg('addmessage').'!</div>
			 <textarea name="message" id="message" rows="4" cols="50"></textarea>
			 <div class="give-gift-buttons">
			 <input type="hidden" name="gift_id" value="' . $gift_id . '">
			  <input type=hidden name="user_name" value="' . addslashes($this->user_name_to) . '">
			  <input type="button" value="'.wfMsg('send_gift_btn').'" size="20" onclick="document.gift.submit()" />
			  <input type="button" value="'.wfMsg('cancel').'" size="20" onclick="history.go(-1)" />
			</div>
			</form>';

			return $output;
		}

		function displayFormNoUser()
		{
			global $wgUser, $wgOut, $wgRequest, $wgFriendingEnabled, $IP;
			$output =  "";
			$output .= '<form action="" method="GET" enctype="multipart/form-data" name="gift">
			<input type="hidden" name="title" value="' .$wgRequest->getVal("title") . '">';
			$output .= $wgOut->setPagetitle( wfMsg('whogivegift') );
			$output .= '<div class="give-gift-message">'.wfMsg('giftsinfo').'</div>';
			if ($wgFriendingEnabled)
			{
				require_once("$IP/extensions/wikia/UserRelationship/UserRelationshipClass.php");
				$rel = new UserRelationship($wgUser->getName());
				$friends = $rel->getRelationshipList(1);
				if ($friends)
				{
					$output .= '<div class="give-gift-title">'.wfMsg('select_friend_from_list').'</div>
					<div class="give-gift-selectbox">
					<select onchange="javascript:chooseFriend(this.value)">';
					$output .= "<option value=\"#\" selected>".wfMsg('select_friend')."</option>";
					foreach($friends as $friend)
					{
						$output .= "<option value=\"{$friend["user_name"]}\">{$friend["user_name"]}</option>";
					}
					$output .= "</select></div>";
					$output .= '<p style="margin:10px 0px 10px 0px;">'.wfMsg('or').'</p>';
				}
			}

			$output .= '<div class="give-gift-title">'.wfMsg('userknowuser').'</div>';
			$output .= '<div class="give-gift-textbox">
			<input type="text" width="85" name="user" value="">
			<input type="button" value="'.wfMsg('give_gift_btn').'" onclick="document.gift.submit()">
			</div>';

			return $output;
		}

		function displayFormAll(){
			global $wgUser, $wgOut, $wgRequest, $wgGiftImagePath;
			$user =  Title::makeTitle( NS_USER  , $this->user_name_to  );

			$page =  $wgRequest->getVal('page');
			if(!$page)$page=1;
			$per_page = 10;
			$per_row = 2;
			$total = Gifts::getGiftCount();

			if (empty($total))
			{
				$out = $wgOut->setPagetitle( wfMsg('woopserrormsg') );
				$out .= "<div class=\"give-gift-message\">".wfMsg('nogitffound', $this->user_name_to)."</div>";
				$out .= "<div class=\"give-gift-buttons\">";
				$out .= "<input type=\"button\" value=\"".wfMsg('gobackbtn')."\" onclick=\"history.go(-1)\"/> ";
				$out .= "</div>";
				return $out;
			}

			$output =  "";
			$output .= $wgOut->setPagetitle( wfMsg('givegifttouser', $this->user_name_to) );
			$output .= '<div class="gift-links">';
			  $output .= "<a href=\"" . Title::makeTitle(NS_USER_PROFILE, $this->user_name_to)->getLocalURL() . "\">< ".wfMsg('user_profile_page', $this->user_name_to)."</a>";
			  $output .= " - <a href=\"/index.php?title=Special:ViewGifts&user={$this->user_name_to}\">".wfMsg('viewallusergifts', $this->user_name_to)."</a>";
			if ( $wgUser->isLoggedIn() )
			{
			  $output .= " - <a href=\"/index.php?title=Special:ViewGifts&user={$wgUser->getName()}\">".wfMsg('viewallyourgifts')."</a>";
			}
			$output .= "</div>";
			$output .= '<form action="" method="post" enctype="multipart/form-data" name="gift">
			<div class="give-gift-message">'.wfMsg('wantto_youcan', $this->user_name_to).'</div>
			<div id="all-gifts">';

			$gifts = Gifts::getGiftList($per_page,$page);
			if ($gifts)
			{
				$x = 1;
				foreach ($gifts as $gift)
				{
					$gift_image = "<img id=\"gift_image_{$gift["id"]}\" src=\"".$wgGiftImagePath."/" . Gifts::getGiftImage($gift["id"],"l") . "\" border=\"0\" alt=\"".wfMsg('gift')."\" />";
					$output .= "<div onclick=\"javascript:selectGift({$gift["id"]})\" id=\"give_gift_{$gift["id"]}\" class=\"give-gift\">
					<div class=\"give-gift-image\">{$gift_image}</div>
					<div class=\"give-gift-info\"><p class=\"give-gift-name\">{$gift["gift_name"]}</p>";
					if ($gift["gift_description"])
					{
					    $output .= "<p class=\"give-gift-description\">{$gift["gift_description"]}</p> ";
					}
				  	$output .= "</div>
				  	<div class=\"cleared\"></div>
					</div>\n";
					if ($x==count($gifts) || $x!=1 && $x%$per_row ==0)
						$output .= "<div class=\"cleared\"></div>";
					$x++;
				}
			}
			$output .= '</div>';


			/**/
			/*BUILD NEXT/PREV NAV
			**/
			$numofpages = $total / $per_page;

			if($numofpages>1)
			{
				$output .= "<div class=\"page-nav\">";
				if ($page > 1)
				{
					$output .= "<a href=\"/index.php?title=Special:GiveGift&user={$user->getPrefixedText()}&page=" . ($page-1) . "\">".wfMsg('imgmultipageprev')."</a> ";
				}

				if (($total % $per_page) != 0) $numofpages++;
				if ($numofpages >=9) $numofpages=9+$page;
				for ($i = 1; $i <= $numofpages; $i++)
				{
					if($i == $page)
					{
						$output .=($i." ");
					}
					else
					{
					    $output .= "<a href=\"/index.php?title=Special:GiveGift&user={$user->getPrefixedText()}&page=$i\">$i</a> ";
					}
				}

				if (($total - ($per_page * $page)) > 0)
				{
					$output .= " <a href=\"/index.php?title=Special:GiveGift&user={$user->getPrefixedText()}&page=" . ($page+1) . "\">".wfMsg('imgmultipagenext')."</a>";
				}

				$output .= "</div>";
			}
			/**/
			/*BUILD NEXT/PREV NAV
			**/

			$output .= '<div class="request-message">'.wfMsg('addmessage').'!</div>
			 <textarea name="message" id="message" rows="4" cols="50"></textarea>
			 <div class="give-gift-buttons">
			  <input type="hidden" name="gift_id" value="0">
			  <input type=hidden name="user_name" value="' . addslashes($this->user_name_to) . '">
			  <input type="button" value="'.wfMsg('send_gift_btn').'" size="20" onclick="sendGift(\''.wfMsg('asktoselectgift').'\')" />
			  <input type="button" value="'.ucfirst(wfMsg('cancel')).'" size="20" onclick="history.go(-1)" />
			</div>
			</form>';

			return $output;
		}
	}

	SpecialPage::addPage( new GiveGift );
	global $wgMessageCache,$wgOut;
	//$wgMessageCache->addMessage( 'givegift', 'add user relationship' );
}

?>
