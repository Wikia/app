<?php

class RevisionUpvotesService {

	const UPVOTE_TABLE = 'upvote';
	const UPVOTE_REVISIONS_TABLE = 'upvote_revisions';
	const UPVOTE_USERS_TABLE = 'upvote_users';

	/**
	 * Add upvote for given revision
	 *
	 * @param int $wikiId
	 * @param int $pageId
	 * @param int $revisionId
	 * @param int $userId
	 * @param int $fromUser
	 */
	public function addUpvote( $wikiId, $pageId, $revisionId, $userId, $fromUser ) {
		$id = 0;
		$upvoteId = $this->getUpvoteId( $wikiId, $revisionId );

		if ( empty( $upvoteId ) ) {
			$upvoteId = $this->addUpvoteRevision( $wikiId, $pageId, $revisionId, $userId );
		}

		if ( !empty( $upvoteId ) ) {
			$id = $this->addUserUpvote( $upvoteId, $userId, $fromUser );
		}

		return $id;
	}

	/**
	 * Remove upvote for given revision made by user
	 *
	 * @param int $id
	 * @param int $fromUser
	 */
	public function removeUpvote( $id, $fromUser, $userId ) {
		$db = $this->getDatabaseForWrite();

		$db->begin();

		( new \WikiaSQL() )
			->DELETE( self::UPVOTE_TABLE )
			->WHERE( 'id' )->EQUAL_TO( $id )
			->AND_( 'from_user' )->EQUAL_TO( $fromUser )
			->run( $db );

		$rowRemoved = $db->affectedRows();

		if ( $this->shouldStoreUserData( $userId ) ) {
			( new \WikiaSQL() )
				->UPDATE( self::UPVOTE_USERS_TABLE )
				->SET_RAW( 'total', 'IF(`total` > 0, `total` - 1, 0)' )
				->SET_RAW( 'new', 'IF(`new` > 0, `new` - 1, 0)' )
				->WHERE( 'user_id' )->EQUAL_TO( $userId )
				->run( $db );
		}

		if ( $rowRemoved ) {
			$db->commit();
		} else {
			$db->rollback();
		}

		return $rowRemoved;
	}

	/**
	 * Get all upvotes for given revision
	 *
	 * @param int $wikiId
	 * @param int $revisionId
	 * @return bool|array
	 */
	public function getRevisionUpvotes( $wikiId, $revisionId ) {
		$db = $this->getDatabaseForRead();

		$upvote = ( new \WikiaSQL() )
			->SELECT_ALL()
			->FROM( self::UPVOTE_REVISIONS_TABLE )->AS_( 'revs' )
			->INNER_JOIN( self::UPVOTE_TABLE )->AS_( 'uv' )
			->ON( 'revs.upvote_id', 'uv.upvote_id' )
			->WHERE( 'wiki_id' )->EQUAL_TO( $wikiId )
			->AND_( 'revision_id' )->EQUAL_TO( $revisionId )
			->runLoop( $db, function( &$upvote, $row ) {
				if ( empty( $upvote['revision'] ) ) {
					$upvote['revision'] = [
						'wikiId' => (int) $row->wiki_id,
						'pageId' => (int) $row->page_id,
						'revisionId' => (int) $row->revision_id,
						'userId' => (int) $row->user_id,
						'upvoteId' => (int) $row->upvote_id
					];
				}

				$upvote['upvotes'][] = [
					'id' => (int) $row->id,
					'from_user' => (int) $row->from_user
				];
			} );

		$upvote['count'] = count( $upvote['upvotes'] );

		return $upvote;
	}

	/**
	 * Get upvotes data for many revisions
	 *
	 * @param int $wikiId
	 * @param array $revisionsIds
	 * @return bool|array
	 */
	public function getRevisionsUpvotes( $wikiId, array $revisionsIds ) {
		$db = $this->getDatabaseForRead();

		$upvotes = ( new \WikiaSQL() )
			->SELECT_ALL()
			->FROM( self::UPVOTE_REVISIONS_TABLE )->AS_( 'revs' )
			->INNER_JOIN( self::UPVOTE_TABLE )->AS_( 'uv' )
			->ON( 'revs.upvote_id', 'uv.upvote_id' )
			->WHERE( 'wiki_id' )->EQUAL_TO( $wikiId )
			->AND_( 'revision_id' )->IN( $revisionsIds )
			->runLoop( $db, function( &$upvotes, $row ) {
				if ( empty( $upvotes[$row->revision_id]['revision'] ) ) {
					$upvotes[$row->revision_id]['revision'] = [
						'wikiId' => (int) $row->wiki_id,
						'pageId' => (int) $row->page_id,
						'revisionId' => (int) $row->revision_id,
						'userId' => (int) $row->user_id,
						'upvoteId' => (int) $row->upvote_id
					];
				}

				$upvotes[$row->revision_id]['upvotes'][] = [
					'id' => (int) $row->id,
					'from_user' => (int) $row->from_user
				];
			} );

		foreach ( $upvotes as $revisionId => $upvote ) {
			$upvotes[$revisionId]['count'] = count( $upvotes[$revisionId]['upvotes'] );
		}

		return $upvotes;
	}

	/**
	 * Get all upvotes for revisions made by given user
	 *
	 * @param int $userId
	 * @param string $afterDate date in TS_DB format (YYYY-MM-DD HH:MM:SS)
	 * @return bool|array
	 */
	public function getUserUpvotes( $userId, $afterDate = '' ) {
		$db = $this->getDatabaseForRead();

		$sql = ( new \WikiaSQL() )
			->SELECT_ALL()
			->FROM( self::UPVOTE_REVISIONS_TABLE )->AS_( 'revs' )
			->LEFT_JOIN( self::UPVOTE_TABLE )->AS_( 'uv' )
			->ON( 'revs.upvote_id', 'uv.upvote_id' )
			->WHERE( 'user_id' )->EQUAL_TO( $userId );

		if ( !empty( $afterDate ) ) {
			$sql->AND_( 'date' )->GREATER_THAN( $afterDate );
		}

		$upvotes = $sql->runLoop( $db, function( &$upvotes, $row ) {
			if ( empty( $upvotes[$row->upvote_id]['revision'] ) ) {
				$upvotes[$row->upvote_id]['revision'] = [
					'wikiId' => (int) $row->wiki_id,
					'pageId' => (int) $row->page_id,
					'revisionId' => (int) $row->revision_id,
					'userId' => (int) $row->user_id,
					'upvoteId' => (int) $row->upvote_id
				];
			}

			$upvotes[$row->upvote_id]['upvotes'][] = [
				'from_user' => (int) $row->from_user
			];
		} );

		foreach ( $upvotes as $upvoteId => $upvote ) {
			$upvotes[$upvoteId]['count'] = count( $upvotes[$upvoteId]['upvotes'] );
		}

		return $upvotes;
	}

	/**
	 * Get new upvotes for revisions made by given user
	 *
	 * @param int $userId
	 * @return bool|array
	 */
	public function getUserNewUpvotes( $userId ) {
		$status = $this->getUserUpvotesStatus( $userId );

		if ( !empty( $status['notified'] ) ) {
			return [];
		}

		return $this->getUserUpvotes( $userId, $status['last_notified'] );
	}

	private function getUserUpvotesStatus( $userId ) {
		$db = $this->getDatabaseForRead();

		$status = ( new \WikiaSQL() )
			->SELECT( 'notified', 'last_notified' )
			->FROM( self::UPVOTE_USERS_TABLE )
			->WHERE( 'user_id' )->EQUAL_TO( $userId )
			->run( $db, function( $result ) {
				$status = [];
				$row = $result->fetchObject();

				if ( !empty( $row ) ) {
					$status = [
						'notified' => $row->notified,
						'last_notified' => $row->last_notified
					];
				}

				return $status;
			} );

		return $status;
	}

	/**
	 * Update user upvotes notification state
	 *
	 * @param $userId
	 */
	public function setUserNotified( $userId ) {
		$db = $this->getDatabaseForWrite();

		( new \WikiaSQL() )
			->UPDATE( self::UPVOTE_USERS_TABLE )
			->SET( 'notified', true )
			->SET( 'new', 0 )
			->SET( 'last_notified', wfTimestamp( TS_DB ) )
			->WHERE( 'user_id' )->EQUAL_TO( $userId )
			->run( $db );
	}

	/**
	 * Gets upvote id for given wiki id and revision id
	 *
	 * @param int $wikiId
	 * @param int $revisionId
	 * @return bool|int
	 */
	private function getUpvoteId( $wikiId, $revisionId ) {
		$db = $this->getDatabaseForRead();

		$upvoteId = ( new \WikiaSQL() )
			->SELECT( 'upvote_id' )
			->FROM( self::UPVOTE_REVISIONS_TABLE )
			->WHERE( 'wiki_id' )->EQUAL_TO( $wikiId )
			->AND_( 'revision_id' )->EQUAL_TO( $revisionId )
			->run( $db, function( $result ) {
				$row = $result->fetchObject();
				return (int) $row->upvote_id;
			} );

		return $upvoteId;
	}

	/**
	 * Adds revision data
	 *
	 * @param int $wikiId
	 * @param int $pageId
	 * @param int $revisionId
	 * @param int $userId
	 * @return int
	 */
	private function addUpvoteRevision( $wikiId, $pageId, $revisionId, $userId ) {
		$db = $this->getDatabaseForWrite();

		( new \WikiaSQL() )
			->INSERT( self::UPVOTE_REVISIONS_TABLE )
			->SET( 'wiki_id', $wikiId )
			->SET( 'page_id', $pageId )
			->SET( 'revision_id', $revisionId )
			->SET( 'user_id', $userId )
			->run( $db );

		$lastId = $db->insertId();

		return $lastId;
	}

	/**
	 * Add upvote for given revision and update user upvotes data
	 *
	 * @param int $upvoteId
	 * @param int $userId
	 * @param int $fromUser
	 *
	 * @throws DBQueryError
	 * @throws MWException
	 */
	private function addUserUpvote( $upvoteId, $userId, $fromUser ) {
		$db = $this->getDatabaseForWrite();

		$db->begin();

		$db->insert( self::UPVOTE_TABLE, [ 'upvote_id' => $upvoteId, 'from_user' => $fromUser ] );

		$lastId = $db->insertId();

		if ( $this->shouldStoreUserData( $userId ) ) {
			$db->upsert(
				self::UPVOTE_USERS_TABLE,
				[
					'user_id' => $userId,
					'total' => 1,
					'new' => 1
				],
				[ ],
				[
					'total = total + 1',
					'new = new + 1',
					'notified' => false
				]
			);
		}

		$db->commit();

		return $lastId;
	}

	/**
	 * @return DatabaseMysqli
	 */
	private function getDatabaseForRead() {
		return $this->getDatabase();
	}

	/**
	 * @return DatabaseMysqli
	 */
	private function getDatabaseForWrite() {
		return $this->getDatabase( DB_MASTER );
	}

	private function getDatabase( $db = DB_SLAVE ) {
		return wfGetDB( $db, [], F::app()->wg->RevisionUpvotesDB );
	}

	private function shouldStoreUserData( $userId ) {
		return $userId > 0;
	}
}
