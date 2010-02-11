<?php

class HotSpotsRenderer extends FeedRenderer {

	public function __construct() {
		parent::__construct('hot-spots');
	}

	public function render($data) {
		wfProfileIn(__METHOD__);

		$this->template->set('data', $data);
		$content = $this->template->render('hot.spots');
		$content = $this->wrap($content, false);

		wfProfileOut(__METHOD__);
		return $content;
	}
}
