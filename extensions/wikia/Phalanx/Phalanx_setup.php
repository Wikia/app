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
$wgAutoloadClasses['BadWordsBlock'] = $dir.'blocks/BadWordsBlock.class.php';
$wgAutoloadClasses['FilterWordsBlock'] = $dir.'blocks/FilterWordsBlock.class.php';
$wgAutoloadClasses['AWCCreationBlock'] = $dir.'blocks/AWCCreationBlock.class.php';

$wgExtensionMessagesFiles['Phalanx'] = $dir . 'Phalanx.i18n.php';

$wgExtensionFunctions[] = 'efPhalanxInit';

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

	// former TitleBlackList (TYPE_TITLE)
	$wgHooks['SpecialMovepageBeforeMove'][] = 'TitleBlock::beforeMove';
	$wgHooks['EditFilter'][] = 'TitleBlock::listCallback';
	$wgHooks['ApiCreateMultiplePagesBeforeCreation'][] = 'TitleBlock::newWikiBuilder';
	$wgHooks['CreateDefaultQuestionPageFilter'][] = 'TitleBlock::genericTitleCheck';

	// former BadWords list (TYPE_ANSWERS_QUESTION)
	$wgHooks['CreateDefaultQuestionPageFilter'][] = 'BadWordsBlock::badWordsTest';

	// former FilterWords list (TYPE_ANSWERS_WORDS)
	$wgHooks['DefaultQuestion::filterWordsTest'][] = 'FilterWordsBlock::filterWordsTest';

	// former TextRegex (TYPE_WIKI_CREATION)
	$wgHooks['AutoCreateWiki::checkBadWords'][] = 'AWCCreationBlock::isAllowedText';
}
