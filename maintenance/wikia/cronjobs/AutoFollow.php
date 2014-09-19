<?php

require_once( dirname(__FILE__) . '/../../commandLine.inc' );

$alreadyWatchedKey = 'autowatched-already';

$dbr = wfGetDB( DB_SLAVE, array(), $wgExternalSharedDB );

$range = date( 'Ymd', strtotime( '-30 days' ) ) . '000000';

$res = $dbr->select( '`user`', 'user_id', array( 'user_registration >= ' . $range ) );

$titlesToWatch = array();
$textsToWatch = array(
	'Blog:Wikia Staff Blog',
);

foreach ( $textsToWatch as $text ) {
	$titlesToWatch[] = Title::newFromText( $text );
}

while ( $row = $dbr->fetchRow( $res ) ) {
	$user = User::newFromId( $row['user_id'] );

	if ( !is_object( $user ) ) {
		continue;
	}

	if ( $user->getOption( $alreadyWatchedKey ) == 1 ) {
		continue;
	}

	if ( $user->getOption( 'language' ) != 'en' ) {
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

	foreach ( $titlesToWatch as $title ) {
		echo "Watching {$title->getText()} as {$user->getName()}...\n";
		WatchAction::doWatch( $title, $user );
	}

	$user->setOption( $alreadyWatchedKey, 1 );
	$user->saveSettings();
}
