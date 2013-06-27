<?php

/**
 * This filter blocks questions (articles) from being displayed
 * in a number of outputs (widgets, lists, tag-generated listings).
 *
 * It does not block those articles from being created.
 *
 * Note: works only on Answers-type wikis
 */

class PhalanxAnswersBlock extends WikiaObject {
	function __construct() {
		parent::__construct();
		F::setInstance( __CLASS__, $this );
	}
	
	public function badWordsTest( $title ) {
		wfProfileIn( __METHOD__ );
		global $wgLanguageCode;

		$phalanxModel = new PhalanxContentModel( $title, $wgLanguageCode );
		$ret = $phalanxModel->match_question_title();
		
		wfProfileOut( __METHOD__ );
		return $ret;
	}
}
