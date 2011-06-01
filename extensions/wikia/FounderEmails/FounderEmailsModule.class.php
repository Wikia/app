<?php
class FounderEmailsModule extends Module {

	var $language;
	var $msgParams;

	public function executeIndex() {
		global $wgRequest;
		$day = $wgRequest->getVal('day');
		$type = $wgRequest->getVal('type');
		if(!empty($day)){
			$this->previewBody = wfRenderModule("FounderEmails", $day, array('language' => 'en'));
			$this->previewBody = strtr($this->previewBody, 
				array('$FOUNDERNAME' => 'WEB TESTING',
					'$UNIQUEVIEWS' => '6')
			);
		} else if(!empty($type)) {
			$this->previewBody = wfRenderModule("FounderEmails", "GeneralUpdate", 
				array('type' => $type, 
					'language' => 'en', 
					'$PAGEURL' => 'http://www.wikia.com',
					'$USERTALKPAGEURL' => 'http://www.wikia.com'
					)
				);
			$this->previewBody = strtr($this->previewBody, 
				array('$FOUNDERNAME' => 'WEB TESTING',
					'$UNIQUEVIEWS' => '6',
					)
			);
		}
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
	
	/**
	 * General Entry point for Event emails
	 * 
	 * @requestParam String type which set of messages to use
	 * 
	 * types so far are: 
	 * user-registered
	 * anon-edit
	 * general-edit
	 * first-edit
	 * lot-happening
	 * views-digest
	 * complete-digest
	 * 
	 */
	public function executeGeneralUpdate($params) {
		$type = $params['type'];
		$this->greeting = wfMsg('founderemails-email-'.$type.'-greeting');
		$this->headline = wfMsg('founderemails-email-'.$type.'-headline');
		$this->content = wfMsg('founderemails-email-'.$type.'-content');
		$this->signature = wfMsg('founderemails-email-'.$type.'-signature');
		$this->button = wfMsg('founderemails-email-'.$type.'-button');
		//$this->buttonUrl = 'http://www.wikia.com';
		if (isset($params['$PAGEURL'])) {
			$this->buttonUrl = $params['$PAGEURL'];
		}
		switch($type) {
			case 'user-registered':
				$this->buttonUrl = $params['$USERTALKPAGEURL'];
				break;
			case 'anon-edit':
				break;
			case 'general-edit':
				break;
			case 'first-edit':
				break;
			case 'lot-happening':
				$this->buttonUrl = $params['$MYHOMEURL'];
				break;
			case 'views-digest':
				break;
			case 'complete-digest':
				break;
			default:
				break;
		}
	}
}
