<?php
/**
 * ResearchTools extension
 * 
 * @file
 * @ingroup Extensions
 * 
 * @author Trevor Parscal <trevor@wikimedia.org>
 * @license GPL v2 or later
 * @version 0.1.0
 */

/* Setup */

$wgExtensionCredits['other'][] = array(
	'path' => __FILE__,
	'name' => 'ResearchTools',
	'author' => array( 'Trevor Parscal' ),
	'version' => '0.1.0',
	'url' => 'https://www.mediawiki.org/wiki/Extension:ResearchTools',
	'descriptionmsg' => 'researchtools-desc',
);
$dir = dirname( __FILE__ );
$wgExtensionMessagesFiles['ResearchTools'] = "$dir/ResearchTools.i18n.php";
$wgExtensionMessagesFiles['ResearchToolsAlias'] = "$dir/ResearchTools.alias.php";
$wgAutoloadClasses['ResearchToolsHooks'] = "$dir/ResearchTools.hooks.php";
$wgAutoloadClasses['SpecialResearchTools'] = "$dir/SpecialResearchTools.php";
$wgAutoloadClasses['ResearchToolsPage'] = "$dir/ResearchToolsPage.php";
$wgAutoloadClasses['ResearchToolsDashboardPage'] = "$dir/pages/ResearchToolsDashboardPage.php";
$wgAutoloadClasses['ResearchToolsSurveysPage'] = "$dir/pages/ResearchToolsSurveysPage.php";
$wgAutoloadClasses['ResearchToolsClicksPage'] = "$dir/pages/ResearchToolsClicksPage.php";
$wgAutoloadClasses['ResearchToolsPrefsPage'] = "$dir/pages/ResearchToolsPrefsPage.php";
$wgAutoloadClasses['ApiQueryResearchToolsSurveys'] = "$dir/api/ApiQueryResearchToolsSurveys.php";
$wgAutoloadClasses['ApiQueryResearchToolsSurveyResponses'] = "$dir/api/ApiQueryResearchToolsSurveyResponses.php";
$wgAutoloadClasses['ApiResearchToolsSurveyResponse'] = "$dir/api/ApiResearchToolsSurveyResponse.php";
$wgSpecialPages['ResearchTools'] = 'SpecialResearchTools';
$wgSpecialPageGroups['ResearchTools'] = 'other';
$wgHooks['ResourceLoaderRegisterModules'][] = 'ResearchToolsHooks::resourceLoaderRegisterModules';
$wgHooks['LoadExtensionSchemaUpdates'][] = 'ResearchToolsHooks::loadExtensionSchemaUpdates';
$wgAPIListModules['researchtools_surveys'] = 'ApiQueryResearchToolsSurveys';
$wgAPIListModules['researchtools_surveyresponses'] = 'ApiQueryResearchToolsSurveyResponses';
$wgAPIModules['researchtools_surveyresponse'] = 'ApiResearchToolsSurveyResponse';
