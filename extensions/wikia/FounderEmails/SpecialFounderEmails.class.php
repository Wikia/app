<?php

class SpecialFounderEmails extends UnlistedSpecialPage {

	public function __construct() {
		wfLoadExtensionMessages('FounderEmails');
		parent::__construct('FounderEmails', 'founderemails');
	}
	
	public function execute() {
		global $wgOut;
		wfProfileIn(__METHOD__);
		wfLoadExtensionMessages('FounderEmails');
		
		Wikia::setVar( 'OasisEntryControllerName', 'FounderEmails' );
		
		wfProfileOut(__METHOD__);
	}

}