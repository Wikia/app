<?php
/**
 * InterwikiDispatcher - see ticket #2954
 *
 * @author Maciej Błaszkowski (Marooned) <marooned at wikia-inc.com>
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia.com>
 *
 * @date 2008-07-08
 * @copyright Copyright (C) 2008 Maciej Błaszkowski, Wikia Inc.
 * @license http://www.gnu.org/copyleft/gpl.html GNU General Public License 2.0 or later
 * @package MediaWiki
 * @subpackage SpecialPage
 *
 * To activate this functionality, place this file in your extensions/
 * subdirectory, and add the following line to LocalSettings.php:
 *     require_once("$IP/extensions/wikia/InterwikiDispatcher/SpecialInterwikiDispatcher.php");
 */

if (!defined('MEDIAWIKI')) {
	echo "This is MediaWiki extension named InterwikiDispatcher.\n";
	exit(1) ;
}

class InterwikiDispatcher extends UnlistedSpecialPage {
	const IS_WIKI_EXISTS_CACHE_TTL = 10800;
	/**
	 * contructor
	 */
	function  __construct() {
		parent::__construct('InterwikiDispatcher' /*class*/);
	}

	function execute($subpage) {
		global $wgOut, $wgRequest, $wgNotAValidWikia, $IP;

		$redirect = $wgNotAValidWikia;
		$wikia = $wgRequest->getText('wikia');
		$art = $wgRequest->getText('article');

		if (!empty($wikia)) {
			// The code in NotAValidWikiaArticle.class.php will drop the ".interwiki" pseudo-TLD
			// When constructing the search query
			$redirect .= '?from=' . rawurlencode( $wikia . '.interwiki' );
			$iCityId = self::isWikiExists($wikia);
			if ($iCityId) {	//wiki exists
				$redirect = self::getCityUrl($iCityId);
				if (empty($art)) {	//no article set - redir to the main page
					$output = null;
					exec ("'echo Title::newMainPage();' | SERVER_ID={$iCityId} php $IP/maintenance/eval.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php", $output);
					if (count($output)) {
						$redirect .= '/index.php?title=' . $output[0];
					}
				} else {	//article provided
					$redirect .= '/index.php?title=' . $art;
				}
			}
		}
//		$wgOut->SetPageTitle(wfMsg('interwikidispatcher'));
		$wgOut->redirect($redirect, 301);
	}

	private static function isWikiExists($sName) {
		global $wgExternalSharedDB, $wgMemc;

		$cacheKey = wfSharedMemcKey( __METHOD__ . ':' . $sName );

		$cachedValue = $wgMemc->get( $cacheKey );
		if( is_numeric( $cachedValue ) ) {
			if ($cachedValue > 0) {
				return $cachedValue;
			} else {
				return false;
			}
		}

		$DBr = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
		$dbResult = $DBr->Query(
			  'SELECT city_id'
			. ' FROM city_domains'
			. ' WHERE city_domain = ' . $DBr->AddQuotes("$sName.wikia.com")
			. ' LIMIT 1'
			. ';'
			, __METHOD__
		);

		if ($row = $DBr->FetchObject($dbResult)) {
			$DBr->FreeResult($dbResult);
			$wgMemc->set( $cacheKey, intval( $row->city_id ), self::IS_WIKI_EXISTS_CACHE_TTL );
			return intval( $row->city_id );
		}
		else {
			$DBr->FreeResult($dbResult);
			$wgMemc->set( $cacheKey, 0, self::IS_WIKI_EXISTS_CACHE_TTL );
			return false;
		}
	}

	private static function getCityUrl($iCityId) {
		return WikiFactory::getVarValueByName('wgServer', $iCityId);
	}

	public static function getInterWikiaURL(Title &$title, &$url, $query) {
		global $wgArticlePath, $wgScriptPath;

		if (in_array($title->mInterwiki, array('w', 'wikia', 'wikicities'))) {
			$aLinkParts = explode(':', $title->getFullText());
			if ($aLinkParts[1] == 'c') {
				$iCityId = self::isWikiExists($aLinkParts[2]);
				if ($iCityId) {
					$sArticlePath = WikiFactory::getVarValueByName('wgArticlePath', $iCityId);

					//I've replaced wgArticlePath to hardcoded value in order to fix FogBug:3066
					//This is a persistent issue with getting default value of variable that is not set in WikiFactory
					//Similar problem exists when displaying "default value" in WikiFactory - it's not the real default (taken from file)
					//it's value for current wiki (community for WikiFactory, www.wikia.com  for 3066 bug)
					//anyway - current value in CommonSettings.php for wgArticlePath is '/wiki/$1' that's why this hardcoded
					//fix will work.. for now.. it would be nice to introduce some function to get REAL DEFAULT VALUE for any variable
					//Marooned
					$sArticlePath = !empty($sArticlePath) ? $sArticlePath : '/wiki/$1'; //$wgArticlePath;

					/* $wgScriptPath is already included in city_url
					$sScriptPath = WikiFactory::getVarValueByName('wgScriptPath', $iCityId);
					$sScriptPath = !empty($sScriptPath) ? $sScriptPath : $wgScriptPath;
					*/

					if (!empty($sArticlePath)) {
						$sArticleTitle = '';
						for($i = 3; $i < count($aLinkParts); $i++) {
							$sArticleTitle .= (!empty($sArticleTitle) ? ':' : '') . $aLinkParts[$i];
						}

						//RT#54264,#41254
						$sArticleTitle = str_replace(' ', '_', $sArticleTitle);
						$sArticleTitle = wfUrlencode($sArticleTitle);

						$sCityUrl = self::getCityUrl($iCityId);
						if (!empty($sCityUrl)) {
							$url = str_replace( '$1', $sArticleTitle, $sArticlePath);
							$url = $sCityUrl . $url;
						}
					}
				}
			}
		}
		return true;
	}
}
