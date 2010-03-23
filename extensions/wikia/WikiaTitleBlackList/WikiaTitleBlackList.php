<?php

/**
 * Parse black-list of article's titles
 * use
 * 	- $wgBlackTitleListFiles - to define files with addresses
 * 	- $wgBlackListCacheTime - to define memcache expiry time
 *
 */

if ( ! defined( 'MEDIAWIKI' ) ) {
	die();
}

#---
$wgExtensionFunctions[] = 'wfBlackTitlelistMessageLoader';
$wgHooks['SpecialMovepageBeforeMove'][] = 'wfSpamBlackTitleBeforeMove';
$wgHooks['EditFilter'][] = 'wfSpamBlackTitleListCallback';
$wgHooks['UploadForm:BeforeProcessing'][] = 'wfSpamBlackTitleSpecialUpload';
$wgHooks['WikiaMiniUpload:BeforeProcessing'][] = 'wfSpamBlackTitleWikiaMiniUpload';
$wgHooks['ApiCreateMultiplePagesBeforeCreation'][] = 'wfSpamBlackTitleNewWikiBuilder';
$wgHooks['CreateDefaultQuestionPageFilter'][] = 'wfSpamBlacklistTitleGenericTitleCheck';

// other functions
function wfBlackTitleListParseSetup() {
	global $wgBlackTitleListFiles, $wgBlackListCacheTime;
	global $useSpamRegexNoHttp;

	$blackTitleListSetup = array();

	#---
	if ( empty($wgBlackTitleListFiles) ) # default values
		$blackTitleListSetup['files'] = null;
	else
		$blackTitleListSetup['files'] = (is_array($wgBlackTitleListFiles)) ? $wgBlackTitleListFiles : array($wgBlackTitleListFiles);
	#---
	if ( empty($wgBlackListCacheTime) ) # default values
		$blackTitleListSetup['expiryTime'] = 900;
	else
		$blackTitleListSetup['expiryTime'] = $wgBlackListCacheTime;

	return $blackTitleListSetup;
}

function wfBlackTitlelistMessageLoader() {
	global $wgMessageCache;
	if (file_exists('WikiaTitleBlackList.i18n.php')) {
		require_once( 'SpamBlacklist.i18n.php' );
		foreach( efTitleBlackListMessages() as $lang => $messages ) {
			$wgMessageCache->addMessages( $messages, $lang );
		}
	}
	return;
}

function wfSpamBlackTitleListCallback( $editPage, $text, $section, &$hookError ) {
	global $IP, $useSpamRegexNoHttp;
	#---
	wfProfileIn( __METHOD__ );
	$useSpamRegexNoHttp = 1;
	#---
	$retVal = true;
	$title = $editPage->mTitle;
	if (!($title instanceof Title)) {
		wfProfileOut( __METHOD__ );
		return $retVal;
	}
	/* */
	$retVal = wfBlackListTitleParse($title);
	/* */

	#---
	wfProfileOut( __METHOD__ );
	return $retVal;
}

function wfSpamBlackTitleBeforeMove( &$move ) {
	global $IP, $useSpamRegexNoHttp;
	$useSpamRegexNoHttp = 1;
	wfProfileIn( __METHOD__ );

	$retVal = true;
	$title = Title::newFromURL( $move->newTitle );
	if (!($title instanceof Title)) {
		wfProfileOut( __METHOD__ );
		return $retVal;
	}
	/* */
	$retVal = wfBlackListTitleParse($title);
	/* */

	wfProfileOut( __METHOD__ );
	return $retVal;
}

//used in Special:Upload
function wfSpamBlackTitleSpecialUpload($uploadForm) {
	global $useSpamRegexNoHttp;
	wfProfileIn( __METHOD__ );
	$useSpamRegexNoHttp = true;
	$retVal = true;

	if ($uploadForm instanceof UploadForm) {
		$title = Title::newFromText($uploadForm->mDesiredDestName, NS_IMAGE);
		if ($title instanceof Title) {
			$retVal = wfBlackListTitleParse($title);
		}
	}

	wfProfileOut( __METHOD__ );
	return $retVal;
}

//used in WikiaMiniUpload
function wfSpamBlackTitleWikiaMiniUpload($fileName) {
	global $useSpamRegexNoHttp;
	wfProfileIn( __METHOD__ );
	$useSpamRegexNoHttp = true;
	$retVal = true;

	$title = Title::newFromText($fileName, NS_IMAGE);
	if ($title instanceof Title) {
		$retVal = wfBlackListTitleParse($title);
	}
	wfProfileOut( __METHOD__ );
	return $retVal;
}

//used in NewWikiBuilder
function wfSpamBlackTitleNewWikiBuilder( $api, $titleObj, $category, $text ) {
	global $useSpamRegexNoHttp;
	wfProfileIn( __METHOD__ );
	$useSpamRegexNoHttp = true;
	$retVal = true;

	// titleObj is already verified as object earlier in NWB
	$retVal = wfBlackListTitleParse($titleObj);

	wfProfileOut( __METHOD__ );
	return $retVal;
}

//used in Answer's CreateDefaultQuestionPage
function wfSpamBlacklistTitleGenericTitleCheck( $titleObj ) {
	global $useSpamRegexNoHttp;
	wfProfileIn( __METHOD__ );
	$useSpamRegexNoHttp = true;
	$retVal = true;

	// titleObj is already verified as object earlier in CDQP
	if ($titleObj instanceof Title) {
		$retVal = wfBlackListTitleParse($titleObj);
	}

	wfProfileOut( __METHOD__ );
	return $retVal;
}

function wfBlackListTitleParse($title) {
	wfProfileIn( __METHOD__ );

	$retVal = true;
	$setup = wfBlackTitleListParseSetup();
	$aBlackListRegexes = array();
	$blacklist = WikiaTitleBlackList::Instance($setup);
	if (is_object($blacklist)) {
		$aBlackListRegexes = $blacklist->getRegexes();
		# check edited page title -> if page with regexes just clear memcache.
		$blacklist->getSpamList()->clearListMemCache();
	}

	if (!empty($aBlackListRegexes) && is_array($aBlackListRegexes)) {
		wfDebug( "Checking text against " . count( $aBlackListRegexes ) . " regexes: " . implode( ', ', $aBlackListRegexes ) . "\n" );
		foreach ($aBlackListRegexes as $id => $regex) {
			$m = array();
			if (preg_match($regex, strtolower($title->getText()), $m)) {
				wfDebug( "Match!\n" );
				SpamRegexBatch::spamPage( $m[0], $title );
				$retVal = false;
				break;
			}
			if (preg_match($regex, strtolower($title->getFullText()), $m)) {
				wfDebug( "Match!\n" );
				SpamRegexBatch::spamPage( $m[0], $title );
				$retVal = false;
				break;
			}
		}
	}

	if ($retVal) {
		# Call the rest of the hook chain first
		if ( is_object($blacklist) ) {
			$f = $blacklist->getSpamList()->getPreviousFilter();
			if ( ( !empty($f) ) && (function_exists($f)) ) {
				if ( $f( $title, $text, $section ) )
				{
					$retVal = false;
				}
			}
		}
	}

	wfProfileOut( __METHOD__ );
	return $retVal;
}

#----
#
#
class WikiaTitleBlackList {
	private $spamList = null;
	private $settings = array();
	private static $_oInstance = null;

	private function __construct( $settings ) {
		global $wgDBname;
		foreach ( $settings as $name => $value ) {
			$this->$name = $value;
		}
		wfDebug ("build list of black-titles \n");
		$use_prefix = 0;
		if (empty($settings['regexes'])) {
			$settings['regexes'] = false;
		}
		if (empty($settings['previousFilter'])) {
			$settings['previousFilter'] = false;
		}
		if (empty($settings['files'])) {
			$settings['files'] = array("DB: wikicities MediaWiki:Blacklist_title_list");
		} else {
			$use_prefix = 1;
		}
		if (empty($settings['warningTime'])) {
			$settings['warningTime'] = 600;
		}
		if (empty($settings['expiryTime'])) {
			$settings['expiryTime'] = 900;
		}
		if (empty($settings['warningChance'])) {
			$settings['warningChance'] = 100;
		}
		if (empty($settings['memcache_file'])) {
			$settings['memcache_file']  = 'blacklist_title_file'.(($use_prefix == 1) ? '_'.$wgDBname : "");
		}
		if (empty($settings['memcache_regexes'])) {
			$settings['memcache_regexes'] = 'blacklist_title_regexes'.(($use_prefix == 1) ? '_'.$wgDBname : "");
		}

		$this->settings = $settings;
		$this->spamList = new SpamRegexBatch("BlackListTitles", $this->settings);
		$this->regexes = $this->spamList->getRegexes();
	}

	public static function Instance($settings = array()) {
		if(!self::$_oInstance instanceof self) {
			wfDebug("New instamce of WikiaTitleBlackList class \n");
			self::$_oInstance = new self($settings);
		}
		return self::$_oInstance;
	}

	public function getSettings() { return $this->settings; }
	public function getSpamList() { return $this->spamList; }
	public function getRegexes()  { return $this->regexes; }
}
?>
