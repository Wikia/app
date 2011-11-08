<?php

class WallNotificationEntity {
	const TITLE_MAX_LEN = 24;
	
	public $id;
	public $data; // data stored in memcache
	public $data_noncached; // this data is here only after you create this object
	                        // when recreating object from memcache this will be empty
	                        
	/*
		$data->timestamp;
		$data->wiki;            // on which wiki 
		$data->wall_username;   // on who's wall we are posting? 
		$data->wall_realname;    
		$data->parent_title_dbkey;
		$data->parent_username; // if this is a reply, who wrote original message we answer to? 
		$data->parent_realname;  
		$data->parent_title;    // title of whole conversation (this msg, or parent title if this is reply)
		$data->msg_author_username;      // who wrote message we send notification for 
		$data->msg_author_realname; 
	*/
	
	public function __construct() {
		$this->helper = F::build('WallHelper', array());
	}
			
	/*
	 *	Public Interface
	 */
	
	public static function createFromRev(Revision $rev, $wiki) {
		$wn = F::build('WallNotificationEntity', array() );
		if($wn->loadDataFromRev($rev, $wiki)) {
			$wn->save();
			return $wn;
		}
	}
	
	public static function getByWikiAndRevId($RevId, $wikiId) {
		return F::build('WallNotificationEntity', array($RevId.'_'.$wikiId), 'getById');
	}
	
	public static function getById($id) {
		$wn = F::build('WallNotificationEntity', array() );

		$wn->id = $id;
		$wn->data = $wn->getCache()->get($wn->getMemcKey());
		if(empty($wn->data)) {
			$wn->recreateFromDB();
		}

		if(empty($wn->data)) {
			return null;
		}
		
		return $wn;
	}
	
	public function isMain() {
		return empty($this->data->parent_id);
	}
	
	public function getUniqueId() {
		if($this->isMain()) {
			return $this->data->title_id;
		} else {
			return $this->data->parent_id;
		}
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function loadDataFromRev(Revision $rev, $wiki) {
		$this->id = $rev->getId(). '_' .  $wiki;
		
		$title = $rev->getTitle();
		
		$ac = F::build('WallMessage', array($rev->getTitle()), 'newFromTitle' );
		$ac->load();
		
		$app = F::app();
		
		$walluser = $ac->getWallOwner();
		$authoruser = $ac->getUser();
		
		if(empty($walluser)) {
			error_log('WALL_NO_OWNER: (entityId)'.$this->id);
			$this->data = null;
			$this->data_noncached = null;
			return;
		}
		
		$this->data->wiki = $wiki;
		$this->data->rev_id = $rev->getId();
		$this->data->timestamp = $rev->getTimestamp();
		
		if( $authoruser instanceof User ) {
			$msg_author_realname = $authoruser->getRealName();
			$this->data->msg_author_id = $authoruser->getId();
			$this->data->msg_author_username = $authoruser->getName();
			$this->data->msg_author_displayname = empty($msg_author_realname) ?  $this->data->msg_author_username:$msg_author_realname;
		} else {
		//annon
			$this->data->msg_author_displayname = $app->wf->Msg('oasis-anon-user');
			$this->data->msg_author_id = 0;
		}
		
		$this->data->wall_username = $walluser->getName();
		$wall_realname = $walluser->getRealName();
		$this->data->wall_userid = $walluser->getId();
		
		$this->data->wall_displayname = empty($wall_realname) ? $this->data->wall_username:$wall_realname;
		
		$this->data->title_id = $ac->getTitle()->getArticleId();
		
		$this->data_non_cached->title = $ac->getTitle();

		$acParent = $ac->getTopParentObj();
		$this->data->parent_username = '';
		$this->data->thread_title = '';
		$this->data_non_cached->parent_title_dbkey = '';
		
		if( !empty($acParent) ) {
			$acParent->load();
			$parentUser = $acParent->getUser();
			
			if( $parentUser instanceof User ) {
				$this->data->parent_username = $parentUser->getName();
				$parent_realname = $parentUser->getRealName();
				$this->data->parent_displayname = empty($parent_realname) ? $this->data->parent_username : $parent_realname; 
				$this->data->parent_user_id = $acParent->getUser()->getId();
			} else {
			//parent was deleted and somehow reply stays in the system
			//the only way I've reproduced it was: I deleted a thread
			//then I went to Special:Log/delete and restored only its reply
			//an edge case but it needs to be handled
			//--nAndy
				$this->data->parent_username = $this->data->parent_displayname = $app->wf->Msg('oasis-anon-user');
				$this->data->parent_user_id = 0;
			}
			
			$this->data->thread_title = $this->helper->shortenText($acParent->getMetaTitle(), self::TITLE_MAX_LEN);
			$this->data_noncached->parent_title_dbkey = $acParent->getTitle()->getDBkey();
			$this->data->parent_id = $acParent->getTitle()->getArticleId();
			$this->data->url = $acParent->getMessagePageUrl();
		} else {
			$this->data->url = $ac->getMessagePageUrl();
			$this->data->parent_username = $walluser->getName();
			$this->data->thread_title = $this->helper->shortenText($ac->getMetaTitle(), self::TITLE_MAX_LEN);
		}
		
		return true;
	}
	
	protected function buildId($wikiId, $RCid ) {
		
	}

	function recreateFromDB() {
		$explodedId = explode('_', $this->id);
		$RevId = $explodedId[0];
		$wikiId = $explodedId[1];

		$rev = Revision::newFromId($RevId);
		if(empty($rev)) {
			// also cache failures not to make expensive database queries
			// again and again for the same Entity
			$this->save();
			return;
		}
		
		$this->loadDataFromRev($rev, $wikiId);
		$this->save();
	} 
	
	public function save() {
		$cache = $this->getCache();
		$key = $this->getMemcKey();
		
		//$cache->delete($key);
		$cache->set($key, $this->data);
	}

	/*
	 * Helper functions
	 */
	public function getMemcKey() {
		return F::App()->runFunction( 'wfSharedMemcKey', __CLASS__, "v22", $this->id, 'notification' );
	}

	public function getCache() {
		return F::App()->getGlobal('wgMemc');
	}
}

?>
