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
	'name' => 'Count Edits',
	'svn-date' => '$LastChangedDate: 2008-09-26 08:27:47 +0200 (ptk, 26 wrz 2008) $',
	'svn-revision' => '$LastChangedRevision: 41282 $',
	'author' => 'Rob Church',
	'description' => '[[Special:CountEdits|Special page]] that counts user edits and provides a top-ten contributor list',
	'descriptionmsg' => 'countedits-desc',
	'url' => 'http://www.mediawiki.wiki/wiki/Extesion:CountEdits',
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
