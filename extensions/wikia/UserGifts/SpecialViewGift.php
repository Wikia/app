<?php

$wgExtensionFunctions[] = 'wfSpecialViewGift';


function wfSpecialViewGift(){
	global $wgUser,$IP;

	include_once("$IP/includes/SpecialPage.php");

	class ViewGift extends SpecialPage
	{

		function ViewGift()
		{
			global $wgMessageCache;
			global $wgGiftImageUploadPath, $wgGiftImagePath, $wgUploadDirectory, $wgUploadPath;

			SpecialPage::SpecialPage("ViewGift","",false);

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
			global $wgUser, $wgOut, $wgRequest, $IP;
			global $wgGiftImagePath, $wgImageCommonPath;
			global $wgScriptPath, $wgStyleVersion;

			require_once("$IP/extensions/wikia/UserGifts/UserGiftsClass.php");
			require_once("$IP/extensions/wikia/UserGifts/GiftsClass.php");
			require_once("$IP/extensions/wikia/UserRelationship/UserRelationshipClass.php");

			$output = "";
			$text =	'<style type="text/css">/*<![CDATA[*/ @import "'.$wgScriptPath.'/extensions/wikia/UserGifts/css/usergifts.css?'.$wgStyleVersion.'"; /*]]>*/</style>'."\n";
			$wgOut->addHTML($text);

			$gift_id =  $wgRequest->getVal('gift_id');
			if (!$gift_id)
			{
				$wgOut->setPagetitle( wfMsg('woopserror') );
				$wgOut->addHTML("<p class=\"user-message\">".wfMsg('invalid_link')."</p>");
				return false;
			}

			$user_name = $wgUser->getName();
			$gift = UserGifts::getUserGift($gift_id);
			$id=User::idFromName($user_name);
			$relationship = UserRelationship::getUserRelationshipByID($id,$wgUser->getID());

			$output .= $wgOut->setPagetitle( wfMsg('user_gift', $gift["user_name_to"], $gift["name"]) );

			$output .= '<div class="gift-links">';

			if (!($wgUser->getName() == $gift["user_name_to"]))
			{
				$output .= "<a href=\"" . Title::makeTitle(NS_USER_PROFILE, $gift["user_name_to"])->getLocalURL() . "\">< ".wfMsg('user_profile_page', $gift["user_name_to"])."</a>";
				$output .= " - <span class=\"profile-on\"><a href=\"/index.php?title=Special:GiveGift&user={$gift["user_name_to"]}\">".wfMsg('give_user_gift', $gift["user_name_to"])."</a></span>";
			}
			else
			{
				$output .= "<a href=\"" . Title::makeTitle(NS_USER_PROFILE, $gift["user_name_to"])->getLocalURL() . "\">< ".wfMsg('yourprofile')."</a>";
			}

			$output .= "</div>";

			if ($gift)
			{
				$user =  Title::makeTitle( NS_USER  , $gift["user_name_from"]  );
				$avatar = new WikiaAvatar($gift["user_id_from"],"s");
				$avatar_img = $avatar->getAvatarImageTag("s");
				$gift_image = "<img src=\"".$wgGiftImagePath."/" . Gifts::getGiftImage($gift["gift_id"],"l") . "\" border=\"0\" alt=\"".wfMsg('gift')."\" />";

				$output .= "<div class=\"gift\">
				<div class=\"gift-image\">{$gift_image}</div>
				<div class=\"individual-gift-info\">
				<div class=\"individual-gift-name-div\">{$gift["name"]}</div>
				<div class=\"individual-gift-date\">({$gift["timestamp"]})</div>
				<div class=\"individual-gift-from\">".wfMsg('from_gift').": $avatar_img <a href=\"{$user->getFullURL()}\">{$gift["user_name_from"]}</a></div>
				";
				if ($gift["message"])
				{
					$output .= "<p class=\"individual-gift-message\"><img src=\"".$wgImageCommonPath."/quoteIcon.png\" border=\"0\" alt=\"\"/> {$gift["message"]} <img src=\"".$wgImageCommonPath."/endQuoteIcon.png\" border=\"0\" alt=\"\"/></p>";
				}

				$output .= "<div class=\"cleared\"></div>";

				#---
				if ($gift["gift_count"]==1) {
					$given_text = wfMsg('giftgivenonetime', $gift["gift_count"]);
                }
				else {
					$given_text = wfMsg('giftgivenmanytimes', $gift["gift_count"]);
                }
				#---
				$output .= "<p class=\"individual-gift-description\">{$gift["description"]}</p>
				<p class=\"individual-gift-count\">{$given_text}</p>
				<p class=\"give-gift-link\"><img src=\"".$wgImageCommonPath."/giftIcon.png\" border=\"0\"/> <a href=\"/index.php?title=Special:GiveGift&gift_id={$gift["gift_id"]}\">".wfMsg('give_gift_someone')."</a></p>";
				if ($gift["user_name_to"]==$wgUser->getName())
				{
					$output .= "<p class=\"give-gift-link\"><a href=\"/index.php?title=Special:RemoveGift&gift_id={$gift["id"]}\">(".wfMsg('remove_gift').")</a></p>";
				}
				$output .= "</div><div class=\"cleared\"></div></div>";
			}
			else
			{
				$output .= 'x';
			}

			$output .= "<div class=\"give-gift-buttons\">";
			if (!($wgUser->getName() == $gift["user_name_to"]))
			{
				$output .= "<input type=\"button\" value=\"".wfMsg('view_your_gifts')."\" onclick=\"window.location='/index.php?title=Special:ViewGifts&user={$wgUser->getName()}'\"/> ";
				$output .= "<input type=\"button\" value=\"".wfMsg('view_user_gifts', $gift["user_name_to"])."\" onclick=\"window.location='/index.php?title=Special:ViewGifts&user={$gift["user_name_to"]}'\"/>";
			}
			else
			{
				$output .= "<input type=\"button\" value=\"".wfMsg('home')."\" onclick=\"window.location='/index.php?title=Main_Page'\"/> ";
				$output .= "<input type=\"button\" value=\"".wfMsg('view_your_gifts')."\" onclick=\"window.location='/index.php?title=Special:ViewGifts&user={$gift["user_name_to"]}'\"/>";
			}

			$output .= "</div>";

			$wgOut->addHTML($output);
		}
	}

	SpecialPage::addPage( new ViewGift );
	global $wgMessageCache,$wgOut;
	//$wgMessageCache->addMessage( 'viewrelationship', 'view relationship requests' );
}

?>
