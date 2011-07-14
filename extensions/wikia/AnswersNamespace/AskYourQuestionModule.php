<?php

class AskYourQuestionModule extends Module {

	var $loginToUse;
	var $specialPageLink;

	public function executeRailModule() {
		global $wgUser;
		$this->loginToUse = !$wgUser->isAllowed( 'ask-questions' );
	}

	public function executeModalWindow() {
		$this->specialPageLink = Title::makeTitle(NS_SPECIAL, 'CreateQuestion')->getLocalURL();
	}

}
