<?php

require_once( dirname(__FILE__) . '/../../commandLine.inc' );

global $wgCityId;
$contentLanguage = WikiFactory::getVarValueByName( 'wgLanguageCode', $wgCityId );

$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );
$range = date( 'Ymd', strtotime( '-30 days' ) ) . '000000';
$res = $dbr->select( '`user`', 'user_id', array( 'user_registration >= ' . $range ) );

$alreadyWatchedKey = 'autowatched-already';

$titlesToWatch = [];
$textsToWatch = [
	'en' => ['Blog:Wikia Staff Blog'],
	'pl' => ['Blog:Wikia News'],
	'zh' => ['博客:博客帖子'],
	'ja' => ['ブログ:ウィキアスタッフブログ'],
	'pt' => ['Blog_de_usuário:Macherie_ana'],
	'fr' => ['Blog:Actualité_Wikia'],
	'it' => ['Blog:Blog_ufficiale_di_Wikia_Italia'],
	'ru' => ['Блог:Все_сообщения'],
	'nl' => ['Blog:Staff_blogs'],
	'fi' => ['Blogi:Wikia-uutiset'],
	'de' => ['Blog:Wikia_Deutschland_News'],
	'es' => ['Blog:Comunidad'],
];

while ( $row = $dbr->fetchRow( $res ) ) {

	$user = User::newFromId( $row['user_id'] );

	if ( !is_object( $user ) ) {
		continue;
	}

	if ( $user->getOption( $alreadyWatchedKey ) == 1 ) {
		continue;
	}

	// Include dialects like pt-br
	$userLanguage = substr( $user->getOption( 'language' ), 0, 2 );
	if ( $userLanguage != $contentLanguage ) {
		continue;
	}

	if ( $user->getOption( 'marketingallowed' ) != 1 ) {
		continue;
	}

	if ( !$user->isEmailConfirmed() ) {
		continue;
	}

	if ( $user->getEditCount() == 0 ) {
		continue;
	}

	foreach ( $textsToWatch[$contentLanguage] as $text ) {
		$titlesToWatch[] = Title::newFromText( $text );
	}

	foreach ( $titlesToWatch as $title ) {
		$logParams = [
			'user_id' => $row['user_id'],
			'user_name' => $user->getName(),
			'user_lang' => $userLanguage,
			'title' => $title->getText(),
		];
		if ( $title instanceof Title ) {
			WatchAction::doWatch( $title, $user );
			\Wikia\Logger\WikiaLogger::instance()->info( "AutoFollow: User {$user->getName()} added to watchlist of {$title->getText()}.", $logParams );
		} else {
			// Log error to check for typos etc. Can be deleted when tested in production enviroment.
			\Wikia\Logger\WikiaLogger::instance()->error( "AutoFollow: Invalid article name in {$userLanguage}", $logParams );
		}
	}

	$user->setOption( $alreadyWatchedKey, 1 );
	$user->saveSettings();
}
