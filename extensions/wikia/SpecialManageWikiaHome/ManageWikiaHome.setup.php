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
	'descriptionmsg' => 'managewikiahome-desc',
	'authors' => array(
		'Andrzej "nAndy" Łukaszewski',
		'Marcin Maciejewski',
		'Sebastian Marzjan',
		'Damian Jóźwiak',
		'Łukasz Konieczny'
	),
	'version' => 1.0,
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/SpecialManageWikiaHome'
);

//classes
$wgAutoloadClasses['ManageWikiaHomeController'] = $dir.'ManageWikiaHomeController.class.php';

// models
$wgAutoloadClasses['SpecialManageWikiaHomeModel'] = $dir . '/models/SpecialManageWikiaHomeModel.class.php';

// forms
$wgAutoloadClasses['CollectionsForm'] = $dir.'/forms/CollectionsForm.class.php';
$wgAutoloadClasses['StatsForm'] = $dir.'/forms/StatsForm.class.php';
$wgAutoloadClasses['HubsSlotsForm'] = $dir.'/forms/HubsSlotsForm.class.php';

//special page
$wgSpecialPages['ManageWikiaHome'] = 'ManageWikiaHomeController';
$wgSpecialPageGroups['ManageWikiaHome'] = 'wikia';

//message files
$wgExtensionMessagesFiles['ManageWikiaHome'] = $dir.'ManageWikiaHome.i18n.php';
JSMessages::registerPackage('ManageWikiaHome', array('manage-wikia-home-*'));
