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

$dir = dirname(__FILE__) . '/';
$wgAutoloadClasses['Paginator']	= $dir . 'Paginator.body.php';
$wgExtensionMessagesFiles['Paginator'] = $dir . 'i18n/Paginator.i18n.php';

