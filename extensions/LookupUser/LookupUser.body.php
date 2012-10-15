<?php
/**
 * Provides the special page to look up user info
 *
 * @file
 */
class LookupUserPage extends SpecialPage {

	/**
	 * Constructor
	 */
	public function __construct() {
		parent::__construct( 'LookupUser'/*class*/, 'lookupuser'/*restriction*/ );
	}

	function getDescription() {
		return wfMsg( 'lookupuser' );
	}

	/**
	 * Show the special page
	 *
	 * @param $subpage Mixed: parameter passed to the page or null
	 */
	public function execute( $subpage ) {
		global $wgRequest, $wgUser;

		$this->setHeaders();

		# If the user doesn't have the required 'lookupuser' permission, display an error
		if ( !$wgUser->isAllowed( 'lookupuser' ) ) {
			$this->displayRestrictionError();
			return;
		}

		if ( $subpage ) {
			$target = $subpage;
		} else {
			$target = $wgRequest->getText( 'target' );
		}

		$this->showForm( $target );

		if ( $target ) {
			$emailUser = $wgRequest->getText( 'email_user' );
			$this->showInfo( $target, $emailUser );
		}
	}

	/**
	 * Show the LookupUser form
	 * @param $target Mixed: user whose info we're about to look up
	 */
	function showForm( $target ) {
		global $wgScript, $wgOut;
		$title = htmlspecialchars( $this->getTitle()->getPrefixedText() );
		$action = htmlspecialchars( $wgScript );
		$target = htmlspecialchars( $target );
		$ok = wfMsg( 'go' );
		$username = wfMsg( 'username' );
		$inputformtop = wfMsg( 'lookupuser' );

		$wgOut->addWikiMsg( 'lookupuser-intro' );

		$wgOut->addHTML( <<<EOT
<fieldset>
<legend>$inputformtop</legend>
<form method="get" action="$action">
<input type="hidden" name="title" value="{$title}" />
<table border="0">
<tr>
<td align="right">$username</td>
<td align="left"><input type="text" size="50" name="target" value="$target" />
<td colspan="2" align="center"><input type="submit" name="submit" value="$ok" /></td>
</tr>
</table>
</form>
</fieldset>
EOT
		);
	}

	/**
	 * Retrieves and shows the gathered info to the user
	 * @param $target Mixed: user whose info we're looking up
	 * @param $emailUser String: e-mail address (like example@example.com)
	 */
	function showInfo( $target, $emailUser = '' ) {
		global $wgOut, $wgLang, $wgScript;

		$count = 0;
		$users = array();
		$userTarget = '';

		// Look for @ in username
		if( strpos( $target, '@' ) !== false ) {
			// Find username by email
			$emailUser = htmlspecialchars( $emailUser );
			$dbr = wfGetDB( DB_SLAVE );

			$res = $dbr->select(
				'user',
				array( 'user_name' ),
				array( 'user_email' => $target ),
				__METHOD__
			);

			$loop = 0;
			foreach( $res as $row ) {
				if( $loop === 0 ) {
					$userTarget = $row->user_name;
				}
				if( !empty( $emailUser ) && ( $emailUser == $row->user_name ) ) {
					$userTarget = $emailUser;
				}
				$users[] = $row->user_name;
				$loop++;
			}
			$count = $loop;
		}

		$ourUser = ( !empty( $userTarget ) ) ? $userTarget : $target;
		$user = User::newFromName( $ourUser );
		if ( $user == null || $user->getId() == 0 ) {
			$wgOut->addWikiText( '<span class="error">' . wfMsg( 'lookupuser-nonexistent', $target ) . '</span>' );
		} else {
			# Multiple matches?
			if ( $count > 1 ) {
				$options = array();
				if( !empty( $users ) && is_array( $users ) ) {
					foreach( $users as $id => $userName ) {
						$options[] = Xml::option( $userName, $userName, ( $userName == $userTarget ) );
					}
				}
				$selectForm = "\n" . Xml::openElement( 'select', array( 'id' => 'email_user', 'name' => 'email_user' ) );
				$selectForm .= "\n" . implode( "\n", $options ) . "\n";
				$selectForm .= Xml::closeElement( 'select' ) . "\n";

				$wgOut->addHTML(
					Xml::openElement( 'fieldset' ) . "\n" .
					Xml::openElement( 'form', array( 'method' => 'get', 'action' => $wgScript ) ) . "\n" .
					Html::hidden( 'title', $this->getTitle()->getPrefixedText() ) . "\n" .
					Html::hidden( 'target', $target ) . "\n" .
					Xml::openElement( 'table', array( 'border' => '0' ) ) . "\n" .
					Xml::openElement( 'tr' ) . "\n" .
					Xml::openElement( 'td', array( 'align' => 'right' ) ) .
					wfMsgHtml( 'lookupuser-foundmoreusers' ) .
					Xml::closeElement( 'td' ) . "\n" .
					Xml::openElement( 'td', array( 'align' => 'left' ) ) . "\n" .
					$selectForm . Xml::closeElement( 'td' ) . "\n" .
					Xml::openElement( 'td', array( 'colspan' => '2', 'align' => 'center' ) ) .
					Xml::submitButton( wfMsgHtml( 'go' ) ) .
					Xml::closeElement( 'td' ) . "\n" .
					Xml::closeElement( 'tr' ) . "\n" .
					Xml::closeElement( 'table' ) . "\n" .
					Xml::closeElement( 'form' ) . "\n" .
					Xml::closeElement( 'fieldset' )
				);
			}

			$authTs = $user->getEmailAuthenticationTimestamp();
			if ( $authTs ) {
				$authenticated = wfMsg( 'lookupuser-authenticated', $wgLang->timeanddate( $authTs ) );
			} else {
				$authenticated = wfMsg( 'lookupuser-not-authenticated' );
			}
			$optionsString = '';
			foreach ( $user->getOptions() as $name => $value ) {
				$optionsString .= "$name = $value <br />";
			}
			$name = $user->getName();
			if( $user->getEmail() ) {
				$email = $user->getEmail();
			} else {
				$email = wfMsg( 'lookupuser-no-email' );
			}
			if( $user->getRegistration() ) {
				$registration = $wgLang->timeanddate( $user->getRegistration() );
			} else {
				$registration = wfMsg( 'lookupuser-no-registration' );
			}
			$wgOut->addWikiText( '*' . wfMsg( 'username' ) . ' [[User:' . $name . '|' . $name . ']] (' .
				$wgLang->pipeList( array(
					'[[User talk:' . $name . '|' . wfMsg( 'talkpagelinktext' ) . ']]',
					'[[Special:Contributions/' . $name . '|' . wfMsg( 'contribslink' ) . ']])'
				) ) );
			$wgOut->addWikiText( '*' . wfMsg( 'lookupuser-id', $user->getId() ) );
			$wgOut->addWikiText( '*' . wfMsg( 'lookupuser-email', $email, $name ) );
			$wgOut->addWikiText( '*' . wfMsg( 'lookupuser-realname', $user->getRealName() ) );
			$wgOut->addWikiText( '*' . wfMsg( 'lookupuser-registration', $registration ) );
			$wgOut->addWikiText( '*' . wfMsg( 'lookupuser-touched', $wgLang->timeanddate( $user->mTouched ) ) );
			$wgOut->addWikiText( '*' . wfMsg( 'lookupuser-info-authenticated', $authenticated ) );
			$wgOut->addWikiText( '*' . wfMsg( 'lookupuser-useroptions' ) . '<br />' . $optionsString );
		}
	}
}
