<?php

class DataFeedProvider {

	const ACTIVITY_FEED = 0; // Activity Feed
	const WATCHLIST_FEED = 1; // Watchlist

	const IMAGE_THUMB_WIDTH = 150;
	const VIDEO_THUMB_WIDTH = 150;

	const HIDDEN_CATEGORIES_LIMIT = 500;

	private static $users = array();
	private static $hiddenCategories = null;
	private static $images = array();

	private $proxy;
	private $proxyType;
	private $results = array();
	private $invisibleRevisions = array();
	private $removeDuplicatesType;
	private $parameters = array();

	public function __construct($proxy, $removeDuplicatesType = 0, $parameters = array()) {
		$this->proxy = $proxy;

		if ($this->proxy instanceof ActivityFeedAPIProxy) {
			$this->proxyType = self::ACTIVITY_FEED;
		} else {
			$this->proxyType = self::WATCHLIST_FEED;
		}
		$this->removeDuplicatesType = $removeDuplicatesType;
		$this->parameters = $parameters;
	}

	public function get($limit, $start = null) {
		wfProfileIn(__METHOD__);

		$queryPosition = $start;
		$proxyLimit = $limit;

		$maxIterations = 5;
		while((count($this->results) < $limit + 1) && $maxIterations--) {
			$callLimit = max(10, round(($proxyLimit - count($this->results)) * 1.2));
			$res = $this->proxy->get($callLimit, $queryPosition);
			if (isset($res['results'])) {
				foreach($res['results'] as $oneres) {
					$this->filterOne($oneres);
				}
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

	private function filterOne($res) {
		wfProfileIn(__METHOD__);

		if ($res['type'] == 'log') {
			$this->filterLog($res);
		} else {
			if( empty($res['pageid']) ) {
				$title = Title::newFromText($res['title']);
			} else {
				$title = Title::newFromID($res['pageid']);
			}

			if( $title && $title->exists() ) {
				if ($title->isRedirect()) {
					if ($this->proxyType == self::WATCHLIST_FEED) {
						$this->filterRedirect($res, $title);
					}
				} else {
					$res['rc_params'] = MyHome::unpackData($res['rc_params']);
					if (isset($res['rc_params']['rollback'])) {
						$this->invisibleRevisions[] = $res['rc_params']['revId'];
					} elseif (!in_array($res['revid'], $this->invisibleRevisions)) {
						$hidenewpages = !empty($this->parameters['flags']) && in_array('hidenewpages', $this->parameters['flags']);
						//do not show hidden categories (see RT#32015)
						if (isset($res['rc_params']['categoryInserts'])) {
							$res['rc_params']['categoryInserts'] = $this->filterHiddenCategories($res['rc_params']['categoryInserts']);
						}
						if ($res['type'] == 'new' && !$hidenewpages) {
							$this->filterNew($res, $title);
						} elseif ($res['type'] == 'edit') {
							$this->filterEdit($res, $title);
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

	private function filterRedirect($res, Title $title) {
		wfProfileIn(__METHOD__);
		$article = new Article($title);
		$this->add(
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

	private function filterEdit($res, Title $title) {
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
			$this->add($item, $res);
		}

		wfProfileOut(__METHOD__);
	}

	private function filterNew($res, Title $title) {
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
			$this->add($item, $res);
		}

		wfProfileOut(__METHOD__);
	}

	private function filterLog($res) {
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

	private function add($item, $res) {
		wfProfileIn(__METHOD__);
		global $wgMemc;

		$key = null;
		if( $this->removeDuplicatesType == 0 ) { //default
			$key = $res['user'].'#'.$res['title'].'#'.$res['comment'];

			if (is_array($res['rc_params']) && !empty($res['rc_params']['imageInserts'])) {
				$key .= json_encode($res['rc_params']['imageInserts']);
			}

			if (is_array($res['rc_params']) && !empty($res['rc_params']['categoryInserts'])) {
				$key .= json_encode($res['rc_params']['categoryInserts']);
			}
			global $wgWallNS;
			if( !empty($res['ns']) && !empty($wgWallNS) && in_array(MWNamespace::getSubject($res['ns']), $wgWallNS) ) {
				$key = $res['title'];
			}
		} elseif ($this->removeDuplicatesType == 1) {	//used in `shortlist`, activity tag
			$key = $res['title'];
		}

		if (!isset($this->results[$key])) {
			$item['timestamp'] = $res['timestamp'];

			$users = [];
			if (!isset(self::$users[$res['user']])) {
				if (isset($res['anon'])) {
					$users[$res['user']] = Xml::element('a', array('href' => Skin::makeSpecialUrl('Contributions').'/'.$res['user'], 'rel' => 'nofollow'), wfMsg('masthead-anonymous-user'));
				} else {
					$ut = Title::newFromText($res['user'], NS_USER);
					if (empty($ut)) {
						//we have malformed user names in UTF-8 that causes above function to fail (see FB#1731)
						wfProfileOut(__METHOD__);
						return;
					}
					if ($ut->isKnown()) {
						$users[$res['user']] = Xml::element('a', array('href' => $ut->getLocalURL(), 'rel' => 'nofollow'), $res['user']);
					} else {
						$users[$res['user']] = Xml::element('a', array('href' => $ut->getLocalURL(), 'rel' => 'nofollow', 'class' => 'new'), $res['user']);
						//$users[$res['user']] = Xml::element('a', array('href' => Skin::makeSpecialUrl('Contributions').'/'.$res['user'], 'rel' => 'nofollow'), $res['user']);
					}
				}
			}

			$item['user'] = $users[$res['user']];
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
						if (!$hidevideos && $imageName{0} == ':') { // video
							$video = self::getThumb(substr($imageName, 1));
							if ($video) $item['new_videos'][] = $video;
						} elseif (!$hideimages) { // image
							if (!isset(self::$images[$imageName])) {
								wfProfileIn(__METHOD__ . "-imagelinks-count");
								$memcKey = wfMemcKey('ac_image_cnt', md5($imageName));
								self::$images[$imageName] = $wgMemc->get($memcKey);

								// Note that memcache returns null if record does not exists in cache
								// versus 0 returned from database when image does not link to anything
								if (self::$images[$imageName] === false) {
									$dbr = wfGetDB( DB_SLAVE );
									self::$images[$imageName] = $dbr->selectField(
										'imagelinks',
										'count(*) as cnt',
										array('il_to' => $imageName),
										__METHOD__
									);
									$wgMemc->set($memcKey, self::$images[$imageName], 60*60*12);
								}
								wfProfileOut(__METHOD__ . "-imagelinks-count");
							}
							if (self::$images[$imageName] < 20) {
								$imageObj = null;
								/** @var File $imageObj */
								$image = self::getThumb($imageName, $imageObj);

								if ($image) {
									if ( WikiaFileHelper::isFileTypeVideo($imageObj) ) {
										$item['new_videos'][] = $image;
									} else {
										$item['new_images'][] = $image;
									}
								} else {
									// this trick will avoid checking more then one time if image exists when it does not exists
									self::$images[$imageName] = 20;
								}
							}
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

				if(isset($res['rc_params']['Badge'])){
					$item['Badge'] = $res['rc_params']['Badge'];
				}
			}

			if( class_exists('Wall') && !empty($item['wall']) ) {
				$wh = new WallHelper();
				if( !empty($item['parent-id']) ) {
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

			$this->results[$key] = $item;
		}
		wfProfileOut(__METHOD__);
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
