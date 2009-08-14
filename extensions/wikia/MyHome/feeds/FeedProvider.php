<?php
abstract class FeedProvider {

	const ACTIVITY_MODE = 0;
	const WATCHLIST_MODE = 1;

	const NEW_TALK_PAGE = 0;
	const NEW_ARTICLE = 1;
	const NEW_BLOG_POST = 2;
	const NEW_BLOG_COMMENT = 3;
	const NEW_BLOG_LISTING = 4;
	const NEW_VIDEO = 5;
	const FILE_UPLOAD = 6;
	const FILE_OVERWRITE = 7;
	const ARTICLE_EDIT_WITH_SUMMARY = 8;
	const ARTICLE_EDIT_WITHOUT_SUMMARY = 9;
	const TALK_PAGE_EDIT_WITH_SUMMARY = 10;
	const TALK_PAGE_EDIT_WITHOUT_SUMMARY = 11;
	const TALK_PAGE_SECTION_EDIT_WITH_SUMMARY = 12;
	const TALK_PAGE_SECTION_EDIT_WITHOUT_SUMMARY = 13;
	const ARTICLE_SECTION_EDIT_WITH_SUMMARY = 14;
	const ARTICLE_SECTION_EDIT_WITHOUT_SUMMARY = 15;
	const USER_TALK_EDIT_WITHOUT_SUMMARY = 16;
	const USER_TALK_EDIT_WITH_SUMMARY = 17;
	const USER_EDIT_WITHOUT_SUMMARY = 18;
	const USER_EDIT_WITH_SUMMARY = 19;
	const FILE_EDIT = 20;
	const VIDEO_EDIT = 21;
	const BLOG_EDIT_WITHOUT_SUMMARY = 22;
	const BLOG_EDIT_WITH_SUMMARY = 23;
	const TEMPLATE_OR_MEDIAWIKI_EDIT_WITHOUT_SUMMARY = 24;
	const TEMPLATE_OR_MEDIAWIKI_EDIT_WITH_SUMMARY = 25;

	public $mode;

	public function __construct() {
		if(get_class($this) == 'ActivityFeedProvider') {
			$this->mode = FeedProvider::ACTIVITY_MODE;
		} else {
			$this->mode = FeedProvider::WATCHLIST_MODE;
		}
	}

	/**
	 * Find and return File object assigned to specified data.
	 * It may be either current or archive version.
	 *
	 * @author Inez Korczyński (korczynski@gmail.com)
	 * @param object $title
	 * @param string $timestamp
	 * @return object
	 */
	public function getFile($title, $timestamp) {
		$timestamp = wfTimestamp(TS_UNIX, $timestamp);
		$file = wfFindFile($title);
		if(abs(wfTimestamp(TS_UNIX, $file->timestamp) - $timestamp) < 5) {
			return $file;
		}
		foreach($file->getHistory() as $oldfile) {
			if(abs(wfTimestamp(TS_UNIX, $oldfile->timestamp) - $timestamp) < 5) {
				return $oldfile;
			}
		}
		return null;
	}

	/**
	 * Request scope cache storing information about existance of user page and URL to it.
	 *
	 * @author Inez Korczyński (korczynski@gmail.com)
	 */
	public static $users = array();

	public function filter($results) {
		$out = array();
		foreach($results as $result) {
			if($item = $this->filterOne($result)) {
				if(!isset($out[$item['key']])) {
					$out[$item['key']] = $item;
					unset($out[$item['key']]['key']);
				}
			}
		}
		return $out;
	}

	public function filterOne($result) {
		if($result['type'] == 'new' && ($title = Title::newFromId($result['pageid']))) {
			$item = $this->filterNew($result, $title);
		} else if($result['type'] == 'edit' && ($title = Title::newFromId($result['pageid']))) {
			$item = $this->filterEdit($result, $title);
		} else if($result['type'] == 'log') {
			$item = $this->filterLog($result);
		}
		if($item) {
			$item['timestamp'] = $result['timestamp'];
			if(!isset($result['anon'])) {
				$item['user'] = $result['user'];
				// cache information about user page in static variable
				if(!isset(FeedProvider::$users[$item['user']])) {
					if($userTitle = Title::newFromText($item['user'], NS_USER)) {
						FeedProvider::$users[$item['user']] = $userTitle->getLocalUrl();
					} else {
						FeedProvider::$users[$item['user']] = false;
					}
				}
				if(FeedProvider::$users[$item['user']] != false) {
					$item['userurl'] = FeedProvider::$users[$item['user']];
				}
			}
			$item['key'] = $result['user'].'#'.$result['title'].'#'.$result['comment'];
			return $item;
		}
	}

	public function filterEdit($result, $title) {
		global $wgContentNamespaces;

		if(in_array($result['ns'], $wgContentNamespaces)
			|| $result['ns'] == NS_PROJECT
			|| $result['ns'] == NS_CATEGORY
			|| in_array(($result['ns']-1), $wgContentNamespaces)
			|| ($result['ns']-1) == NS_PROJECT
			|| ($result['ns']-1) == NS_CATEGORY) {
			$item['url'] = $title->getLocalUrl();
			$item['diff'] = $title->getLocalUrl('diff='.$result['revid'].'&oldid='.$result['old_revid']);
			$item['title'] = $title->getPrefixedText();
			if($result['rc_params'] == '') {
				if($result['comment'] == '') {
					if($this->mode == FeedProvider::ACTIVITY_MODE) {
						return;
					}
					$item['type'] = Namespace::isTalk($result['ns']) ? FeedProvider::TALK_PAGE_EDIT_WITHOUT_SUMMARY : FeedProvider::ARTICLE_EDIT_WITHOUT_SUMMARY;
				} else {
					$item['type'] = Namespace::isTalk($result['ns']) ? FeedProvider::TALK_PAGE_EDIT_WITH_SUMMARY : FeedProvider::ARTICLE_EDIT_WITH_SUMMARY;
					$item['summary'] = $result['comment'];
				}
			} else {
				$param = substr($result['rc_params'], 0, 4);
				if($param == MyHome::sectionEditWithSummary) {
					$item['type'] = Namespace::isTalk($result['ns']) ? FeedProvider::TALK_PAGE_SECTION_EDIT_WITH_SUMMARY : FeedProvider::ARTICLE_SECTION_EDIT_WITH_SUMMARY;
					$item['summary'] = $result['comment'];
				} else if($param == MyHome::sectionEditWithOutSummary) {
					$item['type'] = Namespace::isTalk($result['ns']) ? FeedProvider::TALK_PAGE_SECTION_EDIT_WITHOUT_SUMMARY : FeedProvider::ARTICLE_SECTION_EDIT_WITHOUT_SUMMARY;
					$item['section'] = substr($result['rc_params'], 4);
				}
			}
			return $item;
		}

		if($result['ns'] == NS_USER || $result['ns'] == NS_USER_TALK) {
			$item['url'] = $title->getLocalUrl();
			$item['diff'] = $title->getLocalUrl('diff='.$result['revid'].'&oldid='.$result['old_revid']);
			$item['title'] = $title->getPrefixedText();
			if($result['comment'] == '') {
				$item['type'] = Namespace::isTalk($result['ns']) ? FeedProvider::USER_TALK_EDIT_WITHOUT_SUMMARY : FeedProvider::USER_EDIT_WITHOUT_SUMMARY;
			} else {
				$item['type'] = Namespace::isTalk($result['ns']) ? FeedProvider::USER_TALK_EDIT_WITH_SUMMARY : FeedProvider::USER_EDIT_WITH_SUMMARY;
				$item['summary'] = $result['comment'];
			}
			if($item['type'] != FeedProvider::USER_TALK_EDIT_WITH_SUMMARY && $this->mode == FeedProvider::ACTIVITY_MODE) {
				return;
			}
			return $item;
		}

		if($result['ns'] == NS_IMAGE && $this->mode == FeedProvider::WATCHLIST_MODE) {
			$item['diff'] = $title->getLocalUrl('diff='.$result['revid'].'&oldid='.$result['old_revid']);
			$item['url'] = $title->getLocalUrl();
			$item['title'] = $title->getText();
			$item['type'] = FeedProvider::FILE_EDIT;
			return $item;
		}

		if($result['ns'] == NS_VIDEO && $this->mode == FeedProvider::WATCHLIST_MODE) {
			$item['diff'] = $title->getLocalUrl('diff='.$result['revid'].'&oldid='.$result['old_revid']);
			$item['url'] = $title->getLocalUrl();
			$item['title'] = $title->getPrefixedText();
			$item['type'] = FeedProvider::VIDEO_EDIT;
			return $item;
		}

		if($result['ns'] == NS_BLOG_ARTICLE) {
			$item['diff'] = $title->getLocalUrl('diff='.$result['revid'].'&oldid='.$result['old_revid']);
			$item['url'] = $title->getLocalUrl();
			$item['title'] = end(explode('/', $result['title'], 2));
			if($result['comment'] == '') {
				$item['type'] = FeedProvider::BLOG_EDIT_WITHOUT_SUMMARY;
				return null;
			} else {
				$item['type'] = FeedProvider::BLOG_EDIT_WITH_SUMMARY;
				$item['summary'] = $result['comment'];
			}
			return $item;
		}

		if(($result['ns'] == NS_TEMPLATE || $result['ns'] == NS_MEDIAWIKI) && $this->mode == FeedProvider::WATCHLIST_MODE) {
			$item['diff'] = $title->getLocalUrl('diff='.$result['revid'].'&oldid='.$result['old_revid']);
			$item['url'] = $title->getLocalUrl();
			$item['title'] = $title->getPrefixedText();
			if($result['comment'] == '') {
				$item['type'] = FeedProvider::TEMPLATE_OR_MEDIAWIKI_EDIT_WITHOUT_SUMMARY;
			} else {
				$item['type'] = FeedProvider::TEMPLATE_OR_MEDIAWIKI_EDIT_WITH_SUMMARY;
				$item['summary'] = $result['comment'];
			}
			return $item;
		}
	}

	public function filterNew($result, $title) {
		global $wgContentNamespaces;
		$item = array();

		if(in_array($result['ns'], $wgContentNamespaces)
			|| $result['ns'] == NS_PROJECT
			|| $result['ns'] == NS_CATEGORY
			|| in_array(($result['ns']-1), $wgContentNamespaces)
			|| ($result['ns']-1) == NS_PROJECT
			|| ($result['ns']-1) == NS_CATEGORY) {
			$item['url'] = $title->getLocalUrl();
			$item['title'] = $title->getPrefixedText();
			$item['intro'] = $result['rc_params'];
			if(Namespace::isTalk($result['ns'])) {
				$item['type'] = FeedProvider::NEW_TALK_PAGE;
			} else {
				$item['type'] = FeedProvider::NEW_ARTICLE;
			}
			return $item;
		}

		if($result['ns'] == NS_BLOG_ARTICLE) {
			$item['url'] = $title->getLocalUrl();
			$item['title'] = end(explode('/', $result['title'], 2));
			$item['intro'] = $result['rc_params'];
			$item['type'] = FeedProvider::NEW_BLOG_POST;
			return $item;
		}

		if($result['ns'] == NS_BLOG_ARTICLE_TALK) {
			$item['url'] = Title::newFromText($title->getBaseText(), NS_BLOG_ARTICLE)->getLocalUrl();
			$item['title'] = implode('/', array_slice(explode('/', $result['title']), 1, -1));
			$item['intro'] = $result['rc_params'];
			$item['type'] = FeedProvider::NEW_BLOG_COMMENT;
			return $item;
		}

		if($result['ns'] == 400) {
			$video = new VideoPage( $title );
			$video->load();
			$item['thumbnail'] = $video->getThumbnailCode(150, false);
			$item['url'] = $title->getLocalUrl();
			$item['title'] = $title->getPrefixedText();
			$item['type'] = FeedProvider::NEW_VIDEO;
			return $item;
		}

		if($result['ns'] == NS_BLOG_LISTING && $this->mode == FeedProvider::WATCHLIST_MODE) {
			$item['url'] = Title::newFromText($title->getBaseText(), NS_BLOG_ARTICLE)->getLocalUrl();
			$item['title'] = $result['title'];
			$item['type'] = FeedProvider::NEW_BLOG_LISTING;
			return $item;
		}
	}

	public function filterLog($result) {
		if($result['logtype'] == 'upload') {
			if($title = Title::newFromText($result['title'])) {
				if($file = $this->getFile($title, $result['timestamp'])) {
					$item['thumbnail'] =  $file->getThumbnail(150)->toHtml();
					$item['url'] = $title->getLocalUrl();
					$item['title'] = $title->getText();
					if($result['logaction'] == 'overwrite') {
						$item['type'] = FeedProvider::FILE_OVERWRITE;
					} else {
						$item['type'] = FeedProvider::FILE_UPLOAD;
					}
					return $item;
				}
			}
		}
	}

}