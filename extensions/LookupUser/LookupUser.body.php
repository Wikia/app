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
		wfLoadExtensionMessages( 'LookupUser' );

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

		$wgOut->addWikiMsg('lookupuser-intro');

		$wgOut->addHTML( <<<EOT
<fieldset>
<legend>$inputformtop</legend>
<form method="get" action="$action">
<input type="hidden" name="title" value="{$title}" />
<table border="0">
<tr>
<td align="right">$username</td>
<td align="left"><input type="text" size="50" name="target" value="$target" />
<td colspan="2" align="center"><input type="submit" value="$ok" /></td>
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
	 */
	function showInfo( $target, $emailUser = "" ) {
		global $wgOut, $wgLang, $wgScript;
		
		/**
		 * look for @ in username
		 */
		$count = 0; $aUsers = array(); $userTarget = "";
		if( strpos( $target, '@' ) !== false ) {
			/**
			 * find username by email
			 */
			$emailUser = htmlspecialchars( $emailUser );
			$dbr = wfGetDB( DB_SLAVE );
			
			$oRes = $dbr->select( "user", "user_name", array( "user_email" => $target ), __METHOD__ );

			$loop = 0;
			while( $oRow = $dbr->fetchObject( $oRes ) ) {
				if ($loop === 0) {
					$userTarget = $oRow->user_name;
				}
				if (!empty($emailUser) && ($emailUser == $oRow->user_name)) {
					$userTarget = $emailUser;
				}
				$aUsers[] = $oRow->user_name;
				$loop++;
			}
			$count = $loop;
		}

		$user = User::newFromName( (!empty($userTarget)) ? $userTarget : $target );
		if ( $user == null || $user->getId() == 0 ) {
			$wgOut->addWikiText( '<span class="error">' . wfMsg( 'lookupuser-nonexistent', $target ) . '</span>' );
		} else {
			if ( $count > 1 ) {
				$action = htmlspecialchars( $wgScript );
				$title = htmlspecialchars( $this->getTitle()->getPrefixedText() );
				$ok = wfMsg( 'go' );
				$foundInfo = wfMsg('lookupuser-foundmoreusers');
				$options = array();
				if (!empty($aUsers) && is_array($aUsers)) {
					foreach ($aUsers as $id => $userName) {
						$options[] = XML::option( $userName, $userName, ($userName == $userTarget) );
					}
				}
				$selectForm = Xml::openElement( 'select', array( 'id' => 'email_user', 'name' => "email_user" ) );
				$selectForm .= "\n" . implode( "\n", $options ) . "\n";
				$selectForm .= Xml::closeElement( 'select' );
			
				$wgOut->addHTML( <<<EOT
<fieldset>
<form method="get" action="$action">
<input type="hidden" name="title" value="{$title}" />
<input type="hidden" name="target" value="{$target}" />
<table border="0">
<tr>
<td align="right">{$foundInfo}</td>
<td align="left">$selectForm</td>
<td colspan="2" align="center"><input type="submit" value="$ok" /></td>
</tr>
</table>
</form>
EOT
				);
			}

			$authTs = $user->getEmailAuthenticationTimestamp();
			if ( $authTs ) {
				$authenticated = wfMsg( 'lookupuser-authenticated', $wgLang->timeanddate( $authTs ) );
			} else {
				$authenticated = wfMsg( 'lookupuser-not-authenticated' );
			}
			$optionsString = '';
			foreach ( $user->mOptions as $name => $value ) {
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
					'<span id="lu-tools">[[User talk:' . $name . '|' . wfMsg( 'talkpagelinktext' ) . ']]',
					'[[Special:Contributions/' . $name . '|' . wfMsg( 'contribslink' ) . ']]</span>)'
				) ) );
			$wgOut->addWikiText( '*' . wfMsgForContent( 'lookupuser-toollinks', $name, urlencode($name) ) );
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
