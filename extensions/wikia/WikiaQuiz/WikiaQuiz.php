<?php

/**
 * This class represents a quiz: a set of WikiaQuizElements (question and answers)
 */

class WikiaQuiz {
	protected $name;

	const QUIZ_CATEGORY_PREFIX = 'Quiz ';

	static function newFromName($name) {

		$key = self::QUIZ_CATEGORY_PREFIX . $name;
		//@todo parse the category article specified by $key
		
//
//		$sDefinition = wfMsgForContent( $key );
//
//		// check if tour exists
//		if ( wfEmptyMsg( $key, $sDefinition ) ) {
//			return null;
//		}
//
//		$aDefinition = explode( "\n* ", $sDefinition );
		$quiz = new WikiaQuiz();
		$quiz->name = $name;
//		$oGuidedTour->setTitle( trim( array_shift( $aDefinition ), '* ' ) );
//		$oGuidedTour->setImageFromArticleText( array_shift( $aDefinition ) );
//		$oGuidedTour->setDescription( array_shift( $aDefinition ) );
//		$oGuidedTour->createStepsFromArray( $aDefinition );

		return $quiz;
	}
	
}
