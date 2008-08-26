<?php

define('REL_FRIEND', 1);
define('REL_FOE',    2);

$wgExtensionFunctions[] = 'wfSpecialViewRelationships';

function wfSpecialViewRelationships(){
	global $wgUser,$IP;
	#---
	include_once("$IP/includes/SpecialPage.php");

	class ViewRelationships extends SpecialPage
	{
		const PER_PAGE = 24;
		const PER_ROW = 2;

		function ViewRelationships()
		{
			global $wgMessageCache;
			SpecialPage::SpecialPage("ViewRelationships","",false);

			require_once ( dirname( __FILE__ ) . '/UserRelationship.i18n.php' );
			foreach( efSpecialUserReplationship() as $lang => $messages )
			{
				$wgMessageCache->addMessages( $messages, $lang );
			}
		}

		function execute()
		{
			global $wgMessageCache, $wgImageCommonPath;
			global $wgUser, $wgOut, $wgRequest, $IP;
			global $wgScriptPath, $wgStyleVersion;

			require_once("$IP/extensions/wikia/UserRelationship/UserRelationshipClass.php");

			$output = "";
			/*/
			/* Get querystring variables
			/*/
			$user_name = $wgRequest->getVal('user');
			$rel_type = $wgRequest->getVal('rel_type');
			$page =  $wgRequest->getVal('page');

			$text =	'<style type="text/css">/*<![CDATA[*/ @import "'.$wgScriptPath.'/extensions/wikia/UserRelationship/css/relationship.css?'.$wgStyleVersion.'"; /*]]>*/</style>'."\n";
			$wgOut->addHTML($text);

			/*/
			/* Redirect Non-logged in users to Login Page
			/* It will automatically return them to the ViewGifts page
			/*/
			if ( ($wgUser->getID() == 0) && ($user_name=="") )
			{
				$wgOut->setPagetitle( wfMsg('woopserror') );
				$login =  Title::makeTitle( NS_SPECIAL  , "UserLogin"  );
				$wgOut->redirect( $login->getFullURL("returnto=Special:ViewRelationships") );
				return false;
			}


			/*/
			/* Set up config for page / default values
			/*/
			if ( !$page )
			{
				$page=1;
			}
			if ( !$rel_type )
			{
				$rel_type = REL_FRIEND;
			}

			/*/
			/* If no user is set in the URL, we assume its the current user
			/*/
			if (!$user_name)
			{
				$user_name = $wgUser->getName();
			}
			$user_id = User::idFromName($user_name);
			$user =  Title::makeTitle( NS_USER  , $user_name  );

			/*/
			/* Error message for username that does not exist (from URL)
			/*/
			/* FIXME In WikiaUserProfile.php there are two copies of this code. */
			if ($user_id == 0)
			{
				$wgOut->setPagetitle( wfMsg('woops_wrong_turn') );
				$out .= "<div class=\"relationship-request-message\">".wfMsg('user_not_exist')."</div>";
				$out .= "<div class=\"relationship-request-buttons\">";
				$out .= "<input type=\"button\" value=\"".wfMsg('home')."\" onclick=\"window.location='/index.php?title=Main_Page'\"/>";
				if ( $wgUser->isLoggedIn() )
				{
					$out .= " <input type=\"button\" value=\"".wfMsg('your_user_page')."\" onclick=\"window.location='/index.php?title=User:{$wgUser->getName()}'\"/>";
				}
			  	$out .= "</div>";
				$wgOut->addHTML($out);
				return false;
			}

			/*
			Get all relationships
			*/
			$text =	'<style type="text/css">/*<![CDATA[*/ @import "'.$wgScriptPath.'/extensions/wikia/UserRelationship/css/userprofile.css?'.$wgStyleVersion.'"; /*]]>*/</style>'."\n";
			$text .=	'<style type="text/css">/*<![CDATA[*/ @import "'.$wgScriptPath.'/extensions/wikia/UserRelationship/css/avatar.css?'.$wgStyleVersion.'"; /*]]>*/</style>'."\n";
			$wgOut->addHTML($text);

			$rel = new UserRelationship($user_name);

			$relationships = $rel->getRelationshipList($rel_type,self::PER_PAGE,$page);
			$rel_count = UserRelationship::getRelationshipCountByUsername($rel->user_name); // count($relationships);
			$friend_count = $rel_count["friend_count"];
			$foe_count = $rel_count["foe_count"];

			if (!($wgUser->getName() == $user_name))
			{
				if (REL_FRIEND == $rel_type)
				{
					$output .= $wgOut->setPagetitle( wfMsg('user_friend_list', $rel->user_name) );
				}
				else
				{
					$output .= $wgOut->setPagetitle( wfMsg('user_foe_list', $rel->user_name) );
				}
			}
			else
			{
				$output .= $wgOut->setPagetitle( wfMsg('your_friend_list') );
				// why there is no your_foe_list here ?
			}

			#---
			$userAvatar = new WikiaAvatar($user_id, "l");
			#---

			$output .= '<div class="user-feed-title">
			<span class="user-image-avatar">' . $userAvatar->getAvatarImageLink("l", 0 /*nolinks*/ ) . '</span>';

			/*
			 * additional user menu
			 */
			$output .= '<span class="user-feed-menu"><div>';

			if ($wgUser->getName() == $rel->user_name)
			{
				$output .= "<a href=\"" . Title::makeTitle(NS_USER_PROFILE, $rel->user_name)->getLocalURL() . "\">".wfMsg('yourprofile')."</a>";
				$output .= " - <a href=\"" . Title::makeTitle(NS_USER, $rel->user_name)->getLocalURL() . "\">".wfMsg('your_user_page')."</a>";
			}
			else
			{
				$output .= "<a href=\"" . Title::makeTitle(NS_USER_PROFILE, $rel->user_name)->getLocalURL() . "\">".wfMsg('user_profile_page', $rel->user_name)."</a>";
				$user_menu = $rel->getUserPageMenu($rel->user_name);
				if (!empty($user_menu))
				{
					$output .= " - ".$user_menu;
				}
				//$output .= " - <a href=\"" . Title::makeTitle(NS_USER, $wgUser->getName())->getLocalURL() . "\">Your User Page</a>";
				$output .= " - <a href=\"" . Title::makeTitle(NS_USER, $rel->user_name)->getLocalURL() . "\">".wfMsg('selected_user_page', $rel->user_name)."</a>";
			}
			$output .= "</div></span></div>";

			/*
			show friend/foe count for user
			*/
			$label = (REL_FRIEND == $rel_type) ? wfMsg('friend_text') : wfMsg('foe_text');

			$total = (REL_FRIEND == $rel_type) ? $friend_count : $foe_count;
			$output .= "<div class=\"friend-message\">";

			if ($wgUser->getName() == $user_name)
			{
				if (REL_FRIEND == $rel_type)
				{
					if ($friend_count==1)
					{
						$output .= wfMsg('you_have_one_friend');
					}
					else
					{
						$output .= wfMsg('you_have_more_friends', $friend_count);
					}
				}
				else
				{
					if ($foe_count==1)
					{
						$output .= wfMsg('you_have_one_foe');
					}
					else
					{
						$output .= wfMsg('you_have_more_foes', $foe_count);
					}
				}
			}
			else
			{
				if (REL_FRIEND == $rel_type)
				{
					if ($friend_count==1)
					{
						$output .= wfMsg('user_have_one_friend', $rel->user_name);
					}
					else
					{
						$output .= wfMsg('user_have_more_friends', $rel->user_name, $friend_count);
					}
				}
				else
				{
					if ($foe_count==1)
					{
						$output .= wfMsg('user_have_one_foe', $rel->user_name);
					}
					else
					{
						$output .= wfMsg('user_have_more_foes', $rel->user_name, $foe_count);
					}
				}
			}

			if (REL_FRIEND == $rel_type)
			{
				$output .= wfMsg('wantmorefriends')." <a href='/index.php?title=Special:InviteContacts'>".wfMsg('invitethem')."</a>.";
			} else
			{
				$output .= wfMsg('wantmorefoes')." <a href='/index.php?title=Special:InviteContacts'>".wfMsg('startwar')."</a>.";
			}
			$output .= "</div>";

			if($relationships)
			{
				$x = 1;
				foreach ($relationships as $relationship)
				{
					$indivRelationship = UserRelationship::getUserRelationshipByID($relationship["user_id"],$wgUser->getID());

					$user =  Title::makeTitle( NS_USER_PROFILE , $relationship["user_name"]  );
					$avatar = new WikiaAvatar($relationship["user_id"],"l");
					$avatar_img = $avatar->getAvatarImageTag("l");
					$output .= "<div class=\"relationship-item\">
				    <div class=\"relationship-image\"><a href=\"{$user->getFullURL()}\">{$avatar_img}</a></div>
			      	<div class=\"relationship-info\">
			      	<p class=\"relationship-name\"><a href=\"{$user->getFullURL()}\">{$relationship["user_name"]}</a></p>";

					if ($indivRelationship === false) {
						$output .= "<p class=\"relationship-link\">
						<a href=\"/index.php?title=Special:AddRelationship&user={$relationship["user_name"]}&rel_type=" . REL_FRIEND . "\"><img src=\"".$wgImageCommonPath."/friendRequestIcon.png\" border=\"0\" alt=\"".wfMsg('addasfriend')."\"/> ".ucfirst(wfMsg('addasfriend'))."</a>
						</p>";
						$output .= "<p class=\"relationship-link\"><a href=\"/index.php?title=Special:AddRelationship&user={$relationship["user_name"]}&rel_type=" . REL_FOE . "\"><img src=\"".$wgImageCommonPath."/foeRequestIcon.png\" border=\"0\" alt=\"".wfMsg('addasfoe')."\"/> ".ucfirst(wfMsg('addasfoe'))."</a></p>";
						$output .= "<div class=\"cleared\"></div>";
					}
					$output .= "<p class=\"relationship-link\"><a href=\"/index.php?title=Special:GiveGift&user={$relationship["user_name"]}\"><img src=\"".$wgImageCommonPath."/icon_package_get.gif\" border=\"0\" alt=\"".wfMsg('giveusergift')."\"/> ".wfMsg('giveusergift')."</a></p>";
					$output .= "<p class=\"relationship-link\"></p>";
					#$output .= "<a href=\"#\"><img src=\"".$wgImageCommonPath."/challengeIcon.png\" border=\"0\" alt=\"issue challenge\"/> issue challenge</a>";
					$output .= "<div class=\"cleared\"></div>";

					if($user_name == $wgUser->getName())
					{
						$output .= " <p class=\"relationship-remove\"><a href=\"/index.php?title=Special:RemoveRelationship&amp;user={$user->getText()}\">(".wfMsg('delete_relationship', $label).")</a></p>";
					}

					$output .= "<div class=\"cleared\"></div></div>";

					$output .= "</div>";
					if($x==count($relationships) || $x!=1 && $x%self::PER_ROW ==0)
					{
						$output .= "<div class=\"cleared\"></div>";
					}
					$x++;
				}
			}

			/**/
			/*BUILD NEXT/PREV NAV
			**/
			$numofpages = $total / self::PER_PAGE;

			if($numofpages>1)
			{
				$output .= "<div class=\"page-nav\">";
				if($page > 1)
				{
					$output .= "<a href=\"/index.php?title=Special:ViewRelationships&rel_type={$rel_type}&page=" . ($page-1) . "\">".wfMsg('imgmultipageprev')."</a> ";
				}

				if (($total % self::PER_PAGE) != 0)
				{
					$numofpages++;
				}
				if ($numofpages >=9)
				{
					$numofpages=9+$page;
				}

				for($i = 1; $i <= $numofpages; $i++)
				{
					if ($i == $page)
					{
					    $output .=($i." ");
					}
					else
					{
					    $output .="<a href=\"/index.php?title=Special:ViewRelationships&rel_type={$rel_type}&page=$i\">$i</a> ";
					}
				}

				if (($total - (self::PER_PAGE * $page)) > 0)
				{
					$output .=" <a href=\"/index.php?title=Special:ViewRelationships&rel_type={$rel_type}&page=" . ($page+1) . "\">".wfMsg('imgmultipagenext')."</a>";
				}
				$output .= "</div>";
			}

			/**/
			/*BUILD NEXT/PREV NAV
			**/
			$wgOut->addHTML($output);
		}
	}

	SpecialPage::addPage( new ViewRelationships );
	global $wgMessageCache,$wgOut;
}

?>
