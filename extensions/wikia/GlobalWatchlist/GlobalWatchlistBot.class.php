<?php

use \Wikia\Tasks\AsyncTaskList;
use \Wikia\Logger\WikiaLogger;

class GlobalWatchlistBot {

	const MAX_ARTICLES_PER_WIKI = 50;
	const FROM_ADDRESS = 'Wikia <community@wikia.com>';
	const REPLY_ADDRESS = 'noreply@wikia.com';

	public function __construct() {
		\F::app()->wg->ExtensionMessagesFiles['GlobalWatchlist'] = dirname( __FILE__ ) . '/GlobalWatchlist.i18n.php';
	}

	/**
	 * Sends the weekly digest to all users in the global_watchlist table
	 */
	public function sendWeeklyDigest() {
		foreach ( $this->getUserIDs() as $userID ) {
			$this->sendDigestToUser( $userID );
			$this->clearWatchLists( $userID );
		}
	}

	/**
	 * Return all users in the global_watchlist table. If there's a problem with the query
	 * (eg, timing out), log the error. We have a Kibana check which will send out an alert
	 * if any "Weekly Digest Error" messages are sent.
	 * @return array
	 */
	private function getUserIDs() {
		$db = wfGetDB( DB_SLAVE, [], \F::app()->wg->ExternalDatawareDB );
		$userIDs = [];
		try {
			$userIDs = ( new WikiaSQL() )
				->SELECT()->DISTINCT( GlobalWatchlistTable::COLUMN_USER_ID )
				->FROM( GlobalWatchlistTable::TABLE_NAME )
				->runLoop( $db, function ( &$userIDs, $row ) {
					$userIDs[] = $row->gwa_user_id;
				} );
		} catch ( Exception $e ) {
			WikiaLogger::instance()->error( 'Weekly Digest Error', [
				'exception' => $e->getMessage(),
			] );
		}

		return $userIDs;
	}

	/**
	 * Clear the global_watchlist and local watchlists for a given user.
	 * This is done after we send them the weekly digest which effectively
	 * means they have "seen" all the watched pages and will receive notifications
	 * for new edits.
	 * @param int $userID
	 */
	public function clearWatchLists( $userID ) {
		$this->clearLocalWatchlists( $userID );
		$this->clearGlobalWatchlistAll( $userID );
	}

	/**
	 * Clears the local watchlist tables for a given user.
	 * @param int $userID
	 */
	public function clearLocalWatchlists( $userID ) {
		$wikiIDs = $this->getWikisWithWatchedPagesForUser( $userID );
		foreach ( $wikiIDs as $wikiID ) {
			$db = wfGetDB( DB_MASTER, [], WikiFactory::IDtoDB( $wikiID ) );
			( new WikiaSQL() )
				->UPDATE( 'watchlist' )
				->SET( 'wl_notificationtimestamp', null )
				->WHERE( 'wl_user' )->EQUAL_TO( $userID )
				->run( $db );
		}
	}

	/**
	 * Get all wikis that a user has a watched item on. We'll use this list
	 * to clear those watched pages in the local watchlist table.
	 * @param int $userID
	 * @return array
	 */
	private function getWikisWithWatchedPagesForUser( $userID ) {
		$db = wfGetDB( DB_SLAVE, [], \F::app()->wg->ExternalDatawareDB );
		$wikiIDs = ( new WikiaSQL() )
			->SELECT()->DISTINCT( GlobalWatchlistTable::COLUMN_CITY_ID )
			->FROM( GlobalWatchlistTable::TABLE_NAME )
			->WHERE( GlobalWatchlistTable::COLUMN_USER_ID )->EQUAL_TO( $userID )
			->AND_( GlobalWatchlistTable::COLUMN_TIMESTAMP )->IS_NOT_NULL()
			->runLoop( $db, function ( &$wikiIDs, $row ) {
				$wikiIDs[] = $row->gwa_city_id;
			} );

		return $wikiIDs;
	}

	/**
	 * Clears all watched pages from all wikis for the given user in
	 * the global_watchlist table.
	 * @param int $userID
	 */
	public function clearGlobalWatchlistAll( $userID ) {
		$db = wfGetDB( DB_MASTER, [], \F::app()->wg->ExternalDatawareDB );
		( new WikiaSQL() )
			->DELETE()->FROM( GlobalWatchlistTable::TABLE_NAME )
			->WHERE( GlobalWatchlistTable::COLUMN_USER_ID )->EQUAL_TO( $userID )
			->run( $db );
	}


	/**
	 * send email to user
	 * TODO Break this method up a bit. It does way way too many things.
	 * @param $userID integer
	 */
	public function sendDigestToUser( $userID ) {

		if ( $this->shouldNotSendDigest( $userID, $sendLogging = true ) ) {
			return;
		}

		$dbr = wfGetDB( DB_SLAVE, [], \F::app()->wg->ExternalDatawareDB );

		$oResource = $dbr->select(
			[ GlobalWatchlistTable::TABLE_NAME ],
			[
				GlobalWatchlistTable::COLUMN_ID,
				GlobalWatchlistTable::COLUMN_USER_ID,
				GlobalWatchlistTable::COLUMN_CITY_ID,
				GlobalWatchlistTable::COLUMN_NAMESPACE,
				GlobalWatchlistTable::COLUMN_TITLE,
				GlobalWatchlistTable::COLUMN_REVISION_ID,
				GlobalWatchlistTable::COLUMN_TIMESTAMP
			],
			[ GlobalWatchlistTable::COLUMN_USER_ID => $userID ],
			__METHOD__,
			[ "ORDER BY" => GlobalWatchlistTable::COLUMN_TIMESTAMP . ", " . GlobalWatchlistTable::COLUMN_CITY_ID ]
		);

		$records = $dbr->numRows( $oResource );
		$bTooManyPages = ( $records > self::MAX_ARTICLES_PER_WIKI );
		$iWikiId = $loop = 0;
		$aDigestData = [];
		$aWikiDigest = [ 'pages' => [] ];
		$aRemove = [];
		while ( $oResultRow = $dbr->fetchObject( $oResource ) ) {
			# ---
			if ( $loop >= self::MAX_ARTICLES_PER_WIKI ) {
				break;
			}

			$oWikia = WikiFactory::getWikiByID( $oResultRow->gwa_city_id );
			if ( empty( $oWikia->city_public ) ) {
				continue;
			}

			if ( $iWikiId != $oResultRow->gwa_city_id ) {

				if ( count( $aWikiDigest['pages'] ) ) {
					$aDigestData[ $iWikiId ] = $aWikiDigest;
				}

				$iWikiId = $oResultRow->gwa_city_id;

				if ( isset( $aDigestData[ $iWikiId ] ) ) {
					$aWikiDigest = $aDigestData[$iWikiId];
				} else {
					$aWikiDigest = [
						'wikiName' => $oWikia->city_title,
						'wikiLangCode' => $oWikia->city_lang,
						'pages' => []
					];
				}
			} // if

			if ( in_array( $oResultRow->gwa_namespace, [ NS_BLOG_ARTICLE_TALK, NS_BLOG_ARTICLE ] ) ) {
				# blogs
				$aWikiBlogs[$iWikiId][] = $oResultRow;
				$this->makeBlogsList( $aWikiDigest, $iWikiId, $oResultRow );
			} else {
				$oGlobalTitle = GlobalTitle::newFromText( $oResultRow->gwa_title, $oResultRow->gwa_namespace, $iWikiId );
				if ( $oGlobalTitle->exists() ) {
					$aWikiDigest['pages'][] = [
						'title' => GlobalTitle::newFromText( $oResultRow->gwa_title, $oResultRow->gwa_namespace, $iWikiId ),
						'revisionId' => $oResultRow->gwa_rev_id
					];
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

		if ( count( $aDigestData ) ) {
			$this->sendMail( $userID, $aDigestData, $bTooManyPages );
		}

		if ( count( $aRemove ) ) {
			$dbs = wfGetDB( DB_MASTER, [], \F::app()->wg->ExternalDatawareDB );
			foreach ( $aRemove as $gwa_id ) {
				$dbs->delete(
					GlobalWatchlistTable::TABLE_NAME,
					[ GlobalWatchlistTable::COLUMN_USER_ID => $userID, GlobalWatchlistTable::COLUMN_ID => $gwa_id ],
					__METHOD__
				);
			}
		}
	}

	/**
	 * @param int $userID
	 * @param bool $sendLogging
	 * @return bool
	 */
	public function shouldNotSendDigest( $userID, $sendLogging = false ) {
		$user = $this->getUserObject( $userID );
		try {
			$this->checkIfValidUser( $user );
			$this->checkIfEmailUnSubscribed( $user );
			$this->checkIfEmailConfirmed( $user );
			$this->checkIfSubscribedToWeeklyDigest( $user );
		} catch ( Exception $e ) {
			if ( $sendLogging ) {
				WikiaLogger::instance()->info( 'Weekly Digest Skipped', [
					'reason' => $e->getMessage(),
					'userID' => $userID
				] );
			}
			return true;
		}
		return false;
	}

	/**
	 * @param int $userID
	 * @return null|User
	 */
	private function getUserObject( $userID ) {

		if (\F::app()->wg->ExternalAuthType ) {
			$mExtUser = ExternalUser::newFromId( $userID );
			if ( is_object( $mExtUser ) && ( 0 != $mExtUser->getId() ) ) {
				$mExtUser->linkToLocal( $mExtUser->getId() );
				$user = $mExtUser->getLocalUser();
			} else {
				$user = null;
			}
		} else {
			$user = User::newFromId ( $userID );
		}

		return $user;
	}

	/**
	 * @param User $user
	 * @throws Exception
	 */
	private function checkIfValidUser( $user ) {
		if ( !$user instanceof User ) {
			throw new Exception( 'Invalid user object.' );
		}
	}

	/**
	 * @param User $user
	 * @throws Exception
	 */
	private function checkIfEmailUnSubscribed( \User $user ) {
		if ( $user->getBoolOption( 'unsubscribed' ) ) {
			throw new Exception( 'Email is unsubscribed.' );
		}
	}

	/**
	 * @param User $user
	 * @throws Exception
	 */
	private function checkIfEmailConfirmed( \User $user ) {
		if ( !$user->isEmailConfirmed() ) {
			throw new Exception( 'Email is not confirmed.' );
		}
	}

	/**
	 * @param User $user
	 * @throws Exception
	 */
	private function checkIfSubscribedToWeeklyDigest( \User $user ) {
		if ( !$user->getBoolOption( 'watchlistdigest' ) ) {
			throw new Exception( 'Not subscribed to weekly digest' );
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

		// yes this needs to be a MA object, not string (the docs for sendMail are wrong)
		$oReply = new MailAddress( self::REPLY_ADDRESS );

		$oUser->sendMail( $sEmailSubject, $sEmailBody, self::FROM_ADDRESS, $oReply, 'GlobalWatchlist', $sEmailBodyHTML );

		WikiaLogger::instance()->info( 'Weekly Digest Sent', [ 'userID' => $iUserId ] );
	}

	/**
	 * compose digest email for user
	 * TODO Break this method up a bit. It does way way too many things.
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
						[
							0 => $tracking_url, // send the ugly tracking url to the plain emails
							1 => $countComments
						]
					);
					$sDigestsBlogs .= $message . "\n";

					if ( $usehtmlemail ) {
						// for html emails, remake some things
						$clean_url = $blogComments['blogpage']->getFullURL();
						$clean_url = str_replace( '_', ' ', rawurldecode( $clean_url ) );
						$message = wfMsgReplaceArgs(
							( $countComments != 0 ) ? $this->getLocalizedMsg( 'globalwatchlist-blog-page-title-comment', $oUserLanguage ) : "$1",
							[
								0 => "<a href=\"{$tracking_url}\">" . $clean_url . "</a>", // but use the non-tracking one for html display
								1 => $countComments
							]
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
		$aEmailArgs = [
			0 => ucfirst( $oUser->getName() ),
			1 => ( $iPagesCount > 0 ) ? $sDigests : $this->getLocalizedMsg( 'globalwatchlist-no-page-found', $oUserLanguage ),
			2 => ( $iBlogsCount > 0 ) ? $sDigestsBlogs : "",
		];

		$sMessage = $this->getLocalizedMsg( 'globalwatchlist-digest-email-body', $oUserLanguage ) . "\n";
		if ( empty( $aEmailArgs[2] ) ) $sMessage = $this->cutOutPart( $sMessage, '$2', '$3' );
		$sBody = wfMsgReplaceArgs( $sMessage, $aEmailArgs );
		if ( $usehtmlemail ) {
			// rebuild the $ args using the HTML text we've built
			$aEmailArgs = [
				0 => ucfirst( $oUser->getName() ),
				1 => ( $iPagesCount > 0 ) ? $sDigestsHTML : $this->getLocalizedMsg( 'globalwatchlist-no-page-found', $oUserLanguage ),
				2 => ( $iBlogsCount > 0 ) ? $sDigestsBlogsHTML : "",
			];

			$sMessageHTML = $this->getLocalizedMsg( 'globalwatchlist-digest-email-body-html', $oUserLanguage );
			if ( !wfEmptyMsg( 'globalwatchlist-digest-email-body-html', $sMessageHTML ) ) {
				if ( empty( $aEmailArgs[2] ) ) $sMessageHTML = $this->cutOutPart( $sMessageHTML, '$2', '$3' );
				$sBodyHTML = wfMsgReplaceArgs( $sMessageHTML, $aEmailArgs );
			}
		}

		return [ $sBody, $sBodyHTML ];
	}

	private function cutOutPart( $message, $startMarker, $endMarker, $replacement = " " ) {
		// this is a quick way to skip some parts of email message without remaking all the i18n messages.
		$startPos = strpos( $message, $startMarker );
		$endPos = strpos( $message, $endMarker );
		if ( $startPos !== FALSE && $endPos !== FALSE ) {
			$message = substr( $message, 0, $startPos + strlen( $startMarker ) ) . $replacement . substr( $message, $endPos );
		}
		return $message;
	}

	private function getLocalizedMsg( $sMsgKey, $sLangCode ) {
		$sBody = null;

		if ( ( $sLangCode != 'en' ) && !empty( $sLangCode ) ) {
			// custom lang translation
			$sBody = wfMessage( $sMsgKey )->inLanguage( $sLangCode );
		}

		if ( $sBody == null ) {
			$sBody = wfMessage( $sMsgKey )->text();
		}

		return $sBody;
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
						[ "watchlist" ],
						[ "count(*) as cnt" ],
						[
							"wl_namespace = '" . NS_BLOG_ARTICLE_TALK . "'",
							"wl_title $like_title",
							"wl_notificationtimestamp is not null",
							"wl_notificationtimestamp >= '" . $oResultRow->gwa_timestamp . "'",
							"wl_user > 0",
						],
						__METHOD__
					);
					$aWikiDigest[ 'blogs' ][ $blogTitle ] = [
						'comments' => intval( $oRow->cnt ),
						'blogpage' => GlobalTitle::newFromText( $blogTitle, NS_BLOG_ARTICLE, $iWikiId ),
						'own_comments' => 0
					];

					if ( !in_array( $wikiDB, [ 'wikicities', 'messaging' ] ) ) {
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
}
