<?php

class WatchlistFeedRenderer extends FeedRenderer {

	public function __construct() {
		parent::__construct('watchlist');
	}

	public function render($data, $wrap = true) {
		wfProfileIn(__METHOD__);

		$content = parent::render($data, $wrap);

		// add header and wrap
		if (!empty($wrap)) {
			// get timestamp of last entry
			$last_entry = end($data);

			// substract one second so we fetch next item
			$last_timestamp = strtotime($last_entry['timestamp']);
			$last_timestamp = wfTimestamp(TS_ISO_8601, $last_timestamp - 1);

			$content .= "<script type=\"text/javascript\">MyHome.fetchSince.{$this->type} = '{$last_timestamp}';</script>";
		}

		wfProfileOut(__METHOD__);

		return $content;
	}
}
