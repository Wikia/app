<?php

class UserContributionsRenderer extends FeedRenderer {

	public function __construct() {
		parent::__construct('user-contributions');
	}

	public function render($data, $wrap = true) {
		wfProfileIn(__METHOD__);

		$this->template->set('data', $data);

		// render feed
		$content = $this->template->render('user.contributions');

		// add header and wrap
		if (!empty($wrap)) {
			$content = $this->wrap($content, false);
		}

		wfProfileOut(__METHOD__);

		return $content;
	}

	/*
	 * Returns icon type for given action type
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	public static function getIconType($item) {
		wfProfileIn(__METHOD__);

		$type = false;

		if (MWNamespace::isTalk($item['namespace'])) {
			wfProfileOut(__METHOD__);
			return self::FEED_TALK_ICON;
		}

		if (defined('NS_BLOG_ARTICLE_TALK') && $item['namespace'] == NS_BLOG_ARTICLE_TALK) {
			wfProfileOut(__METHOD__);
			return self::FEED_COMMENT_ICON;
		}
		//video namespace
		if ($item['namespace'] == 400) {
			wfProfileOut(__METHOD__);
			return self::FEED_FILM_ICON;
		}

		switch($item['type']) {
			case 'upload':
				$type = self::FEED_PHOTO_ICON;
				break;
			default:
				$type = $item['new'] == '1' ? self::FEED_SUN_ICON : self::FEED_PENCIL_ICON;
		}

		wfProfileOut(__METHOD__);

		return $type;
	}
}