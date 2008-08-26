<?php

$wgExtensionFunctions[] = 'wfSpecialRemoveGift';


function wfSpecialRemoveGift()
{
	global $wgUser,$IP;
	include_once("includes/SpecialPage.php");


	class RemoveGift extends SpecialPage 
	{
	
		function RemoveGift()
		{
			global $wgMessageCache;
			global $wgGiftImageUploadPath, $wgGiftImagePath, $wgUploadDirectory, $wgUploadPath;

			SpecialPage::SpecialPage("RemoveGift","",false);

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
		
		function execute()
		{
			global $wgUser, $wgOut, $wgRequest, $IP, $wgMemc, $wgGiftImagePath;
		
			require_once("$IP/extensions/wikia/UserGifts/UserGiftsClass.php");
			require_once("$IP/extensions/wikia/UserGifts/GiftsClass.php");
			
			$this->gift_id = $wgRequest->getVal('gift_id');
			$rel = new UserGifts($wgUser->getName() );
			
			$text =	'<style type="text/css">/*<![CDATA[*/ @import "'.$wgScriptPath.'/extensions/wikia/UserGifts/css/usergifts.css?'.$wgStyleVersion.'"; /*]]>*/</style>'."\n";
			$wgOut->addScript($text);
			
			if(!$this->gift_id)
			{
				$wgOut->setPagetitle( wfMsg('woopserrormsg') );
				$wgOut->addHTML("<p class=\"user-message\">".wfMsg('invalid_link')."</p>");
				return false;
			}
			if ($rel->doesUserOwnGift($wgUser->getID(), $this->gift_id) == false)
			{
				$wgOut->setPagetitle( wfMsg('woopserrormsg') );
				$wgOut->addHTML("<p class=\"user-message\">".wfMsg('usernotowngift')."</p>");
				return false;	
			}
			
			$gift = $rel->getUserGift($this->gift_id);
			if ($wgRequest->wasPosted() && $_SESSION["alreadysubmitted"] == false)
			{
				$_SESSION["alreadysubmitted"] = true;
				if ($rel->doesUserOwnGift($wgUser->getID(), $this->gift_id) == true)
				{
					$wgMemc->delete( wfMemcKey( 'gifts', 'profile', $wgUser->getID() ) );
					$rel->deleteGift($this->gift_id);
				}
				$gift_image = "<img src=\"".$wgGiftImagePath."/" . Gifts::getGiftImage($gift["gift_id"],"l") . "\" border=\"0\" alt=\"".wfMsg('gift')."\" />";
			
				$out .= $wgOut->setPagetitle( wfMsg('gift_remove_successfully', $gift["name"]) );
				$out .= "<div class=\"gift-links\"><a href=\"" . Title::makeTitle(NS_USER_PROFILE, $wgUser->getName())->getLocalURL() . "\">< ".wfMsg('backtoprofilepage')."</a></div>
				<div class=\"give-gift-image\">{$gift_image}</div>
				<div class=\"give-gift-info\" style=\"width:400px;\">
				<p class=\"give-gift-message\">".wfMsg('gift_remove_successfully', $gift["name"])."\"</p>
				</div>
				<div class=\"cleared\" style=\"margin:0px 0px 15px 0px;\"></div>
				<div class=\"give-gift-buttons\">							
				<input type=\"button\" value=\"".wfMsg('home')."\" size=\"20\" onclick=\"window.location='index.php?title=Main_Page'\" />
				<input type=\"button\" value=\"".wfMsg('viewyourgiftlist')."\" size=\"20\" onclick=\"window.location='index.php?title=Special:ViewGifts&user={$wgUser->getName()}'\" />
				<input type=\"button\" value=\"".wfMsg('your_user_page')."\" size=\"20\" onclick=\"window.location='index.php?title=User:{$wgUser->getName()}'\" />
				</div>";				
				
				$wgOut->addHTML($out);
			}
			else
			{
				$_SESSION["alreadysubmitted"] = false;
				$wgOut->addHTML($this->displayForm());
			}
		}
	
		function displayForm()
		{
			global $wgUser, $wgOut, $wgGiftImagePath, $wgImageCommonPath;
			
			$rel = new UserGifts($wgUser->getName() );
			$gift = $rel->getUserGift($this->gift_id);
			$user =  Title::makeTitle( NS_USER  , $gift["user_name_from"]  );
			#---
			$avatar = new WikiaAvatar($gift["user_id_from"],"s");
			#---
			$avatar_img = $avatar->getAvatarImageTag("s");
			$gift_image = "<img src=\"".$wgGiftImagePath . "/" . Gifts::getGiftImage($gift["gift_id"],"l") . "\" border=\"0\" alt=\"".wfMsg('gift')."\" />";
			
			$form =  "";
			$form .= $wgOut->setPagetitle( wfMsg('removegift') );
			$form .= "<form action=\"\" method=\"post\" enctype=\"multipart/form-data\" name=\"form1\">
		   	<div class=\"gift-links\">
		   	<a href=\"" . Title::makeTitle(NS_USER_PROFILE, $wgUser->getName())->getLocalURL() . "\">< ".wfMsg('backtoprofilepage')."</a>
		   	- <a href=\"index.php?title=Special:ViewGifts&user={$wgUser->getName()}\">".wfMsg('viewyourgiftlist')."</a>
			</div>
		   	<div class=\"give-gift-message\">".wfMsg('confirmremovegift', $gift["name"])."</div>
		   	<div class=\"give-gift-image\">{$gift_image}</div>
			<div class=\"give-gift-info\" style=\"width:400px;\">
			<p class=\"give-gift-name\">{$gift["name"]}</p>
			<p class=\"individual-gift-from\">from: $avatar_img <a href=\"{$user->getFullURL()}\">{$gift["user_name_from"]}</a></p>";
			if ($gift["message"]) 
			{
				$form .= "<p class=\"individual-gift-message\"><img src=\"".$wgImageCommonPath."/quoteIcon.png\" border=\"0\" alt=\"\"/> {$gift["message"]} <img src=\"".$wgImageCommonPath."/endQuoteIcon.png\" border=\"0\" alt=\"\"/></p>";
			}
			$form .= "</div>
			<div class=\"cleared\" style=\"margin:0px 0px 15px 0px;\"></div>
			<div class=\"give-gift-buttons\">
			<input type=\"hidden\" name=\"user\" value=\"" . addslashes($this->user_name_to) . "\">
			<input type=\"button\" value=\"".wfMsg('removebtn')."\" size=\"20\" onclick=\"document.form1.submit()\" />
			<input type=\"button\" value=\"".wfMsg('cancel')."\" size=\"20\" onclick=\"history.go(-1)\" />
			</div>
			</form>";
			return $form;
		}
	}

	SpecialPage::addPage( new RemoveGift );
	global $wgMessageCache,$wgOut;
	$wgMessageCache->addMessage( 'addrelationship', 'add user relationship' );
}

?>
