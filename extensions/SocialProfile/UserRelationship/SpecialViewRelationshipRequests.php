<?php
/**#@+
 * A special page for viewing open relationship requests for the current logged in user
 *
 * @package MediaWiki
 * @subpackage SpecialPage
 *
 * @author David Pean <david.pean@gmail.com>
 * @copyright Copyright © 2007, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

class SpecialViewRelationshipRequests extends SpecialPage {
	function __construct() {
		wfLoadExtensionMessages( 'SocialProfileUserRelationship' );
		parent::__construct( "ViewRelationshipRequests" );
	}

	function execute( $params ) {
		global $wgUser, $wgOut, $wgTitle, $wgRequest, $IP, $wgStyleVersion, $wgUserRelationshipScripts;

		/**
		* Redirect Non-logged in users to Login Page
		* It will automatically return them to the ViewRelationshipRequests page
		*/
		if($wgUser->getID() == 0){
			$wgOut->setPagetitle( "Woops!" );
			$login = Title::makeTitle(NS_SPECIAL, "UserLogin");
			$wgOut->redirect( $login->getFullURL('returnto=Special:ViewRelationshipRequests') );
			return false;
		}

		$wgOut->addScript("<script type=\"text/javascript\" src=\"{$wgUserRelationshipScripts}/UserRelationship.js?{$wgStyleVersion}\"></script>\n");
		$wgOut->addScript("<link rel='stylesheet' type='text/css' href=\"{$wgUserRelationshipScripts}/UserRelationship.css?{$wgStyleVersion}\"/>\n");

		$rel = new UserRelationship($wgUser->getName() );
		$friend_request_count = $rel->getOpenRequestCount($wgUser->getID(), 1);
		$foe_request_count = $rel->getOpenRequestCount($wgUser->getID(), 2);

		if (count($_POST) && $_SESSION["alreadysubmitted"] == false) {
			$_SESSION["alreadysubmitted"] = true;
			$rel->addRelationshipRequest($this->user_name_to, $this->relationship_type, $_POST["message"]);
			$out = "<br /><span class=\"title\">" . wfMsg( 'ur-already-submitted' ) . "</span><br /><br />";
			$wgOut->addHTML($out);
		} else {
			$_SESSION["alreadysubmitted"] = false;
			$output = "";
			$plural="";

			$output .= $wgOut->setPagetitle( wfMsg("ur-requests-title") );
			$requests = $rel->getRequestList(0);

			if ($requests) {

				foreach ($requests as $request) {

					if ($request["type"]=="Foe") {
						$label = wfMsg("ur-foe");
					} else {
						$label = wfMsg("ur-friend");
					}

					$user_from = Title::makeTitle(NS_USER, $request["user_name_from"]);
					$avatar = new wAvatar($request["user_id_from"], "l");
					$avatar_img = $avatar->getAvatarURL();

					$message = $wgOut->parse( trim($request["message"]), false );

					$output .= "<div class=\"relationship-action black-text\" id=\"request_action_{$request["id"]}\">
					  	{$avatar_img}
						".wfMsg('ur-requests-message', $user_from->escapeFullURL(), $request["user_name_from"], $label);
						if ($request["message"]) {
							$output .= "<div class=\"relationship-message\">\"{$message}\"</div>";
						}
						$output .= "<div class=\"cleared\"></div>
						<div class=\"relationship-buttons\">
							<input type=\"button\" class=\"site-button\" value=\"".wfMsg("ur-accept")."\" onclick=\"javascript:requestResponse(1,{$request["id"]})\">
							<input type=\"button\" class=\"site-button\" value=\"".wfMsg("ur-reject")."\" onclick=\"javascript:requestResponse(-1,{$request["id"]})\">
						</div>
					</div>";
				}
			} else {

				$invite_link = Title::makeTitle(NS_SPECIAL, "InviteContacts");
				$output = wfMsg("ur-no-requests-message", $invite_link->escapeFullURL());
			}
			$wgOut->addHTML($output);
		}
	}
}
