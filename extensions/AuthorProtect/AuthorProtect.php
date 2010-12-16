<?php

/**
 * AuthorProtect extension by Ryan Schmidt
 * See http://www.mediawiki.org/wiki/Extension:AuthorProtect for more details
 */

if( !defined( 'MEDIAWIKI' ) ) {
	echo "This file is an extension to MediaWiki and cannot be run externally\n";
	die( 1 );
}

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Author Protect',
	'author' => 'Ryan Schmidt',
	'url' => 'http://www.mediawiki.org/wiki/Extension:AuthorProtect',
	'version' => '1.2',
	'description' => 'Allows the author of a page to protect it from other users',
	'descriptionmsg' => 'authorprotect-desc',
);

$wgAvailableRights[] = 'author'; //dynamically assigned to the author of a page, but can be set w/ wgGroupPermissions too
$wgAvailableRights[] = 'authorprotect'; //users without this right cannot protect pages they author
$wgExtensionMessagesFiles['AuthorProtect'] = dirname( __FILE__ ) . '/AuthorProtect.i18n.php';
$wgGroupPermissions['sysop']['author'] = true; //sysops can edit every page despite author protection
$wgGroupPermissions['user']['authorprotect'] = true; //registered users can protect pages they author
$wgHooks['SkinTemplateContentActions'][] = 'efMakeContentAction';
$wgHooks['UnknownAction'][] = 'efAuthorProtectForm';
$wgHooks['userCan'][] = 'efAuthorProtectDelay';
$wgHooks['UserGetRights'][] = 'efAssignAuthor';
$wgRestrictionLevels[] = 'author'; //so sysops, etc. using the normal protection interface can protect and unprotect it at the author level

//internal variables, do not modify
$wgAuthorProtectDoProtect = false;
$wgAuthorProtectDelayRun = true;

/**
 * Extensions like ConfirmAccount do some weird stuff to $wgTitle during the UserGetRights hook
 * So this delays the hook's execution to a point where $wgTitle is set
 */
function efAuthorProtectDelay( $title, &$user, $action, $result ) {
	global $wgAuthorProtectDelayRun;
	if( $wgAuthorProtectDelayRun ) {
		$user->mRights = null;
		$user->getRights(); //delay hook execution for compatibility w/ ConfirmAccount
		$act = ( $action == '' || $action == 'view' ) ? 'edit' : $action;
		$wgAuthorProtectDelayRun = false;
		if( userIsAuthor() && isAuthorProtected( $title, $act ) ) {
			$result = true;
			return false;
		}
	}
	$result = null;
	return true;
}

function efAssignAuthor( &$user, &$aRights ) {
	//don't assign author to anons... messes up logging stuff.
	//plus it's all user_id based so it is impossible to differentiate one anon from another
	if( userIsAuthor() && $user->isLoggedIn() ) {
		$aRights[] = 'author';
		$aRights = array_unique( $aRights );
	}
	//assign protect too if we need to
	global $wgAuthorProtectDoProtect;
	if( $wgAuthorProtectDoProtect ) {
		$aRights[] = 'protect';
		$aRights = array_unique( $aRights );
	}
	return true;
}

function efAuthorProtectAssignProtect() {
	global $wgAuthorProtectDoProtect, $wgUser;
	$wgAuthorProtectDoProtect = true;
	$wgUser->mRights = null;
	$wgUser->getRights(); //re-trigger the above function to assign the protect right
	$wgAuthorProtectDoProtect = false;
}

function efAuthorProtectUnassignProtect() {
	global $wgUser;
	$wgUser->mRights = null;
	$wgUser->getRights();
}

function efMakeContentAction( &$cactions ) {
	global $wgUser, $wgRequest, $wgTitle;
	if( userIsAuthor() && $wgUser->isAllowed( 'authorprotect' ) && !$wgUser->isAllowed( 'protect' ) ) {
		$action = $wgRequest->getText( 'action' );
		$cactions['authorprotect'] = array(
			'class' => $action == 'authorprotect' ? 'selected' : false,
			'text' => wfMsg( efAuthorProtectMessage( $wgTitle ) ),
			'href' => $wgTitle->getLocalUrl( 'action=authorprotect' ),
		);
	}
	return true;
}

function efAuthorProtectForm( $action, &$article ) {
	global $wgTitle, $wgAuthorProtectDoProtect;
	if( $action == 'authorprotect' ) {
		wfLoadExtensionMessages( 'AuthorProtect' );
		global $wgOut, $wgUser, $wgRequest, $wgRestrictionTypes;
		if( $wgUser->isAllowed( 'authorprotect' ) ) {
			if( userIsAuthor() ) {
				$wgOut->setPageTitle( wfMsg( 'authorprotect' ) );
				if( !$wgRequest->wasPosted() ) {
					$wgOut->addHTML( efAuthorProtectMakeProtectForm() );
				} else {
					if( !$wgUser->matchEditToken( $wgRequest->getText('wpToken') ) ) {
						$wgOut->setPageTitle( wfMsg( 'errorpagetitle' ) );
						$wgOut->addWikiText( wfMsg( 'sessionfailure' ) );
						return;
					}
					$restrictions = array();
					$expiration = array();
					$expiry = efAuthorProtectExpiry( $wgRequest->getText( 'wpExpiryTime' ) );
					foreach( $wgRestrictionTypes as $type ) {
						$rest = $wgTitle->getRestrictions( $type );
						if( $rest !== array() ) {
							if( !$wgUser->isAllowed( $rest[0] ) && !in_array( 'author', $rest ) ) {
								$restrictions[$type] = $rest[0]; //don't let them lower the protection level
								continue;
							}
						}
						if( $wgRequest->getCheck( "check-{$type}" ) ) {
							$restrictions[$type] = 'author';
							$expiration[$type] = $expiry;
						} else {
							if( in_array( 'author', $rest ) ) {
								$restrictions[$type] = '';
								$expiration[$type] = $expiry;
							} else {
								$restrictions[$type] = ( $rest !== array() ) ? $rest[0] : ''; //we're not setting it
								$expiration[$type] = $expiry;
							}
						}
					}
					$cascade = false;
					efAuthorProtectAssignProtect();
					$str = var_export(array('restrictions' => $restrictions, 'reason' => $wgRequest->getText('wpReason'), 'cascade' => $cascade, 'expiry' => $expiration), true);
					wfDebugLog('authorprotect', $str);
					$success = $article->updateRestrictions(
						$restrictions, //array of restrictions
						$wgRequest->getText( 'wpReason' ), //reason
						$cascade, //cascading protection disabled, need to pass by reference
						$expiration //expiration
					);
					efAuthorProtectUnassignProtect();
					if( $success ) {
						$wgOut->addWikiText( wfMsg( 'authorprotect-success' ) );
					} else {
						$wgOut->addWikiText( wfMsg( 'authorprotect-failure' ) );
					}
				}
			} else {
				$wgOut->setPageTitle( wfMsg('errorpagetitle') );
				$wgOut->addWikiText( wfMsg('authorprotect-notauthor') );
			}
		} else {
			$wgOut->permissionRequired( 'authorprotect' );
		}
		return false; //still continues hook processing, but doesn't throw an error message
	}
	return true; //unknown action, so state that the action doesn't exist
}

function efAuthorProtectMakeProtectForm() {
	global $wgRestrictionTypes, $wgTitle, $wgUser;
	$token = $wgUser->editToken();
	$form = Xml::openElement( 'p' ) . wfMsg( 'authorprotect-intro' ) . Xml::closeElement( 'p' );
	$form .= Xml::openElement( 'form', array( 'method' => 'post', 'action' => $wgTitle->getLocalUrl( 'action=authorprotect' ) ) );
	foreach( $wgRestrictionTypes as $type ) {
		$rest = $wgTitle->getRestrictions( $type );
		if( $rest !== array() ) {
			if( !$wgUser->isAllowed( $rest[0] ) && !in_array( 'author', $rest ) )
				continue; //it's protected at a level higher than them, so don't let them change it so they can now mess with stuff
		}
		$checked = in_array( 'author', $rest );
		$array = array( 'type' => 'checkbox', 'name' => 'check-' . $type, 'value' => $type );
		if( $checked )
			$array = array_merge( $array, array( 'checked' => 'checked' ) );
		$form .= Xml::element( 'input', $array );
		$form .= ' ' . wfMsg( 'authorprotect-' . $type ) . Xml::element( 'br' );
	}
	$form .= Xml::element( 'br' ) . Xml::element( 'label', array( 'for' => 'wpExpiryTime' ), wfMsg( 'authorprotect-expiry' ) ) . ' ';
	$form .= Xml::element( 'input', array( 'type' => 'text', 'name' => 'wpExpiryTime' ) ) . Xml::element( 'br' );
	$form .= Xml::element( 'br' ) . Xml::element( 'label', array( 'for' => 'wpReason' ), wfMsg( 'authorprotect-reason' ) ) . ' ';
	$form .= Xml::element( 'input', array( 'type' => 'text', 'name' => 'wpReason' ) );
	$form .= Xml::element( 'br' ) . Xml::element( 'input', array( 'type' => 'hidden', 'name' => 'wpToken', 'value' => $token ) );
	$form .= Xml::element( 'br' ) . Xml::element( 'input', array( 'type' => 'submit', 'name' => 'wpConfirm', 'value' => wfMsg( 'authorprotect-confirm' ) ) );
	$form .= Xml::closeElement( 'form' );
	return $form;
}

function userIsAuthor() {
	global $wgTitle, $wgUser;
	if( !$wgTitle instanceOf Title )
		return false; //quick hack to prevent the API from messing up.
	$id = $wgTitle->getArticleId();
	$dbr = wfGetDB( DB_SLAVE ); //grab the slave for reading
	$aid = $dbr->selectField( 'revision', 'rev_user',  array( 'rev_page' => $id ), __METHOD__ );
	return $wgUser->getID() == $aid;
}

function efAuthorProtectMessage( $title ) {
	global $wgRestrictionTypes;
	foreach( $wgRestrictionTypes as $type ) {
		if( in_array( 'author', $title->getRestrictions( $type ) ) )
			return 'unprotect';
	}
	return 'protect';
}

function isAuthorProtected($title, $action) {
	$rest = $title->getRestrictions($action);
	return in_array('author', $rest);
}

//forked from ProtectionForm::getExpiry and modified to rewrite '' to infinity
function efAuthorProtectExpiry( $value ) {
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
