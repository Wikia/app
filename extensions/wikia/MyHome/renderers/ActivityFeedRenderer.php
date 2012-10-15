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
		return wfTimeFormatAgoOnlyRecent($stamp);
	}
}
