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
$app->registerClass('LightboxHelper', $dir . 'LightboxHelper.class.php');
$app->registerClass('LightboxController', $dir . 'LightboxController.class.php');

// hooks
$app->registerHook('MakeGlobalVariablesScript', 'LightboxHelper', 'onMakeGlobalVariablesScript');

//$app->registerHook('ArticleEditUpdates', 'LightboxController', 'onArticleEditUpdates');

// i18n mapping
$wgExtensionMessagesFiles['Lightbox'] = $dir . 'Lightbox.i18n.php';

F::build('JSMessages')->registerPackage('Lightbox', array(
	'lightbox-carousel-more-items',
));