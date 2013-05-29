<?php
/**
 * ManageWikiaHome
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 *
 */

$dir = dirname(__FILE__) . '/';
$app = F::app();

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Wikia Home Staff Tool',
	'description' => 'Internal tool to manage corporate pages\'s visualization aka. remix feature',
	'authors' => array(
		'Andrzej "nAndy" Łukaszewski',
		'Marcin Maciejewski',
		'Sebastian Marzjan',
		'Damian Jóźwiak',
		'Łukasz Konieczny'
	),
	'version' => 1.0
);

// classes
$app->registerController('ManageWikiaHomeController', $dir . 'ManageWikiaHomeController.class.php');

// models
$app->registerController('SpecialManageWikiaHomeModel', $dir . '/models/SpecialManageWikiaHomeModel.class.php');

// forms
$app->registerClass('CollectionsForm', $dir.'/forms/CollectionsForm.class.php');

// special page
$app->registerSpecialPage('ManageWikiaHome', 'ManageWikiaHomeController', 'wikia');

// message files
$app->registerExtensionMessageFile('ManageWikiaHome', $dir.'ManageWikiaHome.i18n.php');
F::build('JSMessages')->registerPackage('ManageWikiaHome', array('manage-wikia-home-*'));

//add wikia staff tool rights to staff users
$wgGroupPermissions['*']['managewikiahome'] = false;
$wgGroupPermissions['staff']['managewikiahome'] = true;
$wgGroupPermissions['util']['managewikiahome'] = true;
$wgGroupPermissions['vstf']['managewikiahome'] = false;
$wgGroupPermissions['helper']['managewikiahome'] = false;
$wgGroupPermissions['sysop']['managewikiahome'] = false;
