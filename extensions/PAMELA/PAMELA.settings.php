<?php

/**
 * File defining the settings for the PAMELA extension.
 * More info can be found at http://www.mediawiki.org/wiki/Extension:PAMELA#Settings
 *
 *                          NOTICE:
 * Changing one of these settings can be done by copying or cutting it,
 * and placing it in LocalSettings.php, AFTER the inclusion of PAMELA.
 *
 * @since 0.1
 *
 * @file PAMELA.settings.php
 * @ingroup PAMELA
 *
 * @licence GNU GPL v3
 * @author Jeroen De Dauw < jeroendedauw@gmail.com >
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

# The location of the PAMELA webservice read API.
$egPamAPIURL = '';

# The interval between refreshes of data in the widgets, in milliseconds.
$egPamRefreshInterval = 60000;
