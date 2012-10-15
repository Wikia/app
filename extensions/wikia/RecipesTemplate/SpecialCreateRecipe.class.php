<?php

class SpecialCreateRecipe extends RecipesTemplate {

	function __construct() {
		parent::__construct('CreateRecipe', '' /* no restriction */, true /* listed */);

		// setup list of fields for recipe form
		$this->mFields = array(
			'wpTitle' => array(
				'type' => 'input',
				'label' => 'title',
				'hint' => 'title',
				'hintHideable' => true,
				'required' => true,
				'noToolbar' => true,
			),

			'wpIngredients' => array(
				'type' => 'multifield',
				'label' => 'ingredients',
				'hint' => 'ingredients',
				'hintHideable' => true,
				'required' => true,
			),

			'wpDirections' => array(
				'type' => 'textarea',
				'label' => 'directions',
				'hint' => 'directions',
				'hintHideable' => true,
				'required' => true,
			),

			'wpPrepTime' => array(
				'type' => 'time',
				'label' => 'prep-time',
			),

			'wpCookTime' => array(
				'type' => 'time',
				'label' => 'cook-time',
			),

			'wpYields' => array(
				'type' => 'input',
				'label' => 'yields',
				'hint' => 'yields',
				'hintHideable' => true,
			),

			'wpDescription' => array(
				'type' => 'textarea',
				'label' => 'description',
				'hint' => 'description',
				'hintHideable' => true,
			),

			'wpPhoto' => array(
				'type' => 'upload',
				'label' => 'photo',
				'default' => 'Image:Placeholder',
			),

			array(
				'type' => 'heading',
				'label' => 'kind-of-recipe-heading',
				'editLink' => 'recipe-menus',
			),

			'wpCategories' => array(
				'type' => 'multiselect',
				'values' => 'recipe-menus',
				'required' => true,
			),
		);
	}

	/**
	 * Get wikitext for create form
	 */
	protected function getWikitext() {
		return wfMsg('recipes-template-recipe-wikitext');
	}

	/**
	 * Format given title to follow specs of create form
	 */
	public function formatPageTitle($title) {
		global $wgUser;
		wfProfileIn(__METHOD__);

		// get user name
		$userName = (!empty($wgUser) && $wgUser->isLoggedIn()) ? $wgUser->getName() : wfMsg('recipes-template-by-anon');

		// format title
		$ret = $title != '' ? wfMsg('recipes-template-title-format', $title, $userName) : '';

		wfProfileOut(__METHOD__);
		return $ret;
	}

	/**
	 * Get edit summary of given create form
	 */
	protected function getEditSummary() {
		return wfMsg('recipes-template-recipe-edit-summary');
	}
}
