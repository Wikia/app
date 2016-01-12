<?php

// override some variables
$wgDefaultSkin = 'oasis';

// ask a question box
$wgAutoloadClasses['WikiAnswersController'] = dirname( __FILE__ ) . '/WikiAnswersController.class.php';

// i18n
$wgExtensionMessagesFiles['WikiAnswers'] = dirname( __FILE__ ) . '/WikiAnswers.i18n.php';

// add CSS
$wgHooks['BeforePageDisplay'][] = 'wfWikiAnswersAddStyle';
// remove Follow link on the main page
$wgHooks['FooterMenuAfterExecute'][] = 'wfWikiAnswersFooterMenu';
// replace create-a-wiki link with a create-answers-wiki link
$wgHooks['GlobalHeaderIndexAfterExecute'][] = 'wfWikiAnswersGlobalHeaderIndex';
// make "rephrase" action a default
$wgHooks['MenuButtonIndexAfterExecute'][] = 'wfWikiAnswersActionDropdown';
// append question mark to the title
$wgHooks['OutputPageParserOutput'][] = 'wfWikiAnswersPageTitle';
// show the answer box
$wgHooks['OutputPageBeforeHTML'][] = 'wfWikiAnswersAnswerBox';

/**
 * @param OutputPage $out
 * @param $skin
 * @return bool
 */
function wfWikiAnswersAddStyle( &$out, &$skin ) {
	global $wgExtensionsPath;
	$out->addExtensionStyle( "$wgExtensionsPath/wikia/WikiAnswers/WikiAnswers.css" );
	return true;
}

function wfWikiAnswersFooterMenu( &$moduleObject, &$params ) {
	if( WikiaPageType::isMainPage() ) {
		foreach( $moduleObject->items as $idx=>$item ) {
			if( $item['type'] == 'follow' ) {
				unset( $moduleObject->items[$idx] );
				break;
			}
		}
	}
	return true;
}

function wfWikiAnswersGlobalHeaderIndex( &$moduleObject, &$params) {
	/* @var $wgLang Language */
	global $wgLang;
	$userlang = $wgLang->getCode();
	$userlang = $userlang == 'en' ? '' : "?uselang=$userlang";
	$moduleObject->createWikiUrl = "http://www.wikia.com/Special:CreateWiki$userlang";
	$moduleObject->createWikiText = wfMsgHtml('createwikipagetitle');
	return true;
}

function wfWikiAnswersActionDropdown( &$moduleObject, &$params) {
	global $wgTitle;
	$answerObj = Answer::newFromTitle( $wgTitle );
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
function wfWikiAnswersPageTitle( &$out, $parserOutput ) {
	$answerObj = Answer::newFromTitle( $out->getTitle() );
	if( $answerObj->isQuestion() ) {
		$parserOutput->setTitleText( $parserOutput->getTitleText() . wfMsg('?') );
	}
	return true;
}

/**
 * @param OutputPage $out
 * @param string $html
 * @return bool
 */
function wfWikiAnswersAnswerBox( &$out, &$html ) {

	$answerObj = Answer::newFromTitle( $out->getTitle() );
	if( $answerObj->isQuestion() &&
	    in_array( ucfirst(Answer::getSpecialCategory("unanswered")), $out->getCategories() ) ) {
		$html = F::app()->getView( 'WikiAnswers', 'AnswerBox' )->render();
	}
	return true;
}
