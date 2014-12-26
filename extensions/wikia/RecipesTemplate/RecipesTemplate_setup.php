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
	'descriptionmsg' => 'recipiestemplate-desc',
	'url' => 'https://github.com/Wikia/app/tree/dev/extensions/wikia/RecipesTemplate'
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

// i18n
$wgExtensionMessagesFiles['RecipesTemplate'] = $dir . 'RecipesTemplate.i18n.php';

// Ajax dispatcher
$wgAjaxExportList[] = 'RecipesTemplateAjax';
function RecipesTemplateAjax() {
	global $wgRequest;
	$method = $wgRequest->getVal('method', false);

	if (method_exists('RecipesTemplateAjax', $method)) {
		$data = RecipesTemplateAjax::$method();
		$json = json_encode($data);

		$response = new AjaxResponse($json);
		$response->setContentType('application/json; charset=utf-8');

		return $response;
	}
}
