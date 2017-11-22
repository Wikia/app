<?php
/**
 * RelatedPages Extension - version for Oasis skin only
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia-inc.com>
 */

/**
 * Extension credits properties.
 */
$wgExtensionCredits['parserhook'][] = array(
	'path'           => __FILE__,
	'name'           => 'RelatedPages',
	'author'         => 'Adrian \'ADi\' Wieczorek',
	'descriptionmsg' => 'wikiarelatedpages-desc',
	'url'            => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/RelatedPages',
);

$dir = dirname(__FILE__) . '/';

// hooks
global $wgHooks;

$wgHooks['WikiaMobileAssetsPackages'][] = 'RelatedPages::onWikiaMobileAssetsPackages';

// classes
$wgAutoloadClasses['RelatedPages'] = $dir . 'RelatedPages.class.php';

// messages
$wgExtensionMessagesFiles['RelatedPages'] = $dir . 'RelatedPages.i18n.php';
JSMessages::registerPackage( 'RelatedPages', [ 'wikiarelatedpages-heading' ] );
JSMessages::registerPackage( 'RelatedPagesInContent', [ 'wikiamobile-related-article' , 'wikiamobile-people-also-read'] );
