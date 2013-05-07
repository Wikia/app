<?php
/**
 * Lightbox setup
 *
 * @author Hyun Lim, Liz Lee
 *
 */ 
$dir = dirname(__FILE__) . '/';
//classes
$wgAutoloadClasses['LightboxController'] =  $dir . 'LightboxController.class.php';

// hooks
$wgHooks['MakeGlobalVariablesScript'][] = 'LightboxController::onMakeGlobalVariablesScript';

//$wgHooks['ArticleEditUpdates'][] = 'LightboxController::onArticleEditUpdates';

// i18n mapping
$wgExtensionMessagesFiles['Lightbox'] = $dir . 'Lightbox.i18n.php';

JSMessages::registerPackage('Lightbox', array(
	'lightbox-carousel-more-items',
));
