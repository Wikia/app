<?php

class CommunityPageSpecialInsightsModel {
	const INSIGHTS_MODULE_ITEMS = 3;
	const INSIGHTS_CONFIG_SORT_TYPE_KEY = 'sortingType';
	const INSIGHTS_CONFIG_PAGEVIEWS_KEY = 'displayPageviews';
	const INSIGHTS_ICON = 'icon';
	const INSIGHTS_TITLE = 'title';
	const INSIGHTS_MODULES = [
		'popularpages' => [
			self::INSIGHTS_CONFIG_SORT_TYPE_KEY => 'random',
			self::INSIGHTS_CONFIG_PAGEVIEWS_KEY => true,
			self::INSIGHTS_ICON => 'proof-read',
			self::INSIGHTS_TITLE => 'communitypage-cards-proofread-articles'
		],
		'deadendpages' => [
			self::INSIGHTS_CONFIG_SORT_TYPE_KEY => 'random',
			self::INSIGHTS_CONFIG_PAGEVIEWS_KEY => false,
			self::INSIGHTS_ICON => 'add-link',
			self::INSIGHTS_TITLE => 'communitypage-cards-links'
		],
		'uncategorizedpages' => [
			self::INSIGHTS_CONFIG_SORT_TYPE_KEY => 'random',
			self::INSIGHTS_CONFIG_PAGEVIEWS_KEY => false,
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
		$modules[ 'modules' ] = [ ];
		$modules[ 'heading' ] = wfMessage( 'communitypage-cards-start' )->text();

		$modules[ 'messages' ] = [
			'fulllist' => wfMessage( 'communitypage-full-list' )->text()
		];

		foreach ( static::INSIGHTS_MODULES as $insight => $config ) {
			$module = $this->getInsightModule( $insight, $config );
			if ( !empty( $module ) ) {
				$modules[ 'modules' ][] = $module;
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
			$config[ static::INSIGHTS_CONFIG_SORT_TYPE_KEY ]
		);

		if ( empty( $insightPages[ 'pages' ] ) ) {
			return [ ];
		}

		/**
		 * Covers messages:
		 *
		 * communitypage-popularpages-title'
		 * communitypage-uncategorizedpages-title'
		 * communitypage-deadendpages-title'
		 */
		$insightPages[ 'type' ] = $type;
		$insightPages[ 'icon' ] = $config[ static::INSIGHTS_ICON ];
		$insightPages[ 'title' ] = wfMessage( $config[ static::INSIGHTS_TITLE ] )->text();
		$insightPages[ 'helpicon' ] = DesignSystemHelper::getSvg(
			'wds-icons-question', 'community-page-insights-module-help-icon wds-icon-small' );

		if ( $insightPages[ 'count' ] > static::INSIGHTS_MODULE_ITEMS ) {
			$insightPages[ 'fulllistlink' ] = SpecialPage::getTitleFor( 'Insights', $type )
				->getLocalURL( $this->getSortingParam( $config[ static::INSIGHTS_CONFIG_SORT_TYPE_KEY ] ) );
		}

		return $this->addLastRevision( $insightPages, $config[ static::INSIGHTS_CONFIG_PAGEVIEWS_KEY ] );
	}

	/**
	 * @param array $insightsPages
	 * @param boolean $displayPageviews should display information about pageviews
	 * @return array Prepare message about who and when last edited given article
	 * @throws MWException
	 */
	private function addLastRevision( $insightsPages, $displayPageviews ) {
		global $wgLang;

		foreach ( $insightsPages[ 'pages' ] as $key => $insight ) {
			$insightsPages[ 'pages' ][ $key ][ 'metadataDetails' ] = $this->getArticleMetadataDetails( $insight[ 'metadata' ] );
			$insightsPages[ 'pages' ][ $key ][ 'editlink' ] = $this->getEditUrl( $insight[ 'link' ][ 'articleurl' ] );
			$insightsPages[ 'pages' ][ $key ][ 'edittext' ] = $this->getArticleContributeText(
				$insight[ 'metadata' ],
				$insightsPages[ 'type' ] );

			if ( $displayPageviews && !empty( $insight[ 'metadata' ][ 'pv7' ] ) ) {
				$insightsPages[ 'pages' ][ $key ][ 'pageviews' ] = wfMessage(
					'communitypage-noofviews',
					$wgLang->formatNum( $insight[ 'metadata' ][ 'pv7' ] )
				)->text();
			}
		}
		return $insightsPages;
	}

	private function getEditUrl( $articleUrl ) {
		if ( EditorPreference::isVisualEditorPrimary() ) {
			return $articleUrl . '?veaction=edit';
		}
		return $articleUrl . '?action=edit';
	}

	private function getSortingParam( $sortingType ) {
		if ( !empty( $sortingType ) ) {
			return [ 'sort' => $sortingType ];
		}

		return [ ];
	}

	private function getArticleContributeText( $metadata, $type ) {
		if ( !empty( $metadata[ 'wantedBy' ] ) ) {
			return wfMessage( 'communitypage-page-list-create' )->text();
		}

		// Messages that can be used here:
		// * communitypage-popularpages-edittext
		// * communitypage-uncategorizedpages-edittext
		// * communitypage-deadendpages-edittext
		return wfMessage( 'communitypage-' . $type . '-edittext' )->text();
	}

	/**
	 * Get message with article metadata details
	 *
	 * @param array $metadata
	 * @return string
	 */
	private function getArticleMetadataDetails( $metadata ) {
		global $wgUser, $wgLang;

		if ( !empty( $metadata[ 'wantedBy' ] ) ) {
			return wfMessage( $metadata[ 'wantedBy' ][ 'message' ] )->rawParams(
				Html::element(
					'a',
					[
						'href' => $metadata[ 'wantedBy' ][ 'url' ],
						'data-tracking' => 'wanted-by-link',
					],
					$wgLang->formatNum( $metadata[ 'wantedBy' ][ 'value' ] )
				)
			)->escaped();
		}

		$timestamp = wfTimestamp( TS_UNIX, $metadata[ 'lastRevision' ][ 'timestamp' ] );

		$userName = $metadata[ 'lastRevision' ][ 'username' ];

		if ( User::isIp( $userName ) ) {
			$userName = wfMessage( 'oasis-anon-user' )->plain();
		}

		return wfMessage( 'communitypage-lastrevision' )->rawParams(
			Html::element(
				'a',
				[
					'href' => $metadata[ 'lastRevision' ][ 'userpage' ],
					'data-tracking' => 'user-profile-link',
					'class' => 'communitypage-user-link'
				],
				$userName
			),
			$wgLang->userDate( $timestamp, $wgUser )
		)->escaped();
	}
}
