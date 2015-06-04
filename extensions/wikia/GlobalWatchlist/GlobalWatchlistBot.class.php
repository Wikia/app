<?php

use \Wikia\Logger\WikiaLogger;

class GlobalWatchlistBot {

	const MAX_PAGES_PER_DIGEST = 50;
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

		$loop = 0;
		$digestData = [];
		foreach( $this->getUsersWatchedPages( $userID ) as $watchedPage ) {

			if ( $loop >= self::MAX_PAGES_PER_DIGEST ) {
				break;
			}

			$wikiaName = $this->getWikiaName( $watchedPage->gwa_city_id );
			if ( empty( $wikiaName ) ) {
				continue;
			}

			$title = $this->getTitle( $watchedPage );
			if ( !$title->exists() ) {
				continue;
			}

			if ( empty( $digestData[$wikiaName] ) ) {
				$digestData[$wikiaName] = [
					'wikiaName' => $wikiaName,
					'pages' => []
				];
			}

			$digestData[$wikiaName]['pages'][] = [
				'pageUrl' => $this->getPageUrl( $title, $watchedPage->gwa_rev_id ),
				'pageName' => $this->getPageName( $title )
			];

			$loop++;
		}

		if ( !empty( $digestData ) ) {
			$this->sendMail( $userID, array_values( $digestData ) );
		}
	}

	private function getWikiaName( $wikiaId ) {
		$wikiaName = "";
		$wikia = WikiFactory::getWikiByID( $wikiaId );
		// Make sure city isn't private
		if ( !empty( $wikia->city_public ) ) {
			$wikiaName = $wikia->city_title;
		}

		return $wikiaName;
	}

	private function getTitle( $watchedPage ) {
		return GlobalTitle::newFromText( $watchedPage->gwa_title, $watchedPage->gwa_namespace, $watchedPage->gwa_city_id );
	}

	private function getUsersWatchedPages( $userId ) {
		$db = wfGetDB( DB_SLAVE, [], \F::app()->wg->ExternalDatawareDB );
		$watchedPages = ( new WikiaSQL() )
			->SELECT()
			->FIELD( GlobalWatchlistTable::COLUMN_CITY_ID )
			->FIELD( GlobalWatchlistTable::COLUMN_TITLE )
			->FIELD( GlobalWatchlistTable::COLUMN_NAMESPACE )
			->FIELD( GlobalWatchlistTable::COLUMN_REVISION_ID )
			->FROM( GlobalWatchlistTable::TABLE_NAME )
			->WHERE( GlobalWatchlistTable::COLUMN_USER_ID )->EQUAL_TO( $userId )
			->ORDER_BY( GlobalWatchlistTable::COLUMN_TIMESTAMP, GlobalWatchlistTable::COLUMN_CITY_ID )
			->runLoop( $db, function ( &$watchedPages, $row ) {
				$watchedPages[] = $row;
			} );

		return $watchedPages;
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
	private function sendMail( $iUserId, $digestData ) {

		$params = [
			'targetUser' => User::newFromId( $iUserId )->getName(),
			'replyToAddress' => self::REPLY_ADDRESS,
			'fromAddress' => self::FROM_ADDRESS,
			'fromName' => self::FROM_NAME,
			'digestData' => $digestData
		];

		F::app()->sendRequest( self::EMAIL_CONTROLLER, 'handle', $params );
		WikiaLogger::instance()->info( 'Weekly Digest Sent', [ 'userID' => $iUserId ] );
	}

	/**
	 * @param \Title $title
	 * @param $revisionId
	 * @return string
	 */
	private function getPageUrl( Title $title, $revisionId ) {
		return $title->getFullURL('s=dgdiff' . ( $revisionId ? "&diff=" . $revisionId . "&oldid=prev" : "" )
		);
	}

	/**
	 * @param \Title $title
	 * @return string
	 */
	private function getPageName( Title $title ) {
		return str_replace( '_', ' ', rawurldecode( $title->getArticleName() ) );
	}
}
