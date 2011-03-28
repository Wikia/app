<?php
class WikiaTriviaModule extends Module {

	/*
	 * full html page
	 */
	public function executeIndex() {
	}
	
	/**
	 * ajax
	 */
	public function executeSendChoice() {
		global $wgRequest;
		$wgRequest->getVal('quizid');
		$wgRequest->getVal('questionid');
		$wgRequest->getVal('choice');
	}
	
	/**
	 * ajax helper
	 */
	public function executeAnswer(){
	}

}