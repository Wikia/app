<?php
if ( !defined( 'MEDIAWIKI' ) ) {
	exit(1);
}
/**
 * Simple edit counter for small wikis
 *
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 */

$wgExtensionCredits['specialpage'][] = array(
	'path' => __FILE__,
	'name' => 'Count Edits',
	'author' => 'Rob Church',
	'description' => '[[Special:CountEdits|Special page]] that counts user edits and provides a top-ten contributor list',
	'descriptionmsg' => 'countedits-desc',
	'url' => 'http://www.mediawiki.org/wiki/Extension:CountEdits',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['CountEdits'] = $dir . 'CountEdits.i18n.php';
$wgExtensionAliasesFiles['CountEdits'] = $dir . 'CountEdits.alias.php';
$wgAutoloadClasses['SpecialCountEdits'] = $dir . 'CountEdits.page.php';
$wgSpecialPages['CountEdits'] = 'SpecialCountEdits';

/**
 * Should we show the "most active contributors" list?
 * This could be expensive for larger wikis
 */
$wgCountEditsMostActive = true;
