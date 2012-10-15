<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	exit(1);
}
/**
 * Simple edit counter for small wikis
 *
 * @file
 * @ingroup Extensions
 * @author Rob Church <robchur@gmail.com>
 */

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Count Edits',
	'author' => 'Rob Church',
	'descriptionmsg' => 'countedits-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:CountEdits',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['CountEdits'] = $dir . 'CountEdits.i18n.php';
$wgExtensionMessagesFiles['CountEditsAlias'] = $dir . 'CountEdits.alias.php';
$wgAutoloadClasses['SpecialCountEdits'] = $dir . 'CountEdits.page.php';
$wgSpecialPages['CountEdits'] = 'SpecialCountEdits';

/**
 * Should we show the "most active contributors" list?
 * This could be expensive for larger wikis
 */
$wgCountEditsMostActive = true;
