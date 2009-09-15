<?php

class ActivityFeedRenderer extends FeedRenderer {

	public function __construct() {
		parent::__construct('activity');
	}

	/*
	 * Return formatted timestamp
	 *
	 * @author Maciej Brencz <macbre@wikia-inc.com>
	 */
	public static function formatTimestamp($stamp) {
		wfProfileIn(__METHOD__);
		global $wgContLang;

		$ago = time() - strtotime($stamp) + 1;

		if ($ago < 7 * 86400 ) {
			$res = parent::formatTimestamp($stamp);
		}
		else {
			$res = '';
		}

		wfProfileOut(__METHOD__);

		return $res;
	}
}
