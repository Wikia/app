<?php
/**
 * A special page for removing existing friends/foes for the current logged in user
 *
 * Example URL: /index.php?title=Special:RemoveRelationship&user=Awrigh01
 *
 * @file
 * @ingroup Extensions
 * @author David Pean <david.pean@gmail.com>
 * @copyright Copyright © 2007, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 */

class SpecialRemoveRelationship extends UnlistedSpecialPage {

	/**
	 * Constructor -- set up the new special page
	 */
	public function __construct() {
		parent::__construct( 'RemoveRelationship' );
	}

	/**
	 * Show the special page
	 *
	 * @param $params Mixed: parameter(s) passed to the page or null
	 */
	public function execute( $params ) {
		global $wgUser, $wgOut, $wgRequest, $wgUserRelationshipScripts;

		// Can't use $this->setHeaders(); here because then it'll set the page
		// title to <removerelationship> and we don't want that, we'll be
		// messing with the page title later on in the code
		$wgOut->setArticleRelated( false );
		$wgOut->setRobotPolicy( 'noindex,nofollow' );

		$wgOut->addExtensionStyle( $wgUserRelationshipScripts . '/UserRelationship.css' );

		$usertitle = Title::newFromDBkey( $wgRequest->getVal( 'user' ) );
		if ( !$usertitle ) {
			$wgOut->setPageTitle( wfMsgHtml( 'ur-error-title' ) );
			$wgOut->addWikiText( wfMsgNoTrans( 'ur-add-no-user' ) );
			return false;
		}

		$this->user_name_to = $usertitle->getText();
		$this->user_id_to = User::idFromName( $this->user_name_to );
		$this->relationship_type = UserRelationship::getUserRelationshipByID(
			$this->user_id_to,
			$wgUser->getID()
		);

		if ( $this->relationship_type == 1 ) {
			$confirmTitle = wfMsg( 'ur-remove-relationship-title-confirm-friend', $this->user_name_to );
			$confirmMsg = wfMsg( 'ur-remove-relationship-message-confirm-friend', $this->user_name_to );
			$error = wfMsg( 'ur-remove-error-not-loggedin-friend' );
			$pending = wfMsg( 'ur-remove-error-message-pending-friend-request', $this->user_name_to );
		} else {
			$confirmTitle = wfMsg( 'ur-remove-relationship-title-confirm-foe', $this->user_name_to );
			$confirmMsg = wfMsg( 'ur-remove-relationship-message-confirm-foe', $this->user_name_to );
			$error = wfMsg( 'ur-remove-error-not-loggedin-foe' );
			$pending = wfMsg( 'ur-remove-error-message-pending-foe-request', $this->user_name_to );
		}

		$out = '';
		if ( $wgUser->getID() == $this->user_id_to ) {
			$wgOut->setPageTitle( wfMsg( 'ur-error-title' ) );
			$out .= '<div class="relationship-error-message">' .
				wfMsg( 'ur-remove-error-message-remove-yourself' ) .
			'</div>
			<div>
				<input type="button" class="site-button" value="' . wfMsg( 'ur-main-page' ) . '" size="20" onclick=\'window.location="index.php?title=' . wfMsgForContent( 'mainpage' ) . '"\' />';
			if ( $wgUser->isLoggedIn() ) {
				$out .= '<input type="button" class="site-button" value="' . wfMsg( 'ur-your-profile' ) . '" size="20" onclick=\'window.location="' . $wgUser->getUserPage()->escapeFullURL() . '"\' />';
			}
			$out .= '</div>';

			$wgOut->addHTML( $out );
		} elseif ( $this->relationship_type == false ) {
			$wgOut->setPageTitle( wfMsg( 'ur-error-title' ) );
			$out .= '<div class="relationship-error-message">' .
				wfMsg( 'ur-remove-error-message-no-relationship', $this->user_name_to ) .
			'</div>
			<div>
				<input type="button" class="site-button" value="' . wfMsg( 'ur-main-page' ) . '" size="20" onclick=\'window.location="index.php?title="' . wfMsgForContent( 'mainpage' ) . '"\' />';
			if ( $wgUser->isLoggedIn() ) {
				$out .= '<input type="button" class="site-button" value="' . wfMsg( 'ur-your-profile' ) . '" size="20" onclick=\'window.location="' . $wgUser->getUserPage()->escapeFullURL() . '"\' />';
			}
			$out .= '</div>';

			$wgOut->addHTML( $out );
		} elseif ( UserRelationship::userHasRequestByID( $this->user_id_to, $wgUser->getID() ) == true ) {
			$wgOut->setPageTitle( wfMsg( 'ur-error-title' ) );
			$out .= '<div class="relationship-error-message">' .
				$pending .
				'</div>
			<div>
				<input type="button" class="site-button" value="' . wfMsg( 'ur-main-page' ) . '" size="20" onclick=\'window.location="index.php?title="' . wfMsgForContent( 'mainpage' ) . '"\' />';
			if ( $wgUser->isLoggedIn() ) {
				$out .= '<input type="button" class="site-button" value="' . wfMsg( 'ur-your-profile' ) . '" size="20" onclick=\'window.location="' . $wgUser->getUserPage()->escapeFullURL() . '"\' />';
			}
			$out .= '</div>';

			$wgOut->addHTML( $out );
		} elseif ( $wgUser->getID() == 0 ) {
			$wgOut->setPageTitle( wfMsg( 'ur-error-title' ) );
			$out .= '<div class="relationship-error-message">' .
				$error .
			'</div>
			<div>
				<input type="button" class="site-button" value="' . wfMsg( 'ur-main-page' ) . '" size="20" onclick=\'window.location="index.php?title="' . wfMsgForContent( 'mainpage' ) . '"\' />';
			if ( $wgUser->isLoggedIn() ) {
				$out .= '<input type="button" class="site-button" value="' . wfMsg( 'ur-your-profile' ) . '" size="20" onclick=\'window.location="' . $wgUser->getUserPage()->escapeFullURL() . '"\' />';
			}
			$out .= '</div>';

			$wgOut->addHTML( $out );
		} else {
			$rel = new UserRelationship( $wgUser->getName() );
	 		if ( $wgRequest->wasPosted() && $_SESSION['alreadysubmitted'] == false ) {
				$_SESSION['alreadysubmitted'] = true;
				$rel->removeRelationshipByUserID(
					$this->user_id_to,
					$wgUser->getID()
				);
				$rel->sendRelationshipRemoveEmail(
					$this->user_id_to,
					$wgUser->getName(),
					$this->relationship_type
				);
				$avatar = new wAvatar( $this->user_id_to, 'l' );

				$wgOut->setPageTitle( $confirmTitle );

				$out .= "<div class=\"relationship-action\">
					{$avatar->getAvatarURL()}" .
					$confirmMsg .
					"<div class=\"relationship-buttons\">
						<input type=\"button\" class=\"site-button\" value=\"" . wfMsg( 'ur-main-page' ) . "\" size=\"20\" onclick=\"window.location='index.php?title=" . wfMsgForContent( 'mainpage' ) . "'\"/>
						<input type=\"button\" class=\"site-button\" value=\"" . wfMsg( 'ur-your-profile' ) . "\" size=\"20\" onclick=\"window.location='" . $wgUser->getUserPage()->escapeFullURL() . "'\"/>
					</div>
					<div class=\"cleared\"></div>
					</div>";

				$wgOut->addHTML( $out );
			} else {
				$_SESSION['alreadysubmitted'] = false;
				$wgOut->addHTML( $this->displayForm() );
			}

		}
	}

	/**
	 * Displays the form for removing a friend or a foe
	 * @return $form Mixed: HTML code for the form
	 */
	function displayForm() {
		global $wgOut;

		$avatar = new wAvatar( $this->user_id_to, 'l' );

		if ( $this->relationship_type == 1 ) {
			$title = wfMsg( 'ur-remove-relationship-title-friend', $this->user_name_to );
			$remove = wfMsg( 'ur-remove-relationship-message-friend', $this->user_name_to, wfMsg( 'ur-remove' ) );
		} else {
			$title = wfMsg( 'ur-remove-relationship-title-foe', $this->user_name_to );
			$remove = wfMsg( 'ur-remove-relationship-message-foe', $this->user_name_to, wfMsg( 'ur-remove' ) );
		}
		$wgOut->setPageTitle( $title );

		$form = "<form action=\"\" method=\"post\" enctype=\"multipart/form-data\" name=\"form1\">
			<div class=\"relationship-action\">
			{$avatar->getAvatarURL()}" .
			$remove .
			'<div class="relationship-buttons">
				<input type="hidden" name="user" value="' . addslashes( $this->user_name_to ) . '" />
				<input type="button" class="site-button" value="' . wfMsg( 'ur-remove' ) . '" size="20" onclick="document.form1.submit()" />
				<input type="button" class="site-button" value="' . wfMsg( 'ur-cancel' ) . '" size="20" onclick="history.go(-1)" />
			</div>
			<div class="cleared"></div>
			</div>

		</form>';

		return $form;
	}
}
