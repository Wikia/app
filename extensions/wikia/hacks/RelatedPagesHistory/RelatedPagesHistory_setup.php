<?php
/**
 *
 * @package MediaWiki
 * @subpackage RelatedPagesHistory
 * @author Jakub Kurcek
 *
 */

if(!defined('MEDIAWIKI')) {
	exit(1);
}

if ( !defined('MEDIAWIKI') ) {
	echo "This is a MediaWiki extension.\n";
	exit(1);
}

$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['RelatedPagesHistory']	= $dir . 'RelatedPagesHistory.class.php';
$wgHooks['BeforePageDisplay'][] = 'RelatedPagesHistory::onBeforePageDisplay';


