<?php

$wgExtensionCredits['other'][] = array(
	'name' => 'Phalanx',
	'description' => 'Integrated spam control mechanism',
	'descriptionmsg' => 'phalanx-desc',
	'author' => array(
		'[http://community.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]',
		'[http://community.wikia.com/wiki/User:Macbre Maciej Brencz]',
		'[http://community.wikia.com/wiki/User:TOR Lucas \'TOR\' Garczewski]',
		'Bartek Łapiński',
		'[http://community.wikia.com/wiki/User:Grunny Daniel Grunwell (Grunny)]',
		'Władysław Bodzek',
	)
);

// users immune to Phalanx
$wgAvailableRights[] = 'phalanxexempt';

define( "PHALANX_VERSION",  1 );

$dir = dirname(__FILE__) . '/';

$wgAutoloadClasses['Phalanx'] = $dir.'Phalanx.class.php';
$wgAutoloadClasses['UserBlock'] = $dir.'blocks/UserBlock.class.php';
$wgAutoloadClasses['UserCookieBlock'] = $dir.'blocks/UserCookieBlock.class.php';
$wgAutoloadClasses['ContentBlock'] = $dir.'blocks/ContentBlock.class.php';
$wgAutoloadClasses['TitleBlock'] = $dir.'blocks/TitleBlock.class.php';
$wgAutoloadClasses['QuestionTitleBlock'] = $dir.'blocks/QuestionTitleBlock.class.php';
$wgAutoloadClasses['RecentQuestionsBlock'] = $dir.'blocks/RecentQuestionsBlock.class.php';
$wgAutoloadClasses['WikiCreationBlock'] = $dir.'blocks/WikiCreationBlock.class.php';

$wgExtensionMessagesFiles['Phalanx'] = $dir . 'Phalanx.i18n.php';

$wgExtensionFunctions[] = 'efPhalanxInit';

// Phalanx traffic shoadowing
$wgAutoloadClasses['PhalanxShadowing'] = $dir.'PhalanxShadowing.class.php';
$wgAutoloadClasses['PhalanxService'] = $dir.'services/PhalanxService.class.php';

// log type
global $wgLogTypes, $wgLogNames, $wgLogHeaders, $wgLogActions;
$wgLogTypes[]                       = 'phalanx';
$wgLogNames['phalanx']              = 'phalanx-rule-log-name';
$wgLogHeaders['phalanx']            = 'phalanx-rule-log-header';
$wgLogRestrictions['phalanx']       = 'phalanx';
$wgLogActions['phalanx/add']        = 'phalanx-rule-log-add';
$wgLogActions['phalanx/edit']       = 'phalanx-rule-log-edit';
$wgLogActions['phalanx/delete']     = 'phalanx-rule-log-delete';

$wgLogTypes[]                       = 'phalanxemail';
$wgLogNames['phalanxemail']         = 'phalanx-email-rule-log-name';
$wgLogHeaders['phalanxemail']       = 'phalanx-email-rule-log-header';
$wgLogRestrictions['phalanxemail']  = 'phalanxemailblock';
$wgLogActions['phalanxemail/add']   = 'phalanx-rule-log-add';
$wgLogActions['phalanxemail/edit']  = 'phalanx-rule-log-edit';
$wgLogActions['phalanxemail/delete'] = 'phalanx-rule-log-delete';

function efPhalanxInit() {
	global $wgUser, $wgHooks, $wgPhalanxDisableContent;

	// these need to be initialized for UI-level checks to work
	// former RegexBlock (TYPE_USER)
	$wgHooks['GetBlockedStatus'][] = 'UserBlock::blockCheck';
	$wgHooks['GetBlockedStatus'][] = 'UserCookieBlock::blockCheck';
	$wgHooks['EditPhalanxBlock'][] = 'ContentBlock::onEditPhalanxBlock';
	$wgHooks['DeletePhalanxBlock'][] = 'ContentBlock::onDeletePhalanxBlock';
	
	// don't bother initializing hooks if user is immune to Phalanx
	if ( $wgUser->isAllowed( 'phalanxexempt' ) ) {
		wfDebug(__METHOD__.": user has 'phalanxexempt' right - no block will be applied\n");
		return;
	}

	// allow for per wiki disable the content checks
		// (mainly for vstf wiki, causes pain when reporting block issues)
	if( empty($wgPhalanxDisableContent) ) {
		// former SpamRegex (TYPE_SUMMARY and TYPE_CONTENT)
		$wgHooks['EditFilter'][] = 'ContentBlock::onEditFilter';
		$wgHooks['AbortMove'][] = 'ContentBlock::onAbortMove';
	}

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

	// Websitewiki filter
	// @see exntesions/wikia/newsite
	$wgHooks['NewsiteCreationFilter'][] = 'TitleBlock::genericTitleCheck';

	// RT#93196 - prevent use of user2user email
	$wgHooks['UserCanSendEmail'][] = 'UserBlock::onUserCanSendEmail';

	// fb#5311 - prevent a phalanx blocked name from being created.
	$wgHooks['AbortNewAccount'][] = 'UserBlock::onAbortNewAccount';
	$wgHooks['cxValidateUserName'][] = 'UserBlock::onValidateUserName';
	
	// new PhalanxII hooks
	$wgHooks['CheckContent'][] = 'ContentBlock::onCheckContent';
	$wgHooks['SpamFilterCheck'][] = 'ContentBlock::onSpamFilterCheck';
}


// Hooked function
$wgHooks['ContributionsToolLinks'][] = 'efLoadPhalanxLink';

/**
 * Add a link to central:Special:Phalanx from Special:Contributions/USERNAME
 * if the user has 'phalanx' permission
 * @param $id Integer: user ID
 * @param $nt Title: user page title
 * @param $links Array: tool links
 * @return true
 */
function efLoadPhalanxLink( $id, $nt, &$links ) {
	global $wgUser;
	if( $wgUser->isAllowed( 'phalanx' ) ) {
		$links[] = RequestContext::getMain()->getSkin()->makeKnownLinkObj(
			GlobalTitle::newFromText('Phalanx', NS_SPECIAL, 177),
			'PhalanxBlock',
			wfArrayToCGI( array('type'=>'8', 'target'=>$nt->getText(), 'wpPhalanxCheckBlocker'=>$nt->getText() ) )
		);
	}
	return true;
}
