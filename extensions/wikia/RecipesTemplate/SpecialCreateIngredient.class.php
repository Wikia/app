<?php

class SpecialCreateIngredient extends RecipesTemplate {

	function __construct() {
		parent::__construct('CreateIngredient', '' /* no restriction */, true /* listed */);

		// setup list of fields for recipe form
		$this->mFields = array(
			'wpTitle' => array(
				'type' => 'input',
				'label' => 'title',
				'required' => true,
				'noToolbar' => true,
			),

			'wpDescription' => array(
				'type' => 'textarea',
				'label' => 'description',
				'hint' => 'ingredient-description',
			),

			'wpBuying' => array(
				'type' => 'textarea',
				'label' => 'buying',
				'hint' => 'buying',
			),

			'wpProduction' => array(
				'type' => 'textarea',
				'label' => 'production',
				'hint' => 'production',
			),

			'wpPreparation' => array(
				'type' => 'textarea',
				'label' => 'preparation',
				'hint' => 'preparation',
			),

			'wpNutrition' => array(
				'type' => 'textarea',
				'label' => 'nutrition',
				'hint' => 'nutrition',
			),

			'wpPhoto' => array(
				'type' => 'upload',
				'label' => 'photo',
				'default' => 'Image:Placeholder',
			),

			array(
				'type' => 'heading',
				'label' => 'kind-of-ingredient-heading',
				'editLink' => 'ingredient-menus',
			),

			'wpCategories' => array(
				'type' => 'multiselect',
				'values' => 'ingredient-menus',
				'required' => true,
			),
		);
	}

	/**
	 * Get wikitext for create form
	 */
	protected function getWikitext() {
		return wfMsg('recipes-template-ingredient-wikitext');
	}

	/**
	 * Format given title to follow specs of create form
	 */
	public function formatPageTitle($title) {
		return $title;
	}

	/**
	 * Get edit summary of given create form
	 */
	protected function getEditSummary() {
		return wfMsg('recipes-template-ingredient-edit-summary');
	}
}
