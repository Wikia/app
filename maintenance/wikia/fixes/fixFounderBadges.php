<?php

/*
 * written to retroactively award founders with BADGE_CREATOR
 *
 * @author tor
 */

include( '/usr/wikia/source/trunk/maintenance/commandLine.inc' );

if(class_exists(AchAwardingService)) {

	$wiki = WikiFactory::getWikiByDB( $wgDBname );
	if ( empty( $wiki ) ) {
		exit;
	}

	$founderId = $wiki->city_founding_user;

	if ( empty( $founderId ) ) {
		exit;
	}

	$founder = User::newFromId( $founderId );
	$founder->load();

	// get achievement to chek if it's there already
	$achService = new AchAwardingService();
	$achService->awardCustomNotInTrackBadge( $founder, BADGE_CREATOR );
}
