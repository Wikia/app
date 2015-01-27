<?php

class GlobalWatchlistBot {
	private $mDebugMode;
	private $mDebugMailTo = '';
	private $mUsers;
	private $mUseDB;
	private $iEmailsSent;

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

	public function clearWatchLists( $userID ) {
		$this->clearLocalWatchlists( $userID );
		$this->clearGlobalWatchlist( $userID );
	}

	private function clearLocalWatchlists( $userID ) {
		global $wgExternalDatawareDB;

		$db = wfGetDB( DB_SLAVE, [], $wgExternalDatawareDB );
		$wikiIDs = ( new WikiaSQL() )
			->SELECT( 'gwa_city_id' )
			->FROM( 'global_watchlist' )
			->WHERE( 'gwa_user_id' )->EQUAL_TO( $userID )
			->AND_( 'gwa_timestamp' )->IS_NOT_NULL()
			->runLoop( $db, function ( &$wikiIDs, $row ) {
				$wikiIDs[] = $row->gwa_city_id;
			} );

		foreach ( $wikiIDs as $wikiID ) {
			$db = wfGetDB( DB_MASTER, [], $wikiID );
			( new WikiaSQL() )
				->UPDATE( 'watchlist' )
				->SET( 'wl_notificationtimestamp', null )
				->WHERE( 'wl_user' )->EQUAL_TO( $userID )
				->run( $db );
		}
	}

	private function clearGlobalWatchlist( $userID ) {
		global $wgExternalDatawareDB;
		$db = wfGetDB( DB_MASTER, [], $wgExternalDatawareDB );
		( new WikiaSQL() )
			->UPDATE( 'global_watchlist' )
			->SET( 'gwa_timestamp', null )
			->WHERE( 'gwa_user_id' )->EQUAL_TO( $userID )
			->run( $db );
	}

	/**
	 * compose digest email for user
	 */
	function composeMail ( $oUser, $aDigestsData, $isDigestLimited ) {

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
	 * send email to user
	 */
	public function sendDigestToUser( $iUserId ) {
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
				continue;
			}

			if ( $iWikiId != $oResultRow->gwa_city_id ) {

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
			$this->sendMail( $iUserId, $aDigestData, $bTooManyPages );
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
		} else {
			UserMailer::send( new MailAddress( $this->mDebugMailTo ), new MailAddress( $sFrom ), $sEmailSubject, $sEmailBody, null, null, 'GlobalWatchlist' );
		}

		$this->iEmailsSent++;
	}
}
