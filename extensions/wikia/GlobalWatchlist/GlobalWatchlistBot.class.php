<?php

use \Wikia\Logger\WikiaLogger;

class GlobalWatchlistBot {

	const MAX_ARTICLES_PER_WIKI = 50;
	const FROM_NAME = 'Wikia';
	const FROM_ADDRESS = 'community@wikia.com';
	const REPLY_ADDRESS = 'noreply@wikia.com';
	const EMAIL_CONTROLLER = 'Email\Controller\WeeklyDigestController';

	public function __construct() {
		$messageFiles = \F::app()->wg->ExtensionMessagesFiles;
		$messageFiles['GlobalWatchlist'] = dirname( __FILE__ ) . '/GlobalWatchlist.i18n.php';
	}

	/**
	 * Sends the weekly digest to all users in the global_watchlist table
	 */
	public function sendWeeklyDigest() {
		foreach ( $this->getUserIDs() as $userID ) {
			$this->sendDigestToUser( $userID );
//			$this->clearWatchLists( $userID );
		}
	}

	/**
	 * Return all users in the global_watchlist table.
	 * @return array
	 */
	private function getUserIDs() {
		$db = wfGetDB( DB_SLAVE, [], \F::app()->wg->ExternalDatawareDB );
		$userIDs = ( new WikiaSQL() )
			->SELECT()->DISTINCT( GlobalWatchlistTable::COLUMN_USER_ID )
			->FROM( GlobalWatchlistTable::TABLE_NAME )
			->runLoop( $db, function ( &$userIDs, $row ) {
				$userIDs[] = $row->gwa_user_id;
			} );

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
			return $this->prepareDigestDataForEmail( $aDigestData );
			//return $this->sendMail( $userID, $aDigestData, $bTooManyPages );
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
	private function sendMail( $iUserId, $aDigestData ) {

		$digestDataForEmail = $this->prepareDigestDataForEmail( $aDigestData );
		$params = [
			'targetUser' => User::newFromId( $iUserId )->getName(),
			'replyToAddress' => self::REPLY_ADDRESS,
			'fromAddress' => self::FROM_ADDRESS,
			'fromName' => self::FROM_NAME,
			'digestData' => $digestDataForEmail
		];

		print_r($digestDataForEmail);

		F::app()->sendRequest( self::EMAIL_CONTROLLER, 'handle', $params );
		WikiaLogger::instance()->info( 'Weekly Digest Sent', [ 'userID' => $iUserId ] );
	}

	/**
	 */
	function prepareDigestDataForEmail ( $digestsData ) {

		$iPagesCount = 0;
		$allWikiDigestData = [];
		foreach ( $digestsData as $digest ) {
			$currentWikiDigestData = [
				'wikiaName' => $digest['wikiName'],
				'pages' => []
			];

			if ( !empty( $digest['pages'] ) ) {
				foreach ( $digest['pages'] as $pageData ) {
					$currentWikiDigestData['pages'][] = [
						'pageUrl' => $this->getPageUrl( $pageData ),
						'pageName' => $this->getPageName( $pageData )
					];
					$iPagesCount++;
				}
				$allWikiDigestData[] = $currentWikiDigestData;
			}
		}

		return $allWikiDigestData;
	}

	private function getPageUrl( $pageData ) {
		return $pageData['title']->getFullURL(
			's=dgdiff' . ( $pageData['revisionId'] ? "&diff=" . $pageData['revisionId'] . "&oldid=prev" : "" )
		);
	}

	private function getPageName( $pageData ) {
		return str_replace( '_', ' ', rawurldecode( $pageData['title']->getArticleName() ) );
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

//	private function doTheBlogStuff() {
//		# blog comments
//		if ( !empty( $aDigest['blogs'] ) ) {
//			foreach ( $aDigest['blogs'] as $blogTitle => $blogComments ) {
//				# $countComments = ($blogComments['comments'] >= $blogComments['own_comments']) ? intval($blogComments['comments'] - $blogComments['own_comments']) : $blogComments['comments'];
//				$countComments = $blogComments['comments'];
//
//				$tracking_url = $blogComments['blogpage']->getFullURL( 's=dg' ); // watchlist tracking, rt#33913
//
//				$message = wfMsgReplaceArgs(
//					( $countComments != 0 ) ? $this->getLocalizedMsg( 'globalwatchlist-blog-page-title-comment', $oUserLanguage ) : "$1",
//					[
//						0 => $tracking_url, // send the ugly tracking url to the plain emails
//						1 => $countComments
//					]
//				);
//				$sDigestsBlogs .= $message . "\n";
//
//				// for html emails, remake some things
//				$clean_url = $blogComments['blogpage']->getFullURL();
//				$clean_url = str_replace( '_', ' ', rawurldecode( $clean_url ) );
//				$message = wfMsgReplaceArgs(
//					( $countComments != 0 ) ? $this->getLocalizedMsg( 'globalwatchlist-blog-page-title-comment', $oUserLanguage ) : "$1",
//					[
//						0 => "<a href=\"{$tracking_url}\">" . $clean_url . "</a>", // but use the non-tracking one for html display
//						1 => $countComments
//					]
//				);
//				$sDigestsBlogsHTML .= $message . "<br/>\n";
//
//				$iBlogsCount++;
//			}
//			$sDigestsBlogs .= "\n";
//		}
//
//	}
}
