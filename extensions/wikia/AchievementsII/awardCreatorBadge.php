<?php
include '../../../maintenance/commandLine.inc';

//
// Michał Roszka (Mix) <michal@wikia-inc.com>
// 
// IMPORTANT: The script might look too verbose.
// The point of the extra verbosity is to investigate the BugId:10474.
//

//
// Step 1 of 3: load a wiki based on SERVER_ID
//

echo "Step 1 of 3: trying to load a wiki based on SERVER_ID.\n";

$wiki = WikiFactory::getWikiById( $wgCityId );

// Force WikiFactory::getWikiById() to query DB_MASTER if needed.
if ( !is_object( $wiki ) ) {
    echo "Step 1 of 3: first attempt to load a wiki failed, querying DB_MASTER.\n";
    $wiki = WikiFactory::getWikiById( $wgCityId, true );
}

if ( !is_object( $wiki ) ) {
    echo "Not a valid wiki. Aborting.\n";
    exit( 1 );
}

echo "Step 1 of 3: wiki has been loaded.\n";

//
// Step 2 of 3: load a User object corresponding to the founder of the wiki
//

echo "Step 2 of 3: trying to load a User object corresponding to the founder of the wiki.\n";

$user = User::newFromId( $wiki->city_founding_user );

// User::newFromId always returns an instance of User class so the load() call without any checks is safe.
$user->load();

if ( 0 == $user->getId() ) {
    echo "Not a valid user. Aborting.\n";
    exit( 1 );
}

echo "Step 2 of 3: a User object has been loaded.\n";

//
// Step 3 of 3: give the founder a BADGE_CREATOR badge.
//

echo "Step 3 of 3: checking for the AchAwardingService class.\n";

if ( !class_exists( 'AchAwardingService' ) ) {
	echo "Achievements not enabled. Aborting.\n";
	exit( 1 );
}

echo "Step 3 of 3: creating an object of the AchAwardingService class.\n";
$achService = new AchAwardingService();

echo "Step 3 of 3: giving the founder a BADGE_CREATOR badge.\n";
$achService->awardCustomNotInTrackBadge( $user, BADGE_CREATOR );

echo "Creator badge awarded!\n";
exit( 0 );