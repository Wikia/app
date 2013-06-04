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

//classes
$wgAutoloadClasses['ManageWikiaHomeController'] = $dir.'ManageWikiaHomeController.class.php';

// models
$wgAutoloadClasses['SpecialManageWikiaHomeModel'] = $dir . '/models/SpecialManageWikiaHomeModel.class.php';

// forms
$wgAutoloadClasses['CollectionsForm'] = $dir.'/forms/CollectionsForm.class.php';

//special page
$wgSpecialPages['ManageWikiaHome'] = 'ManageWikiaHomeController';
$wgSpecialPageGroups['ManageWikiaHome'] = 'wikia';

//message files
$wgExtensionMessagesFiles['ManageWikiaHome'] = $dir.'ManageWikiaHome.i18n.php';
JSMessages::registerPackage('ManageWikiaHome', array('manage-wikia-home-*'));

//add wikia staff tool rights to staff users
$wgGroupPermissions['*']['managewikiahome'] = false;
$wgGroupPermissions['staff']['managewikiahome'] = true;
$wgGroupPermissions['util']['managewikiahome'] = true;
$wgGroupPermissions['vstf']['managewikiahome'] = false;
$wgGroupPermissions['helper']['managewikiahome'] = false;
$wgGroupPermissions['sysop']['managewikiahome'] = false;
