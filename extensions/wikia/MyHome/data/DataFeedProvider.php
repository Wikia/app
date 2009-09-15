<?php

class DataFeedProvider {

	var $proxy, $proxyType, $results = array(), $invisibleRevisions = array();

	const AF = 0; // Activity Feed
	const WL = 1; // Watchlist

	const UPLOAD_THUMB_WIDTH = 150;
	const VIDEO_THUMB_WIDTH = 150;

	public static function getImageThumb($imageName) {
		$imageObj = wfFindFile(Title::newFromText($imageName, NS_FILE));
		if($imageObj) {
			$width = $imageObj->getWidth();
			$height = $imageObj->getHeight();

			if($width > self::UPLOAD_THUMB_WIDTH || $height > self::UPLOAD_THUMB_WIDTH) {
				$thumbObj = $imageObj->getThumbnail(self::UPLOAD_THUMB_WIDTH, self::UPLOAD_THUMB_WIDTH);
				$width = $thumbObj->getWidth();
				$height = $thumbObj->getHeight();
				$html = $thumbObj->toHtml();
			} else {
				$html = $imageObj->getUnscaledThumb()->toHtml();
			}

			return array('name' => $imageName, 'html' => $html, 'width' => $width, 'height' => $height);
		}
		return null;
	}

	public static function getVideoThumb($videoName) {
		$videoObj = new VideoPage(Title::newFromText($videoName, NS_VIDEO));
		$videoObj->load();
		if($videoObj->getVideoId()) {
			return array('name' => $videoName, 'html' => $videoObj->getThumbnailCode(self::VIDEO_THUMB_WIDTH, false), 'width' => self::VIDEO_THUMB_WIDTH, 'height' => round(self::VIDEO_THUMB_WIDTH / $videoObj->getRatio()));
		}
		return null;
	}

	private static $users = array();

	public function __construct($proxy) {
		$this->proxy = $proxy;

		if($this->proxy instanceof ActivityFeedAPIProxy) {
			$this->proxyType = self::AF;
		} else {
			$this->proxyType = self::WL;
		}
	}

	public function get($limit, $start = null) {
		$queryContinue = $start;
		$proxyLimit = $limit;

		while(count($this->results) < $limit + 1) {
			$callLimit = max(2, round(($proxyLimit - count($this->results)) * 1.2));
			$res = $this->proxy->get($callLimit, $queryContinue);

			if(isset($res['results'])) {
				foreach($res['results'] as $oneres) {
					$this->filterOne($oneres);
				}
			}

			if(isset($res['query-continue'])) {
				$queryContinue = $res['query-continue'];
			} else {
				break;
			}
		}

		$out = array();

		$keys = array_keys($this->results);
		if(isset($keys[$limit])) $out['query-continue'] = $this->results[$keys[$limit]]['timestamp'];
		$out['results'] = array_slice($this->results, 0, $limit);

		return $out;
	}

	private function add($item, $res) {

		$key = $res['user'].'#'.$res['title'].'#'.$res['comment'];

		if(is_array($res['rc_params']) && !empty($res['rc_params']['imageInserts'])) {
			$key .= Wikia::json_encode($res['rc_params']['imageInserts']);
		}

		if(is_array($res['rc_params']) && !empty($res['rc_params']['categoryInserts'])) {
			$key .= Wikia::json_encode($res['rc_params']['categoryInserts']);
		}

		if(!isset($this->results[$key])) {
			$item['timestamp'] = $res['timestamp'];

			if(!isset(self::$users[$res['user']])) {
				if(isset($res['anon'])) {
					$users[$res['user']] = Xml::element('a', array('href' => Skin::makeSpecialUrl('Contributions').'/'.$res['user'], 'rel' => 'nofollow'), wfMsg('masthead-anonymous-user'));
				} else {
					$ut = Title::newFromText($res['user'], NS_USER);
					if($ut->isKnown()) {
						$users[$res['user']] = Xml::element('a', array('href' => $ut->getLocalUrl(), 'rel' => 'nofollow'), $res['user']);
					} else {
						$users[$res['user']] = Xml::element('a', array('href' => $ut->getLocalUrl(), 'rel' => 'nofollow', 'class' => 'new'), $res['user']);
					}
				}
			}

			$item['user'] = $users[$res['user']];

			if(is_array($res['rc_params'])) {

				if(isset($res['rc_params']['autosummaryType'])) {
					$item['autosummaryType'] = $res['rc_params']['autosummaryType'];
				}

				if(isset($res['rc_params']['imageInserts'])) {
					$item['new_images'] = $item['new_videos'] = array();

					foreach($res['rc_params']['imageInserts'] as $imageName) {
						if($imageName{0} == ':') { // video
							$video = self::getVideoThumb(substr($imageName, 1));
							if($video) $item['new_videos'][] = $video;
						} else { // image
							$image = self::getImageThumb($imageName);
							if($image) $item['new_images'][] = $image;
						}
					}

					if(count($item['new_images']) == 0) unset($item['new_images']);
					if(count($item['new_videos']) == 0) unset($item['new_videos']);
				}

				if(isset($res['rc_params']['categoryInserts'])) {
					$item['new_categories'] = $res['rc_params']['categoryInserts'];
				}

				if(isset($res['rc_params']['viewMode'])) {
					$item['viewMode'] = $res['rc_params']['viewMode'];
				}

			}

			$item['ns'] = $res['ns'];

			$this->results[$key] = $item;
		}
	}

	private function filterOne($res) {
		if($res['type'] == 'log') {
			$this->filterLog($res);
		} else {
			$title = Title::newFromText($res['title']);
			if($title && $title->exists()) {
				/*if($title->isRedirect()) {
					if($this->proxyType == self::WL) {
						$item = $this->filterRedirect($res, $title);
					}
				} else {*/
					$res['rc_params'] = MyHome::unpackData($res['rc_params']);
					if(isset($res['rc_params']['rollback'])) {
						$this->invisibleRevisions[] = $res['rc_params']['revId'];
					} else if(!in_array($res['revid'], $this->invisibleRevisions)) {
						if($res['type'] == 'new') {
							$this->filterNew($res, $title);
						} else if($res['type'] == 'edit') {
							$this->filterEdit($res, $title);
						}
					}
				/*}*/
			}
		}
	}

	private function filterRedirect($res, $title) {
		$article = new Article($title);
		return $this->add(array('type' => 'redirect',
								'title' => $res['title'],
								'url' => $title->getLocalUrl(),
								'redir_title' => $article->getRedirectTarget()->getPrefixedText(),
								'redir_url' => $article->getRedirectTarget()->getLocalUrl()
								), $res);
	}

	private function filterEdit($res, $title) {
		global $wgContentNamespaces;

		$item = array('type' => 'edit');

		if(in_array($res['ns'], $wgContentNamespaces)
		|| $res['ns'] == NS_PROJECT
		|| $res['ns'] == NS_CATEGORY
		|| in_array(($res['ns']-1), $wgContentNamespaces)
		|| ($res['ns']-1) == NS_PROJECT
		|| ($res['ns']-1) == NS_CATEGORY
		|| $res['ns'] == NS_USER
		|| $res['ns'] == NS_USER_TALK
		|| $res['ns'] == NS_BLOG_ARTICLE
		|| ($res['ns'] == NS_TEMPLATE && $this->proxyType == self::WL)
		|| ($res['ns'] == NS_MEDIAWIKI && $this->proxyType == self::WL)
		|| ($res['ns'] == NS_IMAGE && $this->proxyType == self::WL)
		|| ($res['ns'] == NS_VIDEO && $this->proxyType == self::WL)) {

			$item['title'] = $res['title'];
			$item['url'] = $title->getLocalUrl();
			$item['diff'] = $title->getLocalUrl('diff='.$res['revid'].'&oldid='.$res['old_revid']);

			if(isset($res['rc_params']['sectionName'])) {
				$item['section'] = $res['rc_params']['sectionName'];
				if(isset($res['rc_params']['summary'])) {
					$item['comment'] = $res['rc_params']['summary'];
				}
			} else if($res['comment'] != '') {
				$item['comment'] = $res['comment'];
			}

			if($res['ns'] == NS_BLOG_ARTICLE) {
				$item['title'] = end(explode('/', $res['title'], 2));
			}
		}

		if(count($item) > 1) {
			return $this->add($item, $res);
		}

	}

	private function filterNew($res, $title) {
		global $wgContentNamespaces;

		$item = array('type' => 'new');

		if(in_array($res['ns'], $wgContentNamespaces)
		|| $res['ns'] == NS_PROJECT
		|| $res['ns'] == NS_CATEGORY
		|| in_array(($res['ns']-1), $wgContentNamespaces)
		|| ($res['ns']-1) == NS_PROJECT
		|| ($res['ns']-1) == NS_CATEGORY) {

			$item['title'] = $res['title'];
			$item['url'] = $title->getLocalUrl();

		} else if($res['ns'] == NS_BLOG_ARTICLE) {

			$item['title'] = end(explode('/', $res['title'], 2));
			$item['url'] = $title->getLocalUrl();

		} else if($res['ns'] == NS_BLOG_ARTICLE_TALK) {

			$item['title'] = implode('/', array_slice(explode('/', $res['title']), 1, -1));
			$item['url'] = Title::newFromText($title->getBaseText(), NS_BLOG_ARTICLE)->getLocalUrl();

 		} else if($res['ns'] == 400) {

 			if($this->proxyType == self::WL) {
				$video = new VideoPage($title);
				$video->load();

				$item['title'] = $res['title'];
				$item['url'] = $title->getLocalUrl();
				$item['thumbnail'] = $video->getThumbnailCode(self::VIDEO_THUMB_WIDTH, false);
 			}

		} else if($res['ns'] == NS_BLOG_LISTING) {

			if($this->proxyType == self::WL) {

				$item['title'] = $res['title'];
				$item['url'] = Title::newFromText($title->getBaseText(), NS_BLOG_ARTICLE)->getLocalUrl();

			}

		}

		if(count($item) > 1) {
			if(isset($res['rc_params']['intro'])) {
				$item['intro'] = $res['rc_params']['intro'];
			}

			if($res['comment'] != '') {
				$item['comment'] = $res['comment'];
			}
			return $this->add($item, $res);
		}

	}

	private function filterLog($res) {

		if($res['logtype'] == 'move') {
			if(isset($res['move'])) {
				$newTitle = Title::newFromText($res['move']['new_title'], $res['move']['new_ns']);
			} else {
				$newTitle = Title::newFromText(trim($res['rc_params']));
			}
			if($newTitle && $newTitle->exists()) {
				$oldTitle = Title::newFromText($res['title']);
				return $this->add(array('type' => 'move',
										'to_title' => $newTitle->getPrefixedText(),
										'to_url' => $newTitle->getLocalUrl(),
										'title' => $oldTitle->getPrefixedText(),
										'url' => $oldTitle->getLocalUrl(),
										'comment' => $res['comment']
										),
										$res);
			}

		}

		if($this->proxyType == self::WL) {

			if($res['logtype'] == 'delete') {

				return $this->add(array('type' => 'delete',
										'title' => $res['title']),
										$res);

			} else if($res['logtype'] == 'upload') {

				$title = Title::newFromText($res['title']);
				if($title && $title->exists()) {
					$file = wfFindFile($title);
					if($file) {
						return $this->add(array('type' => 'upload',
												'title' => $title->getPrefixedText(),
												'url' => $title->getLocalUrl(),
												'thumbnail' => $file->getThumbnail(self::UPLOAD_THUMB_WIDTH)->toHtml()
												),
												$res);
					}
				}

			}

		}
	}

}
