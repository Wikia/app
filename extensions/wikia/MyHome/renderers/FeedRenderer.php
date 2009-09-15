<?php

class FeedRenderer {

	// icon types definition - this value will be used as CSS class name
	const FEED_SUN_ICON = 'sun';
	const FEED_PENCIL_ICON = 'pencil';
	const FEED_TALK_ICON = 'talk';
	const FEED_PHOTO_ICON = 'photo';
	const FEED_FILM_ICON = 'film';
	const FEED_COMMENT_ICON = 'comment';
	const FEED_MOVE_ICON = 'move';
	const FEED_DELETE_ICON = 'delete';

	protected $template;
	protected $type;

	public function __construct($type) {
		global $wgStylePath;

		$this->type = $type;

		$this->template = new EasyTemplate(dirname(__FILE__) . '/../templates');

		$this->template->set_vars(array(
			'assets' => array(
				'blank' => $wgStylePath . '/monobook/blank.gif',
			),
			'type' => $this->type,
		));
	}

	/*
	 * Add header and wrap feed HTML
	 */
	public function wrap($content, $showMore = true) {
		$this->template->set_vars(array(
			'content' => $content,
			'defaultSwitch' => $this->renderDefaultSwitch(),
			'showMore' => $showMore,
			'type' => $this->type,
		));
		return $this->template->execute('feed.wrapper');
	}

	public function render($data, $wrap = true) {
		wfProfileIn(__METHOD__);

		$this->template->set('data', $data['results']);

		// handle message to be shown when given feed is empty
		if (empty($data['results'])) {
			$this->template->set('emptyMessage', wfMsg("myhome-{$this->type}-feed-empty"));
		}

		// render feed
		$content = $this->template->execute('feed');

		// add header and wrap
		if (!empty($wrap)) {
			// show "more" link?
			$showMore = isset($data['query-continue']);

			// store timestamp for next entry to fetch when "more" is requested
			if ($showMore) {
				$content .= "\t<script type=\"text/javascript\">MyHome.fetchSince.{$this->type} = '{$data['query-continue']}';</script>\n";
			}

			$content = $this->wrap($content, $showMore);

		}
		wfProfileOut(__METHOD__);

		return $content;
	}

	/*
	 * Return HTML of default view switch for activity / watchlist feed
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	private function renderDefaultSwitch() {

		// only add switch to activity / watchlist feed
		$feeds = array('activity', 'watchlist');

		if ( !in_array($this->type, $feeds)) {
			return '';
		}

		// check current default view
		$defaultView = MyHome::getDefaultView();

		if ($defaultView == $this->type) {
			return '';
		}

		// render checkbox with label
		$html = '';
		$html .= Xml::openElement('div', array(
			'id' => 'myhome-feed-switch-default',
			'class' => 'accent',
		));
		$html .= Xml::element('input', array(
			'id' => 'myhome-feed-switch-default-checkbox',
			'type' => 'checkbox',
			'name' => $this->type,
			'disabled' => 'true'
		));
		$html .= Xml::element('label', array(
			'for' => 'myhome-feed-switch-default-checkbox'
		), wfMsg('myhome-default-view-checkbox', wfMsg("myhome-{$this->type}-feed")));
		$html .= Xml::closeElement('div');

		return $html;
	}

	/*
	 * Return action of given row (edited / created / ...)
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	public static function getActionLabel($row) {
		wfProfileIn(__METHOD__);

		switch($row['type']) {
			case 'new':
				switch($row['ns']) {
					// blog post
					case 500:
						$msgType = 'posted';
						break;

					// blog comment
					case 501:
						$msgType = 'comment';
						break;

					// content NS
					default:
						$msgType = 'created';
				}
				break;

			case 'delete':
				$msgType = 'deleted';
				break;

			case 'move':
				$msgType = 'moved';
				break;

			default:
				$msgType = 'edited';
		}

		$res = wfMsg("myhome-feed-{$msgType}-by", self::getUserPageLink($row))  . ' ';

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
		global $wgLang;

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
		else if ($ago < 30 * 86400) {
			// Under 30 days: to the day (5 days ago)
			$res = wfMsgExt('myhome-days-ago', array('parsemag'), floor($ago / 86400));
		}
		else if ($ago < 365 * 86400) {
			// Under 365 days: date, with no year (July 26)
			$pref = $wgLang->dateFormat(true);
			if($pref == 'default' || !isset($wgLang->dateFormats["$pref date"])) {
				$pref = $wgLang->defaultDateFormat;
			}
			//remove year from user's date format
			$format = trim($wgLang->dateFormats["$pref date"], ' ,yY');
			$res = $wgLang->sprintfDate($format, wfTimestamp(TS_MW, $stamp));
		}
		else {
			// Over 365 days: date, with a year (July 26, 2008)
			$res = $wgLang->date(wfTimestamp(TS_MW, $stamp));
		}

		wfProfileOut(__METHOD__);

		return $res;
	}

	/*
	 * Returns intro which should be no more than 150 characters.
	 * The cut off ends with an ellipsis (...), coming after the last whole word.
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	public static function formatIntro($intro) {
		wfProfileIn(__METHOD__);

		// remove newlines
		$intro = str_replace("\n", ' ', $intro);

		if (mb_strlen($intro) == 150) {
			// find last space in intro
			$last_space = strrpos($intro, ' ');

			if ($last_space > 0) {
				$intro = substr($intro, 0, $last_space) . wfMsg('ellipsis');
			}
		}

		wfProfileOut(__METHOD__);

		return $intro;
	}

	/*
	 * Returns one row for details section (Label: content)
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	public static function formatDetailsRow($type, $content, $encodeContent = true, $count = false) {
		wfProfileIn(__METHOD__);

		if (is_numeric($count)) {
			$msg = wfMsgExt("myhome-feed-{$type}-details", array('parsemag'), $count);
		}
		else {
			$msg = wfMsg("myhome-feed-{$type}-details");
		}

		$html = Xml::openElement('tr', array('class' => 'myhome-feed-details-row'));
		$html .= Xml::openElement('td', array('class' => 'myhome-feed-details-label'));
		$html .= Xml::element('em', array('class' => 'dark_text_2'), $msg);
		$html .= ': ';
		$html .= Xml::closeElement('td');
		$html .= Xml::openElement('td');
		$html .= $encodeContent ? htmlspecialchars($content) : $content;
		$html .= Xml::closeElement('td');
		$html .= Xml::closeElement('tr');

		// indent
		$html = "\n\t\t\t{$html}";

		wfProfileOut(__METHOD__);

		return $html;
	}

	/*
	 * Returns <a> tag pointing to user page
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	public static function getUserPageLink($row) {
		return $row['user'];
	}

	/*
	 * Returns <a> tag with an image pointing to diff page
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	public static function getDiffLink($row) {
		if (empty($row['diff'])) {
			return '';
		}

		global $wgExtensionsPath;

		$html = Xml::openElement('a', array(
			'class' => 'myhome-diff',
			'href' => $row['diff'],
			'title' => wfMsg('myhome-feed-diff-alt'),
			'rel' => 'nofollow',
		));
		$html .= Xml::element('img', array(
			'src' => $wgExtensionsPath . '/wikia/MyHome/images/diff.png',
			'width' => 16,
			'height' => 16,
			'alt' => 'diff',
		));
		$html .= Xml::closeElement('a');

		return ' ' . $html;
	}

	/*
	 * Returns icon type for given row
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	public static function getIconType($row) {

		if (!isset($row['type'])) {
			return false;
		}

		wfProfileIn(__METHOD__);

		$type = false;

		switch($row['type']) {
			case 'new':
				switch($row['ns']) {
					// blog post
					case 500:
						$type = self::FEED_SUN_ICON;
						break;

					// blog comment
					case 501:
						$type = self::FEED_COMMENT_ICON;
						break;

					// content NS
					default:
						$type = Namespace::isTalk($row['ns']) ? self::FEED_TALK_ICON : self::FEED_SUN_ICON;
				}
				break;

			case 'edit':
				// edit done from editor
				if (empty($row['viewMode'])) {
					// talk pages
					if (Namespace::isTalk($row['ns'])) {
						$type = self::FEED_TALK_ICON;
					}
					// content pages
					else {
						$type = self::FEED_PENCIL_ICON;
					}
				}
				// edit from view mode
				else {
					// category added
					if (!empty($row['new_categories'])) {
						$type = self::FEED_PENCIL_ICON;
					}
					// image(s) added
					else if (!empty($row['new_images'])) {
						$type =self::FEED_PHOTO_ICON;
					}
					// video(s) added
					// TODO: uncomment when video cpde is fixed
					else /*if (!empty($row['new_videos'])) */{
						$type = self::FEED_FILM_ICON;
					}
				}
				break;

			case 'delete':
				$type = self::FEED_DELETE_ICON;
				break;

			case 'move':
			case 'redirect':
				$type = self::FEED_MOVE_ICON;
				break;

			case 'upload':
				$type = self::FEED_PHOTO_ICON;
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
	public static function getDetails($row) {
		wfProfileIn(__METHOD__);

		$html = '';

		//
		// let's show everything we have :)
		//

		if (isset($row['to_title']) && isset($row['to_url'])) {
			$html .= self::formatDetailsRow('move', Xml::element('a', array('href' => $row['to_url']), $row['to_title']), false);
		}

		// intro of new content
		if (isset($row['intro'])) {
			// new blog post
			if (defined('NS_BLOG_ARTICLE') && $row['ns'] == NS_BLOG_ARTICLE) {
				$html .= self::formatDetailsRow('new-blog-post', self::formatIntro($row['intro']));
			}
			// blog comment
			else if (defined('NS_BLOG_ARTICLE_TALK') && $row['ns'] == NS_BLOG_ARTICLE_TALK) {
				$html .= self::formatDetailsRow('new-blog-comment', self::formatIntro($row['intro']));
			}
			// another new content
			else {
				$html .= self::formatDetailsRow('new-page', self::formatIntro($row['intro']));
			}
		}

		// section name
		if (isset($row['section'])) {
			$html .= self::formatDetailsRow('section-edit', $row['section']);
		}

		// edit summary (don't show auto summary and summaries added by tools using edit from view mode)
		if (isset($row['comment']) && trim($row['comment']) != '' && !isset($row['autosummaryType']) && !isset($row['viewMode'])) {
			global $wgUser;
			$html .= self::formatDetailsRow('summary', $wgUser->getSkin()->formatComment($row['comment']), false);
		}

		// added categories
		if (isset($row['new_categories'])) {
			$categories = array();

			// list of comma separated categories
			foreach($row['new_categories'] as $cat) {
				$link = Title::newFromText($cat, NS_CATEGORY)->getLocalUrl();
				$categories[] = Xml::element('a', array('href' => $link), str_replace('_', ' ', $cat));
			}

			$html .= self::formatDetailsRow('inserted-category', implode(', ', $categories), false, count($categories));
		}

		// added image(s)
		$html .= self::getAddedMediaRow($row, 'images');

		// added video)s)
		$html .= self::getAddedMediaRow($row, 'videos');

		wfProfileOut(__METHOD__);

		return $html;
	}

	/*
	 * Returns row with added images / videos
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	public static function getAddedMediaRow($row, $type) {
		$key = "new_{$type}";

		if (empty($row[$key])) {
			return '';
		}

		wfProfileIn(__METHOD__);

		$thumbs = array();

		foreach($row[$key] as $item) {
			// offset from the top of thumbnail cell (160x160px)
			$topOffset = round(160/2 -$item['height']/2);

			$thumb = substr($item['html'], 0, -2) . "style=\"padding-top: {$topOffset}px\"/>";

			// wrapper for thumbnail
			$attribs = array(
				'class' => ($type == 'videos') ? 'myhome-video-thumbnail' :  'myhome-image-thumbnail',
				'title' => ($type == 'videos' ? 'Video:' : 'File:') . $item['name'],
				'rel' => 'nofollow',
			);

			// add "play" overlay for videos
			if ($type == 'videos') {
				$thumb .= Xml::element('span', array('class' => 'myhome-video-play'), ' ');
			}

			$html = Xml::openElement('li') . Xml::openElement('a', $attribs) . $thumb . Xml::closeElement('a') . Xml::closeElement('li');

			// indent
			$html = "\n\t\t\t\t\t{$html}";

			$thumbs[] = $html;
		}

		// render thumbs
		$html = Xml::openElement('ul', array('class' => 'myhome-feed-inserted-media reset')) . implode('', $thumbs) . "\n\t\t\t\t" . Xml::closeElement('ul');

		// indent
		$html = "\n\t\t\t\t{$html}";

		// wrap them
		$html = self::formatDetailsRow($type == 'images' ? 'inserted-image' : 'inserted-video', $html, false, count($thumbs));

		wfProfileOut(__METHOD__);

		return $html;
	}
}
