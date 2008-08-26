<?php

///$wgExtensionFunctions[] = 'wfSpecialGiftManager';

$wgSpecialPages['GiftManager'] = array('SpecialPage','GiftManager','giftmanage');
$wgAvailableRights[] = 'giftmanage';
$wgGroupPermissions['staff']['giftmanage'] = true;
$wgGroupPermissions['sysop']['giftmanage'] = true;

function wfSpecialGiftManager()
{
	global $wgUser,$IP;
	#---
	include_once("$IP/includes/SpecialPage.php");

	class GiftManager extends SpecialPage
	{
		function GiftManager()
		{
			global $wgMessageCache;
			global $wgGiftImageUploadPath, $wgGiftImagePath, $wgUploadDirectory, $wgUploadPath;

			UnlistedSpecialPage::UnlistedSpecialPage("GiftManager");

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
			global $wgUser, $wgOut, $wgRequest, $wgSiteView, $IP, $wgLogTypes;
			global $wgScriptPath, $wgStyleVersion;

			require_once("$IP/extensions/wikia/UserGifts/GiftsClass.php");

			$text =	'<style type="text/css">/*<![CDATA[*/ @import "'.$wgScriptPath.'/extensions/wikia/UserGifts/css/usergifts.css?'.$wgStyleVersion.'"; /*]]>*/</style>'."\n";
			$wgOut->addHTML($text);

			if (! in_array('staff',($wgUser->getGroups())) )
			{
				if (! in_array('sysop',($wgUser->getGroups())) )
				{
					$wgOut->addHTML("<p class=\"user-message\">".wfMsg('invalidpage')."</p>");
					return;
				}
			}
			$wgOut->setPagetitle( wfMsg('gifts_manager') );
			$css = "<style>
			.view-form {font-weight:800;font-size:12px;font-color:#666666}
			.view-status {font-weight:800;font-size:12px;background-color:#FFFB9B;color:#666666;padding:5px;margin-bottom:5px;}
			</style>";
			$wgOut->addHTML($css);

	 		if (count($_POST)) #--- count($_POST)? what is that?
	 		{
				if( !($_POST["id"]) )
				{
                    if (!empty($_POST["gift_name"])) { #--- very lame error handler
                        $gift_id = Gifts::addGift(htmlspecialchars($_POST["gift_name"]),htmlspecialchars($_POST["gift_description"]));
                        $wgOut->addHTML("<span class='user-message'>".wfMsg('gift_created')."</span><br /><br />");
                    }
                    else {
                        $wgOut->setPagetitle( wfMsg('woopserrormsg') );
                        $wgOut->addHTML("<p class=\"user-message\">".wfMsg('invalid_link')."</p>");
                    }
				}
				else
				{
					$gift_id = htmlspecialchars($_POST["id"]);
					Gifts::updateGift($gift_id,htmlspecialchars($_POST["gift_name"]),htmlspecialchars($_POST["gift_description"]));
					$wgOut->addHTML("<span class='user-message'>".wfMsg('gift_saved')."</span><br /><br />");
				}

				if (!in_array('gift', $wgLogTypes))
				{
					$wgLogTypes[] = 'gift';
				}

				$userText = $wgUser->getName();
				$giftTitle = Title::newFromText( "GiftManager", NS_SPECIAL );

				$logPage = new LogPage( 'gift' );
				$logComment = "Add/change text for gift ({$gift_id}) [[Special:ViewGift&gift_id={$gift_id}]] by {$userText}";
				$logPage->addEntry( 'gift', $giftTitle, $logComment);

				$wgOut->addHTML($this->displayForm($gift_id));
			}
			else
			{
				$gift_id = $wgRequest->getVal( 'id' );
				if ($gift_id || $wgRequest->getVal( 'method' )=="edit")
				{
					$wgOut->addHTML($this->displayForm($gift_id));
				}
				else
				{
					$wgOut->addHTML("<div class=\"gift-links\"><b><a href=\"/index.php?title=Special:GiftManager&method=edit\">+ ".wfMsg('addnewgift')."</a></b></div>");
					$wgOut->addHTML("<div class=\"cleared\"></div>");
					$wgOut->addHTML($this->displayGiftList());
				}
			}
		}

		function displayGiftList()
		{
			global $wgRequest;
			global $wgGiftImagePath;
			#---
			$output = "";
			$page =  $wgRequest->getVal('page');
			if(!$page)$page=1;
			$per_page = 12;
			$per_row = 3;
			#---
			$total = Gifts::getGiftCount();
			#---
			$gifts = Gifts::getGiftList($per_page,$page,"gift_name");
			if ($gifts)
			{
				$loop=1;
				foreach ($gifts as $gift)
				{
					$gift_image = "<img src=\"".$wgGiftImagePath."/" . Gifts::getGiftImage($gift["id"],"m") . "\" border=\"0\" alt=\"".wfMsg('gift')."\" />";
					$output .= "<div class=\"user-gift-manager\" >
					<div class=\"gift-info-manager\"><a href=\"/index.php?title=Special:GiftManager&amp;id={$gift["id"]}\">{$gift["gift_name"]}</a></div>
					<div class=\"cleared\"></div>
					<div class=\"gift-image-manager\">{$gift_image}</div>
					<div class=\"cleared\"></div>
					</div>";

					if ($loop == count($gifts) || $loop != 1 && $loop % $per_row == 0)
					{
						$output .= "<div class=\"cleared\"></div>";
					}
					$loop++;
				}
			}

			/**/
			/*BUILD NEXT/PREV NAV
			**/
			$numofpages = $total / $per_page;

			if($numofpages>1)
			{
				$output .= "<div class=\"page-nav\">";
				if ($page > 1)
				{
					$output .= "<a href=\"/index.php?title=Special:GiftManager&page=" . ($page-1) . "\">".wfMsg('imgmultipageprev')."</a> ";
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
					    $output .= "<a href=\"/index.php?title=Special:GiftManager&page=$i\">$i</a> ";
					}
				}

				if (($total - ($per_page * $page)) > 0)
				{
					$output .= " <a href=\"/index.php?title=Special:GiftManager&page=" . ($page+1) . "\">".wfMsg('imgmultipagenext')."</a>";
				}

				$output .= "</div>";
			}
			/**/
			/*BUILD NEXT/PREV NAV
			**/

			return "<div id=\"gift\">" . $output . "</div>";
		}

		function displayForm($gift_id)
		{
			global $wgGiftImagePath;

			$form = "<div class=\"gift-links\"><b><a href=\"/index.php?title=Special:GiftManager\">".wfMsg('viewgiftlist')."</a></b></div>";

			$gift = array("gift_name"=>"", "gift_description"=>"", "gift_id"=>"");
			if ($gift_id)
			{
				$gift = Gifts::getGift($gift_id);
			}

			$form .=  '<form action="" method="POST" enctype="multipart/form-data" name="gift">';
			$form .= '<table border="0" cellpadding="5" cellspacing="0" width="500">';
			$form .=  '<tr>
			<td width="200" class="give-gift-message">'.wfMsg('giftname').'</td>
			<td width="695"><input type="text" size="45" class="createbox" name="gift_name" value="'. htmlspecialchars($gift["gift_name"]) . '"/></td>
			</tr>
			<tr>
			<td width="200" class="give-gift-message" valign="top">'.wfMsg('giftdescription').'</td>
			<td width="695"><textarea class="createbox" name="gift_description" rows="2" cols="30">'. htmlspecialchars($gift["gift_description"]) . '</textarea></td>
			</tr>';

			if($gift_id)
			{
				$gift_img = $wgGiftImagePath."/" . Gifts::getGiftImage($gift_id,"l");
				$gift_image = "";
				if (file_exists($gift_img))
				{
					$gift_image = "<img src=\"".$gift_img."\" border=\"0\" alt=\"".wfMsg('gift')."\" />";
				}
				$form .=  '<tr>
				<td width="200" class="view-form" valign="top">'.wfMsg('giftimage').'</td>
				<td width="695">' . $gift_image . '
				<p>
				<a href="/index.php?title=Special:GiftManagerLogo&gift_id=' . $gift_id . '">'.wfMsg('addreplaceimg').'</a>
				</td>
				</tr>';
			}

			$form .=  '<tr>
			<td colspan="2" class="give-gift-buttons">
			<input type=hidden name="id" value="' . $gift["gift_id"] . '">
			<input type="button" value="' . (($gift["gift_id"]) ? wfMsg('editgift') : wfMsg('creategift')) . '" size="20" onclick="document.gift.submit()" />
			<input type="button" value="'.wfMsg('cancel').'" size="20" onclick="history.go(-1)" />
			</td>
			</tr>
			</table>

			</form>';
			return $form;
		}
	}

	//SpecialPage::addPage( new GiftManager );
	global $wgMessageCache,$wgOut;
	//$wgMessageCache->addMessage( 'viewmanager', 'just a test extension' );
	$giftManager = new GiftManager();
	$giftManager->execute();
}

?>
