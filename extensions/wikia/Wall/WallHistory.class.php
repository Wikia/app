<?php

class WallHistory extends WikiaModel {

	/**
	 * Number of activity items for getLastPosts() method.
	 */
	const DEFAULT_LAST_POSTS_COUNT = 5;

	var $wikiId;
	var $page = 1;
	var $perPage = 100;

	public function __construct() {
		parent::__construct();
	}

	public function getDB($db = DB_MASTER) {
		return wfGetDB($db);
	}

	public function add( $type, $feed, $user ) {

		switch($type) {
			case WH_EDIT:
			case WH_NEW:
				//wall the wall action goes through this point.
				wfRunHooks('WallAction', array($type, $feed->data->parent_id, $feed->data->title_id));
				$this->addNewOrEdit( $type, $feed, $user );
			break;
			case WH_ARCHIVE:
			case WH_DELETE:
			case WH_REOPEN:
			case WH_REMOVE:
			case WH_RESTORE:
				//wall the wall action goes through this point.
				wfRunHooks('WallAction', array($type, $feed->data->parent_id, $feed->data->message_id));
				$this->addStatChangeAction( $type, $feed, $user );
			break;
		}

		WikiaDataAccess::cachePurge( $this->getLastPostsMemcKey() );
	}

	public function remove($pageId) {
		$this->getDB(DB_MASTER)->delete(
			'wall_history',
			array(
				'parent_comment_id' => ((int) $pageId)
			)
		);
	}

	public function moveThreads( $from, $to ) {
		$this->getDB(DB_MASTER)->update(
			'wall_history',
			array( 'parent_page_id' => $to ),
			array(
				'parent_page_id' => $from
			),
			__METHOD__
		);

		$this->getDB(DB_MASTER)->commit();
	}

	public function moveThread( $thread, $to ) {
		$this->getDB(DB_MASTER)->update(
			'wall_history',
			array( 'parent_page_id' => $to ),
			array(
				"parent_comment_id = $thread or comment_id = $thread"
			),
			__METHOD__
		);

		$this->getDB(DB_MASTER)->commit();
	}

	private function addNewOrEdit($action, $feed, $user) {
		if(!($feed instanceof WallNotificationEntity)) {
			return false;
		}

		$this->internalAdd(
			(int) $feed->data->parent_page_id,
			(int) $user->getID(),
			$user->getName(),
			!$feed->isMain(),
			$feed->data->title_id,
			$feed->data->article_title_ns,
			$feed->data->parent_id,
			$feed->data_noncached->thread_title_full,
			$action,
			$feed->data->reason,
			$feed->data->rev_id
		);
		return true;
	}

	private function addStatChangeAction($action, $feed, $user) {
		if(!($feed instanceof WallNotificationAdminEntity)) {
			return false;
		}

		$title = Title::newFromId($feed->data->message_id);

		if(empty($title)) {
			return false;
		}

		$this->internalAdd(
			$feed->data->parent_page_id,
			$feed->data->user_removing_id,
			'',
			$feed->data->is_reply,
			$feed->data->message_id,
			$title->getNamespace(),
			$feed->data->parent_id,
			$feed->data->title,
			$action,
			$feed->data->reason,
			null
		);


		$this->getDB(DB_MASTER)->update(
			'wall_history',
			array( 'deleted_or_removed' => ($action == WH_DELETE || $action == WH_REMOVE) ? 1:0),
			array(
				'comment_id' => $feed->data->message_id
			),
			__METHOD__
		);

		return true;
	}
	//make it public for migration script

	public function internalAdd( $parentPageId, $postUserId, $postUserName, $isReply, $commentId, $ns, $parentCommentId, $metatitle, $action, $reason, $revId) {
		$this->getDB(DB_MASTER)->insert(
			'wall_history',
			array(
				'parent_page_id' => $parentPageId,
				'post_user_id' => $postUserId,
				'post_ns' => MWNamespace::getSubject( $ns ),
				'post_user_ip' => ( intval($postUserId) === 0 ? $this->ip2long($postUserName) : null),
				'is_reply' => $isReply,
				'comment_id' => $commentId,
				'parent_comment_id' => ( $isReply ? $parentCommentId:$commentId),
				'metatitle' => $metatitle,
				'reason' => empty($reason) ? null:$reason,
				'action' => $action,
				'revision_id' => $revId
			)
		);
	}

	/**
	 * Gets data for Forum Activity Module with a cache layer.
	 *
	 * @param int $ns    The namespace (this should theoretically work for Forum and Wall)
	 * @param int $count The number of activities to get
	 *
	 * @return array Formatted data that gets passed to the view
	 */
	public function  getLastPosts( $ns, $count = self::DEFAULT_LAST_POSTS_COUNT ) {
		wfProfileIn( __METHOD__ );

		$key = $this->getLastPostsMemcKey();
		$cacheTime = 86400; // Cache for a day unless explicitly purged by `WallHistory::add()`.

		$data = WikiaDataAccess::cache( $key, $cacheTime, function () use ( $ns, $count ) {
			return $this->getLastPostsFromDB( $ns, $count );
		} );

		wfProfileOut( __METHOD__ );

		return $data;
	}

	/**
	 * Get a wiki-specific memcache key to use in the `getLastPosts()` method.
	 *
	 * @return string
	 */
	public function getLastPostsMemcKey() {
		return wfMemcKey( 'WallHistory::getLastPosts' );
	}

	/**
	 * Gets data for Forum Activity Module directly from the DB.
	 *
	 * @param int $ns    The namespace (this should theoretically work for Forum and Wall)
	 * @param int $count The number of activities to get
	 *
	 * @return array Formatted data that gets passed to the view
	 */
	public function  getLastPostsFromDB( $ns, $count = self::DEFAULT_LAST_POSTS_COUNT ) {
		wfProfileIn( __METHOD__ );

		$ns    = (int)MWNamespace::getSubject( $ns );
		$count = (int)$count;
		$db    = $this->getDB( DB_SLAVE );
		$out   = array();

		$result = $db->query(
			'SELECT
				`parent_page_id`,
				`post_user_id`,
				`post_user_ip`,
				`is_reply`,
				`parent_comment_id`,
				`comment_id`,
				`action`,
				`event_date`,
				(
					SELECT `metatitle`
					FROM `wall_history` AS `last_title`
					WHERE
						`parent_comment_id` = `wall_history`.`parent_comment_id`
						AND (`event_date`, `revision_id`) = (
							SELECT MAX(`event_date`), MAX(`revision_id`)
							FROM `wall_history`
							WHERE
								`action` IN (' . WH_EDIT . ', ' . WH_NEW . ')
								AND `parent_comment_id` = `last_title`.`parent_comment_id`
						)
					LIMIT 1
				) AS `metatitle`,
				`reason`,
				`revision_id`
			FROM `wall_history`
			RIGHT JOIN
				(
					SELECT
						`parent_comment_id`,
						MAX(`event_date`) AS `event_date`,
						MAX(`revision_id`) AS `revision_id`
					FROM `wall_history`
					RIGHT JOIN
						(
							SELECT `parent_comment_id`
							FROM `wall_history`
							WHERE
								`action` = ' . WH_NEW . '
								AND `deleted_or_removed` = 0
								AND `post_ns` = ' . $ns . '
								AND `is_reply` = 0
						) AS `not_removed_parents`
						USING (`parent_comment_id`)
					WHERE
						`action` = ' . WH_NEW . '
						AND `deleted_or_removed` = 0
						AND `post_ns` = ' . $ns . '
					GROUP BY `parent_comment_id`
					ORDER BY `event_date` DESC
					LIMIT ' . $count . '
				) AS `last_new_post_date`
				USING (`parent_comment_id`, `event_date`, `revision_id`)',
			__METHOD__
		);

		while ( $row = $db->fetchRow( $result ) ) {
			$data = $this->formatData( $row );
			// This empty check shouldn't be necessary, but I'll leave it here just in case.
			if ( !empty( $data ) ) {
				$out[] = $data;
			}
		}

		wfProfileOut( __METHOD__ );

		return $out;
	}

	public function get($parent_page_id, $sort, $parent_comment_id = 0, $show_replay = true) {
		$sort = ($sort === 'nf') ? 'desc' : 'asc';
		$where = $this->getWhere($parent_page_id, $parent_comment_id, $show_replay);

		if($where === false) {
			return array();
		}
		return $this->loadFromDB($where, $this->getLimit(), $this->getOffset(), $sort);
	}

	public function getCount($parent_page_id = 0, $parent_comment_id = 0, $show_replay  = true) {
		$where = $this->getWhere($parent_page_id, $parent_comment_id, $show_replay);

		if($where === false) {
			return false;
		}
		$db =  $this->getDB(DB_SLAVE);
		$row = $db->selectRow(
			'wall_history',
			array(
				'count(*) as cnt'
			),
			$where,
			__METHOD__
		);
		return $row->cnt;
	}

	protected function getWhere($parent_page_id = 0, $parent_comment_id = 0, $show_replay = true) {
		$query = array();

		if( $parent_comment_id === 0 ) {
			$query[] = 'parent_page_id is null';
		} else {
			$query[] = '(comment_id = '.$parent_comment_id.' OR parent_comment_id = '.$parent_comment_id.')';
		}

		if(empty($parent_page_id)) {
			return $query;
		}

		if($parent_page_id > 0 ) {
			$query = array(
				'parent_page_id' => $parent_page_id
			);
		}

		if(!$show_replay) {
			$query['is_reply'] = 0;
		}

		return $query;
	}

	public function setPage($page, $perPage) {
		$this->page = (int) $page;
		$this->perPage = (int) $perPage;
	}

	protected function getLimit() {
		return $this->perPage;
	}

	protected function getOffset() {
		return ($this->page - 1) * $this->perPage;
	}

	protected function baseLoadFromDB($con, $limit, $offset, $sort) {
		$db =  $this->getDB(DB_SLAVE);

		$res = $db->select(
			'wall_history',
			array(
				'parent_page_id',
				'post_user_id',
				'post_user_ip',
				'is_reply',
				'parent_comment_id',
				'comment_id',
				'action',
				'event_date',
				'metatitle',
				'reason',
				'revision_id'
			),
			$con,
			__METHOD__,
			array(
				'LIMIT' => $limit,
				'OFFSET' => $offset,
				'ORDER BY' => 'event_date '.$sort,
			)
		);

		return $res;
	}

	protected function loadFromDB($con, $limit, $offset, $sort) {
		$db =  $this->getDB(DB_SLAVE);

		$res = $this->baseLoadFromDB($con, $limit, $offset, $sort);

		$out = array();
		while($row = $db->fetchRow($res)) {
			$data = $this->formatData($row);
			if(!empty($data)){
				$out[] = $data;
			}
		}

		return $out;
	}

	protected function formatData($row) {
		$user = null;
		if($row['post_user_id'] > 0) {
			$user = User::newFromID($row['post_user_id']);
		} else {
			$user = User::newFromName($this->long2ip($row['post_user_ip']), false);
		}

		$message = WallMessage::newFromId($row['comment_id']);

		if(empty($message)) {
			return;
		}

		$title = $message->getTitle();

		if( ($title instanceof Title) && ($message instanceof WallMessage) ) {
			return array(
				'user' => $user,
				'event_date' => $row['event_date'],
				'event_iso' => wfTimestamp(TS_ISO_8601, $row['event_date']),
				'event_mw' => wfTimestamp(TS_MW, $row['event_date']),
				'display_username' => $user->getId() == 0 ? wfMsg('oasis-anon-user'):$user->getName(),
				'metatitle' => $row['metatitle'],
				'page_id' => $row['comment_id'],
				'title' => $title,
				'is_reply' => $row['is_reply'],
				'action' => $row['action'],
				'reason' => $row['reason'],
				'revision_id' => $row['revision_id'],
				'wall_message' => $message
			);
		} else {
		//it happened once on devbox when master&slave weren't sync'ed
			wfDebug( __METHOD__ . ": Seems like master&slave are not sync'ed\n" );
		}
	}

	protected function ip2long($userName) {
		return User::isIP($userName) ? ip2long($userName):null;
	}

	protected function long2ip($IP) {
		return long2ip($IP);
	}
}
