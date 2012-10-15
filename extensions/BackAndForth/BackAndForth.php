<?php
/**
 * Extension adds "next" and "previous" alphabetic paging links to
 * the top of articles
 *
 * @file
 * @ingroup Extensions
 * @author Rob Church <robchur@gmail.com>
 */

if ( !defined( 'MEDIAWIKI' ) ) {
	echo( "This file is an extension to the MediaWiki software and cannot be used standalone.\n" );
	die( 1 );
}

$wgAutoloadClasses['BackAndForth'] = dirname( __FILE__ ) . '/BackAndForth.class.php';
$wgHooks['ArticleViewHeader'][] = 'BackAndForth::viewHook';
$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'Back and Forth',
	'author' => 'Rob Church',
	'descriptionmsg' => 'backandforth-desc',
	'url' => 'https://www.mediawiki.org/wiki/Extension:Back-and-Forth',
);

$wgExtensionMessagesFiles['BackAndForth'] = dirname( __FILE__ ) . '/BackAndForth.i18n.php';
