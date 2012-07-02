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

//credits
$wgExtensionCredits['parserhook'][] = array(
	'path' => __FILE__,
	'name' => 'RightFunctions',
	'version' => '1.10',
	'url' => 'https://www.mediawiki.org/wiki/Extension:RightFunctions',
	'author' => 'Ryan Schmidt',
	'descriptionmsg' => 'rightfunctions-desc',
);

$wgExtensionMessagesFiles['RightFunctions'] = dirname(__FILE__) . '/RightFunctions.i18n.php';
$wgExtensionMessagesFiles['RightFunctionsMagic'] = dirname(__FILE__) . '/RightFunctions.i18n.magic.php';
$wgHooks['ParserFirstCallInit'][] = 'ExtRightFunctions::onParserFirstCallInit';

//Default globals.
$wgRightFunctionsUserGroups = array( '*', 'user', 'autoconfirmed', 'sysop', 'bureaucrat' );
$wgRightFunctionsAllowExpensiveQueries = true;
$wgRightFunctionsAllowCaching = false;
$wgRightFunctionsDisableFunctions = array();

Class ExtRightFunctions {
	public static function onParserFirstCallInit( $parser ) {
		$parser->setFunctionHook( 'ifright', array( __CLASS__, 'ifright' ) );
		$parser->setFunctionHook( 'ifallowed', array( __CLASS__, 'ifallowed' ) );
		$parser->setFunctionHook( 'switchright', array( __CLASS__, 'switchright' ) );
		$parser->setFunctionHook( 'userrights', array( __CLASS__, 'userrights' ) );
		$parser->setFunctionHook( 'usergroup', array( __CLASS__, 'usergroup' ) );
		$parser->setFunctionHook( 'ifgroup', array( __CLASS__, 'ifgroup' ) );
		$parser->setFunctionHook( 'switchgroup', array( __CLASS__, 'switchgroup' ) );
		$parser->setFunctionHook( 'ifpageright', array( __CLASS__, 'ifpageright' ) );
		$parser->setFunctionHook( 'ifpageallowed', array( __CLASS__, 'ifpageallowed' ) );
		$parser->setFunctionHook( 'ifprotected', array( __CLASS__, 'ifprotected' ) );
		$parser->setFunctionHook( 'getrestrictions', array( __CLASS__, 'getrestrictions' ) );

		return true;
	}

	public static function ifright( &$parser, $right = '', $then = '', $else = '' ) {
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

	public static function ifallowed( &$parser, $name = '', $right = '', $then = '', $else = '') {
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

	public static function switchright( &$parser ) {
		$args = func_get_args();
		array_shift( $args );
		$found = false;
		$parts = null;
		$default = null;
		foreach( $args as $arg ) {
			$parts = array_map( 'trim', explode( '=', $arg, 2 ) );
			if ( count( $parts ) == 2 ) {
				if ( $found || self::ifright($parser, $parts[0], true, false) ) {
					return $parts[1];
				} else {
					$mwDefault =& MagicWord::get( 'default' );
					if ( $mwDefault->matchStartAndRemove( $parts[0] ) ) {
						$default = $parts[1];
					}
				}
			} elseif ( count( $parts ) == 1 ) {
				if ( self::ifright($parser, $parts[0], true, false) ) {
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

	public static function userrights( &$parser, $name = '' ) {
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

	public static function usergroup( &$parser, $name = '' ) {
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
			}
		}
		return $right;
	}

	public static function ifgroup(&$parser, $group = '', $then = '', $else = '', $name = '') {
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

	public static function switchgroup( &$parser ) {
		$args = func_get_args();
		array_shift( $args );
		$found = false;
		$parts = null;
		$default = null;
		foreach( $args as $arg ) {
			$parts = array_map( 'trim', explode( '=', $arg, 2 ) );
			if ( count( $parts ) == 2 ) {
				if ( $found || self::ifgroup($parser, $parts[0], true, false) ) {
					return $parts[1];
				} else {
					$mwDefault =& MagicWord::get( 'default' );
					if ( $mwDefault->matchStartAndRemove( $parts[0] ) ) {
						$default = $parts[1];
					}
				}
			} elseif ( count( $parts ) == 1 ) {
				if ( self::ifgroup($parser, $parts[0], true, false) ) {
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

	public static function ifpageright(&$parser, $right = '', $then = '', $else = '', $page = '') {
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

	public static function ifpageallowed(&$parser, $name = '', $right = '', $then = '', $else = '', $page = '') {
		global $wgRightFunctionsAllowExpensiveQueries, $wgRightFunctionsDisableFunctions, $wgRightFunctionsAllowCaching;
		if(in_array('ifpageallowed', $wgRightFunctionsDisableFunctions) || $name == '') {
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

	public static function ifprotected(&$parser, $then = '', $else = '', $page = '', $type = 'fscn') {
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
		if(strpos($type, 'n')) {
			global $wgNamespaceProtection;
			$ns = $title->getNamespace();
			if(isset($wgNamespaceProtection[$ns])) {
				return $then;
			}
		}
		return $else;
	}

	public static function getrestrictions(&$parser, $right = 'edit', $page = '', $returnall = false) {
		global $wgRightFunctionsAllowCaching, $wgRightFunctionsDisableFunctions, $wgRestrictionLevels, $wgNamespaceProtection;
		
		if(in_array('getrestrictions', $wgRightFunctionsDisableFunctions)) {
			return;
		}
		if(!$wgRightFunctionsAllowCaching) {
			$parser->disableCache();
		}
		$sep = wfMsg('rightfunctions-sep');
		$localmsg = wfMsg('rightfunctions-local');
		$cascmsg = wfMsg('rightfunctions-casc');
		$nsmsg = wfMsg('rightfunctions-ns');
		
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
		$cascrest = '';
		if($title->isCascadeProtected()) {
			$cascaderestrictions = $title->getCascadeProtectionSources();
			foreach(array_slice($cascaderestrictions, 1) as $groups) {
				foreach($groups as $action => $restrictions) {
					if($action == $right) {
						foreach($restrictions as $value) {
							$cascrest .= $sep . ' ' . $value;
							$iscascade = true;
						}
					}
				}
			}
		}
		$cascrest = trim(trim($cascrest, $sep));
		$localrest = $title->getRestrictions($right);
		if(is_array($localrest)){
			$localrest = array_pop($localrest);
		}
		$isns = false;
		$nsrest = '';
		if(isset($wgNamespaceProtection[$title->getNamespace()])) {
			$isns = true;
			$nsresta = (array) $wgNamespaceProtection[$title->getNamespace()];
			foreach($nsresta as $right) {
				if($right != '') {
					$nsrest .= $sep . ' ' . $right;
				}
			}
		}
		$nsrest = trim(trim($nsrest, $sep));
		if($returnall) {
			if($iscascade && $isns && $localrest) {
				return wfMsg('rightfunctions-rest3', array( $localrest, $localmsg, $cascrest, $cascmsg, $nsrest, $nsmsg, $sep ) );
			} elseif($iscascade && $localrest) {
				return wfMsg('rightfunctions-rest2', array( $localrest, $localmsg, $cascrest, $cascmsg, $sep ) );
			} elseif($isns && $localrest) {
				return wfMsg('rightfunctions-rest2', array( $localrest, $localmsg, $nsrest, $nsmsg, $sep ) );
			} elseif($iscascade && $isns) {
				return wfMsg('rightfunctions-rest2', array( $cascrest, $cascmsg, $nsrest, $nsmsg, $sep ) );
			} elseif($iscascade) {
				return wfMsg('rightfunctions-rest1', array( $cascrest, $cascmsg ) );
			} elseif($isns) {
				return wfMsg('rightfunctions-rest1', array( $nsrest, $nsmsg ) );
			} elseif($localrest != '') {
				return wfMsg('rightfunctions-rest1', array( $localrest, $localmsg ) );
			} else {
				return '';
			}
		}
		$restrictions = explode($sep, $localrest . $sep . $cascrest);
		$return = "";
		foreach($wgRestrictionLevels as $level) {
			foreach($restrictions as $right) {
				if(trim($right) == $level) {
					$return = $level;
					break(1);
				}
			}
		}
		if($isns) {
			$return = trim(trim($return . $sep. ' ' . $nsrest, $sep));
		}
		return $return;
	}
}
