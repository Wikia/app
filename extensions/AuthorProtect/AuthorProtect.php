<?php
/**
 * AuthorProtect extension by Ryan Schmidt
 * See http://www.mediawiki.org/wiki/Extension:AuthorProtect for more details
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo "This file is an extension to MediaWiki and cannot be run externally\n";
	die( 1 );
}

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Author Protect',
	'author' => 'Ryan Schmidt',
	'url' => 'https://www.mediawiki.org/wiki/Extension:AuthorProtect',
	'version' => '1.3',
	'descriptionmsg' => 'authorprotect-desc',
);

$wgAvailableRights[] = 'author'; // dynamically assigned to the author of a page, but can be set w/ wgGroupPermissions too
$wgAvailableRights[] = 'authorprotect'; // users without this right cannot protect pages they author
$wgExtensionMessagesFiles['AuthorProtect'] = dirname( __FILE__ ) . '/AuthorProtect.i18n.php';
$wgGroupPermissions['sysop']['author'] = true; // sysops can edit every page despite author protection
$wgGroupPermissions['user']['authorprotect'] = true; // registered users can protect pages they author
$wgHooks['SkinTemplateNavigation::Universal'][] = 'AuthorProtect::MakeContentAction';
$wgHooks['UnknownAction'][] = 'AuthorProtect::AuthorProtectForm';
$wgHooks['userCan'][] = 'AuthorProtect::AuthorProtectDelay';
$wgHooks['UserGetRights'][] = 'AuthorProtect::AssignAuthor';
$wgRestrictionLevels[] = 'author'; // so sysops, etc. using the normal protection interface can protect and unprotect it at the author level
$wgAvailableRights[] = 'author';
$wgAvailableRights[] = 'authorprotect';

// internal variables, do not modify
$wgAuthorProtectDoProtect = false;
$wgAuthorProtectDelayRun = true;

class AuthorProtect {
	/**
	 * Extensions like ConfirmAccount do some weird stuff to $wgTitle during the UserGetRights hook
	 * So this delays the hook's execution to a point where $wgTitle is set
	 */
	public static function AuthorProtectDelay( $title, &$user, $action, $result ) {
		global $wgAuthorProtectDelayRun;
		if ( $wgAuthorProtectDelayRun ) {
			$user->mRights = null;
			$user->getRights(); // delay hook execution for compatibility w/ ConfirmAccount
			$act = ( $action == '' || $action == 'view' ) ? 'edit' : $action;
			$wgAuthorProtectDelayRun = false;
			if ( self::userIsAuthor( $title ) && self::isAuthorProtected( $title, $act ) ) {
				$result = true;
				return false;
			}
		}
		$result = null;
		return true;
	}

	public static function AssignAuthor( $user, &$aRights ) {
		global $wgTitle;

		// don't assign author to anons... messes up logging stuff.
		// plus it's all user_id based so it is impossible to differentiate one anon from another
		if ( self::userIsAuthor( $wgTitle ) && $user->isLoggedIn() ) {
			$aRights[] = 'author';
			$aRights = array_unique( $aRights );
		}
		// assign protect too if we need to
		global $wgAuthorProtectDoProtect;
		if ( $wgAuthorProtectDoProtect ) {
			$aRights[] = 'protect';
			$aRights = array_unique( $aRights );
		}
		return true;
	}

	private static function AuthorProtectAssignProtect() {
		global $wgAuthorProtectDoProtect, $wgUser;
		$wgAuthorProtectDoProtect = true;
		$wgUser->mRights = null;
		$wgUser->getRights(); // re-trigger the above function to assign the protect right
		$wgAuthorProtectDoProtect = false;
	}

	private static function AuthorProtectUnassignProtect() {
		global $wgUser;
		$wgUser->mRights = null;
		$wgUser->getRights();
	}

	public static function MakeContentAction( $skin, &$links ) {
		global $wgUser, $wgRequest;

		$title = $skin->getTitle();
		if ( self::userIsAuthor( $title ) && $wgUser->isAllowed( 'authorprotect' ) && !$wgUser->isAllowed( 'protect' ) ) {
			$action = $wgRequest->getText( 'action' );
			$links['actions']['authorprotect'] = array(
				'class' => $action == 'authorprotect' ? 'selected' : false,
				'text' => wfMessage( self::AuthorProtectMessage( $title ) ),
				'href' => $title->getLocalUrl( 'action=authorprotect' ),
			);
		}
		return true;
	}

	public static function AuthorProtectForm( $action, $article ) {
		if ( $action != 'authorprotect' ) {
			return true; // unknown action, so state that the action doesn't exist
		}
		global $wgOut, $wgUser, $wgRequest, $wgRestrictionTypes;
		if ( !$wgUser->isAllowed( 'authorprotect' ) ) {
			$wgOut->permissionRequired( 'authorprotect' );
			return false;
		}
		if ( !self::userIsAuthor( $article->getTitle() ) ) {
			$wgOut->setPageTitle( wfMessage( 'errorpagetitle' ) );
			$wgOut->addWikiMsg( 'authorprotect-notauthor' );
			return false;
		}
		$wgOut->setPageTitle( wfMessage( 'authorprotect' ) );
		if ( !$wgRequest->wasPosted() ) {
			$wgOut->addHTML( self::AuthorProtectMakeProtectForm( $article->getTitle() ) );
		} else {
			if ( !$wgUser->matchEditToken( $wgRequest->getText( 'wpToken' ) ) ) {
				$wgOut->setPageTitle( wfMessage( 'errorpagetitle' ) );
				$wgOut->addWikiMsg( 'sessionfailure' );
				return false;
			}
			$restrictions = array();
			$expiration = array();
			$expiry = self::AuthorProtectExpiry( $wgRequest->getText( 'wpExpiryTime' ) );
			foreach ( $wgRestrictionTypes as $type ) {
				// hack, but don't allow setting create or upload restrictions
				if( $type == 'upload' || $type == 'create' ) {
					continue;
				}
				$rest = $article->getTitle()->getRestrictions( $type );
				if ( $rest !== array() ) {
					if ( !$wgUser->isAllowed( $rest[0] ) && !in_array( 'author', $rest ) ) {
						$restrictions[$type] = $rest[0]; // don't let them lower the protection level
						continue;
					}
				}
				if ( $wgRequest->getCheck( "check-{$type}" ) ) {
					$restrictions[$type] = 'author';
					$expiration[$type] = $expiry;
				} else {
					if ( in_array( 'author', $rest ) ) {
						$restrictions[$type] = '';
						$expiration[$type] = $expiry;
					} else {
						$restrictions[$type] = ( $rest !== array() ) ? $rest[0] : ''; // we're not setting it
						$expiration[$type] = $expiry;
					}
				}
			}
			$cascade = false;
			self::AuthorProtectAssignProtect();
			$str = var_export( array(
				'restrictions' => $restrictions,
				'reason' => $wgRequest->getText( 'wpReason' ),
				'cascade' => $cascade,
				'expiry' => $expiration ), true );
			wfDebugLog( 'authorprotect', $str );
			$success = $article->updateRestrictions(
				$restrictions, // array of restrictions
				$wgRequest->getText( 'wpReason' ), // reason
				$cascade, // cascading protection disabled, need to pass by reference
				$expiration // expiration
			);
			self::AuthorProtectUnassignProtect();
			if ( $success ) {
				$wgOut->addWikiMsg( 'authorprotect-success' );
			} else {
				$wgOut->addWikiMsg( 'authorprotect-failure' );
			}
		}
		return false; // still continues hook processing, but doesn't throw an error message
	}

	private static function AuthorProtectMakeProtectForm( $title ) {
		global $wgRestrictionTypes, $wgUser;
		$token = $wgUser->editToken();
		$form = Html::rawElement( 'p', array(), htmlspecialchars( wfMessage( 'authorprotect-intro' ) ) );
		$form .= Html::openElement( 'form', array( 'method' => 'post', 'action' => $title->getLocalUrl( 'action=authorprotect' ) ) );

		$br = Html::element( 'br' );

		foreach ( $wgRestrictionTypes as $type ) {
			// hack, but don't show create or upload restrictions
			if( $type == 'upload' || $type == 'create' ) {
				continue;
			}
			$rest = $title->getRestrictions( $type );
			if ( $rest !== array() ) {
				if ( !$wgUser->isAllowed( $rest[0] ) && !in_array( 'author', $rest ) ) {
					continue; // it's protected at a level higher than them, so don't let them change it so they can now mess with stuff
				}
			}

			$checked = in_array( 'author', $rest );
			$form .= Xml::checkLabel( wfMessage( "authorprotect-$type" ), "check-$type", "check-$type", $checked ) . $br;
		}

		$form .= $br . Xml::inputLabel( wfMessage( 'protectexpiry' ), 'wpExpiryTime', 'wpExpiryTime' );
		$form .= $br . Xml::inputLabel( wfMessage( 'protectcomment', 'reason' ), 'wpReason', 'wpReason' );
		$form .= $br . Html::hidden( 'wpToken', $token );
		$form .= $br . Xml::submitButton( wfMessage( 'authorprotect-confirm' ) );
		$form .= Xml::closeElement( 'form' );
		return $form;
	}

	private static function userIsAuthor( $title ) {
		global $wgUser;

		if ( !$title instanceOf Title ) {
			return false; // quick hack to prevent the API from messing up.
		}
		
		if ( $wgUser->getID() === 0 ) {
			return false; // don't allow anons, they shouldn't even get this far but just in case...
		}

		$id = $title->getArticleId();
		$dbr = wfGetDB( DB_SLAVE ); // grab the slave for reading
		$aid = $dbr->selectField( 'revision', 'rev_user',  array( 'rev_page' => $id ), __METHOD__ );
		return $wgUser->getID() == $aid;
	}

	private static function AuthorProtectMessage( $title ) {
		global $wgRestrictionTypes;
		foreach ( $wgRestrictionTypes as $type ) {
			if ( in_array( 'author', $title->getRestrictions( $type ) ) ) {
				return 'unprotect';
			}
		}
		return 'protect';
	}

	private static function isAuthorProtected( $title, $action ) {
		$rest = $title->getRestrictions( $action );
		return in_array( 'author', $rest );
	}

	// forked from ProtectionForm::getExpiry and modified to rewrite '' to infinity
	private static function AuthorProtectExpiry( $value ) {
		if ( $value == 'infinite' || $value == 'indefinite' || $value == 'infinity' || $value == '' ) {
			$time = Block::infinity();
		} else {
			$unix = strtotime( $value );

			if ( !$unix || $unix === -1 ) {
				return false;
			}

			// Fixme: non-qualified absolute times are not in users specified timezone
			// and there isn't notice about it in the ui
			$time = wfTimestamp( TS_MW, $unix );
		}
		return $time;
	}
}
