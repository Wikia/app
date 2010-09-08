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
$wgHooks['OutputPageMakeCategoryLinks'][] = 'RelatedPages::onOutputPageMakeCategoryLinks';
$wgHooks['OutputPageBeforeHTML'][] = 'RelatedPages::onOutputPageBeforeHTML';

// classes
$wgAutoloadClasses['RelatedPages'] = $dir . 'RelatedPages.class.php';
$wgAutoloadClasses['RelatedPagesModule'] = $dir . 'RelatedPagesModule.class.php';

// messages
$wgExtensionMessagesFiles['RelatedPages'] = $dir . 'RelatedPages.i18n.php';
