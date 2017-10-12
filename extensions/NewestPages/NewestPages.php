<?php
if ( ! defined( 'MEDIAWIKI' ) )
    die();

/**
 * Special page to show the last X pages added to the wiki
 * This doesn't use recent changes so the items don't expire
 *
 * @file
 * @ingroup Extensions
 * @author Rob Church <robchur@gmail.com>
 * @copyright © 2006 Rob Church
 * @licence GNU General Public Licence 2.0
 */

$wgExtensionCredits['specialpage'][] = array(
	'path'           => __FILE__,
	'name'           => 'Newest Pages',
	'version'        => '1.9',
	'author'         => 'Rob Church',
	'url'            => 'https://www.mediawiki.org/wiki/Extension:Newest_Pages',
	'descriptionmsg' => 'newestpages-desc',
);

$wgNewestPagesLimit = 50;

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['NewestPages'] = $dir . 'NewestPages.i18n.php';
$wgExtensionMessagesFiles['NewestPagesAlias'] = $dir . 'NewestPages.alias.php';
$wgAutoloadClasses['NewestPages'] = $dir . 'NewestPages.page.php';
$wgSpecialPages['NewestPages'] = 'NewestPages';
