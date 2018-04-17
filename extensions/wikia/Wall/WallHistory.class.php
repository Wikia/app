<?php

/**
 * Class WallHistory, it's used by WallHistoryController and ForumController
 */
class WallHistory extends WikiaModel {

	private $page = 1;
	private $perPage = 100;

	/**
	 * Events of message creation, edit, delete and restore are stored in wall_history table.
	 *
	 * - Messages deleted using MediaWiki flow are removed from the table.
	 * - Messages deleted via Wall flow are marked as deleted in comments_index table
	 *
	 * @param int $type one of WH_* defines
	 * @param WallNotificationAdminEntity $feed
	 * @param User $user
	 */
	public function add( int $type, $feed, User $user ) {

		switch( $type ) {
			case WH_EDIT:
			case WH_NEW:
				// notify Forum extension
				Hooks::run( 'WallAction', [ $type, $feed->data->parent_id, $feed->data->title_id ] );
				$this->addNewOrEdit( $type, $feed, $user );
			break;
			case WH_ARCHIVE:
			case WH_DELETE:
			case WH_REOPEN:
			case WH_REMOVE:
			case WH_RESTORE:
				// notify Forum extension
				Hooks::run( 'WallAction', [ $type, $feed->data->parent_id, $feed->data->message_id ] );
				$this->addStatChangeAction( $type, $feed );
			break;
		}
	}

	/**
	 * When deleting a page from NS_USER_WALL_MESSAGE namespace, remove its entries from wall_history
	 *
	 * @param int $pageId
	 */
	public function remove( int $pageId ) {
		$this->getDB( DB_MASTER )->delete(
			'wall_history',
			[
				'parent_comment_id' => ( (int) $pageId )
			],
			__METHOD__
		);
	}

	public function moveThreads( $from, $to ) {
		$this->getDB( DB_MASTER )->update(
			'wall_history',
			[ 'parent_page_id' => $to ],
			[
				'parent_page_id' => $from
			],
			__METHOD__
		);

		$this->getDB( DB_MASTER )->commit();
	}

	public function moveThread( $thread, $to ) {
		$this->getDB( DB_MASTER )->update(
			'wall_history',
			[ 'parent_page_id' => $to ],
			[
				"parent_comment_id = $thread or comment_id = $thread"
			],
			__METHOD__
		);

		$this->getDB( DB_MASTER )->commit();
	}

	/**
	 * @param int $action
	 * @param WallNotificationEntity $feed
	 * @param User $user
	 */
	private function addNewOrEdit( int $action, $feed, User $user ) {

		$data = $feed->data;

		$this->internalAdd(
			(int) $data->parent_page_id,
			(int) $user->getId(),
			$user->getName(),
			$feed->isReply(),
			$data->title_id,
			$data->parent_id,
			$feed->threadTitleFull,
			$action,
			$data->reason,
			$data->rev_id
		);
	}

	/**
	 * @param int $action
	 * @param WallNotificationAdminEntity $feed
	 */
	private function addStatChangeAction( int $action, $feed ) {

		$data = $feed->data;
		$title = Title::newFromID( $data->message_id );

		if ( empty( $title ) ) {
			return;
		}

		$this->internalAdd(
			$data->parent_page_id,
			$data->user_removing_id,
			'',
			$data->is_reply,
			$data->message_id,
			$data->parent_id,
			$data->title,
			$action,
			$data->reason,
			null
		);
	}

	private function internalAdd( $parentPageId, $postUserId, $postUserName, $isReply, $commentId, $parentCommentId, $metatitle, $action, $reason, $revId ) {
		$this->getDB( DB_MASTER )->insert(
			'wall_history',
			[
				'parent_page_id' => $parentPageId,
				'post_user_id' => $postUserId,
				'post_user_ip_bin' => ( intval( $postUserId ) === 0 ? inet_pton( $postUserName ) : null ),
				'is_reply' => $isReply,
				'comment_id' => $commentId,
				'parent_comment_id' => ( $isReply ? $parentCommentId: $commentId ),
				'metatitle' => $metatitle,
				'reason' => empty( $reason ) ? null: $reason,
				'action' => $action,
				'revision_id' => $revId
			],
			__METHOD__
		);
	}

	/**
	 * Data provider for WallHistoryController used to render action=history pages for NS_USER_WALL articles
	 *
	 * @param $parent_page_id
	 * @param $sort
	 * @param int $parent_comment_id
	 * @param bool $show_replay
	 * @return array
	 */
	public function get( $parent_page_id, $sort, $parent_comment_id = 0, $show_replay = true ) {
		$sort = ( $sort === 'nf' ) ? 'desc' : 'asc';
		$where = $this->getWhere( $parent_page_id, $parent_comment_id, $show_replay );

		if ( $where === false ) {
			return [ ];
		}
		return $this->loadFromDB( $where, $this->getLimit(), $this->getOffset(), $sort );
	}

	public function getCount( $parent_page_id = 0, $parent_comment_id = 0, $show_replay  = true ) {
		$where = $this->getWhere( $parent_page_id, $parent_comment_id, $show_replay );

		if ( $where === false ) {
			return false;
		}
		$db =  $this->getDB( DB_SLAVE );
		$row = $db->selectRow(
			'wall_history',
			[
				'count(*) as cnt'
			],
			$where,
			__METHOD__
		);
		return $row->cnt;
	}

	protected function getWhere( $parent_page_id = 0, $parent_comment_id = 0, $show_replay = true ) {
		$query = [ ];

		if ( $parent_comment_id === 0 ) {
			$query[] = 'parent_page_id is null';
		} else {
			$query[] = '(comment_id = ' . $parent_comment_id . ' OR parent_comment_id = ' . $parent_comment_id . ')';
		}

		if ( empty( $parent_page_id ) ) {
			return $query;
		}

		if ( $parent_page_id > 0 ) {
			$query = [
				'parent_page_id' => $parent_page_id
			];
		}

		if ( !$show_replay ) {
			$query['is_reply'] = 0;
		}

		return $query;
	}

	public function setPage( $page, $perPage ) {
		$this->page = (int) $page;
		$this->perPage = (int) $perPage;
	}

	protected function getLimit() {
		return $this->perPage;
	}

	protected function getOffset() {
		return ( $this->page - 1 ) * $this->perPage;
	}

	protected function baseLoadFromDB( $conds, $limit, $offset, $sort ) {
		$db =  $this->getDB( DB_SLAVE );

		$res = $db->select(
			'wall_history',
			[
				'parent_page_id',
				'post_user_id',
				'post_user_ip_bin',
				'is_reply',
				'parent_comment_id',
				'comment_id',
				'action',
				'event_date',
				'metatitle',
				'reason',
				'revision_id'
			],
			$conds,
			__METHOD__,
			[
				'LIMIT' => $limit,
				'OFFSET' => $offset,
				'ORDER BY' => 'event_date ' . $sort,
			]
		);

		return $res;
	}

	protected function loadFromDB( $conds, $limit, $offset, $sort ) {
		$db =  $this->getDB( DB_SLAVE );

		$res = $this->baseLoadFromDB( $conds, $limit, $offset, $sort );

		$out = [ ];
		while ( $row = $db->fetchRow( $res ) ) {
			$data = $this->formatData( $row );
			if ( !empty( $data ) ) {
				$out[] = $data;
			}
		}

		return $out;
	}

	/**
	 * @param array $row
	 * @return array|void
	 */
	protected function formatData( Array $row ) {

		if ( $row['post_user_id'] > 0 ) {
			$user = User::newFromId( $row['post_user_id'] );
		} else {
			$user = User::newFromName( inet_ntop( $row['post_user_ip_bin'] ), false );
		}

		$message = WallMessage::newFromId( $row['comment_id'] );

		if ( empty( $message ) ) {
			return;
		}

		$title = $message->getTitle();

		if ( $title instanceof Title ) {
			return [
				'user' => $user,
				'event_date' => $row['event_date'],
				'event_iso' => wfTimestamp( TS_ISO_8601, $row['event_date'] ),
				'event_mw' => wfTimestamp( TS_MW, $row['event_date'] ),
				'display_username' => $user->isAnon() ? wfMsg( 'oasis-anon-user' ): $user->getName(),
				'metatitle' => $row['metatitle'],
				'page_id' => $row['comment_id'],
				'title' => $title,
				'is_reply' => $row['is_reply'],
				'action' => $row['action'],
				'reason' => $row['reason'],
				'revision_id' => $row['revision_id'],
				'wall_message' => $message
			];
		}
	}
}
