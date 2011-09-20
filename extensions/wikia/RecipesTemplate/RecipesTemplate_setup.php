<?php

/**
 * RecipesTemplates
 *
 * Create forms to help people add recipes and ingredients pages to our Recipes wikis
 */

$wgExtensionCredits['specialpage'][] = array(
	'name' => 'Recipes Template',
	'author' => array(
		'Maciej Brencz',
		"[http://community.wikia.com/wiki/User:TOR Lucas 'TOR' Garczewski]",
	),
	'description' => 'Adds forms to help people add recipes and ingredients pages to Recipes wikis'
);

$dir = dirname(__FILE__) . '/';

// register classes
$wgAutoloadClasses['RecipesTemplate'] = $dir.'RecipesTemplate.class.php';
$wgAutoloadClasses['RecipesTemplateAjax'] = $dir.'RecipesTemplateAjax.class.php';

// register special pages
$wgAutoloadClasses['SpecialCreateIngredient'] = $dir.'SpecialCreateIngredient.class.php';
$wgAutoloadClasses['SpecialCreateRecipe'] = $dir.'SpecialCreateRecipe.class.php';
$wgAutoloadClasses['SpecialCreateFromTemplate'] = $dir.'SpecialCreateFromTemplate.class.php';
$wgSpecialPages['CreateIngredient'] = 'SpecialCreateIngredient';
$wgSpecialPages['CreateRecipe'] = 'SpecialCreateRecipe';
$wgSpecialPages['CreateFromTemplate'] = 'SpecialCreateFromTemplate';

// hooks
if ( !empty( $wgEnableRecipesTemplateExt ) ) {
	/*
	 * this extension is used in two contexts:
	 * 1. stand-alone, displaying at Special:CreatePage
	 * 2. by user profile extensions
	 * in the second case, the toggle should not be displayed
	 */
	// $wgHooks['EditPage::showEditForm:initial'][] = 'RecipesTemplate::showCreatePageToggle'; // macbre: disable for EditPageLayout ext
}

// i18n
$wgExtensionMessagesFiles['RecipesTemplate'] = $dir . 'RecipesTemplate.i18n.php';

// Ajax dispatcher
$wgAjaxExportList[] = 'RecipesTemplateAjax';
function RecipesTemplateAjax() {
	global $wgRequest;
	$method = $wgRequest->getVal('method', false);

	if (method_exists('RecipesTemplateAjax', $method)) {
		$data = RecipesTemplateAjax::$method();
		$json = Wikia::json_encode($data);

		$response = new AjaxResponse($json);
		$response->setContentType('application/json; charset=utf-8');

		return $response;
	}
}
