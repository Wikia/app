<?php
/**
 * Lightbox setup
 *
 * @author Hyun Lim, Liz Lee
 *
 */ 
$dir = dirname(__FILE__) . '/';
$app = F::app();
//classes
$wgAutoloadClasses['LightboxController'] =  $dir . 'LightboxController.class.php';

// hooks
$app->registerHook('MakeGlobalVariablesScript', 'LightboxController', 'onMakeGlobalVariablesScript');

//$app->registerHook('ArticleEditUpdates', 'LightboxController', 'onArticleEditUpdates');

// i18n mapping
$wgExtensionMessagesFiles['Lightbox'] = $dir . 'Lightbox.i18n.php';

JSMessages::registerPackage('Lightbox', array(
	'lightbox-carousel-more-items',
));
