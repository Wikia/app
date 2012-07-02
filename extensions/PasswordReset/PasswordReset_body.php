<?php
/** \file
* \brief Contains code for the PasswordReset Class (extends SpecialPage).
*/

///Special page class for the Password Reset extension
/**
 * Special page that allows sysops to reset local MW user's
 * passwords
 *
 * @ingroup Extensions
 * @author Tim Laqua <t.laqua@gmail.com>
 */
class PasswordReset extends SpecialPage {
	function __construct() {
		
		parent::__construct( "PasswordReset", "passwordreset" );
	}

	function execute( $par ) {
		global $wgRequest, $wgOut, $wgUser;

		$this->setHeaders();

		
		if ( !$wgUser->isAllowed( 'passwordreset' ) ) {
			$wgOut->permissionRequired( 'passwordreset' );
			return;
		}

		$username = Title::newFromText( $wgRequest->getText( 'username' ) );
		$username_text = is_object( $username ) ? $username->getText() : '';

		$disableuser = $wgRequest->getCheck( 'disableuser' );

		if ( $disableuser ) {
			$disableuserchecked = ' CHECKED';
			$passwordfielddisabled = ' disabled="true"';
		} else {
			$disableuserchecked = '';
			$passwordfielddisabled = '';
		}

		if ( strlen( $wgRequest->getText( 'username' ) . $wgRequest->getText( 'newpass' ) . $wgRequest->getText( 'confirmpass' ) ) > 0 ) {
			//POST data found
			if ( strlen( $username_text ) > 0 ) {
				$objUser = User::newFromName( $username->getText() );
				$userID = $objUser->idForName();

				if ( !is_object( $objUser ) || $userID == 0 ) {
					$validUser = false;
					$wgOut->addHTML( Xml::element( 'span', array( 'class' => 'error' ), wfMsg( 'passwordreset-invalidusername' ) ) . "\n" );
				} else {
					$validUser = true;
				}
			} else {
				$validUser = false;
				$wgOut->addHTML( Xml::element( 'span', array( 'class' => 'error' ), wfMsg( 'passwordreset-emptyusername' ) ) . "\n" );
			}

			$newpass = $wgRequest->getText( 'newpass' );
			$confirmpass = $wgRequest->getText( 'confirmpass' );

			if( ( $newpass == $confirmpass && strlen( $newpass ) > 0 ) || $disableuser ) {
				//Passwords match
				$passMatch = true;
			} else {
				//Passwords DO NOT match
				$passMatch = false;
				$wgOut->addHTML( Xml::element( 'span', array( 'class' => 'error' ), wfMsg( 'passwordreset-nopassmatch' ) ) . "\n" );
			}

			if ( !$wgUser->matchEditToken( $wgRequest->getVal( 'token' ) ) ) {
				$validUser = false;
				$passMatch = false;
				$wgOut->addHTML( Xml::element( 'span', array( 'class' => 'error' ), wfMsg( 'passwordreset-badtoken' ) ) . "\n" );
			}
		} else {
			$validUser = false;
			$confirmpass = '';
			$newpass = '';
		}

		$wgOut->addHTML( "
<script language=\"Javascript\">
	function disableUserClicked() {
		if (document.getElementById('disableuser').checked) {
			document.getElementById('newpass').disabled = false;
			document.getElementById('confirmpass').disabled = false;
		} else {
			document.getElementById('newpass').disabled = true;
			document.getElementById('confirmpass').disabled = true;
		}
		return true;
	}
</script>" .
			Xml::openElement( 'form', array( 'method' => 'post', 'action' => $this->getTitle()->getLocalUrl(), 'id' => 'passwordresetform' ) ) .
			Xml::openElement( 'table', array( 'id' => 'mw-passwordreset-table' ) ) .
			"<tr>
				<td class='mw-label'>" . 
					Xml::label( wfMsg( 'passwordreset-username' ), 'username' ) . 
				"</td>
				<td class='mw-input'>
					<input tabindex='1' type='text' size='20' name='username' id='username' value=\"$username_text\" onFocus=\"document.getElementById('username').select;\" />
				</td>
			</tr>
			<tr>
				<td class='mw-label'>" . 
					Xml::label( wfMsg( 'passwordreset-newpass' ), 'newpass' ) . 
				"</td>
				<td class='mw-input'>
					<input tabindex='2' type='password' size='20' name='newpass' id='newpass' value=\"$newpass\" onFocus=\"document.getElementById('newpass').select;\"{$passwordfielddisabled} />
				</td>
			</tr>
			<tr>
				<td class='mw-label'>" . 
					Xml::label( wfMsg( 'passwordreset-confirmpass' ), 'confirmpass' ) . 
				"</td>
				<td class='mw-input'>
					<input tabindex='3' type='password' size='20' name='confirmpass' id='confirmpass' value=\"$confirmpass\" onFocus=\"document.getElementById('confirmpass').select;\"{$passwordfielddisabled} />
				</td>
			</tr>
			<tr>
				<td class='mw-label'>" . 
					Xml::label( wfMsg( 'passwordreset-disableuser' ), 'disableuser' ) . 
				"</td>
				<td class='mw-input'>
					<input tabindex='4' type='checkbox' name='disableuser' id='disableuser' onmouseup='return disableUserClicked();'{$disableuserchecked} /> " . wfMsg('passwordreset-disableuserexplain') .
				"</td>
			</tr>
			<tr>
				<td></td>
				<td class='mw-submit'>" .
					Xml::submitButton( wfMsg( 'passwordreset-submit' ), array( 'name' => 'submit' ) ) .
				"</td>
			</tr>" .
			Xml::closeElement( 'table' ) .
			Html::Hidden( 'token', $wgUser->editToken() ) .
			Xml::closeElement( 'form' )
		);

		if ( $validUser && $passMatch ) {
			$wgOut->addWikiText ( Xml::tags( 'div', array( 'class' => 'successbox' ), $this->resetPassword( $userID, $newpass, $disableuser ) ) );
		} else {
			//Invalid user or passwords don't match - do nothing
		}
	}

	private function resetPassword( $userID, $newpass, $disableuser ) {
		global $wgMemc;
		$dbw = wfGetDB( DB_MASTER );


		$user = User::newFromId( $userID );

		if ( $disableuser ) {
			$user->setPassword( null );
			$message = wfMsg( 'passwordreset-disablesuccess', $userID );
		} else {
			$user->setPassword( $newpass );
			$message = wfMsg( 'passwordreset-success', $userID );
		}
		$user->saveSettings();
		return $message;
	}

	static function GetBlockedStatus(&$user) {
		global $wgTitle;

		if ( $wgTitle && $wgTitle->isSpecial( 'Userlogin' ) ) {
			global $wgRequest;
			if ( $wgRequest->wasPosted() ) {
				$name = $wgRequest->getText( 'wpName' );
				if ( $name <> '' ) {

					$u = User::newFromName( $name );
					if( !$u instanceof User ) {
						return true;
					} elseif ( 0 == $u->getID() ) {
						return true;
					} else {
						$u->load();
						if ( $u->mPassword == 'DISABLED' ) {
							$user->mBlockedby = 1;
							$user->mBlockreason = wfMsg( 'passwordreset-accountdisabled' );
						}
						return true;
					}
				}
			}
		} elseif ( $user->isLoggedIn() ) {
			if ( $user->mPassword == 'DISABLED' ) {
				global $wgOut;
				//mean, I know.
				$user->logout();
				$wgOut->redirect( Title::newMainPage()->escapeFullURL() );
			}
		}
		return true;
	}
}
