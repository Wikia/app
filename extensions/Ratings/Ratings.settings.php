<?php

/**
 * File defining the settings for the Ratings extension.
 * More info can be found at http://www.mediawiki.org/wiki/Extension:Ratings#Settings
 *
 *                          NOTICE:
 * Changing one of these settings can be done by copieng or cutting it,
 * and placing it in LocalSettings.php, AFTER the inclusion of this extension.
 *
 * @file Ratings.Settings.php
 * @ingroup Ratings
 *
 * @licence GNU GPL v3 or above
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

# When a user is not allowed to rate, show the rating stars (disabled) or not?.
$egRatingsShowWhenDisabled = true;

# Users that can rate.
$wgGroupPermissions['*']['rate'] = true;

# Set to true to invalidate the cache of pages when a vote for them is made.
$egRatingsInvalidateOnVote = false;

# Include a summary by default above ratings?
$egRatingsIncSummary = false;