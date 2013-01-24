<?php

$wgExtensionCredits['other'][] = array(
	'name' => 'Phalanx II',
	'description' => 'Integrated spam control mechanism',
	'descriptionmsg' => 'phalanx-desc',
	'author' => array(
		'[http://community.wikia.com/wiki/User:Marooned Maciej Błaszkowski (Marooned)]',
		'[http://community.wikia.com/wiki/User:Macbre Maciej Brencz]',
		'[http://community.wikia.com/wiki/User:TOR Lucas \'TOR\' Garczewski]',
		'Bartek Łapiński',
		'[http://community.wikia.com/wiki/User:Grunny Daniel Grunwell (Grunny)]',
		'Władysław Bodzek',
		'Piotr Molski (moli@wikia-inc.com)',
		'Krzysztof Krzyżaniak (eloy@wikia-inc.com)',
		'Maciej Szumocki (szumo@wikia-inc.com)'
	)
);

$dir = dirname(__FILE__) . '/';
$app = F::app();

$classes = array(
	/* controllers */ 
	'Phalanx'              => $dir . 'PhalanxController.class.php',
	/* models */
	'PhalanxModel'         => $dir . 'models/PhalanxModel.php',
	'PhalanxUserModel'     => $dir . 'models/PhalanxUserModel.php',
	'PhalanxContentModel'  => $dir . 'models/PhalanxContentModel.php',
	/* services */
	'PhalanxService'       => $dir . 'services/PhalanxService.class.php',
	/* hooks */
	'PhalanxUserBlock'     => $dir . 'hooks/PhalanxUserBlock.class.php',
	'UserCookieBlock'      => $dir . 'hooks/UserCookieBlock.class.php',
	'ContentBlock'	       => $dir . 'hooks/ContentBlock.class.php',
	'TitleBlock'	       => $dir . 'hooks/TitleBlock.class.php',
	'QuestionTitleBlock'   => $dir . 'hooks/QuestionTitleBlock.class.php',
	'RecentQuestionsBlock' => $dir . 'hooks/RecentQuestionsBlock.class.php',
	'WikiCreationBlock'    => $dir . 'hooks/WikiCreationBlock.class.php',
	'PhalanxHook'	       => $dir . 'hooks/PhalanxHook.class.php'
);

foreach ( $classes as $class_name => $class_path ) {
	$app->registerClass( $class_name, $class_path );
}

/*
 * hooks
 */
/* UserBlock */
$app->registerHook( 'GetBlockedStatus', 'PhalanxUserBlock', 'blockCheck' );
$app->registerHook( 'UserCanSendEmail', 'PhalanxUserBlock', 'userCanSendEmail' ); #RT#93196
$app->registerHook( 'AbortNewAccount', 'PhalanxUserBlock', 'abortNewAccount' ); #FB#5311
$app->registerHook( 'cxValidateUserName', 'PhalanxUserBlock', 'validateUserName' );
/* UserCookieBlock */
$app->registerHook( 'GetBlockedStatus', 'PhalanxUserCookieBlock', 'blockCheck' );
/* ContentBlock */
$app->registerHook( 'EditFilter', 'PhalanxContentBlock', 'editFilter' );
$app->registerHook( 'AbortMove', 'PhalanxContentBlock', 'abortMove' );
/* TitleBlock */
$app->registerHook( 'SpecialMovepageBeforeMove', 'TitleBlock', 'beforeMove' );
$app->registerHook( 'EditFilter', 'TitleBlock', 'listCallback' );
$app->registerHook( 'ApiCreateMultiplePagesBeforeCreation', 'TitleBlock', 'newWikiBuilder' );
$app->registerHook( 'CreateDefaultQuestionPageFilter', 'TitleBlock', 'genericTitleCheck' );
$app->registerHook( 'CreatePageTitleCheck', 'TitleBlock', 'genericTitleCheck' );
$app->registerHook( 'NewsiteCreationFilter', 'TitleBlock', 'genericTitleCheck' );
/* QuestionTitleBlock */
$app->registerHook( 'CreateDefaultQuestionPageFilter', 'QuestionTitleBlock', 'badWordsTest' );
/* RecentQuestionsBlock */
$app->registerHook( 'DefaultQuestion::filterWordsTest', 'RecentQuestionsBlock', 'filterWordsTest' );
/* WikiCreationBlock */
$app->registerHook( 'AutoCreateWiki::checkBadWords', 'WikiCreationBlock', 'isAllowedText' );
/* PhalanxHook */
$app->registerHook( 'ContributionsToolLinks', 'PhalanxHook', 'loadLinks' ); #efLoadPhalanxLink

/**
 * messages
 */
$app->registerExtensionMessageFile('Phalanx', $dir . 'Phalanx.i18n.php');

/*
 * globals, rights etc
 */
$wgLogTypes[]                       	= 'phalanx';
$wgLogTypes[]                       	= 'phalanxemail';

$wgLogNames['phalanx']              	= 'phalanx-rule-log-name';
$wgLogNames['phalanxemail']         	= 'phalanx-email-rule-log-name';

$wgLogHeaders['phalanx']            	= 'phalanx-rule-log-header';
$wgLogHeaders['phalanxemail']       	= 'phalanx-email-rule-log-header';

$wgLogRestrictions['phalanx']       	= 'phalanx';
$wgLogRestrictions['phalanxemail']  	= 'phalanxemailblock';

$wgLogActions['phalanx/add']        	= 'phalanx-rule-log-add';
$wgLogActions['phalanx/edit']       	= 'phalanx-rule-log-edit';
$wgLogActions['phalanx/delete']     	= 'phalanx-rule-log-delete';
$wgLogActions['phalanxemail/add']   	= 'phalanx-rule-log-add';
$wgLogActions['phalanxemail/edit']  	= 'phalanx-rule-log-edit';
$wgLogActions['phalanxemail/delete'] 	= 'phalanx-rule-log-delete';

$wgAvailableRights[] = 'phalanxexempt';
