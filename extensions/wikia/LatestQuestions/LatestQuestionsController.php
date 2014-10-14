<?php

class LatestQuestionsController extends WikiaController {

	public function executePlaceholder() {
		$this->wgLatestQuestionsHeader = wfMsg('latest-questions-header');
	}

}
