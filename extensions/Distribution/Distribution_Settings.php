<?php

/**
 * Settings file for the Deployment extension.
 * Extension documentation: http://www.mediawiki.org/wiki/Extension:Deployment
 *
 * @file Deployment_Settings.php
 * @ingroup Deployment
 *
 * @author Jeroen De Dauw
 * @author Chad Horohoe
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	die( 'Not an entry point.' );
}

$wgDistributionDownloads = 'http://www.mediawiki.org/wiki/Special:ExtensionDistributor';
$wgMWRSvnUrl = 'http://svn.wikimedia.org/svnroot/mediawiki/';
$wgMWRDownloadUrl = 'http://download.wikimedia.org/mediawiki/';