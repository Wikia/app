<?php

class LatestQuestionsModule extends Module {

	var $wgLatestQuestionsHeader;

	public function executePlaceholder() {
		$this->wgLatestQuestionsHeader = wfMsg('latest-questions-header');
	}

}
