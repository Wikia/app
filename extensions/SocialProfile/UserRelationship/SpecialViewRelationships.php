<?php
/**#@+
 * A special page for viewing all relationships by type
 * Example URL: index.php?title=Special:ViewRelationships&user=Pean&rel_type=1 (viewing friends)
 * Example URL: index.php?title=Special:ViewRelationships&user=Pean&rel_type=2 (viewing foes)
 *
 * @package MediaWiki
 * @subpackage SpecialPage
 *
 * @author David Pean <david.pean@gmail.com>
 * @copyright Copyright © 2007, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

class SpecialViewRelationships extends SpecialPage {
	function __construct() {
		wfLoadExtensionMessages( 'SocialProfileUserRelationship' );
		parent::__construct( "ViewRelationships" );
	}

	function execute( $params ) {
		global $wgUser, $wgOut, $wgRequest, $IP, $wgUserRelationshipScripts, $wgStyleVersion;

		$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"{$wgUserRelationshipScripts}/UserRelationship.css?{$wgStyleVersion}\"/>\n");

		$output = "";

		/**
		* Get querystring variables
		*/
		$user_name = $wgRequest->getVal('user');
		$rel_type = $wgRequest->getVal('rel_type');
		$page =  $wgRequest->getVal('page');

		/**
		* Redirect Non-logged in users to Login Page
		* It will automatically return them to the ViewGifts page
		*/
		if($wgUser->getID() == 0 && $user_name==""){
			$wgOut->setPagetitle( "Woops!" );
			$login = Title::makeTitle(NS_SPECIAL,"UserLogin");
			$wgOut->redirect( $login->escapeFullURL('returnto=Special:ViewRelationships'));
			return false;
		}

		/**
		* Set up config for page / default values
		*/
		if(!$page || !is_numeric($page) )$page=1;
		if(!$rel_type || !is_numeric($rel_type) )$rel_type = 1;
		$per_page = 50;
		$per_row = 2;

		/**
		* If no user is set in the URL, we assume its the current user
		*/
		if(!$user_name)$user_name = $wgUser->getName();
		$user_id = User::idFromName($user_name);
		$user = Title::makeTitle(NS_USER, $user_name);

		/**
		* Error message for username that does not exist (from URL)
		*/
		if($user_id == 0){
			$wgOut->setPagetitle( wfMsg('ur-error-title') );
			$out .= "<div class=\"relationship-error-message\">
				".wfMsg("ur-error-message-no-user")."
			</div>
			<div class=\"relationship-request-buttons\">
				<input type=\"button\" class=\"site-button\" value=\"".wfMsg('ur-main-page')."\" onclick=\"window.location='index.php?title=Main_Page'\"/>";
				if($wgUser->isLoggedIn())$out .= " <input type=\"button\" class=\"site-button\" value=\"".wfMsg('ur-your-profile')."\" onclick=\"window.location='".$wgUser->getUserPage()->escapeFullURL() . "'\"/>";
		  	$out .= "</div>";
			$wgOut->addHTML($out);
			return false;
		}

		/**
		* Get all relationships
		*/

		$rel = new UserRelationship($user_name);
		$relationships = $rel->getRelationshipList($rel_type, $per_page, $page);

		$stats = new UserStats($rel->user_id, $rel->user_name);
		$stats_data = $stats->getUserStats();
		$friend_count = $stats_data["friend_count"];
		$foe_count = $stats_data["foe_count"];

		if ($rel_type==1) {
		    $output .= $wgOut->setPagetitle( wfMsg( 'ur-title-friend', $rel->user_name ) );
			$total = $friend_count;
			$label = wfMsg('ur-friend');
		} else {
		    $output .= $wgOut->setPagetitle( wfMsg( 'ur-title-foe', $rel->user_name ) );
			$total = $foe_count;
			$label = wfMsg('ur-foe');
		}

		$back_link = Title::makeTitle(NS_USER,$rel->user_name);
		$invite_contacts_link = Title::makeTitle(NS_SPECIAL,"InviteContacts");

		$output .= "<div class=\"back-links\">
			<a href=\"".$back_link->escapeFullURL()."\">".wfMsg('ur-backlink',$rel->user_name)."</a>
		</div>
		<div class=\"relationship-count\">".
			wfMsgExt('ur-relationship-count', 'parsemag', $rel->user_name, $total, $label, $invite_contacts_link->escapeFullURL()).
		"</div>";

		if ($relationships) {

			$x = 1;

			foreach ($relationships as $relationship) {

				$indivRelationship = UserRelationship::getUserRelationshipByID($relationship["user_id"],$wgUser->getID());

				//safetitles
				$user =  Title::makeTitle(NS_USER, $relationship["user_name"]);
				$add_relationship_link = Title::makeTitle(NS_SPECIAL,"AddRelationship");
				$remove_relationship_link = Title::makeTitle(NS_SPECIAL,"RemoveRelationship");
				$give_gift_link = Title::makeTitle(NS_SPECIAL, "GiveGift");

				$avatar = new wAvatar($relationship["user_id"],"ml");

				$avatar_img = $avatar->getAvatarURL();

				$user_safe = urlencode($relationship["user_name"]);

				$username_length = strlen($relationship["user_name"]);
				$username_space = stripos($relationship["user_name"], ' ');

				if (($username_space == false || $username_space >= "30") && $username_length > 30){
					$user_name_display = substr($relationship["user_name"], 0, 30)." ".substr($relationship["user_name"], 30, 50);
				}
				else {
					$user_name_display = $relationship["user_name"];
				};

				$output .= "<div class=\"relationship-item\">
					<a href=\"{$user->escapeFullURL()}\">{$avatar_img}</a>
					<div class=\"relationship-info\">
						<div class=\"relationship-name\">
							<a href=\"{$user->escapeFullURL()}\">{$user_name_display}</a>
						</div>
					<div class=\"relationship-actions\">";
				if ($indivRelationship == false) {
					$output .= "<a href=\"".$add_relationship_link->escapeFullURL('user='.$user_safe.'&rel_type=1')."\">".wfMsg("ur-add-friend")."</a> |
						<a href=\"".$add_relationship_link->escapeFullURL('user='.$user_safe.'&rel_type=2')."\">".wfMsg("ur-add-foe")."</a> | ";
				} else if ($user_name == $wgUser->getName()) {
							$output .= "<a href=\"".$remove_relationship_link->escapeFullURL('user='.$user_safe)."\">".wfMsg("ur-remove-relationship", ucfirst($label))."</a> ";
				}

				 $output .= "</div>
					<div class=\"cleared\"></div>
				</div>";

				$output .= "</div>";
				 if($x==count($relationships) || $x!=1 && $x%$per_row ==0)$output .= "<div class=\"cleared\"></div>";
				$x++;
			}
		}

		/**
		* Build next/prev nav
		*/
		$total = intval(str_replace(",", "", $total));
		$numofpages = $total / $per_page;

		$page_link = Title::makeTitle(NS_SPECIAL,"ViewRelationships");

		if($numofpages>1) {
			$output .= "<div class=\"page-nav\">";
			if($page>1) {
				$output .= "<a href=\"".$page_link->escapeFullURL('user='.$user_name.'&rel_type='.$rel_type.'&page='.($page-1))."\">".wfMsg("ur-previous")."</a> ";
			}

			if(($total % $per_page) != 0)$numofpages++;
			if($numofpages >=9 && $page < $total)$numofpages=9+$page;
			if($numofpages >= ($total / $per_page) )$numofpages = ($total / $per_page)+1;

			for($i = 1; $i <= $numofpages; $i++){
				if($i == $page) {
				    $output .=($i." ");
				} else {
				    $output .="<a href=\"".$page_link->escapeFullURL('user='.$user_name.'&rel_type='.$rel_type.'&page='.$i)."\">$i</a> ";
				}
			}

			if(($total - ($per_page * $page)) > 0){
				$output .=" <a href=\"".$page_link->escapeFullURL('user='.$user_name.'&rel_type='.$rel_type.'&page='.($page+1))."\">".wfMsg("ur-next")."</a>";
			}
			$output .= "</div>";
		}
		/**
		* Build next/prev nav
		*/

		$wgOut->addHTML($output);
	}
}
