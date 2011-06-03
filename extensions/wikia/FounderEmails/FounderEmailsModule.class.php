<?php
class FounderEmailsModule extends Module {

	var $language;

	// This function is only used for testing / previewing / debugging the FounderEmails templates
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
			$executionType = $type == 'complete-digest' ? 'CompleteDigest' : 'GeneralUpdate';
			$this->previewBody = wfRenderModule("FounderEmails", $executionType, 
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
		$this->language = $params['language'];
		$this->greeting = wfMsgForContent('founderemails-email-'.$type.'-greeting');
		$this->headline = wfMsgForContent('founderemails-email-'.$type.'-headline');
		$this->content = wfMsgForContent('founderemails-email-'.$type.'-content');
		$this->signature = wfMsgForContent('founderemails-email-'.$type.'-signature');
		$this->button = wfMsgForContent('founderemails-email-'.$type.'-button');
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
	
	public function executeCompleteDigest($params) {
		$this->greeting = wfMsgForContent('founderemails-email-complete-digest-greeting');
		$this->headline = wfMsgForContent('founderemails-email-complete-digest-headline');
		$this->heading1 = wfMsgForContent('founderemails-email-complete-digest-content-heading1');
		$this->content1 = wfMsgForContent('founderemails-email-complete-digest-content1');
		$this->heading2 = wfMsgForContent('founderemails-email-complete-digest-content-heading2');
		$this->content2 = wfMsgForContent('founderemails-email-complete-digest-content2');
		$this->heading3 = wfMsgForContent('founderemails-email-complete-digest-content-heading3');
		$this->content3 = wfMsgForContent('founderemails-email-complete-digest-content3');
		$this->signature = wfMsgForContent('founderemails-email-complete-digest-signature');
		$this->button = wfMsgForContent('founderemails-email-complete-digest-button');
		$this->buttonUrl = $params['$PAGEURL'];
	}
}
