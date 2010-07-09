<?php

class GlobalWatchlistBot {

	private $mDebugMode;
	private $mDebugMailTo = '';
	private $mUsers;
	private $useDB;
	private $mStartTime;
	private $mWatchlisters;
	private $mWikiData = array();
	private $iEmailsSent;

	const MAX_LAG = 30;
	const RECORDS_SLEEP = 350;
	const EMAILS = 100;
	const TIME_SLEEP = 60;

	public function __construct($bDebugMode = false, $aUsers = array(), $useDB = array() ) {
		global $wgExtensionMessagesFiles;
		$this->mDebugMode = $bDebugMode;
		$this->mUsers = $aUsers;
		$this->useDB = $useDB;
		$this->iEmailsSent = 0;

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
			$dbr->freeResult( $oResource );
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
		wfWaitForSlaves(5);

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

		$dbr->close();

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

		$dbr = wfGetDB(DB_SLAVE, array(), $wgExternalSharedDB);
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
			$localTime = time();
			$this->printDebug("Processing {$oResultRow->city_dbname} ... ");
			$aUsers = $this->getUsersPagesFromWatchlist( $oResultRow->city_dbname );
			#---
			$this->printDebug( count($aUsers). " watchlister(s) found ");
			if ( !empty($aUsers) ) {
				#----
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
			} // !empty
			$this->printDebug("Gathering watchlist data for: {$oResultRow->city_dbname} ({$oResultRow->city_id}) and ".count($this->mUsers)." users ... done! (time: " . $this->calculateDuration(time() - $localTime ) . ")");
			if ( ($wlNbr % self::RECORDS_SLEEP) == 0) {
				sleep(self::TIME_SLEEP);
			}
		} // while
		$dbr->freeResult( $oResource );

		$this->printDebug("Gathering all watchlist data ... done! (time: " . $this->calculateDuration(time() - $this->mStartTime ) . ")");
		return $wlNbr;
	}

	/**
	 * mark all pages sent as weekly digest as visited (only for users who requested that in Special:Preferences)
	 */
	private function markWeeklyDigestAsVisited() {
		global $wgExternalDatawareDB, $wgDefaultUserOptions;
		$dbs = wfGetDB(DB_MASTER, array(), $wgExternalDatawareDB);
		$wgDefaultUserOptions['watchlistdigestclear'] = 0;

		foreach($this->mWatchlisters as $iUserId => $aUserData) {
			$this->printDebug("Markig all digested pages as 'visited' for user: ". $aUserData['name']);

			$oResource = $dbs->query("SELECT * FROM global_watchlist WHERE gwa_user_id='" . $iUserId . "' ORDER BY gwa_city_id");
			$iCurrentCityId = 0;
			while($oResultRow = $dbs->fetchObject($oResource)) {
				$sWikiDbName = "";
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
			$dbs->freeResult( $oResource );

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

		$sDigests = ""; 
		$sDigestsHTML = ""; 
		$sDigestsBlogs = "";
		$sDigestsBlogsHTML = "";
		$iPagesCount = 0; $iBlogsCount = 0;
		
		$sBodyHTML = null;
		$usehtmlemail = false;
		if ($oUser->isAnon() || $oUser->getOption('htmlemails')) {
			$usehtmlemail = true;
		}
		$oUserLanguage = $oUser->getOption('language'); //get this once, since its used 10 times in this func

		foreach ( $aDigestsData as $aDigest ) {
			$wikiname = $aDigest['wikiName'] . ( $aDigest['wikiLangCode'] != 'en' ?  " (" . $aDigest['wikiLangCode'] . ")": "" ) . ':';

			$sDigests .=  $wikiname . "\n";
			if( $usehtmlemail ) {
				$sDigestsHTML .= "<b>" . $wikiname . "</b><br/>\n";
			}

			if ( !empty($aDigest['pages']) ) {
				if( $usehtmlemail ) {
					$sDigestsHTML .= "<ul>\n";
				}

				foreach( $aDigest['pages'] as $aPageData ) {
					// watchlist tracking, rt#33913
					$url = $aPageData['title']->getFullURL('s=dgdiff' . ($aPageData['revisionId'] ? "&diff=0&oldid=" . $aPageData['revisionId'] : ""));
					
					//plain email
					$sDigests .= $url . "\n";

					//html email
					if( $usehtmlemail ) {
						$pagename = $aPageData['title']->getArticleName();
						$pagename = str_replace('_', ' ', rawurldecode($pagename));
						$sDigestsHTML .= '<li><a href="' . $url . '">' . $pagename . "</a></li>\n";
					}

					$iPagesCount++;
				}

				if( $usehtmlemail ) {
					$sDigestsHTML .= "</ul>\n<br/>\n";
				}
			}
			
			# blog comments
			if ( !empty($aDigest['blogs']) ) {
				foreach( $aDigest['blogs'] as $blogTitle => $blogComments ) {
					#$countComments = ($blogComments['comments'] >= $blogComments['own_comments']) ? intval($blogComments['comments'] - $blogComments['own_comments']) : $blogComments['comments'];
					$countComments = $blogComments['comments'];
					
					$tracking_url = $blogComments['blogpage']->getFullURL('s=dg'); // watchlist tracking, rt#33913

					$message = wfMsgReplaceArgs(
						($countComments != 0) ? $this->getLocalizedMsg('globalwatchlist-blog-page-title-comment', $oUserLanguage ) : "$1",
						array ( 
							0 => $tracking_url, //send the ugly tracking url to the plain emails
							1 => $countComments
						)
					);
					$sDigestsBlogs .= $message . "\n";

					if( $usehtmlemail ) {
						//for html emails, remake some things
						$clean_url = $blogComments['blogpage']->getFullURL();
						$clean_url = str_replace('_', ' ', rawurldecode($clean_url));
						$message = wfMsgReplaceArgs(
							($countComments != 0) ? $this->getLocalizedMsg('globalwatchlist-blog-page-title-comment', $oUserLanguage ) : "$1",
							array ( 
								0 => "<a href=\"{$tracking_url}\">" . $clean_url . "</a>", //but use the non-tracking one for html display
								1 => $countComments
							)
						);
						$sDigestsBlogsHTML .= $message . "<br/>\n";
					}

					$iBlogsCount++;
				}
				$sDigestsBlogs .= "\n";
			}

			$sDigests .= "\n";
		}

		if ( $isDigestLimited ) {
			$sDigests .= $this->getLocalizedMsg('globalwatchlist-see-more', $oUserLanguage) . "\n";
		}

		$aEmailArgs = array(
			0 => ucfirst($oUser->getName()),
			1 => ( $iPagesCount > 0 ) ? $sDigests : $this->getLocalizedMsg('globalwatchlist-no-page-found', $oUserLanguage),
			2 => ( $iBlogsCount > 0 ) ? $sDigestsBlogs : $this->getLocalizedMsg('globalwatchlist-no-blog-page-found', $oUserLanguage),
		);

		$sMessage = $this->getLocalizedMsg( 'globalwatchlist-digest-email-body', $oUserLanguage ) . "\n";
		$sBody = wfMsgReplaceArgs($sMessage, $aEmailArgs);

		if ($usehtmlemail) {
			//rebuild the $ args using the HTML text we've built
			$aEmailArgs = array(
				0 => ucfirst($oUser->getName()),
				1 => ( $iPagesCount > 0 ) ? $sDigestsHTML : $this->getLocalizedMsg('globalwatchlist-no-page-found', $oUserLanguage),
				2 => ( $iBlogsCount > 0 ) ? $sDigestsBlogsHTML : $this->getLocalizedMsg('globalwatchlist-no-blog-page-found', $oUserLanguage),
			);

			$sMessageHTML = $this->getLocalizedMsg( 'globalwatchlist-digest-email-body-HTML', $oUserLanguage );
			if(!wfEmptyMsg( 'globalwatchlist-digest-email-body-HTML', $sMessageHTML )) {
				$sBodyHTML = wfMsgReplaceArgs($sMessageHTML, $aEmailArgs);
			}
		}

		return array($sBody, $sBodyHTML);
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
		global $wgExternalDatawareDB;

		$this->mStartTime = time();
		$this->printDebug("Script started. (" . date('Y-m-d H:i:s'). ")");

		// ditch previous watchlist data
		$dbw = wfGetDB(DB_MASTER, array(), $wgExternalDatawareDB);
		$dbw->query("DELETE FROM global_watchlist");
		$this->printDebug("Old digest data removed.");

		$this->fetchWatchlists();
		$this->sendDigests();

		$dbw->close();
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
				$this->printDebug("Sending digest emails to user: " . $iUserId);

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

					if ( in_array($oResultRow->gwa_namespace, array(NS_BLOG_ARTICLE_TALK, NS_BLOG_ARTICLE)) ) {
						# blogs
						$aWikiBlogs[$iWikiId][] = $oResultRow;
						$this->makeBlogsList( $aWikiDigest, $iWikiId, $oResultRow );
					} else {
						$aWikiDigest[ 'pages' ][] = array(
							'title' => GlobalTitle::newFromText($oResultRow->gwa_title, $oResultRow->gwa_namespace, $iWikiId),
							'revisionId' => $oResultRow->gwa_rev_id
						);
					}

				} // while
				$dbr->freeResult( $oResource );
	
				$cnt = count($aWikiDigest['pages']);
				if ( isset($aWikiDigest['blogs']) ) {
					$cnt += count($aWikiDigest['blogs']);
				}
				if ( !empty($cnt) ) {
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
	 * blogs
	 */
	private function makeBlogsList( &$aWikiDigest, $iWikiId, $oResultRow ) {
		$blogTitle = $oResultRow->gwa_title;

		if ( $oResultRow->gwa_namespace == NS_BLOG_ARTICLE_TALK ) {
			list( $user, $page_title, $comment ) = BlogComment::explode( $oResultRow->gwa_title );
			$blogTitle = $user . "/" . $page_title;
		}
		
		if ( empty($aWikiDigest[ 'blogs' ][ $blogTitle ]) ) {
			$wikiDB = WikiFactory::IDtoDB( $oResultRow->gwa_city_id );
			if ( $wikiDB ) {
				$db_wiki = wfGetDB( DB_SLAVE, 'stats', $wikiDB );
				$db_wiki->ping();
				$oRow = $db_wiki->selectRow(
					array( "watchlist" ),
					array( "count(*) as cnt" ),
					array( 
						"wl_namespace = '".NS_BLOG_ARTICLE_TALK."'",
						"wl_title LIKE '" . $db_wiki->escapeLike($oResultRow->gwa_title) . "%'",
						"wl_notificationtimestamp is not null",
						"wl_notificationtimestamp >= '".$oResultRow->gwa_timestamp."'",
						"wl_user > 0",
					),
					__METHOD__
				);
				$aWikiDigest[ 'blogs' ][ $blogTitle ] = array (
					'comments' => intval($oRow->cnt),
					'blogpage' => GlobalTitle::newFromText( $blogTitle, NS_BLOG_ARTICLE, $iWikiId ),
					'own_comments' => 0
				);
				$db_wiki->close();
			}
		}
		
		if ( 
			($oResultRow->gwa_namespace == NS_BLOG_ARTICLE_TALK) &&  
			isset( $aWikiDigest[ 'blogs' ][ $blogTitle ] )
		) {
			$aWikiDigest[ 'blogs' ][ $blogTitle ]['own_comments']++;
		}
	}

	/**
	 * send email
	 */
	private function sendMail($iUserId, $aDigestData, $isDigestLimited) {
		$oUser = User::newFromId($iUserId);
		$oUser->load();

		$sEmailSubject = $this->getLocalizedMsg('globalwatchlist-digest-email-subject', $oUser->getOption('language'));
		list($sEmailBody, $sEmailBodyHTML) = $this->composeMail($oUser, $aDigestData, $isDigestLimited);

		$sFrom = 'Wikia <community@wikia.com>';
		//yes this needs to be a MA object, not string (the docs for sendMail are wrong)
		$oReply = new MailAddress( 'noreply@wikia.com' );

		if ( empty($this->mDebugMailTo) ) {
			$oUser->sendMail( $sEmailSubject, $sEmailBody, $sFrom, $oReply, 'GlobalWatchlist', $sEmailBodyHTML );
			$this->printDebug("Digest email sent to user: " . $oUser->getName());
		}
		else {
			UserMailer::send(new MailAddress($this->mDebugMailTo), new MailAddress($sFrom), $sEmailSubject, $sEmailBody, null, null, 'GlobalWatchlist');
			$this->printDebug("Digest email sent to: " . $this->mDebugMailTo . " (debug mode)");
		}

		if ( ($this->iEmailsSent % self::EMAILS) == 0 ) {
			$this->printDebug("Sent: " . $this->iEmailsSent . ", sleep: " . self::TIME_SLEEP . " sec.");
			sleep(self::TIME_SLEEP);
		}
		$this->iEmailsSent++;
	}

	private function printDebug($sMessage, $bForceDebugMode = false) {
		if ( $this->mDebugMode || $bForceDebugMode ) {
			print sprintf("[GlobalWatchlistBot] (%s): %s\n", $sMessage, date('Y-m-d H:i:s'));
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


	/*
	 * check lag only for this bot
	 */
	private function isLagged($dbr) {
		$res = $dbr->query( 'SHOW SLAVE STATUS', __METHOD__ );
		$row = $dbr->fetchObject( $res );
		if ( $row ) {
			$val = isset($row->Seconds_behind_master) ? $row->Seconds_behind_master : $row->Seconds_Behind_Master;
			return intval($val);
		} else {
			return 0;
		}
	}

}
