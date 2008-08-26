<?php

$wgExtensionFunctions[] = 'wfSpecialViewGifts';


function wfSpecialViewGifts()
{
	global $wgUser,$IP;
	include_once("$IP/includes/SpecialPage.php");


	class ViewGifts extends SpecialPage
	{
		function ViewGifts()
		{
			global $wgMessageCache;
			global $wgGiftImageUploadPath, $wgGiftImagePath, $wgUploadDirectory, $wgUploadPath;

			SpecialPage::SpecialPage("ViewGifts","",false);

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
			global $wgUser, $wgOut, $wgRequest, $IP, $wgGiftImagePath, $wgAvatarPath;
			global $wgImageCommonPath, $wgScriptPath, $wgStyleVersion;

			require_once("$IP/extensions/wikia/UserGifts/UserGiftsClass.php");
			require_once("$IP/extensions/wikia/UserGifts/GiftsClass.php");
			require_once("$IP/extensions/wikia/UserRelationship/UserRelationshipClass.php");

			/**/
			/* INSERT TEST DATA
			**/
			/*
			$dbr =& wfGetDB( DB_MASTER );
			$sql = "SELECT user_id, user_name from user where user_name <> 'Pean' limit 0,700";
			$res = $dbr->query($sql);
			while ($row = $dbr->fetchObject( $res ) ) {

			$fname = __METHOD__;
			$dbr->insert( '`user_gift`',
			array(
				'ug_gift_id' => rand(0,20),
				'ug_user_id_from' => $row->user_id,
				'ug_user_name_from' => $row->user_name,
				'ug_user_id_to' => 66574,
				'ug_user_name_to' => "Pean",
				'ug_type' => 0,
				'ug_message' => "test"
				), $fname
			);
			}
			exit();
			 */
			/**/
			/* END TEST DATA
			**/


			$output = "";
			$user_name = $wgRequest->getVal('user');
			$page =  $wgRequest->getVal('page');

			/*/
			/* Redirect Non-logged in users to Login Page
			/* It will automatically return them to the ViewGifts page
			/*/
			if ($wgUser->getID() == 0 && $user_name=="")
			{
				$wgOut->setPagetitle( wfMsg('woopserror') );
				$login =  Title::makeTitle( NS_SPECIAL  , "UserLogin"  );
				$wgOut->redirect( $login->getLocalURL("returnto=Special:ViewGifts") );
				return false;
			}

			/*/
			/* If no user is set in the URL, we assume its the current user
			/*/
			if (!$user_name)
				$user_name = $wgUser->getName();
			$user_id = User::idFromName($user_name);
			$user = Title::makeTitle( NS_USER  , $user_name  );

			$text =	'<style type="text/css">/*<![CDATA[*/ @import "'.$wgScriptPath.'/extensions/wikia/UserGifts/css/usergifts.css?'.$wgStyleVersion.'"; /*]]>*/</style>'."\n";
			$wgOut->addHTML($text);

			/*/
			/* Error message for username that does not exist (from URL)
			/*/
			if ($user_id == 0)
			{
				$wgOut->setPagetitle( wfMsg('woopserror') );
				$wgOut->addHTML("<p class=\"user-message\">".wfMsg('user_view_not_exist')."</p>");
				return false;
			}

			/*/
			/* Config for the page
			/*/
			$per_page = 10;
			if (!$page) $page=1;
			$per_row = 2;

			/*
			Get all Gifts for this user into the array
			*/
			$rel = new UserGifts($user_name);

			$gifts = $rel->getUserGiftList(0,$per_page,$page);
			$total = $rel->getGiftCountByUsername($user_name); // count($relationships);

			$relationship = UserRelationship::getUserRelationshipByID($user_id,$wgUser->getID());

			/*
			show gift count for user
			*/

			if (!($wgUser->getName() == $user_name))
			{
				$output .= $wgOut->setPagetitle( wfMsg('user_gift_list', $rel->user_name) );
			}
			else
			{
				$output .= $wgOut->setPagetitle( wfMsg('your_gift_list') );
			}
			$output .= '<div class="gift-links">';
			if (!($wgUser->getName() == $user_name))
			{
				$output .= "<a href=\"" . Title::makeTitle(NS_USER_PROFILE, $rel->user_name)->getLocalURL() . "\">< ".wfMsg('user_profile_page', $rel->user_name)."</a>";
			}
			else
			{
				$output .= "<a href=\"" . Title::makeTitle(NS_USER_PROFILE, $rel->user_name)->getLocalURL() . "\">< ".wfMsg('yourprofile')."</a>";
			}
			if (!($wgUser->getName() == $user_name))
			{
				$output .= " - <span class=\"profile-on\"><a href=\"/index.php?title=Special:GiveGift&user={$rel->user_name}\">".wfMsg('give_user_gift', $rel->user_name)."</a></span>";
			}
			if (($relationship==false)  && (!($wgUser->getName() == $user_name)))
			{
				$output .= " - <a href=\"/index.php?title=Special:AddRelationship&user={$rel->user_name}&rel_type=1\">".wfMsg('friend_text')." {$rel->user_name}</a>";
				#$output .= " - <a href=\"/index.php?title=Special:AddRelationship&user={$rel->user_name}&rel_type=2\">".wfMsg('foe_text')." {$rel->user_name}</a>";
			}
			if ( $wgUser->isLoggedIn() && (!($wgUser->getName() == $user_name)))
			{
				$output .= " - <a href=\"/index.php?title=Special:ViewGifts&user={$wgUser->getName()}\">".wfMsg('view_all_your_gifts')."</a>";
			}
			$output .= "</div>";
			$output .= "<div class=\"gift-count\">";

			if ($wgUser->getName() == $user_name)
			{
				$rel->clearAllUserGiftStatus();
				if ($total==1) {
					$output .= wfMsg('youhaveonegift');
					$output .= "<br />".wfMsg("moreyougiftgive");
				}
				else {
					$output .= wfMsg('youhavemoregift', $total);
					$output .= "<br />".wfMsg("moreyougiftgive");
				}
			}
			else
			{
				if ($total==1)
					$output .= wfMsg('userhaveonegift', $rel->user_name);
				else
					$output .= wfMsg('userhavemoregift', $rel->user_name, $total);
			}
			$output .= "</div>";

			if($gifts)
			{
				$x = 1;
				foreach ($gifts as $gift)
				{
					$user_from =  Title::makeTitle( NS_USER  , $gift["user_name_from"]  );
					$avatar = new WikiaAvatar($gift["user_id_from"]);
					$avatar_img = $avatar->getAvatarImageTag("s");
					$gift_image = "<img src=\"".$wgGiftImagePath."/" . Gifts::getGiftImage($gift["gift_id"],"l") . "\" border=\"0\" alt=\"".wfMsg('gift')."\" />";

					$output .= "<div class=\"user-gift\">
					<div class=\"gift-image\"><a href=\"/index.php?title=Special:ViewGift&gift_id={$gift["id"]}\">{$gift_image}</a></div>
					<div class=\"gift-info\">
					<p><b><a href=\"/index.php?title=Special:ViewGift&gift_id={$gift["id"]}\">{$gift["gift_name"]}</a></b>" . (($gift["status"] == 1)?" <span class=\"profile-on\">".wfMsg('new_gift')."</span>":"") . "</p>
					<p>".wfMsg('from_gift').": $avatar_img <a href=\"{$user_from->getFullURL()}\">{$gift["user_name_from"]}</a></p>
					<p class=\"give-gift-link\"><img src=\"".$wgImageCommonPath."/giftIcon.png\" border=\"0\"/> <a href=\"/index.php?title=Special:GiveGift&gift_id={$gift["gift_id"]}\">".wfMsg('give_gift_someone')."</a></p>";

					if($rel->user_id==$wgUser->getID())
					{
						$output .= "<p class=\"give-gift-link\"><a href=\"/index.php?title=Special:RemoveGift&gift_id={$gift["id"]}\">(".wfMsg('remove_gift').")</a></p>";
					}
					$output .= "</div><div class=\"cleared\"></div>";
					$output .= "</div>";
					if ($x==count($gifts) || $x!=1 && $x%$per_row ==0)
						$output .= "<div class=\"cleared\"></div>";

					$x++;
				}
			}

			/**/
			/*BUILD NEXT/PREV NAV
			**/
			$numofpages = $total / $per_page;

			if ($numofpages>1)
			{
				$output .= "<div class=\"page-nav\">";
				if ($page > 1)
				{
					$output .= "<a href=\"/index.php?title=Special:ViewGifts&user={$user->getText()}&page=" . ($page-1) . "\">".wfMsg('imgmultipageprev')."</a> ";
				}

				if (($total % $per_page) != 0)
				{
					$numofpages++;
				}
				if ($numofpages >=9)
				{
					$numofpages=9+$page;
				}

				for ($i = 1; $i <= $numofpages; $i++)
				{
					if ($i == $page)
					{
					    $output .=($i." ");
					}
					else
					{
						$output .="<a href=\"/index.php?title=Special:ViewGifts&user={$user->getText()}&page=$i\">$i</a> ";
					}
				}

				if (($total - ($per_page * $page)) > 0)
				{
					$output .=" <a href=\"/index.php?title=Special:ViewGifts&user={$user->getText()}&page=" . ($page+1) . "\">".wfMsg('imgmultipagenext')."</a>";
				}
				$output .= "</div>";
			}
			/**/
			/*BUILD NEXT/PREV NAV
			**/

			$wgOut->addHTML($output);
		}
	}

	SpecialPage::addPage( new ViewGifts );
	global $wgMessageCache,$wgOut;
}

?>
