<?php

class GlobalWatchlistBot {
	private $mDebugMode;
	private $mDebugMailTo = '';
	private $mUsers;
	private $mUseDB;
	private $mStartTime;
	private $mWatchlisters;
	private $mWikiData = array();
	private $iEmailsSent;
	private $mCityList;

	const MAX_LAG = 5;
	const RECORDS_SLEEP = 1000;
	const EMAILS = 100;

	public function __construct( $bDebugMode = false, $aUsers = array(), $useDB = array() ) {
		global $wgExtensionMessagesFiles;
		
		$this->mDebugMode = $bDebugMode;
		$this->mUsers = $aUsers;
		$this->mUseDB = $useDB;
		$this->iEmailsSent = 0;

		$wgExtensionMessagesFiles['GlobalWatchlist'] = dirname( __FILE__ ) . '/GlobalWatchlist.i18n.php';
	}

	public function setDebugMailTo( $value ) {
		$this->mDebugMailTo = $value;
	}

	/**
	 * clear watchlist mode: marking all pages as "visited"
	 */
	public function clear() {
		$this->mStartTime = time();
		$this->printDebug( "Script started. (" . date( 'Y-m-d H:i:s' ) . ") - CLEAR MODE" );

		$this->getGlobalWatchlisters( 'watchlistdigestclear' );
		$this->markWeeklyDigestAsVisited();

		$this->printDebug( "Script finished. (total time: " . $this->calculateDuration( time() - $this->mStartTime ) . ")" );
	}

	/**
	 * run watchlist
	 */
	public function run() {
		global $wgExternalDatawareDB;

		$this->mStartTime = time();
		$this->printDebug( "Script started. (" . date( 'Y-m-d H:i:s' ) . ")" );

		// ditch previous watchlist data
		$this->fetchWatchlists();
		$this->sendDigests();

		$this->printDebug( "Script finished. (total time: " . $this->calculateDuration( time() - $this->mStartTime ) . ")" );
	}

	/**
	 * run watchlist
	 */
	public function regenerate() {
		global $wgExternalDatawareDB;

		$this->mStartTime = time();
		$this->printDebug( "Script started. (" . date( 'Y-m-d H:i:s' ) . ")" );

		// regenerate watchlist data
		$this->regenerateWatchlist();
		
		$this->printDebug( "Script finished. (total time: " . $this->calculateDuration( time() - $this->mStartTime ) . ")" );
	}

	/**
	 * update local watchlist
	 */
	public function updateLocalWatchlist( $page_title, $namespace ) {
		if ( empty($this->mUsers) ) {
			return false;
		}

		$iUserId = current( $this->mUsers );
		
		return $this->updateLocalWatchlistForUser( $iUserId, $page_title, $namespace );
	}
	
	/**
	 * sending email to user
	 */
	public function send() {
		if ( empty($this->mUsers) ) {
			return false;
		}

		$iUserId = current( $this->mUsers );
				
		return $this->sendDigestsToUser( $iUserId );
	} 
	
	/**
	 * get all global watchlist users
	 */
	public function getGlobalWatchlisters( $sFlag = 'watchlistdigest' ) {
		global $wgExternalDatawareDB, $wgExternalAuthType;
		$this->mWatchlisters = array();
		
		$defaultValue = (int) User::getDefaultOption( $sFlag );
		$this->printDebug( "Default value for flag $sFlag: $defaultValue" );
		
		$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalDatawareDB );
		
		$aWhereClause = array( 
			"gwa_user_id > 0",
			"gwa_timestamp is not null",
			/*"gwa_timestamp <= gwa_rev_timestamp",*/
		);
		if ( count( $this->mUsers ) ) {
			// get only users passed by --users argument
			$aWhereClause['gwa_user_id'] = $this->mUsers;
		}

		$oResource = $dbr->select(
			array( 'global_watchlist' ),
			array( 'distinct gwa_user_id' ),
			$aWhereClause,
			__METHOD__,
			array( "ORDER BY" => "gwa_user_id" )
		);

		if ( $oResource ) {
			$this->printDebug( "Found " . $dbr->numRows( $oResource ) . " users " );
					
			$iWatchlisters = 0;

			while ( $oResultRow = $dbr->fetchObject( $oResource ) ) {
				
				if ( $wgExternalAuthType ) {
					$mExtUser = ExternalUser::newFromId( $oResultRow->gwa_user_id );
					if ( is_object( $mExtUser ) && ( 0 != $mExtUser->getId() ) ) {
						$mExtUser->linkToLocal( $mExtUser->getId() );
						$oUser = $mExtUser->getLocalUser();
					} else {
						$oUser = null;
					}
				} else {
					$oUser = User::newFromId ( $oResultRow->gwa_user_id );
				}
			
				if ( !$oUser instanceof User ) {
					$this->printDebug( "Invalid user object for user ID: {$oResultRow->gwa_user_id} " );
					continue;
				}

				# check is email unsubscribed
				if ( $oUser->getBoolOption('unsubscribed') ) {
					$this->printDebug( "Email is unsubcribed: {$oResultRow->gwa_user_id} " );
					continue;
				}

				# check is email confirmed
				if ( ! $oUser->isEmailConfirmed() ) {
					$this->printDebug( "Email is not confirmed for user ID: {$oResultRow->gwa_user_id} " );
					continue;
				}

				# flag not set
				if ( ! $oUser->getBoolOption( $sFlag ) ) {
					$this->printDebug( "$sFlag is not set for user ID: {$oResultRow->gwa_user_id} " );
					continue;
				}

				$iWatchlisters++;
				
				$this->mWatchlisters[ $oResultRow->gwa_user_id ] = array (
					'name'	=> $oUser->getName(),
					'email'	=> $oUser->getEmail()
				);

				unset($oUser);
			}
			$dbr->freeResult( $oResource );
			$this->printDebug( "$iWatchlisters global watchilster(s) found. (time: " . $this->calculateDuration( time() - $this->mStartTime ) . ")" );
		}
		else {
			$this->printDebug( "No global watchlist users were found.", true );
		}

		return true;
	}

	/**
	 * get users in watchlist with theirs pages
	 */
	private function getUsersPagesFromWatchlist( $sWikiDb ) {
		$aPages = array();

		$dbr_wiki = wfGetDB( DB_SLAVE, 'stats', $sWikiDb );
		wfWaitForSlaves( 5 );

		if ( $dbr_wiki->tableExists( 'watchlist' ) ) {
			$oResource = $dbr_wiki->select(
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
				while ( $oResultRow = $dbr_wiki->fetchObject( $oResource ) ) {
					$aPages[ $oResultRow->wl_user ][] = $oResultRow;
				}
				$dbr_wiki->freeResult( $oResource );
			}
		}
		
		if ( !in_array($sWikiDb, array( 'wikicities', 'messaging' ) ) ) {
			$dbr_wiki->close();
		}

		return $aPages;
	}

	/**
	 * gather digest data for all users
	 */
	public function fetchWatchlists() {
		$this->printDebug( "Gathering watchlist users ..." );		
		$this->getGlobalWatchlisters();

		$wlNbr = count( $this->mWatchlisters );
		$this->printDebug( "Gathering all watchlist users ( $wlNbr ) ... done! (time: " . $this->calculateDuration( time() - $this->mStartTime ) . ")" );
		return $wlNbr;
	}

	/**
	 * mark all pages sent as weekly digest as visited (only for users who requested that in Special:Preferences)
	 */
	private function markWeeklyDigestAsVisited() {
		$this->mCityList = $this->getWikisFromDigestList();
		
		$cnt = count($this->mWatchlisters);
		$loop = 1;
		foreach ( $this->mWatchlisters as $iUserId => $aUser ) {
			$this->printDebug( "Marking all digested pages as 'visited' for user: " . $aUser['name'] . " ($iUserId), loop: $loop/$cnt" );
			$this->updateUserWatchlist ( $iUserId );
			$loop++;
		}
	}

	/**
	 * update user watchlist
	 */
	private function updateUserWatchlist( $iUserId ) {
		global $wgExternalDatawareDB, $wgDefaultUserOptions, $wgExternalSharedDB, $IP, $wgWikiaLocalSettingsPath;
		
		$wgDefaultUserOptions['watchlistdigestclear'] = 0;
		
		$dbs = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );
		$oResource = $dbs->select(
			'global_watchlist',
			'gwa_city_id, gwa_title, gwa_namespace',
			array( 'gwa_user_id' => $iUserId ),
			__METHOD__
		);
		
		while ( $oResultRow = $dbs->fetchObject( $oResource ) ) {
			$sWikiDbName = @$this->mCityList[ $oResultRow->gwa_city_id ] ;
			
			if ( $sWikiDbName ) {
				$this->printDebug( "Update watchlist for db: $sWikiDbName, page: {$oResultRow->gwa_title}, ns: {$oResultRow->gwa_namespace}" );
				
				$retval = "";
				$sCommand  = "SERVER_ID={$oResultRow->gwa_city_id} php $IP/maintenance/wikia/weeklyDigest.php ";
				$sCommand .= "--update ";
				$sCommand .= "--users=" . $iUserId . " ";
				$sCommand .= "--page=" . escapeshellarg($oResultRow->gwa_title) . " ";
				$sCommand .= "--namespace=" . $oResultRow->gwa_namespace . " ";
				$sCommand .= "--conf " . $wgWikiaLocalSettingsPath . " ";				
				if ( $this->mDebugMode ) {
					$sCommand .= "--debug";
				}

				$log = wfShellExec($sCommand, $retval);

				if ($retval) {
					$this->printDebug("Update failed. Error code returned: " .  $retval . " Error was: " . $log);
				} else {
					$this->printDebug( $log, false, true );
				}
			}
			else {
				$this->printDebug( "ERROR: wiki db name not found for city_id=" . $oResultRow->gwa_city_id );
			}
		}
		$dbs->freeResult( $oResource );
		$dbs->delete( 'global_watchlist', array( 'gwa_user_id' => $iUserId ), __METHOD__ );
		
		# update user preferences
		$oUser = User::newFromId( $iUserId );
		$oUser->setOption( 'watchlistdigestclear', 0 );
		$oUser->saveSettings();
	} 
	 

	/**
	 * list of Wikis
	 */
	private function getWikisFromDigestList() {
		global $wgExternalDatawareDB, $wgExternalSharedDB;
		$dbs = wfGetDB( DB_SLAVE, array(), $wgExternalDatawareDB );
				
		$oResource = $dbs->query( "SELECT distinct gwa_city_id FROM global_watchlist ORDER BY gwa_city_id" );		
		$iCurrentCityId = 0;
		$cityList = array();
		while ( $oResultRow = $dbs->fetchObject( $oResource ) ) {
			$this->printDebug( "Put Wikia " . $oResultRow->gwa_city_id . " to list " );
			$sWikiDbName = WikiFactory::IDtoDB( $oResultRow->gwa_city_id );
			if ( $sWikiDbName ) {
				$cityList[ $oResultRow->gwa_city_id ] = $sWikiDbName;
			}
		}
		$dbs->freeResult( $oResource );	
		
		return $cityList;
	}
	
	/**
	 * update local watchlist 
	 */
	private function updateLocalWatchlistForUser( $iUserId, $sTitle, $iNamespace ) {
		$dbw = wfGetDB( DB_MASTER );
	
		$oUser = User::newFromId( $iUserId );
		if ( !is_object( $oUser ) ) {
			return false;
		}
		
		$oTitle = Title::makeTitle( $iNamespace, $sTitle );
		if ( !is_object( $oTitle ) ) {
			return false;
		}
		
		$wl = WatchedItem::fromUserTitle( $oUser, $oTitle );
		$wl->clearWatch();
		
		return true;
	}

	/**
	 * compose digest email for user
	 */
	function composeMail ( $oUser, $aDigestsData, $isDigestLimited ) {
		global $wgGlobalWatchlistMaxDigestedArticlesPerWiki;

		$sDigests = "";
		$sDigestsHTML = "";
		$sDigestsBlogs = "";
		$sDigestsBlogsHTML = "";
		$iPagesCount = 0; $iBlogsCount = 0;

		$sBodyHTML = null;
		$usehtmlemail = false;
		if ( $oUser->isAnon() || $oUser->getOption( 'htmlemails' ) ) {
			$usehtmlemail = true;
		}
		$oUserLanguage = $oUser->getOption( 'language' ); // get this once, since its used 10 times in this func
		foreach ( $aDigestsData as $aDigest ) {
			$wikiname = $aDigest['wikiName'] . ( $aDigest['wikiLangCode'] != 'en' ?  " (" . $aDigest['wikiLangCode'] . ")": "" ) . ':';

			$sDigests .=  $wikiname . "\n";
			if ( $usehtmlemail ) {
				$sDigestsHTML .= "<b>" . $wikiname . "</b><br/>\n";
			}

			if ( !empty( $aDigest['pages'] ) ) {
				if ( $usehtmlemail ) {
					$sDigestsHTML .= "<ul>\n";
				}

				foreach ( $aDigest['pages'] as $aPageData ) {
					// watchlist tracking, rt#33913
					$url = $aPageData['title']->getFullURL( 's=dgdiff' . ( $aPageData['revisionId'] ? "&diff=" . $aPageData['revisionId'] . "&oldid=prev" : "" ) );

					// plain email
					$sDigests .= $url . "\n";

					// html email
					if ( $usehtmlemail ) {
						$pagename = $aPageData['title']->getArticleName();
						$pagename = str_replace( '_', ' ', rawurldecode( $pagename ) );
						$sDigestsHTML .= '<li><a href="' . $url . '">' . $pagename . "</a></li>\n";
					}

					$iPagesCount++;
				}

				if ( $usehtmlemail ) {
					$sDigestsHTML .= "</ul>\n<br/>\n";
				}
			}

			# blog comments
			if ( !empty( $aDigest['blogs'] ) ) {
				foreach ( $aDigest['blogs'] as $blogTitle => $blogComments ) {
					# $countComments = ($blogComments['comments'] >= $blogComments['own_comments']) ? intval($blogComments['comments'] - $blogComments['own_comments']) : $blogComments['comments'];
					$countComments = $blogComments['comments'];

					$tracking_url = $blogComments['blogpage']->getFullURL( 's=dg' ); // watchlist tracking, rt#33913

					$message = wfMsgReplaceArgs(
						( $countComments != 0 ) ? $this->getLocalizedMsg( 'globalwatchlist-blog-page-title-comment', $oUserLanguage ) : "$1",
						array (
							0 => $tracking_url, // send the ugly tracking url to the plain emails
							1 => $countComments
						)
					);
					$sDigestsBlogs .= $message . "\n";

					if ( $usehtmlemail ) {
						// for html emails, remake some things
						$clean_url = $blogComments['blogpage']->getFullURL();
						$clean_url = str_replace( '_', ' ', rawurldecode( $clean_url ) );
						$message = wfMsgReplaceArgs(
							( $countComments != 0 ) ? $this->getLocalizedMsg( 'globalwatchlist-blog-page-title-comment', $oUserLanguage ) : "$1",
							array (
								0 => "<a href=\"{$tracking_url}\">" . $clean_url . "</a>", // but use the non-tracking one for html display
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
			$sDigests .= $this->getLocalizedMsg( 'globalwatchlist-see-more', $oUserLanguage ) . "\n";
		}
		$aEmailArgs = array(
			0 => ucfirst( $oUser->getName() ),
			1 => ( $iPagesCount > 0 ) ? $sDigests : $this->getLocalizedMsg( 'globalwatchlist-no-page-found', $oUserLanguage ),
			2 => ( $iBlogsCount > 0 ) ? $sDigestsBlogs : "",
		);

		$sMessage = $this->getLocalizedMsg( 'globalwatchlist-digest-email-body', $oUserLanguage ) . "\n";
		if (empty($aEmailArgs[2])) $sMessage = $this->cutOutPart($sMessage, '$2', '$3');
		$sBody = wfMsgReplaceArgs( $sMessage, $aEmailArgs );
		if ( $usehtmlemail ) {
			// rebuild the $ args using the HTML text we've built
			$aEmailArgs = array(
				0 => ucfirst( $oUser->getName() ),
				1 => ( $iPagesCount > 0 ) ? $sDigestsHTML : $this->getLocalizedMsg( 'globalwatchlist-no-page-found', $oUserLanguage ),
				2 => ( $iBlogsCount > 0 ) ? $sDigestsBlogsHTML : "",
			);

			$sMessageHTML = $this->getLocalizedMsg( 'globalwatchlist-digest-email-body-html', $oUserLanguage );
			if ( !wfEmptyMsg( 'globalwatchlist-digest-email-body-html', $sMessageHTML ) ) {
				if (empty($aEmailArgs[2])) $sMessageHTML = $this->cutOutPart($sMessageHTML, '$2', '$3');
				$sBodyHTML = wfMsgReplaceArgs( $sMessageHTML, $aEmailArgs );
			}
		}

		return array( $sBody, $sBodyHTML );
	}
	function cutOutPart($message, $startMarker, $endMarker, $replacement = " ") {
	 // this is a quick way to skip some parts of email message without remaking all the i18n messages.
	 $startPos = strpos($message, $startMarker);
	 $endPos = strpos($message, $endMarker);
	 if ($startPos !== FALSE && $endPos !== FALSE) {
	   $message = substr($message, 0, $startPos + strlen($startMarker)) . $replacement . substr($message, $endPos);
	 }
	 return $message;
	}

	private function getLocalizedMsg( $sMsgKey, $sLangCode ) {
		$sBody = null;

		if ( ( $sLangCode != 'en' ) && !empty( $sLangCode ) ) {
			// custom lang translation
			$sBody = wfMsgExt( $sMsgKey, array( 'language' => $sLangCode ) );
		}

		if ( $sBody == null ) {
			$sBody = wfMsg( $sMsgKey );
		}

		return $sBody;
	}

	/**
	 * send digest
	 */
	private function sendDigests() {
		global $wgCityId, $IP, $wgWikiaLocalSettingsPath;
		
		$this->printDebug( "Sending digest emails ... " );

		$iEmailsSent = 0;

		if ( !empty( $this->mWatchlisters ) ) {
			$this->printDebug( "Sending digest emails to " . count( $this->mWatchlisters ) . " users " );

			foreach ( $this->mWatchlisters as $iUserId => $aUserData ) {

				$this->printDebug( "Sending digest emails to user: " . $iUserId );

				// run script with option --send
				
				$retval = "";
				$sCommand  = "SERVER_ID={$wgCityId} php $IP/maintenance/wikia/weeklyDigest.php ";
				$sCommand .= "--send ";
				$sCommand .= "--users=" . $iUserId . " ";
				$sCommand .= "--conf " . $wgWikiaLocalSettingsPath . " ";
				if ( $this->mDebugMode ) {
					$sCommand .= "--debug";
				}

				# send email to user
				$this->printDebug( $sCommand ) ;
				
				$log = wfShellExec($sCommand, $retval);

				if ($retval) {
					$this->printDebug("Send email to $iUserId failed. Error code returned: " .  $retval . " Error was: " . $log);
				} else {
					$this->printDebug( $log, false, true );
					$iEmailsSent++;
				}
			} // foreach
		}

		$this->printDebug( "Sending digest emails ... Done! ($iEmailsSent total)" );
	}

	/**
	 * send email to user
	 */
	private function sendDigestsToUser( $iUserId ) {
		global $wgExternalDatawareDB, $wgGlobalWatchlistMaxDigestedArticlesPerWiki;
		
		$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalDatawareDB );			
			
		$oResource = $dbr->select(
			array ( "global_watchlist" ),
			array ( "gwa_id", "gwa_user_id", "gwa_city_id", "gwa_namespace", "gwa_title", "gwa_rev_id", "gwa_timestamp" ),
			array (
				"gwa_user_id" => intval( $iUserId ),
				"gwa_timestamp <= gwa_rev_timestamp",
				"gwa_timestamp is not null"
			),
			__METHOD__,
			array (
				"ORDER BY" => "gwa_timestamp, gwa_city_id"
			)
		);
	
		$records = $dbr->numRows( $oResource );
		$bTooManyPages = ( $records > $wgGlobalWatchlistMaxDigestedArticlesPerWiki ) ? true : false;

		$this->printDebug( "Found $records records - limit $wgGlobalWatchlistMaxDigestedArticlesPerWiki" );

		$iWikiId = $loop = 0;
		$aDigestData = array();
		$aWikiDigest = array( 'pages' => array() );
		$aRemove = array();
		while ( $oResultRow = $dbr->fetchObject( $oResource ) ) {
			# ---
			if ( $loop >= $wgGlobalWatchlistMaxDigestedArticlesPerWiki ) {
				break;
			}
			
			$oWikia = WikiFactory::getWikiByID( $oResultRow->gwa_city_id );
			if ( empty( $oWikia ) || empty( $oWikia->city_public ) ) {
				$this->printDebug( "Unknown Wikia: " . $oResultRow->gwa_city_id );
				continue;
			}
			
			if ( $iWikiId != $oResultRow->gwa_city_id ) {
				$this->printDebug( "Prepare email for Wiki: " . $oResultRow->gwa_city_id );

				if ( count( $aWikiDigest['pages'] ) ) {
					$aDigestData[ $iWikiId ] = $aWikiDigest;
				}

				$iWikiId = $oResultRow->gwa_city_id;

				if ( isset( $aDigestData[ $iWikiId ] ) ) {
					$aWikiDigest = $aDigestData[ $iWikiId ];
				} else {
					$aWikiDigest = array(
						'wikiName' => $oWikia->city_title,
						'wikiLangCode' => $oWikia->city_lang,
						'pages' => array()
					);
				}
			} // if

			if ( in_array( $oResultRow->gwa_namespace, array( NS_BLOG_ARTICLE_TALK, NS_BLOG_ARTICLE ) ) ) {
				# blogs
				$aWikiBlogs[$iWikiId][] = $oResultRow;
				$this->makeBlogsList( $aWikiDigest, $iWikiId, $oResultRow );
			} else {
				$oGlobalTitle = GlobalTitle::newFromText( $oResultRow->gwa_title, $oResultRow->gwa_namespace, $iWikiId );
				if ( $oGlobalTitle->exists() ) {
					$aWikiDigest[ 'pages' ][] = array(
						'title' => GlobalTitle::newFromText( $oResultRow->gwa_title, $oResultRow->gwa_namespace, $iWikiId ),
						'revisionId' => $oResultRow->gwa_rev_id
					);
				} else {
					$aRemove[] = $oResultRow->gwa_id;
				}
			}
			
			$loop++;

		} // while
		$dbr->freeResult( $oResource );

		$cnt = count( $aWikiDigest['pages'] );
		if ( isset( $aWikiDigest['blogs'] ) ) {
			$cnt += count( $aWikiDigest['blogs'] );
		}
		if ( !empty( $cnt ) ) {
			$aDigestData[ $iWikiId ] = $aWikiDigest;
		}

		$iEmailsSent = 0;
		if ( count( $aDigestData ) ) {
			$iEmailsSent++;
			$this->printDebug( "Sending email with " . count( $aDigestData ) . " records " );		
			$this->sendMail( $iUserId, $aDigestData, $bTooManyPages );
		} else {
			$this->printDebug( "No records to send " );				
		}
		
		if ( count( $aRemove ) ) {
			$dbs = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );
			foreach ( $aRemove as $gwa_id ) {
				$dbs->delete( 'global_watchlist', array( 'gwa_user_id' => $iUserId, 'gwa_id' => $gwa_id ), __METHOD__ );
			}
			$dbs->commit();
		}
		
		return $iEmailsSent;
	}

	/**
	 * blogs
	 */
	private function makeBlogsList( &$aWikiDigest, $iWikiId, $oResultRow ) {
		$blogTitle = $oResultRow->gwa_title;

		if ( $oResultRow->gwa_namespace == NS_BLOG_ARTICLE_TALK ) {
			$parts = ArticleComment::explode( $oResultRow->gwa_title );
			$blogTitle = $parts['title'];
		}
		
		if ( empty( $blogTitle ) ) {
			return false;
		}		

		if ( empty( $aWikiDigest[ 'blogs' ][ $blogTitle ] ) ) {
			$wikiDB = WikiFactory::IDtoDB( $oResultRow->gwa_city_id );
			if ( $wikiDB ) {
				$db_wiki = wfGetDB( DB_SLAVE, 'stats', $wikiDB );
				$like_title = $db_wiki->buildLike( $oResultRow->gwa_title, $db_wiki->anyString() );
				if ( $db_wiki && $like_title ) {
					$oRow = $db_wiki->selectRow(
						array( "watchlist" ),
						array( "count(*) as cnt" ),
						array(
							"wl_namespace = '" . NS_BLOG_ARTICLE_TALK . "'",
							"wl_title $like_title",
							"wl_notificationtimestamp is not null",
							"wl_notificationtimestamp >= '" . $oResultRow->gwa_timestamp . "'",
							"wl_user > 0",
						),
						__METHOD__
					);
					$aWikiDigest[ 'blogs' ][ $blogTitle ] = array (
						'comments' => intval( $oRow->cnt ),
						'blogpage' => GlobalTitle::newFromText( $blogTitle, NS_BLOG_ARTICLE, $iWikiId ),
						'own_comments' => 0
					);
					
					if ( !in_array( $wikiDB, array( 'wikicities', 'messaging' ) ) ) {
						$db_wiki->close();
					}		
				}	
			}		
		}

		if (
			( $oResultRow->gwa_namespace == NS_BLOG_ARTICLE_TALK ) &&
			isset( $aWikiDigest[ 'blogs' ][ $blogTitle ] )
		) {
			$aWikiDigest[ 'blogs' ][ $blogTitle ]['own_comments']++;
		}
	}

	/**
	 * send email
	 */
	private function sendMail( $iUserId, $aDigestData, $isDigestLimited ) {
		$oUser = User::newFromId( $iUserId );
		$oUser->load();

		$sEmailSubject = $this->getLocalizedMsg( 'globalwatchlist-digest-email-subject', $oUser->getOption( 'language' ) );
		list( $sEmailBody, $sEmailBodyHTML ) = $this->composeMail( $oUser, $aDigestData, $isDigestLimited );

		$sFrom = 'Wikia <community@wikia.com>';
		// yes this needs to be a MA object, not string (the docs for sendMail are wrong)
		$oReply = new MailAddress( 'noreply@wikia.com' );

		if ( empty( $this->mDebugMailTo ) ) {
			$oUser->sendMail( $sEmailSubject, $sEmailBody, $sFrom, $oReply, 'GlobalWatchlist', $sEmailBodyHTML );
			$this->printDebug( "Digest email sent to user: " . $oUser->getName() );
		}
		else {
			UserMailer::send( new MailAddress( $this->mDebugMailTo ), new MailAddress( $sFrom ), $sEmailSubject, $sEmailBody, null, null, 'GlobalWatchlist' );
			$this->printDebug( "Digest email sent to: " . $this->mDebugMailTo . " (debug mode)" );
		}

		$this->iEmailsSent++;
	}

	private function printDebug( $sMessage, $bForceDebugMode = false, $onlytext = false ) {
		if ( $this->mDebugMode || $bForceDebugMode ) {
			if ( $onlytext ) {
				print sprintf( "%s\n", $sMessage );
			} else {
				print sprintf( "[GlobalWatchlistBot] (%s): %s\n", $sMessage, date( 'Y-m-d H:i:s' ) );
			}
		}
	}

	private function calculateDuration( $iSeconds ) {
		if ( !$iSeconds ) {
			return "0s";
		}

		$aValues = array(
			'w' => (int) ( $iSeconds / 86400 / 7 ),
			'd' => $iSeconds / 86400 % 7,
			'h' => $iSeconds / 3600 % 24,
			'm' => $iSeconds / 60 % 60,
			's' => $iSeconds % 60
		);
		$aResult = array();
		$added = false;

		foreach ( $aValues as $k => $v ) {
			if ( $v > 0 || $added ) {
				$added = true;
				$aResult[] = $v . $k;
			}
		}

		return join( ' ', $aResult );
	}

	/*
	 * check lag only for this bot
	 */
	private function isLagged( $dbr ) {
		$res = $dbr->query( 'SHOW SLAVE STATUS', __METHOD__ );
		$row = $dbr->fetchObject( $res );
		if ( $row ) {
			$val = isset( $row->Seconds_behind_master ) ? $row->Seconds_behind_master : $row->Seconds_Behind_Master;
			return intval( $val );
		} else {
			return 0;
		}
	}
	
	/**
	 * gather digest data for all users
	 */
	public function regenerateWatchlist() {
		global $wgExternalSharedDB, $wgExternalDatawareDB;

		$wlNbr = 0;
		$this->printDebug( "Regenerate watchlist data ..." );

		$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
		$dbext = wfGetDB( DB_MASTER, array(), $wgExternalDatawareDB );

		$where = array(
			"city_public" 		=> 1,
			"city_useshared" 	=> 1
		);
		if ( !empty( $this->mUseDB ) ) {
			$where[] = " city_id in (" . implode( ",", $this->mUseDB ) . ") ";
		}

		$oResource = $dbr->select(
			array( "city_list" ),
			array( "city_id", "city_dbname", "city_lang", "city_title" ),
			$where,
			__METHOD__,
			array( "ORDER BY" => "city_id" )
		);

		while ( $oResultRow = $dbr->fetchObject( $oResource ) ) {
			$mCntUsers = 0;
			# -- load users from watchlist table with list of pages
			$localTime = time();
			$this->printDebug( "Processing {$oResultRow->city_dbname} ... " );
			$aUsers = $this->getUsersPagesFromWatchlist( $oResultRow->city_dbname );
			# ---
			$this->printDebug( count( $aUsers ) . " watchlister(s) found " );
			if ( !empty( $aUsers ) ) {
				# ----
				$dbext->begin();
				$dbext->delete("global_watchlist", array( 'gwa_city_id' => $oResultRow->city_id ), __METHOD__ );				
				foreach ( $aUsers as $iUserId => $aWatchLists ) {
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
								__METHOD__,
								array('IGNORE')
							);
							$wlNbr++;
							$mCntUsers++;
						} // foreach $aWatchLists
					} // if !empty $aWatchLists
				} // foreach
				$dbext->commit();
			} // !empty
			$aUsers = null;
			unset($aUsers);
			$this->printDebug( "Gathering watchlist data for: {$oResultRow->city_dbname} ({$oResultRow->city_id}) and " . $mCntUsers . " users ... done! (time: " . $this->calculateDuration( time() - $localTime ) . ")" );
		} // while
		$dbr->freeResult( $oResource );

		$this->printDebug( "Gathering all watchlist data ... done! (time: " . $this->calculateDuration( time() - $this->mStartTime ) . ")" );
		return $wlNbr;
	}	
	
	public function updateLog () {
		global $wgStatsDB;
		$dbw = wfGetDB( DB_MASTER, array(), $wgStatsDB );
		
		$where = array( 'logname' => 'weekly_digest' );
		
		$row = $dbw->selectRow( '`noreptemp`.`script_log`', array( 'logname' ), $where );

		if ( !empty( $row ) && $row->logname ) {
			$dbw->update( '`noreptemp`.`script_log`', array( 'ts' => wfTimestamp( TS_DB ) ), $where, __METHOD__ );
		} else {
			$data = array(
				'ts' => wfTimestamp( TS_DB ),
				'logname' => 'weekly_digest'
			);
			$dbw->insert( '`noreptemp`.`script_log`', $data, __METHOD__, 'IGNORE' );
		}
	}

}
