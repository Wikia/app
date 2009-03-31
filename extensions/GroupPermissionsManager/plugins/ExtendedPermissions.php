<?php

/**
* Extended Permissions plugin for the GroupPermissionsManager extension
* This requires the GroupPermissionsManager extension to function
* Licensed under the GPL
*/

if(!defined('MEDIAWIKI')) {
	echo("This file is an extension to the MediaWiki software and is not a valid access point");
	die(1);
}

$wgExtensionCredits['other'][] = array(
	'name'           => 'Extended Permissions',
	'author'         => 'Ryan Schmidt',
	'url'            => 'http://www.mediawiki.org/wiki/Extension:GroupPermissionsManager',
	'version'        => '1.5',
	'description'    => 'Extended permissions system',
	'descriptionmsg' => 'grouppermissions-desc2',
);

$wgHooks['UserGetRights'][] = 'efGPManagerRevokeRights';
$wgHooks['userCan'][] = 'efGPManagerExtendedPermissionsGrant';
$wgHooks['getUserPermissionsErrors'][] = 'efGPManagerExtendedPermissionsRevoke';
$wgHooks['NormalizeMessageKey'][] = 'efGPManagerReplaceEditMessage';

//Revoke the rights that are set to "never"
function efGPManagerRevokeRights(&$user, &$rights) {
	global $wgGPManagerNeverGrant;
	$groups = $user->getEffectiveGroups();
	$never = array();
	$rights = array_unique($rights);
	foreach( $groups as $group ) {
		if( array_key_exists( $group, $wgGPManagerNeverGrant ) ) {
			foreach( $wgGPManagerNeverGrant[$group] as $right ) {
				$never[] = $right;
			}
		}
	}
	$never = array_unique( $never );
	foreach( $never as $revoke ) {
		$offset = array_search( $revoke, $rights );
		if( $offset !== false ) {
			array_splice( $rights, $offset, 1 );
		}
	}
	return true;
}

//Extend the permissions system for finer-grained control without requiring hacks
//For allowing actions that the normal permissions system would prevent
function efGPManagerExtendedPermissionsGrant($title, $user, $action, &$result) {
	global $wgRequest, $wgGroupPermissions;
	$result = false;
	if( $action == 'edit' || $action == 'create' ) {
		if( !$title->exists() ) {
			$protection = getTitleProtection($title);
			if($protection) {
				if( !$user->isAllowed($protection['pt_create_perm']) ) {
					//pass it on to the normal permissions system to handle
					$result = null;
					return true;
				}
			}
			//need to explicitly set this right just for this instance because of a hard-coded check when saving a page
			if( $title->isTalkPage() && $user->isAllowed('createtalk') ) {
				$wgGroupPermissions['*']['edit'] = true;
				$user->mRights = null; //force a reload of rights
				$result = true;
				return false;
			} elseif( !$title->isTalkPage() && $user->isAllowed('createpage') ) {
				$wgGroupPermissions['*']['edit'] = true;
				$user->mRights = null; //force a reload of rights
				$result = true;
				return false;
			}
		} else {
			$protection = $title->getRestrictions('edit');
			if($protection) {
				foreach($protection as $right) {
					if(!$user->isAllowed($right)) {
						//pass it on to the normal permissions system
						$result = null;
						return true;
					}
				}
			}
			if( $title->isNamespaceProtected() ) {
				//user can't edit due to namespace protection
				$result = null;
				return false;
			}
			//ditto here w/ the GroupPermissions
			if( $title->isTalkPage() && $user->isAllowed('edittalk') ) {
				$wgGroupPermissions['*']['edit'] = true;
				$user->mRights = null; //force a reload of rights
				$result = true;
				return false;
			} elseif( !$title->isTalkPage() && $user->isAllowed('edit') ) {
				$wgGroupPermissions['*']['edit'] = true;
				$user->mRights = null; //force a reload of rights
				$result = true;
				return false;
			}
		}
	} elseif( $action == 'read' && ($wgRequest->getVal('action') == 'edit' || $wgRequest->getVal('action') == 'submit') ) {
		# hack so anons can still view page source if they can't edit
		if($user->isAllowed('viewsource')) {
			$result = true;
			return false;
		}
	}
	//hack for the UserCanRead method
	$res = efGPManagerExtendedPermissionsRevoke($title, $user, $action, $result);
	if(!$res) {
		$result = false;
		//yay epic hacking! If I can't choose to make it return badaccess-group0... I'll simply force it to
		global $wgGroupPermissions;
		foreach($wgGroupPermissions as $group => $rights) {
			$wgGroupPermissions[$group]['read'] = false;
		}
		return false;
	}
	$result = null;
	return true; //otherwise we don't care
}

//for preventing actions the normal permissions system would allow
function efGPManagerExtendedPermissionsRevoke($title, $user, $action, &$result) {
	global $wgRequest;
	$result = null;
	$err = array('badaccess-group0');
	if( $action == 'read' ) {
		if( $title->isSpecial('Recentchanges') && !$user->isAllowed('recentchanges') ) {
			$result = $err;
			return false;
		}
		if( $title->isSpecial('Search') && !$user->isAllowed('search') ) {
			$result = $err;
			return false;
		}
		if( $title->isSpecial('Contributions') && !$user->isAllowed('contributions') ) {
			$result = $err;
			return false;
		}
		if( $wgRequest->getVal('action') == 'edit' || $wgRequest->getVal('action') == 'submit' ) {
			if( !$title->userCan('edit') && !$user->isAllowed('viewsource') ) {
				$result = $err;
				return false;
			}
		}
		if( $wgRequest->getVal('action') == 'history' && !$user->isAllowed('history') ) {
			$result = $err;
			return false;
		}
		if( $wgRequest->getVal('action') == 'raw' && !$user->isAllowed('raw') ) {
			$result = $err;
			return false;
		}
		if( $wgRequest->getVal('action') == 'render' && !$user->isAllowed('render') ) {
			$result = $err;
			return false;
		}
		if( $wgRequest->getVal('action') == 'credits' && !$user->isAllowed('credits') ) {
			$result = $err;
			return false;
		}
		if( $wgRequest->getVal('action') == 'info' && !$user->isAllowed('info') ) {
			$result = $err;
			return false;
		}
	}
	if( $action == 'edit' ) {
		if($title->exists() && ($wgRequest->getVal('action') == 'edit' || $wgRequest->getVal('action') == 'submit')) {
			if( $title->isTalkPage() && !$user->isAllowed('edittalk') ) {
				$result = $err;
				return false;
			} elseif( !$title->isTalkPage() && !$user->isAllowed('edit') ) {
				$result = $err;
				return false;
			}
		}
	}
	if( ($wgRequest->getVal('diff') || $wgRequest->getVal('oldid')) && !$user->isAllowed('readold') ) {
		//if they can't read it, they shouldn't be able to do other stuff with it anyway
		$result = $err;
		return false;
	}
	return true; //otherwise we don't care
}

//replace right-edit messages with right-edit-new wherever applicable
function efGPManagerReplaceEditMessage(&$key, &$useDB, &$langCode, $transform) {
	# Dirty hack, prevents that issue on viewsource pages
	global $wgRequest;
	if($wgRequest->getVal('action') == 'edit' || $wgRequest->getVal('action') == 'sumbit') {
		global $wgTitle;
		if(!$wgTitle instanceOf Title || !$wgTitle->userCan('edit')) return true;
	}
	loadGPMessages();
	if($key == 'right-edit') {
		$key = 'right-edit-new';
		return false; //so it doesn't change load times TOO much
	}
	return true;
}