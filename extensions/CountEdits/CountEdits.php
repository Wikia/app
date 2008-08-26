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
	'svn-date' => '$LastChangedDate: 2008-05-06 11:59:58 +0000 (Tue, 06 May 2008) $',
	'svn-revision' => '$LastChangedRevision: 34306 $',
	'author' => 'Rob Church',
	'description' => '[Special:CountEdits|Special page]] that counts user edits and provides a top-ten contributor list',
	'descriptionmsg' => 'countedits-desc',
	'url' => 'http://www.mediawiki.wiki/wiki/Extesion:CountEdits',
);

$dir = dirname(__FILE__) . '/';
$wgExtensionMessagesFiles['CountEdits'] = $dir . 'CountEdits.i18n.php';
$wgAutoloadClasses['SpecialCountEdits'] = $dir . 'CountEdits.page.php';
$wgSpecialPages['CountEdits'] = 'SpecialCountEdits';

/**
 * Should we show the "most active contributors" list?
 * This could be expensive for larger wikis
 */
$wgCountEditsMostActive = true;
