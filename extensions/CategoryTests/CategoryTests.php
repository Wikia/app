<?php
/*
* CategoryTests extension by Ryan Schmidt
* Functions for category testing
* Check http://www.mediawiki.org/wiki/Extension:CategoryTests for more info on what everything does
*/

if( !defined( 'MEDIAWIKI' ) ) {
	echo "This file is an extension of the MediaWiki software and cannot be used standalone\n";
	die( 1 );
}

//credits and hooks
$wgExtensionFunctions[] = 'wfCategoryTests';
$wgExtensionCredits['parserhook'][] = array(
	'name' => 'Category Tests',
	'version' => '1.2',
	'url' => 'http://www.mediawiki.org/wiki/Extension:CategoryTests',
	'author' => 'Ryan Schmidt',
	'description' => 'Functions for category testing',
	'descriptionmsg' => 'categorytests',
);

$wgHooks['LanguageGetMagic'][] = 'wfCategoryTestsLanguageGetMagic';
$wgExtensionMessagesFiles['CategoryTests'] = dirname(__FILE__) . '/CategoryTests.i18n.php';

function wfCategoryTests() {
	global $wgParser, $wgExtCategoryTests;
	
	$wgExtCategoryTests = new ExtCategoryTests();
	$wgParser->setFunctionHook( 'ifcategory', array(&$wgExtCategoryTests, 'ifcategory') );
	$wgParser->setFunctionHook( 'ifnocategories', array(&$wgExtCategoryTests, 'ifnocategories') );
	$wgParser->setFunctionHook( 'switchcategory', array(&$wgExtCategoryTests, 'switchcategory') );
}

function wfCategoryTestsLanguageGetMagic( &$magicWords, $langCode ) {
	require_once(dirname(__FILE__) . '/CategoryTests.i18n.magic.php');
	if( $langCode == 'en' || !array_key_exists($langCode, $words) ) {
		$functions = $words['en'];
	} else {
		$functions = array_merge($words[$langCode], $words['en']);
	}
	foreach($functions as $key => $value) {
		$magicWords[$key] = $value;
	}
	return true;
} 

Class ExtCategoryTests {
	
	function ifcategory( &$parser, $category = '', $then = '', $else = '', $pagename = '' ) {
		if($category === '') {
			return $then;
		}
		if($pagename === '') {
			$title = $parser->getTitle();
			$page = $title->getDBkey();
			$ns = $title->getNamespace();
		} else {
			$title = Title::newFromText($pagename);
			if(!$title->exists())
				return $else;
			$page = $title->getDBkey();
			$ns = $title->getNamespace();
		}
		$cattitle = Title::makeTitleSafe(NS_CATEGORY, $category);
		$catkey = $cattitle->getDBkey();
		$db = wfGetDb(DB_SLAVE);
		$res = $db->select(array('page', 'categorylinks'), 'cl_from', array(
					'page_id=cl_from',
					'page_namespace' => $ns,
					'page_title' => $page,
					'cl_to' => $catkey), __METHOD__,
					array('LIMIT' => 1));
		if($db->numRows($res) == 0)
			return $else;
		return $then;
	}

	function ifnocategories( &$parser, $then = '', $else = '', $pagename = '' ) {
		if($pagename === '') {
			$title = $parser->getTitle();
			$page = $title->getDBkey();
			$ns = $title->getNamespace();
		} else {
			$title = Title::newFromText($pagename);
			if(!$title->exists())
				return $then;
			$page = $title->getDBkey();
			$ns = $title->getNamespace();
		}
		$db = wfGetDb(DB_SLAVE);
		$res = $db->select(array('page', 'categorylinks'), 'cl_from', array(
					'page_id=cl_from',
					'page_namespace' => $ns,
					'page_title' => $page), __METHOD__,
					array('LIMIT' => 1));
		if($db->numRows($res) == 0)
			return $then;
		return $else;
	}
	
	function switchcategory( &$parser ) {
		$args = func_get_args();
		array_shift( $args );
		$found = false;
		$parts = null;
		$default = null;
		$page = '';
		foreach( $args as $arg ) {
			$parts = array_map( 'trim', explode( '=', $arg, 2 ) );
			if ( count( $parts ) == 2 ) {
				$mwPage = MagicWord::get( 'page' );
				if( $mwPage->matchStartAndRemove( $parts[0] ) ) {
					$page = $parts[1];
					continue;
				}
				if ( $found || $this->ifcategory($parser, $parts[0], true, false, $page) ) {
					return $parts[1];
				} else {
					$mwDefault = MagicWord::get( 'default' );
					if ( $mwDefault->matchStartAndRemove( $parts[0] ) ) {
						$default = $parts[1];
					}
				}
			} elseif ( count( $parts ) == 1 ) {
				if ( $this->ifcategory($parser, $parts[0], true, false, $page) ) {
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
}