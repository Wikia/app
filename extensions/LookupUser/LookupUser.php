<?php

/**
 * Extension to to retrieve information about a user such as email address and ID.
 *
 * @addtogroup Extensions
 * @author Tim Starling
 * @copyright 2006 Tim Starling
 * @licence GNU General Public Licence
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

$wgExtensionFunctions[] = 'wfSetupLookupUser';
$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Lookup User',
	'author' => 'Tim Starling',
	'description' => 'Retrieve information about a user such as email address and ID',
	'url' => 'http://www.mediawiki.org/wiki/Extension:LookupUser',
	'descriptionmsg' => 'lookupuser-desc',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['LookupUser'] = $dir . 'LookupUser.i18n.php';

$wgSpecialPages['LookupUser'] = 'LookupUserPage';
$wgAvailableRights[] = 'lookupuser';
$wgSpecialPageGroups['LookupUser'] = 'users';
$wgGroupPermissions['staff']['lookupuser'] = true;

function wfSetupLookupUser() {
	global $IP;

	class LookupUserPage extends SpecialPage {
		function __construct() {
			SpecialPage::SpecialPage( 'LookupUser', 'lookupuser' );
		}

		function getDescription() {
			return wfMsg( 'lookupuser' );
		}

		function execute( $subpage ) {
			global $wgRequest, $wgUser;
			wfLoadExtensionMessages( 'LookupUser' );

			$this->setHeaders();

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

		function showForm( $target ) {
			global $wgScript, $wgOut;
			$title = htmlspecialchars( $this->getTitle()->getPrefixedText() );
			$action = htmlspecialchars( $wgScript );
			$target = htmlspecialchars( $target );
			$ok = wfMsg( 'go' );
			$username = wfMsg( 'username' );
			$inputformtop = wfMsg( 'lookupuser' );

			$wgOut->addWikiText( wfMsg( 'lookupuser_intro' ));

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
				
				$oRes = $dbr->select(
					wfSharedTable( "user" ),
					array( "user_name" ),
					array( "user_email" => $target ),
					__METHOD__
				);

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
			if ( ($user == null) || ($user->getId() == 0) ) {
				$wgOut->addWikiText( '<span class="error">' . wfMsg( 'lookupuser_nonexistent', $target ) . '</span>' );
			} else {
				if ( $count > 1 ) {
					$action = htmlspecialchars( $wgScript );
					$title = htmlspecialchars( $this->getTitle()->getPrefixedText() );
					$ok = wfMsg( 'go' );
					$foundInfo = wfMsg('lookupuser_foundmoreusers');
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
<td colspan="2" align="center"><input type="submit" name="submit" value="$ok" /></td>
</tr>
</table>
</form>
EOT
					);
				}
					
				$authTs = $user->getEmailAuthenticationTimestamp();
				if ( $authTs ) {
					$authenticated = wfMsg( 'lookupuser_authenticated', $wgLang->timeanddate( $authTs ) );
				} else {
					$authenticated = wfMsg( 'lookupuser_not_authenticated' );
				}
				$optionsString = '';
				foreach ( $user->mOptions as $name => $value ) {
					$optionsString .= "$name = $value <br />";
				}
				$name = $user->getName();
				if( $user->getEmail() ) {
					$email = $user->getEmail();
				} else {
					$email = wfMsg( 'lookupuser_no_email' );
				}
				if( $user->getRegistration() ) {
					$registration = $wgLang->timeanddate( $user->getRegistration() );
				} else {
					$registration = wfMsg( 'lookupuser_no_registration' );
				}
				$wgOut->addWikiText( '*' . wfMsg( 'username' ) . ' [[User:' . $name . '|' . $name . ']] ([[User talk:' . $name . '|' . wfMsg( 'talkpagelinktext' ) . ']] | [[Special:Contributions/' . $name . '|' . wfMsg( 'contribslink' ) . ']])' );
				$wgOut->addWikiText( '*' . wfMsg( 'lookupuser_id', $user->getId() ));
				$wgOut->addWikiText( '*' . wfMsg( 'lookupuser_email', $email, $name ));
				$wgOut->addWikiText( '*' . wfMsg( 'lookupuser_realname', $user->getRealName() ));
				$wgOut->addWikiText( '*' . wfMsg( 'lookupuser_registration', $registration ));
				$wgOut->addWikiText( '*' . wfMsg( 'lookupuser_touched', $wgLang->timeanddate( $user->mTouched ) ));
				$wgOut->addWikiText( '*' . wfMsg( 'lookupuser_authenticated', $authenticated ));
				$wgOut->addWikiText( '*' . wfMsg( 'lookupuser_useroptions' ) . '<br />' . $optionsString );
			}
		}
	}
}
