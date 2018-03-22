<?php

class CommunityPageSpecialInsightsModel {
	const INSIGHTS_MODULE_ITEMS = 3;
	const INSIGHTS_ICON = 'icon';
	const INSIGHTS_TITLE = 'title';
	const RANDOM_SORTING_TYPE = 'random';
	const INSIGHTS_MODULES = [
		'popularpages' => [
			self::INSIGHTS_ICON => 'proof-read',
			self::INSIGHTS_TITLE => 'communitypage-cards-proofread-articles'
		],
		'deadendpages' => [
			self::INSIGHTS_ICON => 'add-link',
			self::INSIGHTS_TITLE => 'communitypage-cards-links'
		],
		'uncategorizedpages' => [
			self::INSIGHTS_ICON => 'add-category',
			self::INSIGHTS_TITLE => 'communitypage-cards-categories'
		]
	];

	private $insightsService;

	public function __construct() {
		$this->insightsService = new InsightsService();
	}

	/**
	 * Get insights modules
	 *
	 * @return array
	 */
	public function getInsightsModules() {
		$modules = [ ];

		foreach ( static::INSIGHTS_MODULES as $insight => $config ) {
			$module = $this->getInsightModule( $insight, $config );
			if ( !empty( $module ) ) {
				$modules[] = $module;
			}
		}

		return $modules;
	}

	/**
	 * @param string $type type of module we want to build.
	 * @param array $config array with variables that determine
	 *  - should display page views on list
	 *  - how data should be sorted (@see InsightsSorting::$sorting)
	 * @return array Insight Module
	 */
	private function getInsightModule( $type, $config ) {
		$insightPages = $this->insightsService->getInsightPages(
			$type,
			static::INSIGHTS_MODULE_ITEMS,
			static::RANDOM_SORTING_TYPE
		);

		if ( empty( $insightPages[ 'pages' ] ) ) {
			return [ ];
		}

		$insightPages[ 'type' ] = $type;
		$insightPages[ 'icon' ] = $config[ static::INSIGHTS_ICON ];
		$insightPages[ 'title' ] = wfMessage( $config[ static::INSIGHTS_TITLE ] )->text();
		$insightPages[ 'helpicon' ] = DesignSystemHelper::renderSvg(
			'wds-icons-question', 'community-page-card-module-help-icon wds-icon-small' );

		if ( $insightPages[ 'count' ] > static::INSIGHTS_MODULE_ITEMS ) {
			$insightPages[ 'fulllistlink' ] = SpecialPage::getTitleFor( 'Insights', $type )
				->getLocalURL();
		}

		return $this->addEditLinks( $insightPages );
	}

	private function addEditLinks( $insightsPages ) {
		foreach ( $insightsPages[ 'pages' ] as $key => $insight ) {
			$insightsPages[ 'pages' ][ $key ][ 'link' ][ 'editlink' ]
				= LinkHelper::forceLoginLink( Title::newFromText( $insight[ 'link' ][ 'title' ] ), LinkHelper::WITH_EDIT_MODE );
		}
		return $insightsPages;
	}
}
