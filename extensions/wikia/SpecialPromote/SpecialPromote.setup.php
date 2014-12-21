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

// classes
$wgAutoloadClasses['SpecialPromoteController'] =  $dir . 'SpecialPromoteController.class.php';
$wgAutoloadClasses['SpecialPromoteHelper'] =  $dir . 'SpecialPromoteHelper.class.php';
$wgAutoloadClasses['SpecialPromoteHooks'] =  $dir . 'SpecialPromoteHooks.class.php';
$wgAutoloadClasses['UploadVisualizationImageFromFile'] =  $dir . 'UploadVisualizationImageFromFile.class.php';

// needed task
$wgAutoloadClasses['PromoteImageReviewTask'] = $promoteImageReviewExtDir  . 'PromoteImageReviewTask.php';

// hooks
$wgHooks['UploadVerification'][] = 'UploadVisualizationImageFromFile::UploadVerification';
$wgHooks['CityVisualization::wikiDataInserted'][] = 'CityVisualization::onWikiDataUpdated';
$wgHooks['FileDeleteComplete'][] = 'SpecialPromoteHooks::onFileDeleteComplete';

// i18n mapping
$wgExtensionMessagesFiles['SpecialPromote'] = $dir.'SpecialPromote.i18n.php';
$wgExtensionMessagesFiles['SpecialPromoteAliases'] = $dir . 'SpecialPromote.alias.php';

JSMessages::registerPackage('SpecialPromote', array('promote-*'));

// special pages
$wgSpecialPages['Promote'] = 'SpecialPromoteController';

$wgAvailableRights[] = 'restricted_promote';
$wgGroupPermissions['*']['restricted_promote'] = false;
$wgGroupPermissions['staff']['restricted_promote'] = true;
$wgGroupPermissions['helper']['restricted_promote'] = true;
$wgGroupPermissions['sysop']['restricted_promote'] = false;
$wgGroupPermissions['bureaucrat']['restricted_promote'] = false;
