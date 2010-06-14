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
	/**
	 * contructor
	 */
	function  __construct() {
		parent::__construct('InterwikiDispatcher' /*class*/);
	}

	function execute($subpage) {
		global $wgOut, $wgRequest, $wgNotAValidWikia;

		wfLoadExtensionMessages('SpecialInterwikiDispatcher');

		$redirect = $wgNotAValidWikia;
		$wikia = $wgRequest->getText('wikia');
		$art = $wgRequest->getText('article');

		if (!empty($wikia)) {
			$iCityId = self::isWikiExists($wikia);
			if ($iCityId) {	//wiki exists
				$redirect = self::getCityUrl($iCityId);
				if (empty($art)) {	//no article set - redir to the main page
					$output = null;
					exec ("'echo Title::newMainPage();' | SERVER_ID={$row->city_id} /opt/wikia/php/bin/php /usr/wikia/source/wiki/maintenance/eval.php --conf /usr/wikia/docroot/wiki.factory/LocalSettings.php", $output);
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
		global $wgExternalSharedDB;
		$DBr = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
		$dbResult = $DBr->Query(
			  'SELECT city_id'
			. ' FROM city_domains'
			. ' WHERE city_domain = ' . $DBr->AddQuotes("$sName.wikia.com")
			. ' LIMIT 1'
			. ';'
			, __METHOD__
		);

		if($row = $DBr->FetchObject($dbResult)) {
			$DBr->FreeResult($dbResult);
			return $row->city_id;
		}
		else {
			$DBr->FreeResult($dbResult);
			return false;
		}
	}

	private static function getCityUrl($iCityId) {
		return WikiFactory::getVarValueByName('wgServer', $iCityId);
	}

	public static function getInterWikiaURL(&$title, &$url, $query) {
		global $wgArticlePath, $wgScriptPath;

		if(in_array($title->mInterwiki, array('w', 'wikia', 'wikicities'))) {
			$aLinkParts = explode(':', $title->getFullText());
			if($aLinkParts[1] == 'c') {
				$iCityId = self::isWikiExists($aLinkParts[2]);
				if($iCityId) {
					$sArticlePath = WikiFactory::getVarValueByName('wgArticlePath', $iCityId);
					$sArticlePath = !empty($sArticlePath) ? $sArticlePath : $wgArticlePath;

					/* $wgScriptPath is already included in city_url
					$sScriptPath = WikiFactory::getVarValueByName('wgScriptPath', $iCityId);
					$sScriptPath = !empty($sScriptPath) ? $sScriptPath : $wgScriptPath;
					*/

					if(!empty($sArticlePath)) {
						$sArticleTitle = "";
						for($i = 3; $i < count($aLinkParts); $i++) {
							$sArticleTitle .= (!empty($sArticleTitle)?":":"") . $aLinkParts[$i];
						}
						//RT#54264
						$sArticleTitle = str_replace(' ', '_', $sArticleTitle);

						$sCityUrl = self::getCityUrl($iCityId);
						if(!empty($sCityUrl)) {
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
