<?php

$wgExtensionMessagesFiles['LatestQuestions'] = dirname(__FILE__) . '/LatestQuestions.i18n.php';
$wgExtensionFunctions[] = 'efLatestQuestionsInit';

$wgAutoloadClasses['LatestQuestionsController'] = dirname( __FILE__ ) . '/LatestQuestionsController.php';

if( empty( $wgAnswersServer ) ) {
	$wgAnswersServer = 'http://frag.wikia.com';
} else {
	$wgAnswersServer = trim( $wgAnswersServer, " /" );
}

if( empty( $wgAnswersScript ) ) {
	$wgAnswersScript = '/index.php';
}

function efLatestQuestionsInit() {
	global $wgLatestQuestionsOnlyForAnons, $wgUser, $wgHooks;
	if( empty( $wgLatestQuestionsOnlyForAnons ) || $wgUser->isAnon() ) {
		$wgHooks['AjaxAddScript'][] = 'wfLatestQuestionsAjaxAddScript';
		$wgHooks['GetRailModuleList'][] = 'wfLatestQuestionsAddModule';
		$wgHooks['MakeGlobalVariablesScript'][] = 'wfLatestQuestionsJSVariables';
	}
}

function wfLatestQuestionsAjaxAddScript( &$out ) {
	global $wgStyleVersion, $wgJsMimeType, $wgExtensionsPath;
	$out->addScript( "<script type=\"{$wgJsMimeType}\" src=\"{$wgExtensionsPath}/wikia/LatestQuestions/LatestQuestions.js?{$wgStyleVersion}\"></script>\n" );
	$out->addStyle( AssetsManager::getInstance()->getSassCommonURL('extensions/wikia/LatestQuestions/LatestQuestions.scss'));
	return true;
}

function wfLatestQuestionsAddModule( &$railModuleList ) {
	foreach( $railModuleList as $i => $m ) {
		if( $m[0] == 'LatestActivity' ) {
			$minKey = min( array_keys( $railModuleList ) );
			$railModuleList[ $minKey - 1 ] = array( 'LatestQuestions', 'Placeholder', null );
			break;
		}
	}
	return true;
}

function wfLatestQuestionsJSVariables( &$vars ) {
	global $wgAnswersServer, $wgAnswersScript;
	wfLoadExtensionMessages('LatestQuestions');
	$vars['wgAnswersServer'] = $wgAnswersServer;
	$vars['wgAnswersScript'] = $wgAnswersScript;
	$vars['wgLatestQuestionsHeader'] = wfMsg('latest-questions-header');
	$vars['wgOasisMoreMsg'] = wfMsg('oasis-more');
	return true;
}
