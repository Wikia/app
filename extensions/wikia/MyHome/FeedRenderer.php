<?php

class FeedRenderer {

	// icon types definition - this value will be used as CSS class name
	const FEED_SUN_ICON = 'sun';
	const FEED_PENCIL_ICON = 'pencil';
	const FEED_TALK_ICON = 'talk';
	const FEED_PHOTO_ICON = 'photo';
	const FEED_FILM_ICON = 'film';
	const FEED_COMMENT_ICON = 'comment';

	protected $template;
	protected $assets;
	protected $type;

	public function __construct($type) {
		global $wgStylePath;

		$this->template = new EasyTemplate(dirname(__FILE__) . '/templates');

		$this->assets = array(
			'blank' => $wgStylePath . '/monobook/blank.gif',
		);

		$this->type = $type;
	}

	/*
	 * Add header and wrap feed HTML
	 */
	public function wrap($content, $showMore = true) {
		$this->template->set_vars(array(
			'content' => $content,
			'showMore' => $showMore,
			'type' => $this->type,
		));
		return $this->template->execute('wrapper');
	}

	public function render($data, $wrap = true) {
		wfProfileIn(__METHOD__);

		$this->template->set_vars(array(
			'assets' => $this->assets,
			'data' => $data,
			'type' => $this->type,
		));

		// render feed
		$content = $this->template->execute('feed');

		// add header and wrap
		if (!empty($wrap)) {
			$content = $this->wrap($content);
		}

		wfProfileOut(__METHOD__);

		return $content;
	}

	public static function getActionLabel($row) {
		wfProfileIn(__METHOD__);

		if (isset($row['user'])) {
			switch($row['type']) {
				case FeedProvider::NEW_ARTICLE:
				case FeedProvider::NEW_TALK_PAGE:
				case FeedProvider::NEW_BLOG_LISTING:
					$msgType = 'created';
					break;

				case FeedProvider::FILE_UPLOAD:
				case FeedProvider::FILE_OVERWRITE:
				case FeedProvider::NEW_VIDEO:
					$msgType = 'added';
					break;

				case FeedProvider::NEW_BLOG_POST:
					$msgType = 'posted';
					break;

				case FeedProvider::NEW_BLOG_COMMENT:
					$msgType = 'comment';
					break;

				default:
					$msgType = 'edited';
			}
			$res = wfMsg("myhome-feed-{$msgType}-by", self::getUserPageLink($row))  . ' ';
		}
		else {
			$res = '';
		}

		wfProfileOut(__METHOD__);

		return $res;
	}

	/*
	 * Return formatted timestamp
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	public static function formatTimestamp($stamp) {
		wfProfileIn(__METHOD__);

		$ago = time() - strtotime($stamp) + 1;

		if ($ago < 60) {
			// Under 1 min: to the second (ex: 30 seconds ago)
			$res = wfMsgExt('myhome-seconds-ago', array('parsemag'), $ago);
		}
		else if ($ago < 3600) {
			// Under 1 hr: to the minute (3 minutes ago)
			$res = wfMsgExt('myhome-minutes-ago', array('parsemag'), floor($ago / 60));
		}
		else if ($ago < 86400) {
			// Under 24 hrs: to the hour (4 hours ago)
			$res = wfMsgExt('myhome-hours-ago', array('parsemag'), floor($ago / 3600));
		}
		else if ($ago < 7 * 86400) {
			// Under 7 days: to the day (5 days ago)
			$res = wfMsgExt('myhome-days-ago', array('parsemag'), floor($ago / 86400));
		}
		else {
			// More than 7 days: nothing
			$res = '';
		}

		wfProfileOut(__METHOD__);

		return $res;
	}

	/*
	 * Returns summary which should be no more than 150 characters.
	 * The cut off ends with an ellipsis (...), coming after the last whole word.
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	public static function formatSummary($summary) {
		wfProfileIn(__METHOD__);

		// remove newlines
		$summary = str_replace("\n", ' ', $summary);

		// find last space in summary
		$last_space = strrpos($summary, ' ');

		if ($last_space > 0) {
			$summary = substr($summary, 0, $last_space);
		}

		$summary = htmlspecialchars($summary) . '&hellip;';

		wfProfileOut(__METHOD__);

		return $summary;
	}

	/*
	 * Returns <a> tag pointing to user page
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	public static function getUserPageLink($row) {
		return Xml::element('a', array('href' => $row['userurl']), $row['user']);
	}

	/*
	 * Returns <a> tag with an image pointing to diff page
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	public static function getDiffPageLink($diff) {
		global $wgExtensionsPath;

		$html = Xml::openElement('a', array(
			'class' => 'myhome-diff',
			'href' => $diff,
		));
		$html .= Xml::element('img', array(
			'src' => $wgExtensionsPath . '/wikia/MyHome/images/diff.png',
			'width' => 16,
			'height' => 16,
			'alt' => 'diff',
		));
		$html .= Xml::closeElement('a');

		return $html;
	}

	/*
	 * Returns icon type for given action type
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	public static function getIconType($actionType) {
		wfProfileIn(__METHOD__);

		$type = false;

		switch($actionType) {
			case FeedProvider::NEW_ARTICLE:
			case FeedProvider::NEW_BLOG_POST:
			case FeedProvider::NEW_BLOG_LISTING:
				$type = self::FEED_SUN_ICON;
				break;

			case FeedProvider::ARTICLE_EDIT_WITH_SUMMARY:
			case FeedProvider::ARTICLE_EDIT_WITHOUT_SUMMARY:
			case FeedProvider::ARTICLE_SECTION_EDIT_WITH_SUMMARY:
			case FeedProvider::ARTICLE_SECTION_EDIT_WITHOUT_SUMMARY:
			case FeedProvider::FILE_EDIT:
			case FeedProvider::VIDEO_EDIT:
			case FeedProvider::BLOG_EDIT_WITH_SUMMARY:
			case FeedProvider::BLOG_EDIT_WITHOUT_SUMMARY:
			case FeedProvider::USER_EDIT_WITH_SUMMARY:
			case FeedProvider::USER_EDIT_WITHOUT_SUMMARY:
			case FeedProvider::TEMPLATE_OR_MEDIAWIKI_EDIT_WITH_SUMMARY:
			case FeedProvider::TEMPLATE_OR_MEDIAWIKI_EDIT_WITHOUT_SUMMARY:
				$type = self::FEED_PENCIL_ICON;
				break;

			case FeedProvider::NEW_TALK_PAGE:
			case FeedProvider::TALK_PAGE_EDIT_WITH_SUMMARY:
			case FeedProvider::TALK_PAGE_EDIT_WITHOUT_SUMMARY:
			case FeedProvider::TALK_PAGE_SECTION_EDIT_WITH_SUMMARY:
			case FeedProvider::TALK_PAGE_SECTION_EDIT_WITHOUT_SUMMARY:
			case FeedProvider::USER_TALK_EDIT_WITH_SUMMARY:
			case FeedProvider::USER_TALK_EDIT_WITHOUT_SUMMARY:
				$type = self::FEED_TALK_ICON;
				break;

			case FeedProvider::FILE_UPLOAD:
			case FeedProvider::FILE_OVERWRITE:
				$type = self::FEED_PHOTO_ICON;
				break;

			case FeedProvider::NEW_VIDEO:
				$type = self::FEED_FILM_ICON;
				break;

			case FeedProvider::NEW_BLOG_COMMENT:
				$type = self::FEED_COMMENT_ICON;
				break;
		}

		wfProfileOut(__METHOD__);

		return $type;
	}

	/*
	 * Returns 3rd row (with details) for given feed item
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	public static function getDetailsRow($row) {
		wfProfileIn(__METHOD__);

		$html = '';

		switch($row['type']) {
			// new article / talk page
			case FeedProvider::NEW_ARTICLE:
			case FeedProvider::NEW_TALK_PAGE:
				$html .= Xml::element('em', array(), wfMsg('myhome-feed-new-page-details'));
				$html .= ': ';
				$html .= self::formatSummary($row['intro']);
				break;

			// edit summary
			case FeedProvider::ARTICLE_EDIT_WITH_SUMMARY:
			case FeedProvider::ARTICLE_SECTION_EDIT_WITH_SUMMARY:
			case FeedProvider::TALK_PAGE_EDIT_WITH_SUMMARY:
			case FeedProvider::TALK_PAGE_SECTION_EDIT_WITH_SUMMARY:
			case FeedProvider::BLOG_EDIT_WITH_SUMMARY:
			case FeedProvider::USER_EDIT_WITH_SUMMARY:
			case FeedProvider::USER_TALK_EDIT_WITH_SUMMARY:
			case FeedProvider::TEMPLATE_OR_MEDIAWIKI_EDIT_WITH_SUMMARY:
				$html .= Xml::element('em', array(), wfMsg('myhome-feed-summary-details'));
				$html .= ': ';
				$html .= htmlspecialchars($row['summary']);

				$html .= self::getDiffPageLink($row['diff']);
				break;

			// just diff link
			case FeedProvider::ARTICLE_EDIT_WITHOUT_SUMMARY:
			case FeedProvider::TALK_PAGE_EDIT_WITHOUT_SUMMARY:
			case FeedProvider::FILE_EDIT:
			case FeedProvider::VIDEO_EDIT:
			case FeedProvider::BLOG_EDIT_WITHOUT_SUMMARY:
			case FeedProvider::USER_EDIT_WITHOUT_SUMMARY:
			case FeedProvider::USER_TALK_EDIT_WITHOUT_SUMMARY:
			case FeedProvider::TEMPLATE_OR_MEDIAWIKI_EDIT_WITHOUT_SUMMARY:
				$html .= self::getDiffPageLink($row['diff']);
				break;

			// section edit
			case FeedProvider::ARTICLE_SECTION_EDIT_WITHOUT_SUMMARY:
			case FeedProvider::TALK_PAGE_SECTION_EDIT_WITHOUT_SUMMARY:
				$html .= Xml::element('em', array(), wfMsg('myhome-feed-section-edit-details'));
				$html .= ': ';
				$html .= htmlspecialchars($row['section']);

				$html .= self::getDiffPageLink($row['diff']);
				break;

			// new blog post
			case FeedProvider::NEW_BLOG_POST:
				$html .= Xml::element('em', array(), wfMsg('myhome-feed-new-blog-post-details'));
				$html .= ': ';
				$html .= self::formatSummary($row['intro']);
				break;

			// new blog comment
			case FeedProvider::NEW_BLOG_COMMENT:
				$html .= Xml::element('em', array(), wfMsg('myhome-feed-new-blog-comment-details'));
				$html .= ': ';
				$html .= self::formatSummary($row['intro']);
				break;

			// video / image thumbnails
			case FeedProvider::FILE_UPLOAD:
			case FeedProvider::FILE_OVERWRITE:
			case FeedProvider::NEW_VIDEO:
				$attribs = array(
					'href' => $row['url'],
					'title' => str_replace(' ', '_', $row['title']),
				);

				if ($row['type'] == FeedProvider::NEW_VIDEO) {
					$attribs['class'] = 'myhome-video-thumbnail';
				} else {
					$attribs['class'] = 'myhome-image-thumbnail';
					$attribs['ref'] = strtotime($row['timestamp']);
				}

				$html .= Xml::openElement('a', $attribs);
				$html .= $row['thumbnail'];
				$html .= Xml::closeElement('a');
				break;
		}

		wfProfileOut(__METHOD__);

		return $html;
	}
}
