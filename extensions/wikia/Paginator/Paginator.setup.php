<?php
if ( !defined('MEDIAWIKI') ) {
	echo "This is a MediaWiki extension.\n";
	exit(1);
}
/**
 *
 * @package MediaWiki
 * @subpackage Pagination
 * @author Jakub Kurcek
 *
 * To use this extension $wgEnablePaginatorExt = true
 */
 
$wgExtensionCredits[ 'other' ][ ] = array(
	'name' => 'Paginator',
	'author' => 'Jakub Kurcek',
	'descriptionmsg' => 'paginator-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/Paginator',
);

$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['Paginator']	= $dir . 'Paginator.body.php';
$wgExtensionMessagesFiles['Paginator'] = $dir . 'i18n/Paginator.i18n.php';

