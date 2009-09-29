<?php

class MagCloudCollection {

	static private $instance = null;
	private $sessionKey = null;

	private function __construct() {
		global $wgCityId;

		$this->sessionKey = 'wsMagCloudCollection' . $wgCityId;
	}

	private function __clone() { }

	static public function getInstance() {
		if(self::$instance == null) {
			self::$instance = new MagCloudCollection;
		}
		return self::$instance;
	}

	public function hasSession() {
		return isset( $_SESSION[$this->sessionKey] ) && isset( $_SESSION[$this->sessionKey]['articles'] ) && is_array($_SESSION[$this->sessionKey]['articles']);
	}

	public function initSession() {
		wfLoadExtensionMessages('MagCloud');

		$_SESSION[$this->sessionKey] = array(
			'toolbar' => false,
			'articles' => array(),
			'coverData' => $this->getDefaultCoverData(),
			'timestamp' => wfTimestampNow(),
			'hash' => md5(microtime(true))
		);
	}

	private function getDefaultCoverData() {
		global $wgSitename;
		$coverData = array(
			'layout' => 1,
			'theme' => 'beach',
			'title' => wfMsg('magcloud-design-default-title', $wgSitename),
			'subtitle' => wfMsg('magcloud-design-default-subtitle'),
			'image' => ''
		);
		return $coverData;
	}

	/**
	 * low level session data storing
	 * @param stirng $key data key
	 * @param mixed $value value
	 */
	private function storeSessionData($key, $value) {
		Wikia::log(__CLASS__, 'info', "storeSession($key), VALUE: " . print_r($value, true));
		if(!$this->hasSession()) {
			Wikia::log(__CLASS__, 'info', "INIT session");
			$this->initSession();
		}
		$_SESSION[$this->sessionKey][$key] = $value;
		$_SESSION[$this->sessionKey]['timestamp'] = time();
	}

	/**
	 * low level session data reading
	 * @param stirng $key data key
	 */
	private function readSessionData($key) {
		Wikia::log(__CLASS__, 'info', "readSession($key) START");
		if(!$this->hasSession()) {
			Wikia::log(__CLASS__, 'info', "INIT session");
			$this->initSession();
		}
		Wikia::log(__CLASS__, 'info', "readSession($key), VALUE: " . print_r($_SESSION[$this->sessionKey][$key], true));
		return isset($_SESSION[$this->sessionKey][$key]) ? $_SESSION[$this->sessionKey][$key] : null;
	}

	/**
	 * set toolbar state (visible/hidden)
	 * @param bool $state toolbar state
	 */
	public function setToolbarVisibleState($state) {
		$this->storeSessionData('toolbar', $state);
	}

	/**
	 * get toolbar state (visible/hidden)
	 * @return bool $state toolbar state
	 */
	public function getToolbarVisibleState() {
		$state = $this->readSessionData('toolbar');

		return !empty($state);
	}


	public function countArticles() {
		if(!$this->hasSession()) {
			return 0;
		}

		return count($this->readSessionData('articles'));
	}

	public function getHash() {
		return $this->readSessionData('hash');
	}

	public function getTimestamp() {
		return $this->readSessionData('timestamp');
	}

	/**
	 * add article into collection
	 * @param Title $title article's title
	 * @return bool result
	 */
	public function addArticle(Title $title, $oldId = 0) {
		$article = new Article( $title, $oldId );
		$latest = $article->getLatest();

		$currentVersion = 0;
		if($oldId == 0) {
			$currentVersion = 1;
			$oldId = $latest;
		}

		$index = $this->findArticle( $title->getPrefixedText(), $oldId );
		if( $index != -1 ) {
			return false;
		}

		$articles = $this->readSessionData('articles');

		$revision = Revision::newFromTitle( $title, $oldId );
		$articles[] = array(
			'type' => 'article',
			'content-type' => 'text/x-wiki',
			'title' => $title->getPrefixedText(),
			'revision' => strval( $oldId ),
			'latest' => strval( $latest ),
			'timestamp' => wfTimestamp( TS_UNIX, $revision->mTimestamp ),
			'url' => $title->getFullURL(),
			'currentVersion' => $currentVersion,
		);

		$this->storeSessionData('articles', $articles);
		return true;
	}

	public function findArticle($titleText, $oldId = 0) {
		if(!$this->hasSession()) {
			return -1;
		}

		foreach($this->readSessionData('articles') as $index => $item) {
			if(($item['type'] == 'article') && ($item['title'] == $titleText)) {
				if($oldId) {
					if($item['revision'] == strval($oldId)) {
						return $index;
					}
				} else {
					if($item['revision'] == $item['latest']) {
						return $index;
					}
				}
			}
		}

		return -1;
	}

	public function getArticles() {
		return $this->readSessionData('articles');
	}

	public function getCoverData() {
		return $this->readSessionData('coverData');
	}

	public function getTitle() {
		$coverData = $this->getCoverData();
		return $coverData['title'];
	}

	public function saveCoverData(Array $data) {
		$this->storeSessionData('coverData', $data);
	}

	/**
	 * remove cover data from colelction
	 */
	public function removeCoverData() {
		$this->storeSessionData('coverData', $this->getDefaultCoverData());
	}

	/**
	 * remove all articles from collection
	 */
	public function removeArticles() {
		$this->storeSessionData('articles', array());
	}

	public function removeArticle($index = 0) {
		if(!$this->hasSession() || (($this->countArticles() - 1) < $index) || ($index < 0)) {
			return false;
		}

		$articles = $this->readSessionData('articles');
		$removedArticle = array_splice( $articles, $index, 1 );

		$this->storeSessionData('articles', $articles);
		return $removedArticle[0];
	}

	public function reorderArticle($oldIndex, $newIndex) {
		if(!$this->hasSession()) {
			return false;
		}

		$maxIndex = $this->countArticles() - 1;
		if(($maxIndex < $oldIndex) || ($maxIndex < $newIndex)  || ($oldIndex < 0) || ($newIndex < 0)) {
			return false;
		}

		$article = $this->removeArticle($oldIndex);
		$articles = $this->readSessionData('articles');
		$start = array_slice($articles, 0, $newIndex);
		$end = array_slice($articles, $newIndex);
		$start[] = $article;
		$articles = array_merge($start, $end);
		$this->storeSessionData('articles', $articles);

		return $articles;
	}

	/**
	 * save collection into db
	 */
	public function save() {
		global $wgExternalDatawareDB, $wgUser, $wgCityId;
		$dbw = wfGetDB(DB_MASTER, array(), $wgExternalDatawareDB);
		$row = array(
			'mco_hash' => $this->getHash(),
			'mco_user_id' => $wgUser->getId(),
			'mco_wiki_id' => $wgCityId,
			'mco_updated' => date('Y-m-d H:i:s'),
			'mco_articles' => serialize($this->getArticles()),
			'mco_cover' => serialize($this->getCoverData())
		);

		$dbw->delete( 'magcloud_collection', array( "mco_user_id='0'", "mco_updated<=DATE_SUB(NOW(), INTERVAL 1 DAY)" ));
		$dbw->replace( 'magcloud_collection', array( 'mco_hash' ), $row, __METHOD__ );
	}

	/**
	 * restore collection from db
	 */
	public function restore($hash) {
		global $wgExternalDatawareDB;

		if(!empty($hash)) {
			$dbw = wfGetDB(DB_MASTER, array(), $wgExternalDatawareDB);
			$row = $dbw->selectRow( 'magcloud_collection', array( 'mco_articles', 'mco_cover' ), array( 'mco_hash' => $hash), __METHOD__ );

			if(is_object($row)) {
				$this->storeSessionData('articles', unserialize($row->mco_articles));
				$this->storeSessionData('coverData', unserialize($row->mco_cover));
				$this->storeSessionData('hash', $hash);
			}
		}
	}

	/**
	 * get list of collection for given user (per wiki)
	 * @param int $userId user id
	 */
	public function getMagazinesByUserId($userId) {
		global $wgExternalDatawareDB, $wgCityId;
		$magazines = array();

		if(!empty($userId)) {
			$dbs = wfGetDB(DB_SLAVE, array(), $wgExternalDatawareDB);
			$res = $dbs->select( 'magcloud_collection', array( 'mco_hash', 'mco_cover'), array( 'mco_user_id' => $userId, 'mco_wiki_id' => $wgCityId ), __METHOD__ );

			while($row = $dbs->fetchObject($res)) {
				$coverData = unserialize($row->mco_cover);
				$magazines[] = array( 'title' => $coverData['title'], 'subtitle' => $coverData['subtitle'], 'hash' => $row->mco_hash );
			}
		}

		return $magazines;
	}
}
