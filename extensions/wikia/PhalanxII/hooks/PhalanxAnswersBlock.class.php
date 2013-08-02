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

	/**
	 * Hook handler for CreateDefaultQuestionPageFilter hook
	 * @see extensions/wikia/Answers/PrefilledDefaultQuestion.php#L15
	 * @see extensions/wikia/Answers/DefaultQuestion.php#L50
	 *
	 * @static
	 *
	 * @param Title $title -- instance of Title class
	 *
	 * @return Bool -- is word bad or not
	 */
	static public function badWordsTest( $title ) {
		wfProfileIn( __METHOD__ );

		$language = RequestContext::getMain()->getLanguage();

		$phalanxModel = new PhalanxContentModel( $title, $language->getCode() );
		$ret = $phalanxModel->match_question_title();

		wfProfileOut( __METHOD__ );
		return $ret;
	}
}
