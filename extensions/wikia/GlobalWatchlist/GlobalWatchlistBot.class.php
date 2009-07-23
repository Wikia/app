<?php

class GlobalWatchlistBot {

	private $mDebugMode;
	private $mDebugMailTo = '';
	private $mUsers;
	private $useDB;
	private $mStartTime;
	private $mWatchlisters;
	private $mWikiData = array();

	public function __construct($bDebugMode = false, $aUsers = array(), $useDB = array() ) {
		global $wgExtensionMessagesFiles;
		$this->mDebugMode = $bDebugMode;
		$this->mUsers = $aUsers;
		$this->useDB = $useDB;

		$wgExtensionMessagesFiles['GlobalWatchlist'] = dirname(__FILE__) . '/GlobalWatchlist.i18n.php';
		wfLoadExtensionMessages('GlobalWatchlist');
	}

	public function setDebugMailTo($value) {
		$this->mDebugMailTo = $value;
	}

	/**
	 * get all global watchlist users
	 */
	public function getGlobalWatchlisters($sFlag = 'watchlistdigest') {
		$aUsers = array();

		if(count($this->mUsers)) {
			// get only users passed by --users argument
			$sUserNames = "";
			foreach($this->mUsers as $sUserName) {
				$sUserNames.= ($sUserNames ? "," : "") . "'" . addslashes($sUserName) . "'";
			}
			$sWhereClause = "user_name IN ($sUserNames)";
		}
		else {
			$sWhereClause = "user_options LIKE '%" . addslashes($sFlag) . "=1%'";
		}

		global $wgWikiaCentralAuthDatabase;
		if( empty( $wgWikiaCentralAuthDatabase ) ) {
			$dbr = wfGetDB( DB_SLAVE );
			$userTbl = $dbr->tableName( 'user' );
		} else {
			$dbr = wfGetDB( DB_SLAVE, array(), $wgWikiaCentralAuthDatabase );
			$userTbl = 'user';
		}
		
		$oResource = $dbr->select(
			$userTbl,
			array("user_id", "user_name", "user_email"),
			array(
				"user_email_authenticated IS NOT NULL",
				$sWhereClause
			),
			__METHOD__, 
			array("ORDER BY" => "user_id")
		);

		if ( $oResource ) {
			$iWatchlisters = 0;

			while ( $oResultRow = $dbr->fetchObject( $oResource ) ) {
				$iWatchlisters++;
				$aUsers[$oResultRow->user_id] = array ( 
					'name' => $oResultRow->user_name, 
					'email' => $oResultRow->user_email 
				);
			}
			$this->printDebug("$iWatchlisters global watchilster(s) found. (time: " . $this->calculateDuration( time() - $this->mStartTime ). ")");
		} 
		else {
			$this->printDebug("No global watchlist users were found.", true);
		}

		$this->mWatchlisters = $aUsers;
		return $aUsers;
	}

	/**
	 * get users in watchlist with theirs pages
	 */
	private function getUsersPagesFromWatchlist($sWikiDb) {
		$aPages = array();

		$dbr = wfGetDB( DB_SLAVE, 'stats', $sWikiDb );

		if ( $dbr->tableExists('watchlist') ) {
			$oResource = $dbr->select(
				array ( "watchlist", "page" ),
				array ( 
					"wl_user", 
					"page_id", 
					"wl_title as page_title", 
					"wl_namespace as page_namespace", 
					"wl_notificationtimestamp as page_timestamp", 
					"(select max(rev_id) from revision where rev_page = page_id and rev_timestamp <= wl_notificationtimestamp) as page_revision"
				), 
				array (
					"page_title = wl_title",
					"page_namespace = wl_namespace",
					"wl_user > 0",
					"wl_notificationtimestamp IS NOT NULL"
				),
				__METHOD__
			);
			
			
			if ( $oResource ) {
				while ( $oResultRow = $dbr->fetchObject($oResource) ) {
					$aPages[ $oResultRow->wl_user ][] = $oResultRow;
				}
				$dbr->freeResult( $oResource );
			}
		}

		return $aPages;
	}

	/**
	 * gather digest data for all users
	 */
	public function fetchWatchlists() {
		global $wgExternalSharedDB, $wgExternalDatawareDB;
		
		$wlNbr = 0;
		$this->getGlobalWatchlisters();
		$this->printDebug("Gathering watchlist data ...");

		$dbr = wfGetDB(DB_SLAVE, "stats", $wgExternalSharedDB);
		$dbext = wfGetDB(DB_MASTER, array(), $wgExternalDatawareDB);

		$where = array(
			"city_public" 		=> 1,
			"city_useshared" 	=> 1
		);
		if ( !empty($this->useDB) ) {
			$where[] = " city_id in (" . implode(",", $this->useDB) . ") ";
		}

		$oResource = $dbr->select(
			array("city_list"),
			array("city_id", "city_dbname", "city_lang", "city_title"),
			$where,
			__METHOD__, 
			array("ORDER BY" => "city_id")
		);

		$this->mUsers = array();
		while ( $oResultRow = $dbr->fetchObject($oResource) ) {
			#-- load users from watchlist table with list of pages 
			$this->printDebug("Processing {$oResultRow->city_dbname} ... ");
			$aUsers = $this->getUsersPagesFromWatchlist( $oResultRow->city_dbname );
			#---
			$this->printDebug( count($aUsers). " watchlister(s) found ");
			if ( !empty($aUsers) ) {
				#----
				$localTime = time();
				foreach ($aUsers as $iUserId => $aWatchLists) {
					#--- skip users without email authentication
					if ( !isset($this->mWatchlisters[ $iUserId ]) ) {
						continue;
					}
							
					$this->mUsers[ $iUserId ] = $this->mWatchlisters[ $iUserId ];

					if (!isset($this->mWikiData[$oResultRow->city_id])) {
						$this->mWikiData[$oResultRow->city_id] = array (
							'wikiName' => $oResultRow->city_title,
							'wikiLangCode' => $oResultRow->city_lang
						);
					}

					if ( !empty( $aWatchLists ) ) {
						foreach ( $aWatchLists as $oWatchLists ) {
							$dbext->insert(
								"global_watchlist",
								array(
									"gwa_user_id" 	=> $iUserId,
									"gwa_city_id"	=> $oResultRow->city_id, 
									"gwa_namespace" => $oWatchLists->page_namespace,
									"gwa_title"		=> $oWatchLists->page_title, 
									"gwa_rev_id"	=> $oWatchLists->page_revision,
									"gwa_timestamp"	=> $oWatchLists->page_timestamp
								),
								__METHOD__
							);
							$wlNbr++;
						} // foreach $aWatchLists
					} // if !empty $aWatchLists
				} // foreach
				$this->printDebug("Gathering watchlist data for: {$oResultRow->city_dbname} ... done! (time: " . $this->calculateDuration(time() - $localTime ) . ")");
			} // !empty
		} // while
		$dbr->freeResult( $oResource );		

		$this->printDebug("Gathering all watchlist data ... done! (time: " . $this->calculateDuration(time() - $this->mStartTime ) . ")");
		return $wlNbr;
	}

	/**
	 * mark all pages sent as weekly digest as visited (only for users who requested that in Special:Preferences)
	 */
	private function markWeeklyDigestAsVisited() {
		global $wgExternalSharedDB, $wgDefaultUserOptions;
		$dbs = wfGetDB(DB_MASTER, array(), $wgExternalSharedDB);
		$wgDefaultUserOptions['watchlistdigestclear'] = 0;

		foreach($this->mWatchlisters as $iUserId => $aUserData) {
			$this->printDebug("Markig all digested pages as 'visited' for user: ". $aUserData['name']);

			$oResource = $dbs->query("SELECT * FROM global_watchlist WHERE gwa_user_id='" . $iUserId . "' ORDER BY gwa_city_id");
			$iCurrentCityId = 0;
			while($oResultRow = $dbs->fetchObject($oResource)) {
				if($iCurrentCityId != $oResultRow->gwa_city_id) {
					$sWikiDbName = WikiFactory::getVarValueByName('wgDBName', $oResultRow->gwa_city_id);
					$iCurrentCityId = $oResultRow->gwa_city_id;
				}
				if(!empty($sWikiDbName)) {
					$dbw = wfGetDB( DB_MASTER, array(), $sWikiDbName );
					$dbw->query("UPDATE watchlist SET wl_notificationtimestamp=NULL WHERE wl_user='" . $iUserId . "' AND wl_namespace='" . $oResultRow->gwa_namespace . "' AND wl_title='" . addslashes($oResultRow->gwa_title) . "'");
				}
				else {
					$this->printDebug("ERROR: wiki db name not found for city_id=" . $oResultRow->gwa_city_id);
				}
			}

			$dbs->query("DELETE FROM global_watchlist WHERE gwa_user_id='" . $iUserId . "'");

			$oUser = User::newFromId($iUserId);
			$oUser->setOption('watchlistdigestclear', false);
			$oUser->saveSettings();
		}
	}

	/**
	 * compose digest email for user
	 */
	private function composeMail ($oUser, $aDigestsData, $isDigestLimited) {
		global $wgGlobalWatchlistMaxDigestedArticlesPerWiki;

		$sDigests = ""; $iPagesCount = 1;
		foreach ( $aDigestsData as $aDigest ) {
			$sDigests .= $aDigest['wikiName'] . ( $aDigest['wikiLangCode'] != 'en' ?  " (" . $aDigest['wikiLangCode'] . ")": "" ) . ":\n";

			foreach( $aDigest['pages'] as $aPageData ) {
				$sDigests .= $aPageData['title']->getFullURL(($aPageData['revisionId'] ? "diff=0&oldid=" . $aPageData['revisionId'] : "")) . "\n";
				$iPagesCount++;
			}

			$sDigests .= "\n";
		}

		if ( $isDigestLimited ) {
			$sDigests .= $this->getLocalizedMsg('globalwatchlist-see-more', $oUser->getOption('language')) . "\n";
		}

		$aEmailArgs = array(
			0 => ucfirst($oUser->getName()),
			1 => $sDigests
		);

		$sMessage = $this->getLocalizedMsg( 'globalwatchlist-digest-email-body', $oUser->getOption('language') );
		$sBody = wfMsgReplaceArgs($sMessage, $aEmailArgs);

		return $sBody;
	}

	private function getLocalizedMsg($sMsgKey, $sLangCode) {
		$sBody = null;

		if(($sLangCode != 'en') && !empty($sLangCode)) {
			// custom lang translation
			$sBody = wfMsgExt($sMsgKey, array( 'language' => $sLangCode ));
		}

		if($sBody == null) {
			$sBody = wfMsg($sMsgKey);
		}

		return $sBody;
	}

	public function run() {
		global $wgExternalSharedDB;

		$this->mStartTime = time();
		$this->printDebug("Script started. (" . date('Y-m-d H:i:s'). ")");

		// ditch previous watchlist data
		$dbw = wfGetDB(DB_MASTER, array(), $wgExternalSharedDB);
		$dbw->query("DELETE FROM global_watchlist");
		$this->printDebug("Old digest data removed.");

		$this->fetchWatchlists();
		$this->sendDigests();

		$this->printDebug("Script finished. (total time: " . $this->calculateDuration( time() - $this->mStartTime ) . ")");
	}

	/**
	 * clear watchlist mode: marking all pages as "visited"
	 */
	public function clear() {
		$this->mStartTime = time();
		$this->printDebug("Script started. (" . date('Y-m-d H:i:s'). ") - CLEAR MODE");

		$this->getGlobalWatchlisters('watchlistdigestclear');
		$this->markWeeklyDigestAsVisited();

		$this->printDebug("Script finished. (total time: " . $this->calculateDuration( time() - $this->mStartTime ) . ")");
	}

	/**
	 * send digest
	 */
	private function sendDigests() {
		global $wgExternalDatawareDB, $wgGlobalWatchlistMaxDigestedArticlesPerWiki;
		$this->printDebug("Sending digest emails ... ");

		$iEmailsSent = 0;

		$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalDatawareDB );

		if ( !empty($this->mUsers) ) {
			$this->printDebug("Sending digest emails to " . count($this->mUsers) . " users ");

			foreach($this->mUsers as $iUserId => $aUserData) {
				
				$oResource = $dbr->select(
					array ( "global_watchlist" ),
					array ( "gwa_id", "gwa_user_id", "gwa_city_id", "gwa_namespace", "gwa_title", "gwa_rev_id", "gwa_timestamp" ),
					array (
						"gwa_user_id" => intval($iUserId),
					),
					__METHOD__, 
					array ( 
						"ORDER BY" => "gwa_timestamp, gwa_city_id",
						"LIMIT" => $wgGlobalWatchlistMaxDigestedArticlesPerWiki + 1,
					)
				);

				$bTooManyPages = false;
				if ( $dbr->numRows($oResource) > $wgGlobalWatchlistMaxDigestedArticlesPerWiki ) {
					$bTooManyPages = true;
				}

				$iWikiId = 0;
				$aDigestData = array();
				$aWikiDigest = array( 'pages' => array() );
				while ( $oResultRow = $dbr->fetchObject($oResource) ) {
					#---
					if ( $iWikiId != $oResultRow->gwa_city_id ) {
						
						if ( count( $aWikiDigest['pages'] ) ) {
							$aDigestData[ $iWikiId ] = $aWikiDigest;
						}

						$iWikiId = $oResultRow->gwa_city_id;
						
						if ( isset( $aDigestData[ $iWikiId ] ) ) {
							$aWikiDigest = $aDigestData[ $iWikiId ];
						} else {
							$aWikiDigest = array(
								'wikiName' => $this->mWikiData[ $iWikiId ]['wikiName'],
								'wikiLangCode' => $this->mWikiData[ $iWikiId ]['wikiLangCode'],
								'pages' => array()
							);
						}
					} // if
					
					$aWikiDigest['pages'][] = array(
						'title' => GlobalTitle::newFromText($oResultRow->gwa_title, $oResultRow->gwa_namespace, $iWikiId),
						'revisionId' => $oResultRow->gwa_rev_id
					);
				} // while

				if ( count($aWikiDigest['pages']) ) {
					$aDigestData[ $iWikiId ] = $aWikiDigest;
				}
				if ( count($aDigestData) ) {
					$iEmailsSent++;
					$this->sendMail( $iUserId, $aDigestData, $bTooManyPages );
				}
			} // foreach
		}

		$this->printDebug("Sending digest emails ... Done! ($iEmailsSent total)");
	}

	/**
	 * send email
	 */
	private function sendMail($iUserId, $aDigestData, $isDigestLimited) {
		$oUser = User::newFromId($iUserId);
		$oUser->load();

		$sEmailSubject = $this->getLocalizedMsg('globalwatchlist-digest-email-subject', $oUser->getOption('language'));
		$sEmailBody = $this->composeMail($oUser, $aDigestData, $isDigestLimited);

		$sFrom = 'Wikia <community@wikia.com>';
		if ( empty($this->mDebugMailTo) ) {
			$oUser->sendMail( $sEmailSubject, $sEmailBody, $sFrom, null, 'GlobalWatchlist' );
			$this->printDebug("Digest email sent to user: " . $oUser->getName());
		}
		else {
			UserMailer::send(new MailAddress($this->mDebugMailTo), new MailAddress($sFrom), $sEmailSubject, $sEmailBody, 'GlobalWatchlist');
			$this->printDebug("Digest email sent to: " . $this->mDebugMailTo . " (debug mode)");
		}
	}

	private function printDebug($sMessage, $bForceDebugMode = false) {
		if ( $this->mDebugMode || $bForceDebugMode ) {
			print "[GlobalWatchlistBot] " . $sMessage . "\n";
		}
	}

	private function calculateDuration($iSeconds) {
		if(!$iSeconds) {
			return "0s";
		}

		$aValues = array(
			'w' => (int) ($iSeconds / 86400 / 7),
			'd' => $iSeconds / 86400 % 7,
			'h' => $iSeconds / 3600 % 24,
			'm' => $iSeconds / 60 % 60,
			's' => $iSeconds % 60
		);
		$aResult = array();
		$added = false;

		foreach ($aValues as $k => $v) {
			if ($v > 0 || $added) {
				$added = true;
				$aResult[] = $v . $k;
			}
		}

		return join(' ', $aResult);
	}

}
