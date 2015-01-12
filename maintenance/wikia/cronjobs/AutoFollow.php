<?php

require_once( dirname(__FILE__) . '/../../commandLine.inc' );

global $wgCityId;

$contentLanguage = WikiFactory::getVarValueByName( 'wgLanguageCode', $wgCityId );

echo "Starting procedure for a wikia in {$contentLanguage}...";

$alreadyWatchedKey = 'autowatched-already';

$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );

$range = date( 'Ymd', strtotime( '-30 days' ) ) . '000000';

$res = $dbr->select( '`user`', 'user_id', array( 'user_registration >= ' . $range ) );

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

$reason = '';

while ( $row = $dbr->fetchRow( $res ) ) {
	if ( !empty( $reason ) ) {
		echo "User not added to watchlist: {$reason}\n";
	}

	$user = User::newFromId( $row['user_id'] );

	if ( !is_object( $user ) ) {
		$reason = "Cannot create an object from ID {$row['user_id']}\n";
		continue;
	}

	if ( $user->getOption( $alreadyWatchedKey ) == 1 ) {
		$reason = "User {$row['user_id']} already on watchlist\n";
		continue;
	}

	// Include dialects like pt-br
	$userLanguage = substr( $user->getOption( 'language' ), 0, 2 );
	if ( $userLanguage != $contentLanguage ) {
		$reason = "There is no blog in {$userLanguage} for user {$row['user_id']}\n";
		continue;
	}

	if ( $user->getOption( 'marketingallowed' ) != 1 ) {
		$reason = "User {$row['user_id']} does not allow marketing\n";
		continue;
	}

	if ( !$user->isEmailConfirmed() ) {
		$reason = "User {$row['user_id']} hasn't confirmed his email\n";
		continue;
	}

	if ( $user->getEditCount() == 0 ) {
		$reason = "User {$row['user_id']} has 0 edits\n";
		continue;
	}

	foreach ( $textsToWatch[$contentLanguage] as $text ) {
		$titlesToWatch[] = Title::newFromText( $text );
	}

	foreach ( $titlesToWatch as $title ) {
		if ( $title instanceof Title ) {
			echo "Watching {$title->getText()} in {$contentLanguage} as {$user->getName()}...\n";
			WatchAction::doWatch( $title, $user );
		}
	}

	$reason = '';

	$user->setOption( $alreadyWatchedKey, 1 );
	$user->saveSettings();
}
