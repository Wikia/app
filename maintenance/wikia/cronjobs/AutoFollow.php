<?php

require_once( dirname(__FILE__) . '/../../commandLine.inc' );

global $wgLanguageCode;

$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
$range = date( 'Ymd', strtotime( '-30 days' ) ) . '000000';
$res = $dbr->select( '`user`', 'user_id', [ 'user_registration >= ' . $range ], __METHOD__ );

$alreadyWatchedKey = 'autowatched-already';

$titlesToWatch = [];
$textsToWatch = [
	'de' => ['Blog:Wikia_Deutschland_News'],
	'en' => ['Blog:Wikia Staff Blog'],
	'es' => ['Blog:Comunidad'],
	'fi' => ['Blogi:Wikia-uutiset'],
	'fr' => ['Blog:Actualité_Wikia'],
	'it' => ['Blog:Blog_ufficiale_di_Wikia_Italia'],
	'ja' => ['ブログ:ウィキアスタッフブログ'],
	'nl' => ['Blog:Staff_blogs'],
	'pl' => ['Blog:Wikia News'],
	'pt' => ['Blog:Notícias_da_Wikia'],
	'ru' => ['Блог:Все_сообщения'],
	'uk' => ['Блог:Все_сообщения'],
	'zh' => ['博客:社区中心博客'],
];

/**
 * This handles languages like uk which doesn't have its own
 * community wikia to run the script at.
 * @var Array
 */
$languageAliases = [
	'uk' => 'ru',
];

while ( $row = $dbr->fetchRow( $res ) ) {

	$user = User::newFromId( $row['user_id'] );

	if ( !is_object( $user ) ) {
		continue;
	}

	if ( $user->getGlobalFlag( $alreadyWatchedKey ) == 1 ) {
		continue;
	}

	$userLanguage = strtolower( $user->getGlobalPreference( 'language' ) );
	// Include dialects like pt-br
	$userLanguageSplit = explode( '-', $userLanguage );
	$userLanguage = $userLanguageSplit[0];
	// Check for aliases
	if ( isset( $languageAliases[$userLanguage] ) ) {
		$userLanguage = $languageAliases[$userLanguage];
	}

	if ( $userLanguage != $wgLanguageCode ) {
		continue;
	}

	if ( $user->getGlobalPreference( 'marketingallowed' ) != 1 ) {
		continue;
	}

	if ( !$user->isEmailConfirmed() ) {
		continue;
	}

	if ( $user->getEditCount() == 0 ) {
		continue;
	}

	foreach ( $textsToWatch[$wgLanguageCode] as $text ) {
		$titlesToWatch[] = Title::newFromText( $text );
	}

	$status = false;
	foreach ( $titlesToWatch as $title ) {
		$logParams = [
			'user_id' => $row['user_id'],
			'user_name' => $user->getName(),
			'user_lang' => $userLanguage,
			'title' => $title->getPrefixedText(),
		];
		if ( $title instanceof Title ) {
			WatchAction::doWatch( $title, $user );
			$status = true;

			\Wikia\Logger\WikiaLogger::instance()->info( "AutoFollow: User {$user->getName()} added to watchlist of {$title->getPrefixedText()}.", $logParams );
		} else {
			// Log error to check for typos etc. Can be deleted when tested in production enviroment.
			\Wikia\Logger\WikiaLogger::instance()->error( "AutoFollow: Invalid article name in {$userLanguage}", $logParams );
		}
	}

	if ( $status ) {
		$user->setGlobalFlag( $alreadyWatchedKey, 1 );
		$user->saveSettings();
	}
}
