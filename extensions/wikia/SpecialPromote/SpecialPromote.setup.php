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
$wgAutoloadClasses['SpecialPromoteController'] =  $dir . 'SpecialPromoteController.class.php';
$wgAutoloadClasses['SpecialPromoteHelper'] =  $dir . 'SpecialPromoteHelper.class.php';
$wgAutoloadClasses['UploadVisualizationImageFromFile'] =  $dir . 'UploadVisualizationImageFromFile.class.php';

// needed task
$wgAutoloadClasses['PromoteImageReviewTask'] =  $promoteImageReviewExtDir  . 'PromoteImageReviewTask.php';

// Needed Wikia Home Page classes

// helper hierarchy
// row assigners

$wgAutoloadClasses['WikiImageRowAssigner'] = $wikiaHomePageExtDir.'classes/WikiImageRowAssigner.class.php';
$wgAutoloadClasses['WikiImageRowHelper'] = $wikiaHomePageExtDir.'classes/WikiImageRowHelper.class.php';
$wgAutoloadClasses['WikiImageNameRowHelper'] = $wikiaHomePageExtDir.'classes/WikiImageNameRowHelper.class.php';
$wgAutoloadClasses['WikiImageReviewStatusRowHelper'] = $wikiaHomePageExtDir.'classes/WikiImageReviewStatusRowHelper.class.php';

// getdata helpers
$wgAutoloadClasses['WikiGetDataHelper'] = $wikiaHomePageExtDir.'classes/WikiGetDataHelper.class.php';
$wgAutoloadClasses['WikiGetDataForVisualizationHelper'] = $wikiaHomePageExtDir.'classes/WikiGetDataForVisualizationHelper.class.php';
$wgAutoloadClasses['WikiGetDataForPromoteHelper'] = $wikiaHomePageExtDir.'classes/WikiGetDataForPromoteHelper.class.php';
$wgAutoloadClasses['WikiDataGetter'] = $wikiaHomePageExtDir.'classes/WikiDataGetter.class.php';
$wgAutoloadClasses['WikiDataGetterForSpecialPromote'] = $wikiaHomePageExtDir.'classes/WikiDataGetterForSpecialPromote.class.php';
$wgAutoloadClasses['WikiDataGetterForVisualization'] = $wikiaHomePageExtDir.'classes/WikiDataGetterForVisualization.class.php';

$wgAutoloadClasses['WikiaHomePageHelper'] =  $wikiaHomePageExtDir . 'WikiaHomePageHelper.class.php';
$wgAutoloadClasses['CityVisualization'] =  $wikiaHomePageExtDir . 'CityVisualization.class.php';

// hooks
$app->registerHook('UploadVerification', 'UploadVisualizationImageFromFile', 'UploadVerification');
$app->registerHook('CityVisualization::wikiDataInserted', 'CityVisualization', 'onWikiDataUpdated');

// i18n mapping
$app->registerExtensionMessageFile('SpecialPromote', $dir.'SpecialPromote.i18n.php');
$app->registerExtensionMessageFile('SpecialPromoteAliases', $dir . 'SpecialPromote.alias.php') ;

JSMessages::registerPackage('SpecialPromote', array('promote-*'));

// special pages
$wgSpecialPages['Promote'] = 'SpecialPromoteController';

$wgAvailableRights[] = 'promote';
$wgGroupPermissions['*']['promote'] = false;
$wgGroupPermissions['staff']['promote'] = true;
$wgGroupPermissions['helper']['promote'] = true;
$wgGroupPermissions['sysop']['promote'] = true;
$wgGroupPermissions['bureaucrat']['promote'] = true;
