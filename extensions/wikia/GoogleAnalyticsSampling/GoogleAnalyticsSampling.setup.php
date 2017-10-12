<?php
/**
 *
 * @package MediaWiki
 * @subpackage GoogleAnalytics
 * @author Jakub Kurcek
 */

if ( !defined('MEDIAWIKI') ) {
	echo "This is a MediaWiki extension.\n";
	exit(1);
}

$wgExtensionCredits[ 'other' ][ ] = array(
	'name' => 'GoogleAnalyticsSampling',
	'author' => 'Wikia',
	'descriptionmsg' => 'google-analytics-sampling-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/GoogleAnalyticsSampling',
);

$dir = dirname(__FILE__);

//i18n

// WikiaApp
$app = F::app();

// autoloaded classes
// $wgAutoloadClasses[ 'GoogleAnalyticsSampling'] =  "$dir/GoogleAnalyticsSampling.body.php" ;
$wgAutoloadClasses[ 'GoogleAnalyticsSamplingController'] =  "$dir/GoogleAnalyticsSamplingController.class.php";

