<?php

class SpecialFinishCreate extends UnlistedSpecialPage {

	public function __construct() {
		parent::__construct('FinishCreate', 'finishcreate');
	}
	
	public function execute( $par ) {
		global $wgUser, $wgOut;
		wfProfileIn( __METHOD__ );
		
		if ( wfReadOnly() ) {
			$wgOut->readOnlyPage();
			wfProfileOut(__METHOD__);
			return;
		}
		
		if (!$wgUser->isAllowed('finishcreate')) {
			$this->displayRestrictionError();
			wfProfileOut( __METHOD__ );
			return;
		}
		
		//Module::get('FinishCreateWiki', 'FinishCreate')->getData();
		F::app()->sendRequest('FinishCreateWiki', 'FinishCreate');
		
		wfProfileOut( __METHOD__ );
	}

}
