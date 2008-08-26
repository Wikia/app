<?php
/*
* RightFunctions extension by Ryan Schmidt
* Permission-based parser functions
* Check http://www.mediawiki.org/wiki/Extension:RightFunctions/Doc for more info on what everything does
* Please note that this can be used superficially to hide information from those with certain rights
*/

if( !defined( 'MEDIAWIKI' ) ) {
	echo "This file is an extension of the MediaWiki software and cannot be used standalone\n";
	die( 1 );
}

//credits and hooks
$wgExtensionFunctions[] = 'wfRightFunctions';
$wgExtensionCredits['parserhook'][] = array(
	'name' => 'RightFunctions',
	'version' => '2.0',
	'url' => 'http://www.mediawiki.org/wiki/Extension:RightFunctions',
	'author' => 'Ryan Schmidt',
	'description' => 'Permission-based parser functions',
	'descriptionmsg' => 'rightfunctions-desc',
);

$wgExtensionMessageFiles['RightFunctions'] = dirname(__FILE__) . '/RightFunctions.i18n.php';
$wgHooks['LanguageGetMagic'][] = 'wfRightFunctionsLanguageGetMagic';

//Default globals. Wrapping in isset() so that it doesn't override any previously-defined stuff
$wgRightFunctionsUserGroups = isset($wgRightFunctionsUserGroups) ? $wgRightFunctionsUserGroups : array('*', 'user', 'autoconfirmed', 'sysop', 'bureaucrat');
$wgRightFunctionsAllowExpensiveQueries = isset($wgRightFunctionsAllowExpensiveQueries) ? $wgRightFunctionsAllowExpensiveQueries : true;
$wgRightFunctionsAllowCaching = isset($wgRightFunctionsAllowCaching) ? $wgRightFunctionsAllowCaching : false;
$wgRightFunctionsDisableFunctions = isset($wgRightFunctionsDisableFunctions) ? $wgRightFunctionsDisableFunctions : array();

function wfRightFunctions() {
	global $wgParser, $wgExtRightFunctions;

	$wgExtRightFunctions = new ExtRightFunctions();
	$wgParser->setFunctionHook( 'ifright', array(&$wgExtRightFunctions, 'ifright') );
	$wgParser->setFunctionHook( 'ifallowed', array(&$wgExtRightFunctions, 'ifallowed') );
	$wgParser->setFunctionHook( 'switchright', array( &$wgExtRightFunctions, 'switchright') );
	$wgParser->setFunctionHook( 'userrights', array(&$wgExtRightFunctions, 'userrights') );
	$wgParser->setFunctionHook( 'usergroup', array(&$wgExtRightFunctions, 'usergroup') );
	$wgParser->setFunctionHook( 'ifgroup', array(&$wgExtRightFunctions, 'ifgroup') );
	$wgParser->setFunctionHook( 'switchgroup', array(&$wgExtRightFunctions, 'switchgroup') );
	$wgParser->setFunctionHook( 'ifpageright', array(&$wgExtRightFunctions, 'ifpageright') );
	$wgParser->setFunctionHook( 'ifpageallowed', array(&$wgExtRightFunctions, 'ifpageallowed') );
	$wgParser->setFunctionHook( 'ifprotected', array(&$wgExtRightFunctions, 'ifprotected') );
	$wgParser->setFunctionHook( 'getrestrictions', array(&$wgExtRightFunctions, 'getrestrictions') );
}

function wfRightFunctionsLanguageGetMagic( &$magicWords, $langCode ) {
	switch ( $langCode ) {
	default:
		$magicWords['ifright'] = array( 0, 'ifright' );
		$magicWords['ifallowed'] = array( 0, 'ifallowed' );
		$magicWords['switchright'] = array( 0, 'switchright' );
		$magicWords['userrights'] = array( 0, 'userrights' );
		$magicWords['usergroup'] = array( 0, 'usergroup' );
		$magicWords['ifgroup'] = array( 0, 'ifgroup' );
		$magicWords['switchgroup'] = array( 0, 'switchgroup' );
		$magicWords['ifpageright'] = array( 0, 'ifpageright' );
		$magicWords['ifpageallowed'] = array( 0, 'ifpageallowed' );
		$magicWords['ifprotected'] = array( 0, 'ifprotected' );
		$magicWords['getrestrictions'] = array( 0, 'getrestrictions' );
	}
	return true;
}

Class ExtRightFunctions {
	function ifright( &$parser, $right = '', $then = '', $else = '' ) {
		global $wgUser, $wgRightFunctionsAllowCaching, $wgRightFunctionsDisableFunctions;
		if(in_array('ifright', $wgRightFunctionsDisableFunctions)) {
			return;
		}
		if(!$wgRightFunctionsAllowCaching) {
			$parser->disableCache();
		}
		if($wgUser->isAllowed($right)) {
			return $then;
		}
		return $else;
	}

	function ifallowed( &$parser, $name = '', $right = '', $then = '', $else = '') {
		global $wgRightFunctionsDisableFunctions, $wgRightFunctionsAllowCaching;
		if(in_array('ifallowed', $wgRightFunctionsDisableFunctions) || $name == '') {
			return;
		}
		if(!$wgRightFunctionsAllowCaching) {
			$parser->disableCache();
		}
		$user = User::newFromName($name);
		$user->load();
		if($user->isAllowed($right)) {
			return $then;
		}
		return $else;
	}

	function switchright( &$parser ) {
		$args = func_get_args();
		array_shift( $args );
		$found = false;
		$parts = null;
		$default = null;
		foreach( $args as $arg ) {
			$parts = array_map( 'trim', explode( '=', $arg, 2 ) );
			if ( count( $parts ) == 2 ) {
				if ( $found || $this->ifright($parser, $parts[0], true, false) ) {
					return $parts[1];
				} else {
					$mwDefault =& MagicWord::get( 'default' );
					if ( $mwDefault->matchStartAndRemove( $parts[0] ) ) {
						$default = $parts[1];
					}
				}
			} elseif ( count( $parts ) == 1 ) {
				if ( $this->ifright($parser, $parts[0], true, false) ) {
					$found = true;
				}
			}
		}

		if ( count( $parts ) == 1) {
			return $parts[0];
		} elseif ( !is_null( $default ) ) {
			return $default;
		} else {
			return '';
		}
	}

	function userrights( &$parser, $name = '' ) {
		global $wgUser, $wgRightFunctionsDisableFunctions, $wgRightFunctionsAllowCaching;
		if(in_array('userrights', $wgRightFunctionsDisableFunctions)) {
			return;
		}
		if(!$wgRightFunctionsAllowCaching) {
			$parser->disableCache();
		}
		if($name) {
			$user = User::newFromName($name);
			$user->load();
		} else {
			$user = $wgUser;
		}
		$userrights = "";
		$rights = $user->getRights();
		foreach($rights as $value) {
			$userrights = "$userrights"."\n* $value";
		}
		return trim($userrights);
	}

	function usergroup( &$parser, $name = '' ) {
		global $wgUser, $wgRightFunctionsUserGroups, $wgRightFunctionsDisableFunctions, $wgRightFunctionsAllowCaching;
		if(in_array('usergroup', $wgRightFunctionsDisableFunctions)) {
			return;
		}
		if(!$wgRightFunctionsAllowCaching) {
			$parser->disableCache();
		}
		if($name) {
			$user = User::newFromName($name);
			$user->load();
			$usergroups = $user->getEffectiveGroups(!$wgRightFunctionsAllowCaching);
		} else {
			$user = $wgUser;
			$usergroups = $wgUser->getEffectiveGroups(!$wgRightFunctionsAllowCaching);
		}
		$right = "";
		foreach($wgRightFunctionsUserGroups as $value) {
			if(in_array($value, $usergroups)) {
				$right = $value;
			} else {
				return $right;
			}
		}
		return $right;
	}

	function ifgroup(&$parser, $group = '', $then = '', $else = '', $name = '') {
		global $wgUser, $wgRightFunctionsDisableFunctions, $wgRightFunctionsAllowCaching;
		if(in_array('ifgroup', $wgRightFunctionsDisableFunctions)) {
			return;
		}
		if(!$wgRightFunctionsAllowCaching) {
			$parser->disableCache();
		}
		if($name) {
			$user = User::newFromName($name);
			$user->load();
			$usergroups = $user->getEffectiveGroups(!$wgRightFunctionsAllowCaching);
		} else {
			$user = $wgUser;
			$usergroups = $wgUser->getEffectiveGroups(!$wgRightFunctionsAllowCaching);
		}
		if(in_array($group, $usergroups)) {
			return $then;
		}
		return $else;
	}

	function switchgroup( &$parser ) {
		$args = func_get_args();
		array_shift( $args );
		$found = false;
		$parts = null;
		$default = null;
		foreach( $args as $arg ) {
			$parts = array_map( 'trim', explode( '=', $arg, 2 ) );
			if ( count( $parts ) == 2 ) {
				if ( $found || $this->ifgroup($parser, $parts[0], true, false) ) {
					return $parts[1];
				} else {
					$mwDefault =& MagicWord::get( 'default' );
					if ( $mwDefault->matchStartAndRemove( $parts[0] ) ) {
						$default = $parts[1];
					}
				}
			} elseif ( count( $parts ) == 1 ) {
				if ( $this->ifgroup($parser, $parts[0], true, false) ) {
					$found = true;
				}
			}
		}

		if ( count( $parts ) == 1) {
			return $parts[0];
		} elseif ( !is_null( $default ) ) {
			return $default;
		} else {
			return '';
		}
	}

	function ifpageright(&$parser, $right = '', $then = '', $else = '', $page = '') {
		global $wgUser, $wgRightFunctionsDisableFunctions, $wgRightFunctionsAllowExpensiveQueries, $wgRightFunctionsAllowCaching;
		if(in_array('ifpageright', $wgRightFunctionsDisableFunctions)) {
			return;
		}
		if(!$wgRightFunctionsAllowCaching) {
			$parser->disableCache();
		}
		if($page) {
			$title = Title::newFromText($page);
			if(!$title->exists())
				$title = $parser->getTitle();
		} else {
			$title = $parser->getTitle();
		}
		if($title->userCan($right, $wgRightFunctionsAllowExpensiveQueries)) {
			return $then;
		}
		return $else;
	}

	function ifpageallowed(&$parser, $name = '', $right = '', $then = '', $else = '', $page = '') {
		global $wgRightFunctionsAllowExpensiveQueries, $wgRightFunctionsDisableFunctions, $wgRightFunctionsAllowCaching;
		if(in_array('ifpageallowed', $wgRightFunctionsDisableFuntions) || $name == '') {
			return;
		}
		if(!$wgRightFunctionsAllowCaching) {
			$parser->disableCache();
		}
		$user = User::newFromName($name);
		$user->load();
		if($page) {
			$title = Title::newFromText($page);
			if(!$title->exists())
				$title = $parser->getTitle();
		} else {
			$title = $parser->getTitle();
		}
		if(!$title->getUserPermissionsErrors($right, $user, $wgRightFunctionsAllowExpensiveQueries)) {
			return $then;
		}
		return $else;
	}

	function ifprotected(&$parser, $then = '', $else = '', $page = '', $type = 'fscn') {
		global $wgRightFunctionsAllowCaching, $wgRightFunctionsDisableFunctions;
		if(in_array('ifprotected', $wgRightFunctionsDisableFunctions)) {
			return;
		}
		if(!$wgRightFunctionsAllowCaching) {
			$parser->disableCache();
		}
		if($page) {
			$title = Title::newFromText($page);
			if(!$title->exists())
				$title = $parser->getTitle();
		} else {
			$title = $parser->getTitle();
		}
		$type = "0{$type}"; //dummy first character so that strpos doesn't return 0.
		if($title->isProtected() && strpos($type, 'f')) {
			return $then;
		}
		if($title->isSemiProtected() && strpos($type, 's')) {
			return $then;
		}
		if($title->isCascadeProtected() && strpos($type, 'c')) {
			return $then;
		}
		if($title->isNamespaceProtected() && strpos($type, 'n')) {
			return $then;
		}
		return $else;
	}

	function getrestrictions(&$parser, $right = 'edit', $page = '', $returnall = false) {
		global $wgRightFunctionsAllowCaching, $wgRightFunctionsDisableFunctions, $wgRestrictionLevels;
		wfLoadExtensionMessages( 'RightFunctions' );
		if(in_array('getrestrictions', $wgRightFunctionsDisableFunctions)) {
			return;
		}
		if(!$wgRightFunctionsAllowCaching) {
			$parser->disableCache();
		}
		if($page) {
			$title = Title::newFromText($page);
			if(!$title->exists()) {
				$title = $parser->getTitle();
			}
		} else {
			$title = $parser->getTitle();
		}
		if(!$right) {
			$right = array('edit');
		}
		$iscascade = false;
		if($title->isCascadeProtected()) {
			$cascaderestrictions = $title->getCascadeProtectionSources();
			foreach(array_slice($cascaderestrictions, 1) as $groups) {
				foreach($groups as $action => $restrictions) {
					if($action == $right) {
						foreach($restrictions as $value) {
							$cascrest = $cascrest . ', ' . $value;
							$iscascade = true;
						}
					}
				}
			}
		}
		$cascrest = trim(trim($cascrest, ","));
		$localrest = $title->getRestrictions($right);
		if(is_array($localrest)){
			$localrest = array_pop($localrest);
		}
		if($returnall) {
			if($iscascade && $localrest) {
				return wfMsg('rightfunctions-restboth', array( $localrest, $cascrest ) );
			} elseif($iscascade && !$localrest) {
				return wfMsg('rightfunctions-restcasc', array( $cascrest ) );
			}
			return $localrest;
		}
		if($localrest && $iscascade) {
			$restrictions = explode(",", "{$localrest}, {$cascrest}");
		} elseif($iscascade && !$localrest) {
			if(strpos($cascrest, ",")) {
				$restrictions = explode(",", $cascrest);
			} else {
				return $cascrest;
			}
		} else {
			return $localrest;
		}
		$return = "";
		foreach($wgRestrictionLevels as $level) {
			foreach($restrictions as $group) {
				if(trim($group) == $level) {
					$return = $level;
					break(1);
				}
			}
		}
		return $return;
	}
}
