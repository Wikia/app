<?php

class AskYourQuestionController extends WikiaController {

	public function executeRailModule() {
		$this->loginToUse = !$this->wg->User->isAllowed( 'ask-questions' );
	}

	public function executeModalWindow() {
		$this->specialPageLink = Title::makeTitle(NS_SPECIAL, 'CreateQuestion')->getLocalURL();
	}

}
