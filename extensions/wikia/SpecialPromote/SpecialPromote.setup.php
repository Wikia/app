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
	'name'				=> 'SpecialPromote',
	'author'			=> 'Andrzej "nAndy" Łukaszewski, Marcin Maciejewski, Sebastian Marzjan',
	'descriptionmsg'	=> 'promote-desc',
	'version'			=> 1.0,
	'url'           	=> 'https://github.com/Wikia/app/tree/dev/extensions/wikia/SpecialPromote'
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
