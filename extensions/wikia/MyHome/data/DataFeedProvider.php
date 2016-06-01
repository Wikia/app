<?php

class DataFeedProvider {

	const ACTIVITY_FEED = 0; // Activity Feed
	const WATCHLIST_FEED = 1; // Watchlist

	const IMAGE_THUMB_WIDTH = 150;
	const VIDEO_THUMB_WIDTH = 150;

	const ONE_PER_TITLE = 1;

	const HIDDEN_CATEGORIES_LIMIT = 500;

	private static $hiddenCategories = null;

	private static $userLinksCache = array();
	private static $imageClassesCache = array();

	private $proxy;
	private $proxyType;
	private $results = array();
	private $invisibleRevisions = array();
	private $onePerTitle = false;
	private $parameters = array();

	public function __construct($proxy, $removeDuplicatesType = 0, $parameters = array()) {
		$this->proxy = $proxy;

		if ($this->proxy instanceof ActivityFeedAPIProxy) {
			$this->proxyType = self::ACTIVITY_FEED;
		} else {
			$this->proxyType = self::WATCHLIST_FEED;
		}

		$this->onePerTitle = $removeDuplicatesType == self::ONE_PER_TITLE;
		$this->parameters = $parameters;
	}

	public function get($limit, $start = null) {
		wfProfileIn(__METHOD__);

		$queryPosition = $start;
		$proxyLimit = $limit;

		$maxIterations = 5;
		while((count($this->results) < $limit + 1) && $maxIterations--) {
			$callLimit = max(10, round(($proxyLimit - count($this->results)) * 1.5));
			$res = $this->proxy->get($callLimit, $queryPosition);
			if (isset($res['results'])) {
				$this->processMany( $res['results'] );
			}

			if (isset($res['query-continue'])) {
				$queryPosition = $res['query-continue'];
			} else {
				break;
			}
		}

		$out = [];

		$keys = array_keys($this->results);
		if (isset($keys[$limit])) {
			$out['query-continue'] = $this->results[$keys[$limit]]['timestamp'];
		}
		$out['results'] = array_slice($this->results, 0, $limit);

		wfProfileOut(__METHOD__);
		return $out;
	}

	private function processMany($results) {
		foreach($results as $item) {
			$itemResult = new DataFeedProviderItemResult();
			$this->filterOne($itemResult, $item);

			if ($itemResult->getInvisibleRevisionId()) {
				$this->invisibleRevisions[$itemResult->getInvisibleRevisionId()] = true;
				continue;
			}
			if (isset($this->invisibleRevisions[$itemResult->getInvisibleRevisionId()])) {
				continue;
			}

			if (!$itemResult->getResult()) {
				continue;
			}

			$key = $this->onePerTitle ? $itemResult->getKeyTitle() : $itemResult->getKey();
			if (!isset($this->results[$key])) {
				$this->results[$key] = $itemResult->getResult();
			}
		}
	}

	private function filterOne( DataFeedProviderItemResult $itemResult, $res) {
		wfProfileIn(__METHOD__);

		if ($res['type'] == 'log') {
			$this->filterLog($itemResult, $res);
		} else {
			if( empty($res['pageid']) ) {
				$title = Title::newFromText($res['title']);
			} else {
				$title = Title::newFromID($res['pageid']);
			}

			if( $title && $title->exists() ) {
				if ($title->isRedirect()) {
					if ($this->proxyType == self::WATCHLIST_FEED) {
						$this->filterRedirect($itemResult, $res, $title);
					}
				} else {
					$res['rc_params'] = MyHome::unpackData($res['rc_params']);
					if (isset($res['rc_params']['rollback'])) {
						$itemResult->setInvisibleRevisionId($res['rc_params']['revId']);
					} else {
						$itemResult->setRevisionId($res['revid']);
						$hidenewpages = !empty($this->parameters['flags']) && in_array('hidenewpages', $this->parameters['flags']);

						//do not show hidden categories (see RT#32015)
						if (isset($res['rc_params']['categoryInserts'])) {
							$res['rc_params']['categoryInserts'] = $this->filterHiddenCategories($res['rc_params']['categoryInserts']);
						}
						if ($res['type'] == 'new' && !$hidenewpages) {
							$this->filterNew($itemResult, $res, $title);
						} elseif ($res['type'] == 'edit') {
							$this->filterEdit($itemResult, $res, $title);
						}
					}
				}
			}
		}
		wfProfileOut(__METHOD__);
	}

	/**
	 * Get list of hidden categories (cached in memcached using WikiaDataAccess).
	 *
	 * Using WikiaDataAccess to limit number of processes regenerating cache and prevent delay when other
	 * process is already regenerating data. The stalled data is returned in the latter case.
	 *
	 * @see https://wikia-inc.atlassian.net/browse/PLATFORM-615
	 *
	 * @return array
	 */
	private function getHiddenCategories() {
		wfProfileIn(__METHOD__);
		$fname = __METHOD__;
		if (!is_array(self::$hiddenCategories)) {
			self::$hiddenCategories = WikiaDataAccess::cacheWithLock(wfMemcKey('hidden-categories-v2'), WikiaResponse::CACHE_SHORT /* 3 hours */,
				function() use ($fname) {
					$dbr = wfGetDB(DB_SLAVE);
					$res = $dbr->query("SELECT page_title FROM page JOIN page_props ON page_id=pp_page AND pp_propname='hiddencat' LIMIT " . self::HIDDEN_CATEGORIES_LIMIT, $fname);
					$hiddenCategories = array();
					while($row = $dbr->fetchObject($res)) {
						$hiddenCategories[] = $row->page_title;
					}
					return $hiddenCategories;
				});
		}
		wfProfileOut(__METHOD__);

		return self::$hiddenCategories;
	}

	private function filterHiddenCategories($categories) {
		wfProfileIn(__METHOD__);
		$categories = array_values(array_diff($categories, $this->getHiddenCategories()));
		wfProfileOut(__METHOD__);

		return $categories;
	}

	private function filterRedirect( DataFeedProviderItemResult $itemResult, $res, Title $title) {
		wfProfileIn(__METHOD__);
		$article = new Article($title);
		$this->add(
			$itemResult,
			[
				'type' => 'redirect',
				'title' => $res['title'],
				'url' => $title->getLocalURL(),
				'redir_title' => $article->getRedirectTarget()->getPrefixedText(),
				'redir_url' => $article->getRedirectTarget()->getLocalURL()
			],
			$res );
		wfProfileOut(__METHOD__);

		return;
	}

	private function filterEdit( DataFeedProviderItemResult $itemResult, $res, Title $title) {
		wfProfileIn(__METHOD__);
		global $wgContentNamespaces;

		$item = array('type' => 'edit');

		$hidecategories = !empty( $this->parameters['flags'] ) && in_array( 'hidecategories', $this->parameters['flags'] );

		if (in_array($res['ns'], $wgContentNamespaces)
			|| $res['ns'] == 110
			|| $res['ns'] == NS_PROJECT
			|| ( $res['ns'] == NS_CATEGORY && !$hidecategories )
			|| in_array( ( $res['ns'] - 1 ), $wgContentNamespaces )
			|| ( $res['ns'] - 1 ) == 110
			|| ( $res['ns'] - 1 ) == NS_PROJECT
			|| ( ( $res['ns'] - 1 ) == NS_CATEGORY && !$hidecategories )
			|| $res['ns'] == NS_USER
			|| $res['ns'] == NS_USER_TALK
			|| ( defined( 'NS_BLOG_ARTICLE' ) && $res['ns'] == NS_BLOG_ARTICLE )
			|| ( $res['ns'] == NS_TEMPLATE && $this->proxyType == self::WATCHLIST_FEED )
			|| ( $res['ns'] == NS_MEDIAWIKI && $this->proxyType == self::WATCHLIST_FEED )
			|| ( $res['ns'] == NS_IMAGE && $this->proxyType == self::WATCHLIST_FEED )
			|| (defined('NS_TOPLIST') && $res['ns'] == NS_TOPLIST))
		{
			$item['title'] = $res['title'];
			$item['url'] = $title->getLocalURL();
			$item['diff'] = $title->getLocalURL('diff='.$res['revid'].'&oldid='.$res['old_revid']);

			if (isset($res['rc_params']['sectionName'])) {
				$item['section'] = $res['rc_params']['sectionName'];
				if (isset($res['rc_params']['summary'])) {
					$item['comment'] = $res['rc_params']['summary'];
				}
			} elseif ($res['comment'] != '' && (defined('NS_TOPLIST') ? $res['ns'] != NS_TOPLIST : true) ) {
				$item['comment'] = $res['comment'];
			}

			if (class_exists('ArticleComment') && ArticleComment::isTitleComment($title)) {
				$item['articleComment'] = true;
				$parts = ArticleComment::explode($res['title']);
				$item['title'] = $parts['title'];
			}
		}

		if (count($item) > 1) {
			$this->add($itemResult, $item, $res);
		}

		wfProfileOut(__METHOD__);
	}

	private function filterNew( DataFeedProviderItemResult $itemResult, $res, Title $title) {
		wfProfileIn(__METHOD__);
		global $wgContentNamespaces, $wgWallNS;

		$item = array('type' => 'new');

		$hidecategories = !empty( $this->parameters['flags'] ) && in_array( 'hidecategories', $this->parameters['flags'] );

		if (in_array($res['ns'], $wgContentNamespaces)
			|| $res['ns'] == 110
			|| $res['ns'] == NS_PROJECT
			|| ( $res['ns'] == NS_CATEGORY && !$hidecategories )
			|| in_array( ( $res['ns'] - 1 ), $wgContentNamespaces )
			|| ( $res['ns'] - 1 ) == 110
			|| ( $res['ns'] - 1 ) == NS_PROJECT
			|| ( ( $res['ns']-1) == NS_CATEGORY && !$hidecategories ) )
		{
			$item['title'] = $res['title'];
			$item['url'] = $title->getLocalURL();
			if (class_exists('ArticleComment') && ArticleComment::isTitleComment($title)) {
				$item['articleComment'] = true;
				$parts = ArticleComment::explode($res['title']);
				$item['title'] = $parts['title'];
			}
		} elseif ( $res['ns'] == NS_USER_TALK ) {  // BugId:15648
			$item['title'] = $res['title'];
			$item['url'] = $title->getLocalURL();
		} elseif (defined('NS_BLOG_ARTICLE') && $res['ns'] == NS_BLOG_ARTICLE && class_exists('ArticleComment')) {
			$parts = ArticleComment::explode($res['title']);
			$item['title'] = $parts['title'];
			$item['url'] = $title->getLocalURL();
		} elseif (defined('NS_BLOG_ARTICLE_TALK') && $res['ns'] == NS_BLOG_ARTICLE_TALK && class_exists('ArticleComment')) {
			$subpageTitle = Title::newFromText($title->getBaseText(), NS_BLOG_ARTICLE_TALK);
			/*
			* Unfortunately $subpageTitle->getSubpageText() don't grab the blog article title text for subcomments.
			* So considering blog structure reasonable way to get it, is to grab second title text part from full title text.
			*/
			$articleText = explode("/", $title->getText());
			$item['title'] = (count($articleText) > 2) ? $articleText[1] : $subpageTitle->getSubpageText();
			$item['url'] = $subpageTitle->getLocalURL();
 		} elseif (defined('NS_BLOG_LISTING') && $res['ns'] == NS_BLOG_LISTING) {
			if ($this->proxyType == self::WATCHLIST_FEED) {
				$item['title'] = $res['title'];
				$item['url'] = Title::newFromText($title->getBaseText(), NS_BLOG_ARTICLE)->getLocalURL();
			}
		} elseif (defined('NS_TOPLIST') && $res['ns'] == NS_TOPLIST ) {
			if ($this->proxyType == self::ACTIVITY_FEED && !stripos($res['title'], 'toplist-item') ) {
				$item['title'] = $res['title'];
				$item['url'] = Title::newFromText($title->getBaseText(), NS_TOPLIST)->getLocalURL();
				$res['comment'] = ''; // suppressing needless details
				$res['rc_params'] = '';
			}
		} elseif ( !empty($wgWallNS) && in_array(MWNamespace::getSubject($res['ns']), $wgWallNS) && $this->proxyType == self::ACTIVITY_FEED ) {
			$wh = (new WallHelper);
			$item = $wh->wikiActivityFilterMessageWall($title, $res);
		}

		if (count($item) > 1) {
			if (isset($res['rc_params']['intro'])) {
				$item['intro'] = $res['rc_params']['intro'];
			}

			if ($res['comment'] != '') {
				$item['comment'] = $res['comment'];
			}
			$this->add($itemResult, $item, $res);
		}

		wfProfileOut(__METHOD__);
	}

	private function filterLog( DataFeedProviderItemResult $itemResult, $res) {
		wfProfileIn(__METHOD__);
		if ($res['logtype'] == 'move') {
			if( isset($res['move'], $res['move']['new_title'], $res['move']['new_ns']) ) { //FB#35775
				//RT#27870
				if (!empty($this->parameters['type']) && $this->parameters['type'] == 'widget') {
					wfProfileOut(__METHOD__);
					return;
				}
				$newTitle = Title::newFromText($res['move']['new_title'], $res['move']['new_ns']);
			} else {
				$newTitle = Title::newFromText(trim($res['rc_params']));
			}
			if ($newTitle && $newTitle->exists()) {
				$oldTitle = Title::newFromText($res['title']);

				if (empty($oldTitle)) {
					wfProfileOut(__METHOD__);
					return;
				}

				// Filter Article Comments from Activity Log without using rc_params FB:1336
				if (class_exists('ArticleComment') && ArticleComment::isTitleComment($newTitle)) {
					wfProfileOut(__METHOD__);
					return;
				}

				$this->add(
					$itemResult,
					[
						'type' => 'move',
						'to_title' => $newTitle->getPrefixedText(),
						'to_url' => $newTitle->getLocalURL(),
						'title' => $oldTitle->getPrefixedText(),
						'url' => $oldTitle->getLocalURL(),
						'comment' => $res['comment']
					],
					$res);
				wfProfileOut(__METHOD__);
				return;
			}

		}

		if ($this->proxyType == self::WATCHLIST_FEED) {
			if ($res['logtype'] == 'delete') {
				$this->add(
					$itemResult,
					[
						'type' => 'delete',
						'title' => $res['title']
					],
					$res);
				wfProfileOut(__METHOD__);
				return;
			} elseif ($res['logtype'] == 'upload') {
				$title = Title::newFromText($res['title']);
				if ($title && $title->exists()) {
					$file = wfFindFile($title);
					if ($file) {
						$this->add(
							$itemResult,
							[
								'type' => 'upload',
								'title' => $title->getPrefixedText(),
								'url' => $title->getLocalURL(),
								'thumbnail' => $file->transform( array( 'width' => self::IMAGE_THUMB_WIDTH ) )->toHtml()
							],
							$res);
						wfProfileOut(__METHOD__);
						return;
					}
				}
			}
		}

		wfProfileOut(__METHOD__);
	}

	private function add( DataFeedProviderItemResult $itemResult, $item, $res) {
		wfProfileIn(__METHOD__);

		$itemResult->setKey( $this->generateKey( $res ) );
		$itemResult->setKeyTitle( $res['title'] );

		$item['timestamp'] = $res['timestamp'];

		$item['user'] = $this->getUserLink( $res['user'], isset($res['anon']) );
		$item['username'] = $res['user'];

		if (is_array($res['rc_params'])) {

			$useflags = !empty($this->parameters['flags']);
			$shortlist = $useflags && in_array('shortlist', $this->parameters['flags']);
			$hideimages = $useflags && ($shortlist || in_array('hideimages', $this->parameters['flags']));
			$hidevideos = $useflags && ($shortlist || in_array('hidevideos', $this->parameters['flags']));

			if (isset($res['rc_params']['autosummaryType'])) {
				$item['autosummaryType'] = $res['rc_params']['autosummaryType'];
			}

			if (isset($res['rc_params']['imageInserts'])) {
				$item['new_images'] = $item['new_videos'] = array();

				foreach($res['rc_params']['imageInserts'] as $imageName) {
					// note: getImageClass() strips leading colon for wikia videos image names
					$imageClass = $this->getImageClass($imageName);
					if (!$imageClass) {
						continue;
					}

					$imageInfo = self::getThumb($imageName);
					if ($imageClass === 'image' && !$hideimages) {
						$item['new_images'][] = $imageInfo;
					} elseif ($imageClass === 'video' && !$hidevideos) {
						$item['new_videos'][] = $imageInfo;
					}
				}

				if (count($item['new_images']) == 0) unset($item['new_images']);
				if (count($item['new_videos']) == 0) unset($item['new_videos']);
			}

			if (isset($res['rc_params']['categoryInserts']) && count($res['rc_params']['categoryInserts'])) {
				$item['new_categories'] = $res['rc_params']['categoryInserts'];
			}

			if (isset($res['rc_params']['viewMode'])) {
				$item['viewMode'] = $res['rc_params']['viewMode'];
			}

			if (isset($res['rc_params']['CategorySelect'])) {
				$item['CategorySelect'] = $res['rc_params']['CategorySelect'];
			}

			if (isset($res['rc_params']['Badge'])){
				$item['Badge'] = $res['rc_params']['Badge'];
			}
		}

		if( class_exists('Wall') && !empty($item['wall']) ) {
			$wh = new WallHelper();
			if ( !empty($item['parent-id']) ) {
				$data = $wh->getWallComments($item['parent-id']);
				$item['comments'] = $data['comments'];
				$item['comments-count'] = $data['count'];
			} else {
				$data = $wh->getWallComments($item['article-id']);
				$item['comments'] = $data['comments'];
				$item['comments-count'] = $data['count'];
			}
		}

		$item['ns'] = $res['ns'];

		$itemResult->setResult( $item );

		wfProfileOut(__METHOD__);
	}

	private function generateKey( $res ) {
		global $wgWallNS;

		$key = $res['user'].'#'.$res['title'].'#'.$res['comment'];

		if (is_array($res['rc_params']) && !empty($res['rc_params']['imageInserts'])) {
			$key .= json_encode($res['rc_params']['imageInserts']);
		}

		if (is_array($res['rc_params']) && !empty($res['rc_params']['categoryInserts'])) {
			$key .= json_encode($res['rc_params']['categoryInserts']);
		}

		if( !empty($res['ns']) && !empty($wgWallNS) && in_array(MWNamespace::getSubject($res['ns']), $wgWallNS) ) {
			$key = $res['title'];
		}

		return $key;
	}

	/**
	 * @param string $username Username
	 * @param bool $anon Is the user anon?
	 * @return string|false
	 */
	private function getUserLink( $username, $anon ) {
		wfProfileIn(__METHOD__);

		if (!isset(self::$userLinksCache[$username])) {
			$userLink = false;

			if ($anon) {
				$userLink = Xml::element('a', array('href' => Skin::makeSpecialUrl('Contributions').'/'.$username, 'rel' => 'nofollow'), wfMsg('masthead-anonymous-user'));
			} else {
				$ut = Title::newFromText($username, NS_USER);
				if (!empty($ut)) {
					if ($ut->isKnown()) {
						$userLink = Xml::element('a', array('href' => $ut->getLocalURL(), 'rel' => 'nofollow'), $username);
					} else {
						$userLink = Xml::element('a', array('href' => $ut->getLocalURL(), 'rel' => 'nofollow', 'class' => 'new'), $username);
						//$userLink = Xml::element('a', array('href' => Skin::makeSpecialUrl('Contributions').'/'.$username, 'rel' => 'nofollow'), $username);
					}
				}
			}

			self::$userLinksCache[$username] = $userLink;
		}

		wfProfileOut(__METHOD__);

		return self::$userLinksCache[$username];
	}

	private function getImageClass( &$imageName ) {
		global $wgMemc;

		wfProfileIn(__METHOD__);

		if ($imageName[0] == ':') {
			$imageName = substr($imageName, 1);
			wfProfileOut(__METHOD__);
			return 'video';
		}

		if (!isset(self::$imageClassesCache[$imageName])) {
			$imageClass = false;

			$memcKey = wfMemcKey('DataFeedProvider','image_class', md5($imageName));

			$imageLinkCount = $wgMemc->get($memcKey);
			// Note that memcache returns null if record does not exists in cache
			// versus 0 returned from database when image does not link to anything
			if ($imageLinkCount === false) {
				$dbr = wfGetDB( DB_SLAVE );
				$imageLinkCount = $dbr->selectField(
					'imagelinks',
					'count(*) as cnt',
					array('il_to' => $imageName),
					__METHOD__
				);
				$wgMemc->set($memcKey, $imageLinkCount, 60*60*12);
			}

			if ($imageLinkCount < 20) {
				$imageObj = wfFindFile(Title::newFromText($imageName, NS_FILE));

				if ($imageObj) {
					if ( WikiaFileHelper::isFileTypeVideo($imageObj) ) {
						$imageClass = 'video';
					} else {
						$imageClass = 'image';
					}
				}
			}

			self::$imageClassesCache[$imageName] = $imageClass;
		}

		wfProfileOut(__METHOD__);

		return self::$imageClassesCache[$imageName];
	}

	private static function getThumb($imageName, &$imageObj=null) {
		wfProfileIn(__METHOD__);

		$imageObj = wfFindFile(Title::newFromText($imageName, NS_FILE));
		$imageInfo = null;

		if ($imageObj) {
			$width = $imageObj->getWidth();
			$height = $imageObj->getHeight();
			$options = [ 'noLightbox' => true ];

			if ($width > self::IMAGE_THUMB_WIDTH || $height > self::IMAGE_THUMB_WIDTH) {
				$thumbObj = $imageObj->transform( array( 'width' => self::IMAGE_THUMB_WIDTH, 'height' => self::IMAGE_THUMB_WIDTH ) );
				$width = $thumbObj->getWidth();
				$height = $thumbObj->getHeight();
				$html = $thumbObj->toHtml( $options );
			} else {
				$html = $imageObj->getUnscaledThumb()->toHtml( $options );
			}

			$imageInfo = array('name' => $imageName, 'html' => $html, 'width' => $width, 'height' => $height);
		}

		wfProfileOut(__METHOD__);

		return $imageInfo;
	}

}

class DataFeedProviderItemResult {
	/** @var int */
	private $revisionId;
	/** @var int */
	private $invisibleRevisionId;
	/** @var string */
	private $key;
	/** @var string */
	private $keyTitle;
	/** @var array */
	private $result;

	/**
	 * @return int
	 */
	public function getRevisionId() {
		return $this->revisionId;
	}

	/**
	 * @param int $revisionId
	 */
	public function setRevisionId( $revisionId ) {
		$this->revisionId = intval($revisionId);
	}

	/**
	 * @return int
	 */
	public function getInvisibleRevisionId() {
		return $this->invisibleRevisionId;
	}

	/**
	 * @param int $invisibleRevisionId
	 */
	public function setInvisibleRevisionId( $invisibleRevisionId ) {
		$this->invisibleRevisionId = intval($invisibleRevisionId);
	}

	/**
	 * @return string
	 */
	public function getKey() {
		return $this->key;
	}

	/**
	 * @param string $key
	 */
	public function setKey( $key ) {
		$this->key = strval($key);
	}

	/**
	 * @return string
	 */
	public function getKeyTitle() {
		return $this->keyTitle;
	}

	/**
	 * @param string $keyTitle
	 */
	public function setKeyTitle( $keyTitle ) {
		$this->keyTitle = strval($keyTitle);
	}

	/**
	 * @return array
	 */
	public function getResult() {
		return $this->result;
	}

	/**
	 * @param array $result
	 */
	public function setResult( array $result ) {
		$this->result = $result;
	}

}
