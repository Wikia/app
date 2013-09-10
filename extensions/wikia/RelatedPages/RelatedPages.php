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
	'descriptionmsg' => 'wikirelatedpages-desc',
	'url'            => 'http://www.wikia.com',
);

$dir = dirname(__FILE__) . '/';

// hooks
global $wgHooks;

array_splice( $wgHooks['OutputPageBeforeHTML'], 0, 0, 'RelatedPages::onOutputPageBeforeHTML' );
$wgHooks['WikiaMobileAssetsPackages'][] = 'RelatedPages::onWikiaMobileAssetsPackages';
$wgHooks['SkinAfterContent'][] = 'RelatedPages::onSkinAfterContent';

// classes
$wgAutoloadClasses['RelatedPages'] = $dir . 'RelatedPages.class.php';

// messages
$wgExtensionMessagesFiles['RelatedPages'] = $dir . 'RelatedPages.i18n.php';
JSMessages::registerPackage( 'RelatedPages', [ 'wikiarelatedpages-heading' ] );
