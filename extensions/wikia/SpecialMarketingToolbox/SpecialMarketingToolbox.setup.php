<?php

/**
 * Marketing Toolbox
 *
 * @author Damian Jóźwiak
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 *
 */

$dir = dirname(__FILE__) . '/';

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Marketing Toolbox',
	'description' => 'Internal tool to configure marketing features',
	'authors' => array(
		'Damian Jóźwiak',
		'Andrzej "nAndy" Łukaszewski',
		'Marcin Maciejewski',
		'Sebastian Marzjan',
	),
	'version' => 1.0
);

//models
$wgAutoloadClasses['MarketingToolboxUserPropertiesHandler'] =  $dir . 'models/MarketingToolboxUserPropertiesHandler.class.php';

//classes
$wgAutoloadClasses['MarketingToolboxController'] = $dir . 'MarketingToolboxController.class.php';
$wgAutoloadClasses['MarketingToolboxVideosController'] =  $dir . 'MarketingToolboxVideosController.class.php';

$wgAutoloadClasses['WikiaValidatorToolboxUrl'] =  $dir . 'validators/WikiaValidatorToolboxUrl.class.php';
$wgAutoloadClasses['WikiaValidatorUsersUrl'] =  $dir . 'validators/WikiaValidatorUsersUrl.class.php';

WikiaUserPropertiesController::registerHandler('MarketingToolboxUserPropertiesHandler');

// hooks
$wgAutoloadClasses['MarketingToolboxHooks'] =  $dir . 'hooks/MarketingToolboxHooks.class.php';
$wgHooks['MakeGlobalVariablesScript'][] = 'MarketingToolboxHooks::onMakeGlobalVariablesScript';

//special page
$wgSpecialPages['MarketingToolbox'] = 'MarketingToolboxController';
$wgSpecialPageGroups['MarketingToolbox'] = 'wikia';

//message files
$wgExtensionMessagesFiles['MarketingToolbox'] = $dir . 'MarketingToolbox.i18n.php';
JSMessages::registerPackage('MarketingToolbox', array('marketing-toolbox-*'));