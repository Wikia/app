<?php

include( '../../../maintenance/commandLine.inc' );

$user = User::newFromId( WikiFactory::getWikiById( $wgCityId )->city_founding_user );

if ( is_null( $user ) ) {
	echo "Not a valid user. Aborting.\n";
	exit(1);
}

$user->load();

if ( $user->getId() == 0 ) {
	echo "User does not exist. Aborting.\n";
	exit(1);
}

if ( !class_exists( 'AchAwardingService' ) ) {
	echo "Achievements not enabled. Aborting.\n";
	exit(1);
}

$achService = new AchAwardingService();
$achService->awardCustomNotInTrackBadge( $user, BADGE_CREATOR );

echo "Creator badge awarded!\n";
