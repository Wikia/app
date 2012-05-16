<?php

// override some variables
$wgDefaultSkin = 'oasis';
$wgForceSkin = 'oasis';
$wgUseNewAnswersSkin = false;

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

function wfWikiAnswersAddStyle( &$out, &$skin ) {
	global $wgExtensionsPath, $wgStyleVersion;
	$out->addExtensionStyle( "$wgExtensionsPath/wikia/WikiAnswers/WikiAnswers.css?$wgStyleVersion" );
	return true;
}

function wfWikiAnswersFooterMenu( &$moduleObject, &$params ) {
	if( ArticleAdLogic::isMainPage() ) {
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
	global $wgLang;
	$userlang = $wgLang->getCode();
	$userlang = $userlang == 'en' ? '' : "?uselang=$userlang";
	$moduleObject->createWikiUrl = "http://www.wikia.com/Special:CreateAnswers$userlang";
	$moduleObject->createWikiText = wfMsgHtml('createwikipagetitle');
	return true;
}

function wfWikiAnswersActionDropdown( &$moduleObject, &$params) {
	global $wgTitle;
	$answerObj = Answer::newFromTitle( $wgTitle );
	if( ArticleAdLogic::isMainPage() ) {
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

function wfWikiAnswersPageTitle( &$out, $parserOutput ) {
	$answerObj = Answer::newFromTitle( $out->getTitle() );
	if( $answerObj->isQuestion() ) {
		$parserOutput->setTitleText( $parserOutput->getTitleText() . wfMsg('?') );
	}
	return true;
}

function wfWikiAnswersAnswerBox( &$out, &$html ) {

	$answerObj = Answer::newFromTitle( $out->getTitle() );
	if( $answerObj->isQuestion() &&
	    in_array( ucfirst(Answer::getSpecialCategory("unanswered")), $out->getCategories() ) ) {
		wfLoadExtensionMessages('WikiAnswers');
		$html = F::app()->getView( 'WikiAnswers', 'AnswerBox' )->render();
	}
	return true;
}
