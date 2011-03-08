<?php
class FounderEmailsModule extends Module {

	var $language;
	var $msgParams;

	public function executeIndex() {
		global $wgRequest;
		$day = $wgRequest->getVal('day', 'DayZero');
		$this->previewBody = wfRenderModule("FounderEmails", $day, array('language' => 'en'));
		$this->previewBody = strtr($this->previewBody, array('$FOUNDERNAME' => 'WEB TESTING'));
	}

	public function executeDayZero($params) {
		$this->language = $params['language'];
	}

}