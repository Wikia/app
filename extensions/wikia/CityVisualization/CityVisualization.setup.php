<?php
/**
 * WikiaHomePage
 *
 * @author Andrzej 'nAndy' Łukaszewski
 * @author Hyun Lim
 * @author Marcin Maciejewski
 * @author Saipetch Kongkatong
 * @author Sebastian Marzjan
 * @author Damian Jóźwiak
 */

$dir = dirname(__FILE__) . '/';
$app = F::app();

$wgExtensionCredits['other'][] = array(
	'name'			  => 'CityVisualization',
	'author'		  => array('Andrzej "nAndy" Łukaszewski', 'Hyun Lim', 'Marcin Maciejewski', 'Saipetch Kongkatong', 'Sebastian Marzjan', 'Damian Jóźwiak'),
	'descriptionmsg'  => 'cityvisualization-desc',
	'url'             => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/CityVisualization',
	'version'		  => 1.0
);

//i18n
$wgExtensionMessagesFiles['CityVisualization'] = $dir . 'i18n/CityVisualization.i18n.php';

// helper hierarchy
// row assigners
$wgAutoloadClasses['WikiImageRowHelper'] = $dir . 'classes/WikiImageRowHelper.class.php';

// getdata helpers
$wgAutoloadClasses['WikiGetDataHelper'] = $dir . 'classes/WikiGetDataHelper.class.php';
$wgAutoloadClasses['WikiGetDataForVisualizationHelper'] = $dir . 'classes/WikiGetDataForVisualizationHelper.class.php';
$wgAutoloadClasses['WikiGetDataForPromoteHelper'] = $dir . 'classes/WikiGetDataForPromoteHelper.class.php';
$wgAutoloadClasses['WikiDataGetter'] = $dir . 'classes/WikiDataGetter.class.php';
$wgAutoloadClasses['WikiDataGetterForSpecialPromote'] = $dir . 'classes/WikiDataGetterForSpecialPromote.class.php';
$wgAutoloadClasses['WikiDataGetterForVisualization'] = $dir . 'classes/WikiDataGetterForVisualization.class.php';
$wgAutoloadClasses['WikiListConditioner'] = $dir . 'classes/WikiListConditioner.class.php';
$wgAutoloadClasses['WikiListConditionerForVertical'] = $dir . 'classes/WikiListConditionerForVertical.class.php';
$wgAutoloadClasses['WikiListConditionerForCollection'] = $dir . 'classes/WikiListConditionerForCollection.class.php';
$wgAutoloadClasses['PromoImage'] = $dir . '/classes/PromoImage.class.php';

//classes
$wgAutoloadClasses['WikiaHomePageHelper'] =  $dir . '/helpers/WikiaHomePageHelper.class.php';
$wgAutoloadClasses['CityVisualization'] =  $dir . '/models/CityVisualization.class.php';
