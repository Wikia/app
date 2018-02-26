<?php

// override some variables
$wgDefaultSkin = 'oasis';

// ask a question box
$wgAutoloadClasses['WikiAnswersController'] = dirname( __FILE__ ) . '/WikiAnswersController.class.php';

// i18n
$wgExtensionMessagesFiles['WikiAnswers'] = dirname( __FILE__ ) . '/WikiAnswers.i18n.php';

// add CSS
$wgHooks['BeforePageDisplay'][] = 'wfWikiAnswersAddStyle';
// make "rephrase" action a default
$wgHooks['MenuButtonIndexAfterExecute'][] = 'wfWikiAnswersActionDropdown';
// append question mark to the title
$wgHooks['OutputPageParserOutput'][] = 'wfWikiAnswersPageTitle';
// show the answer box
$wgHooks['OutputPageBeforeHTML'][] = 'wfWikiAnswersAnswerBox';

$wgResourceModules['ext.wikiAnswers'] = [
	'scripts' => [ 'ext.wikiAnswers.js' ],
	'styles' => [ 'ext.wikiAnswers.css' ],
	'dependencies' => [ 'mediawiki.api' ],
	'messages' => [ 'ellipsis' ],

	'localBasePath' => __DIR__ . '/modules',
	'remoteExtPath' => 'wikia/WikiAnswers'
];

/**
 * @param OutputPage $out
 * @param $skin
 * @return bool
 */
function wfWikiAnswersAddStyle( OutputPage $out, Skin $skin ): bool {
	$out->addModules( 'ext.wikiAnswers' );
	return true;
}

function wfWikiAnswersActionDropdown( WikiaDispatchableObject $moduleObject, array $params ): bool {
	$title = $moduleObject->getContext()->getTitle();
	$answerObj = Answer::newFromTitle( $title );

	if( WikiaPageType::isMainPage() ) {
		$moduleObject->action = null;
	} elseif( $answerObj->isQuestion() && !$answerObj->isArticleAnswered() ) {
		if( isset( $moduleObject->dropdown['move'] ) ) {
			$moduleObject->action = $moduleObject->dropdown['move'];
			$moduleObject->actionName = 'move';
			unset( $moduleObject->dropdown['move'] );
		}
	}
	return true;
}

/**
 * @param OutputPage $out
 * @param ParserOutput $parserOutput
 * @return bool
 */
function wfWikiAnswersPageTitle( OutputPage $out, ParserOutput $parserOutput ): bool {
	$answerObj = Answer::newFromTitle( $out->getTitle() );
	if ( $answerObj->isQuestion() ) {
		$parserOutput->setTitleText( $parserOutput->getTitleText() . $out->msg( '?' )->text() );
	}

	return true;
}

/**
 * @param OutputPage $out
 * @param string $html
 * @return bool
 */
function wfWikiAnswersAnswerBox( OutputPage $out, string &$html ): bool {

	$answerObj = Answer::newFromTitle( $out->getTitle() );
	if( $answerObj->isQuestion() &&
	    in_array( ucfirst(Answer::getSpecialCategory("unanswered")), $out->getCategories() ) ) {
		$out->addJsConfigVars( 'wgIsUnansweredQuestion', true );
		$html = F::app()->getView( 'WikiAnswers', 'AnswerBox' )->render();
	}
	return true;
}
