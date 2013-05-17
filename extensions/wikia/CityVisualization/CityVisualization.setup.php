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
	'name'			=> 'CityVisualization',
	'author'		=> 'Andrzej "nAndy" Łukaszewski, Hyun Lim, Marcin Maciejewski, Saipetch Kongkatong, Sebastian Marzjan, Damian Jóźwiak',
	'description'	=> 'CityVisualization',
	'version'		=> 1.0
);

// helper hierarchy
// row assigners
$app->registerClass('WikiImageRowAssigner',$dir.'classes/WikiImageRowAssigner.class.php');
$app->registerClass('WikiImageRowHelper',$dir.'classes/WikiImageRowHelper.class.php');
$app->registerClass('WikiImageNameRowHelper',$dir.'classes/WikiImageNameRowHelper.class.php');
$app->registerClass('WikiImageReviewStatusRowHelper',$dir.'classes/WikiImageReviewStatusRowHelper.class.php');

// getdata helpers
$app->registerClass('WikiGetDataHelper',$dir.'classes/WikiGetDataHelper.class.php');
$app->registerClass('WikiGetDataForVisualizationHelper',$dir.'classes/WikiGetDataForVisualizationHelper.class.php');
$app->registerClass('WikiGetDataForPromoteHelper',$dir.'classes/WikiGetDataForPromoteHelper.class.php');
$app->registerClass('WikiDataGetter',$dir.'classes/WikiDataGetter.class.php');
$app->registerClass('WikiDataGetterForSpecialPromote',$dir.'classes/WikiDataGetterForSpecialPromote.class.php');
$app->registerClass('WikiDataGetterForVisualization',$dir.'classes/WikiDataGetterForVisualization.class.php');
$app->registerClass('WikiListConditioner', $dir.'classes/WikiListConditioner.class.php');
$app->registerClass('WikiListConditionerForVertical',$dir.'classes/WikiListConditionerForVertical.class.php');
$app->registerClass('WikiListConditionerForCollection',$dir.'classes/WikiListConditionerForCollection.class.php');

//classes
$app->registerClass('WikiaHomePageHelper', $dir.'/helpers/WikiaHomePageHelper.class.php');
$app->registerClass('CityVisualization', $dir.'/models/CityVisualization.class.php');