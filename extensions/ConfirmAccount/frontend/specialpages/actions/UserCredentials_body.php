<?php

class UserCredentialsPage extends SpecialPage {

	protected $target, $file;

	function __construct() {
		parent::__construct( 'UserCredentials', 'lookupcredentials' );
	}

	public function userCanExecute( User $user ) {
		global $wgConfirmAccountSaveInfo;
		return $wgConfirmAccountSaveInfo && parent::userCanExecute( $user );
	}

	function execute( $par ) {
		$out = $this->getOutput();
		$request = $this->getRequest();
		$reqUser = $this->getUser();

		if ( !$this->userCanExecute( $this->getUser() ) ) {
			throw new PermissionsError( 'lookupcredentials' );
		}

		$this->setHeaders();

		# A target user
		$this->target = $request->getText( 'target' );
		# Attachments
		$this->file = $request->getVal( 'file' );

		if ( $this->file ) {
			$this->showFile( $this->file );
		} elseif ( $this->target ) {
			$this->showForm();
			$this->showCredentials();
		} else {
			$this->showForm();
		}
		$out->addModules( 'ext.confirmAccount' ); // CSS
	}

	function showForm() {
		global $wgScript;
		$out = $this->getOutput();

		$username = str_replace( '_', ' ', $this->target );
		$form = Xml::openElement( 'form', array( 'name' => 'stablization', 'action' => $wgScript, 'method' => 'get' ) );
		$form .= "<fieldset><legend>" . wfMsg( 'usercredentials-leg' ) . "</legend>";
		$form .= "<table><tr>";
		$form .= "<td>" . Html::Hidden( 'title', $this->getTitle()->getPrefixedText() ) . "</td>";
		$form .= "<td>" . wfMsgHtml( "usercredentials-user" ) . "</td>";
		$form .= "<td>" . Xml::input( 'target', 35, $username, array( 'id' => 'wpUsername' ) ) . "</td>";
		$form .= "<td>" . Xml::submitButton( wfMsg( 'go' ) ) . "</td>";
		$form .= "</tr></table>";
		$form .= "</fieldset></form>\n";

		$out->addHTML( $form );
	}

	function showCredentials() {
		$reqUser = $this->getUser();
		$out = $this->getOutput();

		$titleObj = SpecialPage::getTitleFor( 'UserCredentials' );

		$row = $this->getAccountData();
		if ( !$row ) {
			$out->addHTML( wfMsgHtml( 'usercredentials-badid' ) );
			return;
		}

		$out->addWikiText( wfMsg( "usercredentials-text" ) );

		$user = User::newFromName( $this->target );

		$list = array();
		foreach ( $user->getGroups() as $group )
			$list[] = self::buildGroupLink( $group );

		$grouplist = '';
		if ( count( $list ) > 0 ) {
			$grouplist = '<tr><td>' . wfMsgHtml( 'usercredentials-member' ) . '</td><td>' . implode( ', ', $list ) . '</td></tr>';
		}

		$form  = "<fieldset>";
		$form .= '<legend>' . wfMsgHtml( 'usercredentials-leg-user' ) . '</legend>';
		$form .= '<table cellpadding=\'4\'>';
		$form .= "<tr><td>" . wfMsgHtml( 'username' ) . "</td>";
		$form .= "<td>" . Linker::makeLinkObj( $user->getUserPage(), htmlspecialchars( $user->getUserPage()->getText() ) ) . "</td></tr>\n";

		$econf = $row->acd_email_authenticated ? ' <strong>' . wfMsgHtml( 'confirmaccount-econf' ) . '</strong>' : '';
		$form .= "<tr><td>" . wfMsgHtml( 'usercredentials-email' ) . "</td>";
		$form .= "<td>" . htmlspecialchars( $row->acd_email ) . $econf . "</td></tr>\n";

		$form .= $grouplist;

		$form .= '</table></fieldset>';

		$areaSet = UserAccountRequest::expandAreas( $row->acd_areas );

		$userAreas = ConfirmAccount::getUserAreaConfig();
		if ( count( $userAreas ) > 0 ) {
			$form .= '<fieldset>';
			$form .= '<legend>' . wfMsgHtml( 'confirmaccount-leg-areas' ) . '</legend>';

			$form .= "<div style='height:150px; overflow:scroll; background-color:#f9f9f9;'>";
			$form .= "<table cellspacing='5' cellpadding='0' style='background-color:#f9f9f9;'><tr valign='top'>";
			$count = 0;

			$att = array( 'disabled' => 'disabled' );
			foreach ( $userAreas as $name => $conf ) {
				$count++;
				if ( $count > 5 ) {
					$form .= "</tr><tr valign='top'>";
					$count = 1;
				}
				$formName = "wpArea-" . htmlspecialchars( str_replace( ' ', '_', $name ) );
				if ( $conf['project'] != '' ) {
					$pg = Linker::link( Title::newFromText( $name ),
						wfMsgHtml( 'requestaccount-info' ), array(), array(), "known" );
				} else {
					$pg = '';
				}
				$form .= "<td>" .
					Xml::checkLabel( $name, $formName, $formName, in_array( $formName, $areaSet ), $att ) .
					" {$pg}</td>\n";
			}
			$form .= "</tr></table></div>";
			$form .= '</fieldset>';
		}

		$form .= '<fieldset>';
		$form .= '<legend>' . wfMsgHtml( 'usercredentials-leg-person' ) . '</legend>';
		$form .= '<table cellpadding=\'4\'>';
		$form .= "<tr><td>" . wfMsgHtml( 'usercredentials-real' ) . "</td>";
		$form .= "<td>" . htmlspecialchars( $row->acd_real_name ) . "</td></tr>\n";
		$form .= '</table>';
		$form .= "<p>" . wfMsgHtml( 'usercredentials-bio' ) . "</p>";
		$form .= "<p><textarea tabindex='1' readonly='readonly' name='wpBio' id='wpNewBio' rows='10' cols='80' style='width:100%'>" .
			htmlspecialchars( $row->acd_bio ) .
			"</textarea></p>\n";
		$form .= '</fieldset>';

		$form .= '<fieldset>';
		$form .= '<legend>' . wfMsgHtml( 'usercredentials-leg-other' ) . '</legend>';

		global $wgAccountRequestExtraInfo ;

		if( $wgAccountRequestExtraInfo ) {
			$form .= '<p>' . wfMsgHtml( 'usercredentials-attach' ) . ' ';
			if ( $row->acd_filename ) {
				$form .= Linker::makeKnownLinkObj( $titleObj, htmlspecialchars( $row->acd_filename ),
					'file=' . $row->acd_storage_key );
			} else {
				$form .= wfMsgHtml( 'confirmaccount-none-p' );
			}
			$form .= "</p><p>" . wfMsgHtml( 'usercredentials-notes' ) . "</p>\n";
			$form .= "<p><textarea tabindex='1' readonly='readonly' name='wpNotes' id='wpNotes' rows='3' cols='80' style='width:100%'>" .
				htmlspecialchars( $row->acd_notes ) .
				"</textarea></p>\n";
			$form .= "<p>" . wfMsgHtml( 'usercredentials-urls' ) . "</p>\n";
			$form .= ConfirmAccountsPage::parseLinks( $row->acd_urls );
		}

		if ( $reqUser->isAllowed( 'requestips' ) ) {
			$form .= "<p>" . wfMsgHtml( 'usercredentials-ip' ) . " " . htmlspecialchars( $row->acd_ip ) . "</p>\n";
		}
		$form .= '</fieldset>';

		$out->addHTML( $form );
	}

	/**
	 * Format a link to a group description page
	 *
	 * @param string $group
	 * @return string
	 */
	private static function buildGroupLink( $group ) {
		static $cache = array();
		if ( !isset( $cache[$group] ) )
			$cache[$group] = User::makeGroupLinkHtml( $group, User::getGroupMember( $group ) );
		return $cache[$group];
	}

	/**
	 * Show a private file requested by the visitor.
	 * @param $key string
	 * @return void
	 */
	function showFile( $key ) {
		global $wgConfirmAccountFSRepos;
		$out = $this->getOutput();
		$request = $this->getRequest();

		$out->disable();

		# We mustn't allow the output to be Squid cached, otherwise
		# if an admin previews a private image, and it's cached, then
		# a user without appropriate permissions can toddle off and
		# nab the image, and Squid will serve it
		$request->response()->header( 'Expires: ' . gmdate( 'D, d M Y H:i:s', 0 ) . ' GMT' );
		$request->response()->header( 'Cache-Control: no-cache, no-store, max-age=0, must-revalidate' );
		$request->response()->header( 'Pragma: no-cache' );

		$repo = new FSRepo( $wgConfirmAccountFSRepos['accountcreds'] );
		$path = $repo->getZonePath( 'public' ) . '/' .
			UserAccountRequest::relPathFromKey( $key );

		$repo->streamFile( $path );
	}

	function getAccountData() {
		$uid = User::idFromName( $this->target );
		if ( !$uid )
			return false;
		# For now, just get the first revision...
		$dbr = wfGetDB( DB_SLAVE );
		$row = $dbr->selectRow( 'account_credentials', '*',
			array( 'acd_user_id' => $uid ),
			__METHOD__,
			array( 'ORDER BY' => 'acd_user_id,acd_id ASC' ) );
		return $row;
	}
}
