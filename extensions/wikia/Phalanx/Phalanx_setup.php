<?php

$wgExtensionCredits['other'][] = array(
	'name' => 'Phalanx',
	'description' => 'Integrated spam control mechanism',
	'description-msg' => 'phalanx-description',
	'author' => array(
		'[http://community.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]',
		'[http://community.wikia.com/wiki/User:Macbre Maciej Brencz]',
		'[http://community.wikia.com/wiki/User:TOR Lucas \'TOR\' Garczewski]',
		'Bartek Łapiński',
	)
);

// users immune to Phalanx
$wgAvailableRights[] = 'phalanxexempt';

$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['Phalanx'] = $dir.'Phalanx.class.php';

$wgAutoloadClasses['UserBlock'] = $dir.'blocks/UserBlock.class.php';
$wgAutoloadClasses['ContentBlock'] = $dir.'blocks/ContentBlock.class.php';
$wgAutoloadClasses['TitleBlock'] = $dir.'blocks/TitleBlock.class.php';
$wgAutoloadClasses['QuestionTitleBlock'] = $dir.'blocks/QuestionTitleBlock.class.php';
$wgAutoloadClasses['RecentQuestionsBlock'] = $dir.'blocks/RecentQuestionsBlock.class.php';
$wgAutoloadClasses['WikiCreationBlock'] = $dir.'blocks/WikiCreationBlock.class.php';

$wgExtensionMessagesFiles['Phalanx'] = $dir . 'Phalanx.i18n.php';

$wgExtensionFunctions[] = 'efPhalanxInit';

// log type
global $wgLogTypes, $wgLogNames, $wgLogHeaders, $wgLogActions;
$wgLogTypes[]                       = 'phalanx';
$wgLogNames['phalanx']              = 'phalanx-rule-log-name';
$wgLogHeaders['phalanx']            = 'phalanx-rule-log-header';
$wgLogRestrictions['phalanx']       = 'phalanx';
$wgLogActions['phalanx/add']        = 'phalanx-rule-log-add';
$wgLogActions['phalanx/edit']       = 'phalanx-rule-log-edit';
$wgLogActions['phalanx/delete']     = 'phalanx-rule-log-delete';


function efPhalanxInit() {
	global $wgUser, $wgHooks;

	// don't bother initializing hooks if user is immune to Phalanx
	if ( $wgUser->isAllowed( 'phalanxexempt' ) ) {
		wfDebug(__METHOD__.": user has 'phalanxexempt' right - no block will be applied\n");
		return;
	}

	// former RegexBlock (TYPE_USER)
	$wgHooks['GetBlockedStatus'][] = 'UserBlock::blockCheck';

	// former SpamRegex (TYPE_SUMMARY and TYPE_CONTENT)
	$wgHooks['EditFilter'][] = 'ContentBlock::onEditFilter';
	$wgHooks['AbortMove'][] = 'ContentBlock::onAbortMove';
	$wgHooks['ProblemReportsContentCheck'][] = 'ContentBlock::genericContentCheck';

	// former TitleBlackList (TYPE_TITLE)
	$wgHooks['SpecialMovepageBeforeMove'][] = 'TitleBlock::beforeMove';
	$wgHooks['EditFilter'][] = 'TitleBlock::listCallback';
	$wgHooks['ApiCreateMultiplePagesBeforeCreation'][] = 'TitleBlock::newWikiBuilder';
	$wgHooks['CreateDefaultQuestionPageFilter'][] = 'TitleBlock::genericTitleCheck';
	$wgHooks['CreatePageTitleCheck'][] = 'TitleBlock::genericTitleCheck';

	// former BadWords list (TYPE_ANSWERS_QUESTION_TITLE)
	$wgHooks['CreateDefaultQuestionPageFilter'][] = 'QuestionTitleBlock::badWordsTest';

	// former FilterWords list (TYPE_ANSWERS_RECENT_QUESTIONS)
	$wgHooks['DefaultQuestion::filterWordsTest'][] = 'RecentQuestionsBlock::filterWordsTest';

	// former TextRegex (TYPE_WIKI_CREATION)
	$wgHooks['AutoCreateWiki::checkBadWords'][] = 'WikiCreationBlock::isAllowedText';
}
