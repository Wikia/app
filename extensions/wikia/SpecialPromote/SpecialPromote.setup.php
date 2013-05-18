<?php

/**
 * Admin Upload Tool
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Marcin Maciejewski
 * @author Sebastian Marzjan
 *
 */

$wgExtensionCredits['other'][] = array(
	'name'			=> 'SpecialPromote',
	'author'		=> 'Andrzej "nAndy" Łukaszewski, Marcin Maciejewski, Sebastian Marzjan',
	'description'	=> 'SpecialPromote page is enable for admins to add information about their wiki. After review of those informations it can show up on wikia.com',
	'version'		=> 1.0
);

$dir = dirname(__FILE__) . '/';
$promoteImageReviewExtDir = dirname(dirname(__FILE__)) . '/ImageReview/modules/PromoteImage/';
$app = F::app();

// classes
$app->registerClass('SpecialPromoteController', $dir . 'SpecialPromoteController.class.php');
$app->registerClass('SpecialPromoteHelper', $dir . 'SpecialPromoteHelper.class.php');
$app->registerClass('UploadVisualizationImageFromFile', $dir . 'UploadVisualizationImageFromFile.class.php');

// needed task
$app->registerClass('PromoteImageReviewTask', $promoteImageReviewExtDir  . 'PromoteImageReviewTask.php');

// hooks
$app->registerHook('UploadVerification', 'UploadVisualizationImageFromFile', 'UploadVerification');
$app->registerHook('CityVisualization::wikiDataInserted', 'CityVisualization', 'onWikiDataUpdated');

// i18n mapping
$app->registerExtensionMessageFile('SpecialPromote', $dir.'SpecialPromote.i18n.php');
$app->registerExtensionMessageFile('SpecialPromoteAliases', $dir . 'SpecialPromote.alias.php') ;

F::build('JSMessages')->registerPackage('SpecialPromote', array('promote-*'));

// special pages
$app->registerSpecialPage('Promote', 'SpecialPromoteController');

$wgAvailableRights[] = 'promote';
$wgGroupPermissions['*']['promote'] = false;
$wgGroupPermissions['staff']['promote'] = true;
$wgGroupPermissions['helper']['promote'] = true;
$wgGroupPermissions['sysop']['promote'] = true;
$wgGroupPermissions['bureaucrat']['promote'] = true;
