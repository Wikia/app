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
	
	public function executeDayThree($params) {
		$this->language = $params['language'];
	}
	
	public function executeDayTen($params) {
		$this->language = $params['language'];
	}
	
	public static function localMsg($key) {
		$text = null;
	
		if ( !empty( $language ) ) {
			// custom lang translation
			$text = wfMsgExt( $key, array( 'language' => $language ) );
		}
	
		if ( $text == null ) {
			$text = wfMsg( $key );
		}
	
		return $text;
	}

}