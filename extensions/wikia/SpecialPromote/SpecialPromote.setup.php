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
$wikiaHomePageExtDir = dirname(dirname(__FILE__)) . '/WikiaHomePage/';
$promoteImageReviewExtDir = dirname(dirname(__FILE__)) . '/ImageReview/modules/PromoteImage/';
$app = F::app();

// classes
$app->registerClass('SpecialPromoteController', $dir . 'SpecialPromoteController.class.php');
$app->registerClass('SpecialPromoteHelper', $dir . 'SpecialPromoteHelper.class.php');
$app->registerClass('UploadVisualizationImageFromFile', $dir . 'UploadVisualizationImageFromFile.class.php');

// needed task
$app->registerClass('PromoteImageReviewTask', $promoteImageReviewExtDir  . 'PromoteImageReviewTask.php');

// Needed Wikia Home Page classes

// helper hierarchy
// row assigners

$app->registerClass('WikiImageRowAssigner',$wikiaHomePageExtDir.'classes/WikiImageRowAssigner.class.php');
$app->registerClass('WikiImageRowHelper',$wikiaHomePageExtDir.'classes/WikiImageRowHelper.class.php');
$app->registerClass('WikiImageNameRowHelper',$wikiaHomePageExtDir.'classes/WikiImageNameRowHelper.class.php');
$app->registerClass('WikiImageReviewStatusRowHelper',$wikiaHomePageExtDir.'classes/WikiImageReviewStatusRowHelper.class.php');

// getdata helpers
$app->registerClass('WikiGetDataHelper',$wikiaHomePageExtDir.'classes/WikiGetDataHelper.class.php');
$app->registerClass('WikiGetDataForVisualizationHelper',$wikiaHomePageExtDir.'classes/WikiGetDataForVisualizationHelper.class.php');
$app->registerClass('WikiGetDataForPromoteHelper',$wikiaHomePageExtDir.'classes/WikiGetDataForPromoteHelper.class.php');
$app->registerClass('WikiDataGetter',$wikiaHomePageExtDir.'classes/WikiDataGetter.class.php');
$app->registerClass('WikiDataGetterForSpecialPromote',$wikiaHomePageExtDir.'classes/WikiDataGetterForSpecialPromote.class.php');
$app->registerClass('WikiDataGetterForVisualization',$wikiaHomePageExtDir.'classes/WikiDataGetterForVisualization.class.php');

$app->registerClass('WikiaHomePageHelper', $wikiaHomePageExtDir . 'WikiaHomePageHelper.class.php');
$app->registerClass('CityVisualization', $wikiaHomePageExtDir . 'CityVisualization.class.php');

// hooks
$app->registerHook('UploadVerification','UploadVisualizationImageFromFile','UploadVerification');
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
$wgGroupPermissions['sysop']['promote'] = true;
$wgGroupPermissions['bureaucrat']['promote'] = true;
