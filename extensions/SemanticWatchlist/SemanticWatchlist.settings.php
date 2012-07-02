<?php

/**
 * File defining the settings for the Semantic Watchlist extension.
 * More info can be found at http://www.mediawiki.org/wiki/Extension:Semantic_Watchlist#Settings
 *
 *                          NOTICE:
 * Changing one of these settings can be done by copying or cutting it,
 * and placing it in LocalSettings.php, AFTER the inclusion of this extension.
 *
 * @file SemanticWatchlist.settings.php
 * @ingroup SemanticWatchlist
 *
 * @licence GNU GPL v3+
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

# Users that can use the semantic watchlist.
$wgGroupPermissions['*'            ]['semanticwatch'] = false;
$wgGroupPermissions['user'         ]['semanticwatch'] = true;
$wgGroupPermissions['autoconfirmed']['semanticwatch'] = true;
$wgGroupPermissions['bot'          ]['semanticwatch'] = false;
$wgGroupPermissions['sysop'        ]['semanticwatch'] = true;

# Users that can modify the watchlist groups via Special:WatchlistConditions
$wgGroupPermissions['*'            ]['semanticwatchgroups'] = false;
$wgGroupPermissions['user'         ]['semanticwatchgroups'] = false;
$wgGroupPermissions['autoconfirmed']['semanticwatchgroups'] = false;
$wgGroupPermissions['bot'          ]['semanticwatchgroups'] = false;
$wgGroupPermissions['sysop'        ]['semanticwatchgroups'] = true;
$wgGroupPermissions['swladmins'    ]['semanticwatchgroups'] = true;

# Enable email notification or not?
$egSWLEnableEmailNotify = true;

# Send an email for every change (as opossed to a "something changed email" for the first $egSWLMaxMails changes)?
$egSWLMailPerChange = true;

# The maximum amount of generic emails to send about changes untill the user actually checks his semantic watchlist.
$egSWLMaxMails = 1;

# The default value for the user preference to send email notifications.
$wgDefaultUserOptions['swl_email'] = true;

# The default value for the user preference to display a top link to the semantic watchlist.
$wgDefaultUserOptions['swl_watchlisttoplink'] = true;

# Enable displaying a top link to the semantic watchlist?
$egSWLEnableTopLink = true;

