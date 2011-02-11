<?php

class SpecialFinishCreate extends UnlistedSpecialPage {

	public function __construct() {
		parent::__construct('FinishCreate', 'finishcreate');
	}
	
	public function execute() {
		global $wgUser, $wgOut, $wgExtensionsPath;
		wfProfileIn( __METHOD__ );
		
		if (!$wgUser->isAllowed('finishcreate')) {
			$this->displayRestrictionError();
			wfProfileOut( __METHOD__ );
			return;
		}
		
		Module::get('FinishCreateWiki', 'FinishCreate')->getData();
		
		wfProfileOut( __METHOD__ );
	}

}