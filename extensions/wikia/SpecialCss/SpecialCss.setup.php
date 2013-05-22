<?php
/**
 * CSS Editor
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Łukasz Konieczny
 */
$dir = dirname(__FILE__) . '/';
$app = F::app();

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'CSS Editor',
	'description' => 'Admin tool for editing CSS files',
	'authors' => array(
		'Andrzej "nAndy" Łukaszewski',
		'Łukasz Konieczny',
	),
	'version' => 1.0
);

// models
// ...

// classes
$app->registerController('SpecialCssController', $dir . 'SpecialCssController.class.php');

// hooks
// ...

// special page
$app->registerSpecialPage('CSS', 'SpecialCssController', 'wikia');

// message files
$app->registerExtensionMessageFile('SpecialCss', $dir . 'SpecialCss.i18n.php');

//user rights
$wgGroupPermissions['*']['specialcss'] = false;
$wgGroupPermissions['staff']['specialcss'] = true;
$wgGroupPermissions['util']['specialcss'] = true;
$wgGroupPermissions['vstf']['specialcss'] = false;
$wgGroupPermissions['helper']['specialcss'] = false;
$wgGroupPermissions['sysop']['specialcss'] = true;