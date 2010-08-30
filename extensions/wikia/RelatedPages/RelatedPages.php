<?php
/**
 * RelatedPages Extension - version for Oasis skin only
 *
 * @author Adrian 'ADi' Wieczorek <adi(at)wikia-inc.com>
 */

$dir = dirname(__FILE__) . '/';

// hooks
$wgHooks['OutputPageMakeCategoryLinks'][] = 'RelatedPages::onOutputPageMakeCategoryLinks';

// classes
$wgAutoloadClasses['RelatedPages'] = $dir . 'RelatedPages.class.php';
$wgAutoloadClasses['RelatedPagesModule'] = $dir . 'RelatedPagesModule.class.php';

// messages
$wgExtensionMessagesFiles['RelatedPages'] = $dir . 'RelatedPages.i18n.php';
