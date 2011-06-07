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

$dir = dirname(__FILE__);

// WikiaApp
$app = F::app();

// autoloaded classes
// $app->registerClass( 'GoogleAnalyticsSampling', "$dir/GoogleAnalyticsSampling.body.php" );
$app->registerClass( 'GoogleAnalyticsSamplingController', "$dir/GoogleAnalyticsSamplingController.class.php" );
