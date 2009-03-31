<?php
/**
 * A special page for adding friends/foe requests for existing users in the wiki
 *
 * Example URL: index.php?title=Special:AddRelationship&user=Pean&rel_type=1 (for adding as friend)
 * Example URL: index.php?title=Special:AddRelationship&user=Pean&rel_type=2 (for adding as foe)
 *
 * @file
 * @ingroup Extension
 * @author David Pean <david.pean@gmail.com>
 * @copyright Copyright © 2007, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

class SpecialAddRelationship extends UnlistedSpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'AddRelationship' );
	}

	/**
	 * Show the special page
	 *
	 * @param $params Mixed: parameter(s) passed to the page or null
	 */
	public function execute( $params ) {
		global $wgUser, $wgOut, $wgRequest, $wgUploadPath, $wgUserRelationshipScripts;

		wfLoadExtensionMessages( 'SocialProfileUserRelationship' );
		$this->setHeaders();

		$wgOut->addStyle( '../..' . $wgUserRelationshipScripts . '/UserRelationship.css' );

		$usertitle = Title::newFromDBkey( $wgRequest->getVal('user') );

		if( !$usertitle ){
			$wgOut->addWikiText( wfMsgNoTrans( 'ur-add-no-user' ) );
			return false;
		}

		$user = Title::makeTitle( NS_USER, $usertitle->getText() );

		$this->user_name_to = $usertitle->getText();
		$this->user_id_to = User::idFromName($this->user_name_to);
		$this->relationship_type = $wgRequest->getVal('rel_type');
		if( !$this->relationship_type || !is_numeric($this->relationship_type) ) $this->relationship_type = 1;

		if( ($wgUser->getID()== $this->user_id_to) && ($wgUser->getID() != 0) ) {
			$out .= $wgOut->setPagetitle( wfMsg('ur-error-title') );
			$out .= '<div class="relationship-error-message">
				'.wfMsg('ur-add-error-message-yourself').'
			</div>
			<div>
				<input type="button" class="site-button" value="'.wfMsg('ur-main-page').'" size="20" onclick=\'window.location="index.php?title="' . wfMsgForContent( 'mainpage' ) . '"\' />';
			 	if( $wgUser->isLoggedIn() ){
					$out.= '<input type="button" class="site-button" value="'.wfMsg('ur-your-profile').'" size="20" onclick=\'window.location="'.$wgUser->getUserPage()->escapeFullURL() . '"\' />';
				}
			$out .= '</div>';

			$wgOut->addHTML($out);

		} else if( $wgUser->isBlocked() ) {
			$out .= $wgOut->setPagetitle( wfMsg('ur-error-title') );
			$out .= '<div class="relationship-error-message">
				'.wfMsg('ur-add-error-message-blocked').'
			</div>
			<div>
				<input type="button" class="site-button" value="'.wfMsg('ur-main-page').'" size="20" onclick=\'window.location="index.php?title="' . wfMsgForContent( 'mainpage' ) . '"\' />';
			 	if( $wgUser->isLoggedIn() ){
					$out.= '<input type="button" class="site-button" value="'.wfMsg('ur-your-profile').'" size="20" onclick=\'window.location="'.$wgUser->getUserPage()->escapeFullURL() . '"\' />';
				}
			$out .= '</div>';

			$wgOut->addHTML($out);

		} else if( $this->user_id_to == 0 ) {
			$out .= $wgOut->setPagetitle( wfMsg('ur-error-title') );
			$out .= '<div class="relationship-error-message">
				'.wfMsg('ur-add-error-message-no-user').'
			</div>
			<div>
				<input type="button" class="site-button" value="'.wfMsg('ur-main-page').'" size="20" onclick=\'window.location="index.php?title="' . wfMsgForContent( 'mainpage' ) . '"\' />';
				if( $wgUser->isLoggedIn() ){
					$out.= '<input type="button" class="site-button" value="'.wfMsg('ur-your-profile').'" size="20" onclick=\'window.location="'.$wgUser->getUserPage()->escapeFullURL() . '"\' />';
				}
			$out .= '</div>';

			$wgOut->addHTML($out);

		} else if( UserRelationship::getUserRelationshipByID( $this->user_id_to, $wgUser->getID() ) >=1 ){

			if( UserRelationship::getUserRelationshipByID( $this->user_id_to, $wgUser->getID() ) == 1 ) {
				$error = wfMsg('ur-add-error-message-existing-relationship-friend', $this->user_name_to);
			} else {
				$error = wfMsg('ur-add-error-message-existing-relationship-foe', $this->user_name_to);
			}

			$avatar = new wAvatar($this->user_id_to, 'l');
			$avatar_img = '<img src="'.$wgUploadPath.'/avatars/' . $avatar->getAvatarImage() . '" alt="" border="0" />';

			$out = '';
			$out .= $wgOut->setPagetitle( wfMsg('ur-error-title') );

			$out .= "<div class=\"relationship-action\">
				{$avatar_img}
				".$error."
				<div class=\"relationship-buttons\">
					<input type=\"button\" class=\"site-button\" value=\"".wfMsg('ur-main-page')."\" size=\"20\" onclick=\"window.location='index.php?title=" . wfMsgForContent( 'mainpage' ) . "'\"/>
					<input type=\"button\" class=\"site-button\" value=\"".wfMsg('ur-your-profile')."\" size=\"20\" onclick=\"window.location='".$wgUser->getUserPage()->escapeFullURL() . "'\"/>
				</div>
				<div class=\"cleared\"></div>
			</div>";

			$wgOut->addHTML($out);

		} else if( UserRelationship::userHasRequestByID( $this->user_id_to, $wgUser->getID() ) == true ){

			if( $this->relationship_type == 1 ) {
				$error = wfMsg('ur-add-error-message-pending-friend-request', $this->user_name_to);
			} else {
				$error = wfMsg('ur-add-error-message-pending-foe-request', $this->user_name_to);
			}

			$avatar = new wAvatar($this->user_id_to, 'l');
			$avatar_img = '<img src="'.$wgUploadPath.'/avatars/' . $avatar->getAvatarImage() . '" alt="" border="0" />';

			$out = '';
			$out .= $wgOut->setPagetitle( wfMsg('ur-add-error-message-pending-request-title') );
			$out .= "<div class=\"relationship-action\">
				{$avatar_img}
				".$error."
				<div class=\"relationship-buttons\">
					<input type=\"button\" class=\"site-button\" value=\"".wfMsg('ur-main-page')."\" size=\"20\" onclick=\"window.location='index.php?title=" . wfMsgForContent( 'mainpage' ) . "'\"/>
					<input type=\"button\" class=\"site-button\" value=\"".wfMsg('ur-your-profile')."\" size=\"20\" onclick=\"window.location='".$wgUser->getUserPage()->escapeFullURL() . "'\"/>
				</div>
				<div class=\"cleared\"></div>
			</div>";

			$wgOut->addHTML($out);
		} else if( UserRelationship::userHasRequestByID( $wgUser->getID(), $this->user_id_to ) == true ) {
			$relationship_request = SpecialPage::getTitleFor( 'ViewRelationshipRequests' );
			$wgOut->redirect( $relationship_request->getFullURL() );
		} else if( $wgUser->getID() == 0 ){
			$login_link = SpecialPage::getTitleFor( 'UserLogin' );

			if( $this->relationship_type == 1) {
				$error = wfMsg('ur-add-error-message-not-loggedin-friend');
			} else {
				$error = wfMsg('ur-add-error-message-not-loggedin-foe');
			}

			$out = '';
			$out .= $wgOut->setPagetitle( wfMsg('ur-error-title') );
			$out .= '<div class="relationship-error-message">
				'.$error.'
			</div>
			<div>
				<input type="button" class="site-button" value="'.wfMsg('ur-main-page').'" size="20" onclick=\'window.location="index.php?title="' . wfMsgForContent( 'mainpage' ) . '"\' />
				<input type="button" class="site-button" value="'.wfMsg('ur-login').'" size="20" onclick="window.location="'.$login_link->escapeFullURL() . '""/>';
			$out .= '</div>';

			$wgOut->addHTML($out);
		} else {
			$rel = new UserRelationship( $wgUser->getName() );

			if( $wgRequest->wasPosted() && $_SESSION['alreadysubmitted'] == false ) {
				$_SESSION['alreadysubmitted'] = true;
				$rel = $rel->addRelationshipRequest( $this->user_name_to, $this->relationship_type, $wgRequest->getVal('message') );

				$avatar = new wAvatar($this->user_id_to, 'l');
				$avatar_img = '<img src="'.$wgUploadPath.'/avatars/' . $avatar->getAvatarImage() . '" alt="" border="0" />';

				$out = '';

				if( $this->relationship_type == 1 ){
					$out .= $wgOut->setPagetitle( wfMsg('ur-add-sent-title-friend', $this->user_name_to) );
					$sent = wfMsg('ur-add-sent-message-friend', $this->user_name_to);
				} else {
					$out .= $wgOut->setPagetitle( wfMsg('ur-add-sent-title-foe', $this->user_name_to) );
					$sent = wfMsg('ur-add-sent-message-foe', $this->user_name_to);
				}

				$out .= "<div class=\"relationship-action\">
					{$avatar_img}
					".$sent."
					<div class=\"relationship-buttons\">
						<input type=\"button\" class=\"site-button\" value=\"".wfMsg('ur-main-page')."\" size=\"20\" onclick=\"window.location='index.php?title=" . wfMsgForContent( 'mainpage' ) . "'\"/>
						<input type=\"button\" class=\"site-button\" value=\"".wfMsg('ur-your-profile')."\" size=\"20\" onclick=\"window.location='".$wgUser->getUserPage()->escapeFullURL() . "'\"/>
					</div>
					<div class=\"cleared\"></div>
				</div>";

				$wgOut->addHTML($out);
			} else {
				$_SESSION['alreadysubmitted'] = false;
				$wgOut->addHTML( $this->displayForm() );
			}
		}
	}

	function displayForm() {
		global $wgOut, $wgUser, $wgUploadPath;
		wfLoadExtensionMessages( 'SocialProfileUserRelationship' );

		$form = '';

		if( $this->relationship_type == 1 ) {
			$form .= $wgOut->setPagetitle( wfMsg('ur-add-title-friend', $this->user_name_to) );
			$add = wfMsg('ur-add-message-friend', $this->user_name_to);
			$button = wfMsg('ur-add-button-friend');
		} else {
			$form .= $wgOut->setPagetitle( wfMsg('ur-add-title-foe', $this->user_name_to) );
			$add = wfMsg('ur-add-message-foe', $this->user_name_to);
			$button = wfMsg('ur-add-button-foe');
		}

		$avatar = new wAvatar($this->user_id_to, 'l');
		$avatar_img = '<img src="'.$wgUploadPath.'/avatars/' . $avatar->getAvatarImage() . '" alt="" border="0" />';

		$user_link = Title::makeTitle( NS_USER, $this->user_name_to );

		$form .= "<form action=\"\" method=\"post\" enctype=\"multipart/form-data\" name=\"form1\">
			<div class=\"relationship-action\">
			{$avatar_img}
			".$add."
			<div class=\"cleared\"></div>
			</div>
			<div class=\"relationship-textbox-title\">
			".wfMsg('ur-add-personal-message')."
			</div>
			<textarea name=\"message\" id=\"message\" rows=\"3\" cols=\"50\"></textarea>
			<div class=\"relationship-buttons\">
			<input type=\"button\" class=\"site-button\" value=\"".$button."\" size=\"20\" onclick=\"document.form1.submit()\" />
			<input type=\"button\" class=\"site-button\" value=\"".wfMsg('ur-cancel')."\" size=\"20\" onclick=\"history.go(-1)\" />
			</div>
			</form>";
		return $form;
	}
}