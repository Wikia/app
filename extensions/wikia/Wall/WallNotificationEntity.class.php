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
	
	public static function createFromRC(RecentChange $RC, $wiki) {
		$wn = F::build('WallNotificationEntity', array() );
		$wn->loadDataFromRC($RC, $wiki);
		return $wn;
	}
	
	public static function getByWikiAndRCId($wikiId, $rc_id) {
		
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
	
	public function loadDataFromRC(RecentChange $RC, $wiki) {
		$title = $RC->getTitle();
		
		$ac = F::build('WallMessage', array($RC->getTitle()), 'newFromTitle' );
		$ac->load();

		$walluser = $ac->getWallOwner();
		$authoruser = $ac->getUser();
		
		$this->data->wiki = $wiki;
		$this->data->rc_id = $RC->getAttribute('rc_id');
		$this->data->timestamp = $RC->getAttribute('rc_timestamp');		
		
		$msg_author_realname = $authoruser->getRealName(); 
		$this->data->msg_author_id = $authoruser->getId();		
		$this->data->msg_author_username = $authoruser->getName();		

		$this->data->msg_author_displayname = empty($msg_author_realname) ?  $this->data->msg_author_username:$msg_author_realname;		
		
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
		
		if(!empty($acParent)) {
			$acParent->load();
			$this->data->parent_username = $acParent->getUser()->getName();
			$parent_realname = $acParent->getUser()->getRealName();
									
			$this->data->parent_displayname = empty($parent_realname) ? $this->data->parent_username:$parent_realname; 
			
			$this->data->parent_user_id = $acParent->getUser()->getId();
			$this->data->thread_title = $this->helper->shortenText($acParent->getMetaTitle(), self::TITLE_MAX_LEN);
			$this->data_noncached->parent_title_dbkey = $acParent->getTitle()->getDBkey();
			$this->data->parent_id = $acParent->getTitle()->getArticleId();
			//$this->data->url = $acParent->getMessagePageUrl();
			$this->data->url = $acParent->getMessagePageUrl();
		} else {
			$this->data->url = $ac->getMessagePageUrl();
			$this->data->parent_username = $walluser->getName();
			$this->data->thread_title = $this->helper->shortenText($ac->getMetaTitle(), self::TITLE_MAX_LEN);
		}
		
		$this->id = $RC->getAttribute('rc_id') . '_' .  $this->data->wiki;
	}
	
	protected function buildId($wikiId, $RCid ) {
		
	}

	function recreateFromDB() {
		$explodedId = explode('_', $this->id);
		$RCId = $explodedId[0];
		$wikiId = $explodedId[1];

		$RC = RecentChange::newFromId($RCId);
		if(empty($RC)) {
			return;
		}
		
		$this->loadDataFromRC($RC, $wikiId);
		$this->save();
	} 
	
	public function save() {
		$cache = $this->getCache();
		$key = $this->getMemcKey();
		
		$cache->set($key, $this->data);
	}

	/*
	 * Helper functions
	 */
	public function getMemcKey() {
		return F::App()->runFunction( 'wfSharedMemcKey', __CLASS__, "v18", $this->id, 'notification' );
	}

	public function getCache() {
		return F::App()->getGlobal('wgMemc');
	}
}

?>
