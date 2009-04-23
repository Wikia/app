<?php
/**
 * SearchRankBot - part of SearchRankTracker extension
 *
 * (Based on code originaly written by Tomek Klim)
 *
 * !IMPORTANT! Please see SearchRankTracker.sql for db shema !IMPORTANT!
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia.com>
 *
 */

class SearchRankBot {

	private $mDebugMode = false;
	private $mCacheDir = false;
	private $mCacheExpire = 4; // in hours
	private $mMaxResultFetched = 100;
	private $mUserAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.2; SV1; .NET CLR 1.1.4322)';
	private $mCurlEngine = null;

	public function __construct($sCacheDir = '', $sProxyUrl = '', $bDebugMode = false) {
		$this->mDebugMode = $bDebugMode;
		$this->mCacheDir = $sCacheDir;

		if(class_exists('WikiCurl')) {
			$this->mCurlEngine = new WikiCurl();
			$this->mCurlEngine->setTimeout(90);
			$this->mCurlEngine->setCookies('cookies');
			$this->mCurlEngine->setAgent($this->mUserAgent);
			if(!empty($sProxyUrl)) {
				$this->mCurlEngine->setProxy($sProxyUrl);
			}

			if($this->mCacheDir) {
				$this->mCurlEngine->setCacheDir($this->mCacheDir);
				$this->mCurlEngine->setCachePeriod(3600 * $this->mCacheExpire);
				$this->mCurlEngine->buildCacheTree();
			}
		}
		else {
			print "SearchRankBot ERROR: WikiCurl extension required.\n";
			exit(1);
		}

	}

	public function __destruct() {
		unset($this->mCurlEngine);
	}

	public function setCacheExpire($iHours) {
		$this->mCacheExpire = $iHours;
	}

	public function setUsetAgent($sUserAgent) {
		$this->mUserAgent = $sUserAgent;
	}

	public function setMaxResultFetched($iValue) {
		$this->mMaxResultFetched = $iValue;
	}

	public function setProxy($sProxyUrl) {
		if($this->mCurlEngine != null) {
			$this->mCurlEngine->setProxy($sProxyUrl);
		}
	}


	public function run($bVerbose = true, $iEntryId = 0, $iMaxEntriesLimit = 0) {
		global $wgSharedDB, $wgSearchRankTrackerConfig;
		$this->printDebug("Starting SearchRankBot ...", $bVerbose);

//		$sCurrentTime = date('Y-m-d H:i:s');
		$sCurrentTime = date('Y-m-d', strtotime('last sunday'));
		$iCurrentYear = date('Y', strtotime($sCurrentTime));
		$iCurrentMonth = date('m', strtotime($sCurrentTime));
		$iCurrentDay = date('d', strtotime($sCurrentTime));

		$dbr = wfGetDB(DB_SLAVE);
		$dbr->selectDB($wgSharedDB);

		$oResource = $dbr->query("SELECT * FROM rank_entry " . ($iEntryId ? "WHERE ren_id='" . addslashes($iEntryId) . "' " : "") . "ORDER BY ren_city_id, ren_id");

		if($oResource) {
			$iResultsFetched = 0;
			while($oResultRow = $dbr->fetchObject($oResource)) {
				if($iMaxEntriesLimit && ($iResultsFetched > $iMaxEntriesLimit)) {
					break;
				}
				// get entry object
				$oSearchEntry = new SearchRankEntry(0, $oResultRow);
				$this->printDebug("-> Checking rank for Page Name: " . $oSearchEntry->getPageName() . ", Phrase: \"" . $oSearchEntry->getPhrase() . "\" (ren_id: " . $oSearchEntry->getId() . ")", $bVerbose);
				foreach($wgSearchRankTrackerConfig['searchEngines'] as $sEngineName => $aEngineConfig) {
					$oRankResults = $oSearchEntry->getRankResults($sEngineName, $iCurrentYear, $iCurrentMonth, $iCurrentDay);
					if(!$oRankResults) {
						$iRank = $this->getRank($sEngineName, $oSearchEntry);
					 $iResultInsertId = $oSearchEntry->setRankResult($sEngineName, $sCurrentTime, $iRank);
					 if($iResultInsertId) {
					 	$this->printDebug("=> ($sEngineName) Rank result saved. (rre_id: $iResultInsertId)");
					 }
					 else {
					 	$this->printDebug("=> ($sEngineName) ERROR: Rank result save failed.");
					 }
						$iResultsFetched++;
					}
					else {
						$this->printDebug("   ($sEngineName) Rank result exists for current date.", $bVerbose);
					}
				}
			}
		}
		else {
			$this->printDebug("No serach entries were found.", $bVerbose);
		}

		$this->printDebug("Done.", $bVerbose);
	}

	public function getRank($sSearchEngine, $oSearchEntry) {
		if($sSearchEngine != 'google') {
			$this->printDebug("=> ERROR: search engine unknown: $sEngineName");
			return 0;
		}
		else {
			$iRank = $this->rankGoogle($oSearchEntry);
			return $iRank;
		}
	}

	private function rankGoogle($oSearchEntry) {
		$sPhrase = $oSearchEntry->getPhrase();
		$sUrl = $oSearchEntry->getPageName();

		$iRank = 0;
		$iCount = 0;
		$iOffset = 0;

		$this->mCurlEngine->setReferer('http://www.google.com/');

		while($iRank == 0) {
			$iDelayTime = rand(0,6);
		 if($iDelayTime) {
				sleep($iDelayTime);
			 $this->printDebug("=> (google) CURL call delayed for $iDelayTime secs.");
		 }

			$sResult = $this->mCurlEngine->get('http://www.google.com/search',
				array(
					'q'     => $sPhrase,
				 'num'   => '100',
				 'start' => $iOffset,
				 'hl'    => 'en',
				 'lr'    => '',
				 'sa'    => 'N'
				));

			preg_match_all( '/<h3 class=r><a href="(.*?)" class=l/si', $sResult, $aLinks, PREG_SET_ORDER );

			if(count($aLinks)) {
				foreach($aLinks as $sLink) {
					$iCount++;
					// filter out trailing slashes
					$sLinkFiltered = ( substr( $sLink[1], -1, 1 ) == '/' ? substr( $sLink[1], 0, -1 ) : $sLink[1] );

					if(strpos($sLinkFiltered, $sUrl) !== false) {
						$iRank = $iCount;
						$this->printDebug("=> (google) Phrase: \"$sPhrase\", URL: $sUrl - found at position: $iCount");
						break;
					}
				}
			}
			else {
				// no links were found, end of results or invalid pattern.
				$this->printDebug("=> (google) No links were found (end or results or invalid pattern) - offset: $iOffset", false, (!$iOffset?$sResult:""));
				break;
			}

			$iOffset += 100;
			if($iOffset >= $this->mMaxResultFetched) {
				// we've ran out of Google results
				break;
			}
		}

		return $iRank;
	}

	private function printDebug($sMessage, $bForceDebugMode = false, $sExtraInfo = "") {
		if($this->mDebugMode || $bForceDebugMode) {
			print "[SearchRankBot] " . $sMessage . "\n";
			if(!empty($sExtraInfo)) {
				print "===START: extra info===\n";
				print $sExtraInfo . "\n";
				print "===END: extra info===\n";
			}
		}
	}

}
