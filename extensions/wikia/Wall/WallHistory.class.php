<?php

class WallHistory extends WikiaModel {
	var $wikiId;
	var $page = 1;
	var $perPage = 100;
	
	public function __construct($wikiId) {
		$this->wikiId = $wikiId;
		parent::__construct();
	}
	
	public function add( $type, $feed, $user ) {
		switch($type) {
			case WH_EDIT: 
			case WH_NEW:
				$this->addNewOrEdit( $type, $feed, $user );
			break;
			case WH_ARCHIVE:
			case WH_DELETE:
			case WH_REOPEN:
			case WH_REMOVE:
			case WH_RESTORE:
				$this->addStatChangeAction( $type, $feed, $user );
			break;	
		}
	}
	
	public function remove($postUserId) {
		$this->getDatawareDB(DB_MASTER)->delete(
			'wall_history', 
			array(
				'wiki_id' => $this->wikiId,
				'page_id ='.((int) $postUserId).' OR parent_page_id = '.((int) $postUserId)
			)
		);
	}
	
	public function moveThread( $from, $to ) {
		$db = wfGetDB( DB_MASTER );

		$db->update(
			'comments_index',
			array( 'parent_page_id' => $to ),
			array( 
				'parent_page_id' => $from 
			),
			__METHOD__
		);
		
		$db->commit();
	}
	
	private function addNewOrEdit($action, $feed, $user) {
		if(!($feed instanceof WallNotificationEntity)) {
			return false;	
		}
		
		$this->internalAdd(
			(int) $feed->data->wall_userid,
			$feed->data->wall_username, 
			(int) $user->getID(),
			$user->getName(),
			!$feed->isMain(),
			$feed->data->title_id,
			$feed->data->article_title_ns,
			$feed->data->parent_id,
			$feed->data_non_cached->thread_title_full,
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
			$feed->data->user_wallowner_id, 
			'', //it is always loged in user 
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
			
		return true;
	}
	
	private function internalAdd( $wallUserId, $wallUserName, $postUserId, $postUserName, $isReply, $pageId, $ns, $parentPageId, $metatitle, $action, $reason, $revId ) {
		$this->getDatawareDB(DB_MASTER)->insert(
			'wall_history', 
			array(
				'wiki_id' => $this->wikiId, 
				'wall_user_ip' => ( intval($wallUserId) === 0 ? $this->ip2long($wallUserName) : null),
				'wall_user_id' => $wallUserId,
				'post_user_id' => $postUserId,
				'post_ns' => $ns,
				'post_user_ip' => ( intval($postUserId) === 0 ? $this->ip2long($postUserName) : null),
				'is_reply' => $isReply,
				'page_id' => $pageId,
				'parent_page_id' => ( intval($parentPageId) === 0 ? null : $parentPageId),
				'metatitle' => $metatitle,
				'reason' => empty($reason) ? null:$reason,
				'action' => $action,
				'revision_id' => $revId
			)
		);

		$this->getDatawareDB(DB_MASTER)->set(
			'wall_history',
			'deleted_or_removed',
			(($action == WH_DELETE || $action == WH_REMOVE) ? 1:0),
			$this->getDatawareDB(DB_MASTER)->makeList( array(
				'wiki_id' => $this->wikiId,
				'page_id' => $pageId 
			), LIST_AND ),
			__METHOD__
		);
	}
	
	public function  getLastPosts($ns, $count = 5) {
		$where = array(
			'action' => WH_NEW,
			'post_ns' => $ns,
			'wiki_id' => $this->wikiId, 
			'deleted_or_removed' => 0
		);
		
		$out = array();
		$group = array();
		
		$db =  $this->getDatawareDB(DB_SLAVE);
		
		for($try = 0; ($try < 5 && count($out) < $count ); $try++  ) {
			$res = $this->baseLoadFromDB($where, 100, $try*100, 'desc');
			while($row = $db->fetchRow($res)) {
				$key = empty($row['parent_page_id']) ? $row['page_id']:$row['parent_page_id'];
				if(empty($group[$key])) {
					$data = $this->formatData($row);
					if(!empty($data)){
						$out[] = $data;
						$group[$key] = true;					
					}
				}
				
				if($count == count($out)) {
					break;
				}
			}
		}
		return $out;
	}
	
	public function getLastUsers($ns, $count = 10) {
		$db =  $this->getDatawareDB(DB_SLAVE);
		
		$res = $db->select(
			'wall_history',
			array(
				'post_user_id',
				'max(revision_id) as revision_id',

			), 
			array(
				'wiki_id' => $this->wikiId, 
				'action' => WH_NEW,
				'post_ns' => $ns,
				'deleted_or_removed' => 0
			),
			__METHOD__,
			array(
				'GROUP BY' => ' post_user_id,post_user_ip',		
				'LIMIT' => 50,
				'ORDER BY' => 'event_date desc'
			)
		);
		
		$in = array();
				
		while ($row = $db->fetchRow($res)) {
			$rev = Revision::newFromId( (int) $row['revision_id'] );
			if(!empty($rev)) {
				$in[] = $row['revision_id'];
			}
		}
		
		if(empty($in)) {
			return array(); 
		}
		
		$where = array(
			'revision_id' => $in,
			'action' => WH_NEW,
			'post_ns' => $ns,
			'wiki_id' => $this->wikiId, 
			'deleted_or_removed' => 0
		);
		
		return $this->loadFromDB($where, $count, 0, 'desc');
	}
	
	public function get($user, $sort, $parent_page_id = 0) {
		$sort = ($sort === 'nf') ? 'desc' : 'asc';
		$where = $this->getWhere($user, $parent_page_id);
		if($where === false) {
			return array();
		}
		return $this->loadFromDB($where, $this->getLimit(), $this->getOffset(), $sort);
	}
	
	public function getCount($user, $parent_page_id = 0) {
		$where = $this->getWhere($user, $parent_page_id);
		if($where === false) {
			return false;
		}
		$db =  $this->getDatawareDB(DB_SLAVE);
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
	
	protected function getWhere($user, $parent_page_id = 0) {
		$query = array( 
			'wiki_id' => $this->wikiId 
		);
		if( $parent_page_id === 0 ) {
			$query[] = 'parent_page_id is null';
		} else {
			$query[] = '(page_id = '.$parent_page_id.' OR parent_page_id = '.$parent_page_id.')';
		}

		if(empty($user)) {
			return $query;
		}
		
		if($user->getId() > 0 ) {
			$query = array(
				'wiki_id' => $this->wikiId,
				'wall_user_id' => $user->getID()
			);
		} elseif ( $this->ip2long($user->getName()) !== false ) {
			$query = array(
				'wiki_id' => $this->wikiId,
				'wall_user_ip' => $this->ip2long($user->getName())
			);
		} else {
			return false;
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
		$db =  $this->getDatawareDB(DB_SLAVE);
		
		$res = $db->select(
			'wall_history',
			array(
				'parent_page_id',
				'post_user_id',
				'post_user_ip',
				'is_reply',
				'page_id',
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
		$db =  $this->getDatawareDB(DB_SLAVE);

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

		$message = WallMessage::newFromId($row['page_id']);

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
				'page_id' => $row['page_id'],
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

