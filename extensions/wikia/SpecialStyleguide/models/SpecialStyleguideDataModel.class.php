<?php

/**
 * Class SpecialStyleguideDataModel
 * Handles getting of data
 */
class SpecialStyleguideDataModel {

	private $sectionData;

	public function __construct() {
		$helper = new StyleguideComponents();
		$components = $this->sortComponents( $helper->getAllComponents() );
		/** @var \Wikia\UI\Component $button */
		$button = \Wikia\UI\Factory::getInstance()->init('button');
		$this->sectionData = [
			'header' => [
				'home' => [
					'mainHeader' => wfMessage( 'styleguide-home-header' )->plain(),
					'getStartedBtn' => $button->render([
						'type' => 'link',
						'vars' => [
							'name' => 'get-started',
							'href' => '#',
							'classes' => 'button',
							'value' => wfMessage( 'styleguide-get-started' )->plain(),
							'title' => wfMessage( 'styleguide-get-started' )->plain()
						],
					]),
					'version' => 'Version 1.0.0'
				],
				'components' => [
					'sectionHeader' => wfMessage( 'styleguide-components-header' )->plain(),
					'tagLine' => wfMessage( 'styleguide-components-header-tagline' )->plain(),
				],
				'tagLine' => wfMessage( 'styleguide-home-header-tagline' )->plain(),
			],
			'footer' => [
				'list' => [
					[
						'link' => '#',
						'linkTitle' => wfMessage( 'styleguide-blog' )->plain(),
						'linkLabel' => wfMessage( 'styleguide-blog' )->plain(),
					],
					[
						'link' => '#',
						'linkTitle' => wfMessage( 'styleguide-changelog' )->plain(),
						'linkLabel' => wfMessage( 'styleguide-changelog' )->plain(),
					]
				]
			],
			'home' => [
				'sections' => [
					[
						'header' => wfMessage( 'styleguide-home-welcome-message' )->plain(),
						'paragraph' => wfMessage( 'styleguide-home-welcome-tagline' )->plain(),
					],
					[
						'header' => wfMessage( 'styleguide-home-stakeholders-header' )->plain(),
						'paragraph' => wfMessage( 'styleguide-home-stakeholders-paragraph' )->plain(),
					],
					[
						'header' => wfMessage( 'styleguide-home-team-header' )->plain(),
						'paragraph' => wfMessage( 'styleguide-home-team-paragraph' )->plain(),
						'list' => [
							[
								'link' => '',
								'linkTitle' => 'Elizabeth Worthy',
								'linkName' => 'Elizabeth Worthy',
								'linkTagline' => wfMessage( 'styleguide-home-team-pm' )->plain(),
							],
							[
								'link' => '',
								'linkTitle' => 'Rafał Leszczyński',
								'linkName' => 'Rafał Leszczyński',
								'linkTagline' => wfMessage( 'styleguide-home-team-engineer' )->plain(),
							],
							[
								'link' => '',
								'linkTitle' => 'Mika Kozma',
								'linkName' => 'Mika Kozma',
								'linkTagline' => wfMessage( 'styleguide-home-team-designer' )->plain(),
							],
							[
								'link' => '',
								'linkTitle' => 'Earl Carlson',
								'linkName' => 'Earl Carlson',
								'linkTagline' => wfMessage( 'styleguide-home-team-designer' )->plain()
							]
						]
					]
				]
			],
			'components' => [
				'exampleHeadline' => wfMessage( 'styleguide-examples-headline' )->plain(),
				'typesHeadline' => wfMessage( 'styleguide-types-headline' )->plain(),
				'paramCellHeadline' => wfMessage( 'styleguide-types-param-cell-headline' )->plain(),
				'templateVarCellHeadline' => wfMessage( 'styleguide-types-template-var-cell-headline' )->plain(),
				'typeCellHeadline' => wfMessage( 'styleguide-types-type-cell-headline' )->plain(),
				'valueObjectCellHeadline' => wfMessage( 'styleguide-types-value-object-cell-headline' )->plain(),
				'descCellHeadline' => wfMessage( 'styleguide-types-desc-cell-headline' )->plain(),
				'showParametersLink' => wfMessage( 'styleguide-show-parameters' )->plain(),
				'componentsList' => $components,
				'toc' => $this->renderTOC( $components )
			]
		];
	}
	
	public function getSectionData() {
		return $this->sectionData;
	}

	/**
	 * Returns data for section given as param
	 * 
	 * @param array $sectionNames
	 * 
	 * @return array
	 */
	public function getPartOfSectionData( $sectionNames ) {
		$results = [];
		$data = $this->getSectionData();
		$iterations = count( $sectionNames );
		
		foreach( $sectionNames as $subSection ) {
			if( $iterations === 1 ) {
				$results = isset( $data[$subSection] ) ? $data[$subSection] : [];
			} else {
				$data = isset( $data[$subSection] ) ? $data[$subSection] : [];
				$iterations--;
			}
		}
		
		return $results;
	}

	public function getStyleguidePageUrl( $subpage = false ) {
		$title = SpecialPage::getTitleFor( 'Styleguide', $subpage );
		
		return ( $title instanceof Title ) ? $title->getFullUrl() : '#';
	}

	/**
	 * @desc Sorts a given components array by the parameter passed in 2nd argument
	 * 
	 * @param array $components array of components
	 * @param string $sortByParam by which component parameter should it be sorted; default = 'name'
	 * 
	 * @see \Wikia\UI\Factory::getAllComponents()
	 * 
	 * @return array
	 */
	private function sortComponents( $components, $sortByParam = 'name' ) {
		$sortedArr = [];
		foreach( $components as $key => $component ) {
			$sortedArr[$key] = $component[ $sortByParam ];
		}
		
		array_multisort( $sortedArr, SORT_ASC, $components );
		
		return $components;
	}

	/**
	 * Render Component Section TOC
	 *
	 * @param Array $components - array of components
	 * @return String - HTML markup for Component Section TOC
	 */

	private function renderTOC($components) {
		$data = [
			"type" => "default",
			"vars" => [
				"id" => "styleguideTOC",
				"sections" => []
			]
		];
		$sections = &$data["vars"]["sections"];

		foreach ($components as $component) {
			$section = [
				"id" => $component["id"],
				"title" => $component["name"]
			];
			$sections[] = $section;
		}

		// set first element as active
		if (isset($sections[0])) {
			$sections[0]["active"] = true;
		}

		return \Wikia\UI\Factory::getInstance()->init('toc')->render($data);
	}
	
}
