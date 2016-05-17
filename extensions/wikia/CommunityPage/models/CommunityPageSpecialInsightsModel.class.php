<?php

class CommunityPageSpecialInsightsModel {
	const INSIGHTS_MODULE_ITEMS = 5;
	const INSIGHTS_MODULES = [
		'popularpages' => [
			'sortingType' => 'pvDiff',
			'displayPageviews' => true
		],
		'deadendpages' => [
			'sortingType' => 'pv7',
			'displayPageviews' => false
		],
		'uncategorizedpages' => [
			'sortingType' => 'pv7',
			'displayPageviews' => false
		],
		'wantedpages' => [
			'sortingType' => false,
			'displayPageviews' => false
		],
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
		$modules['modules'] = [];

		$modules['messages'] = [
			'fulllist' => wfMessage( 'communitypage-full-list' )->text()
		];

		foreach ( self::INSIGHTS_MODULES as $insight => $config ) {
			$module = $this->getInsightModule( $insight, $config );
			if ( !empty( $module ) ) {
				$modules['modules'][] = $module;
			}
		}

		return $modules;
	}

	/**
	 * @param string $type type of module we want to build.
	 * @param string $sortingType define how data should be sorted (@see InsightsSorting::$sorting)
	 * @return array Insight Module
	 */
	private function getInsightModule( $type, $config ) {
		$insightPages = $this->insightsService->getInsightPages(
			$type,
			self::INSIGHTS_MODULE_ITEMS,
			$config['sortingType']
		);

		if ( empty( $insightPages['pages'] ) ) {
			return [];
		}

		/**
		 * Covers messages:
		 *
		 * communitypage-popularpages-title'
		 * communitypage-uncategorizedpages-title'
		 * communitypage-wantedpages-title'
		 * communitypage-deadendpages-title'
		 * communitypage-popularpages-description'
		 * communitypage-uncategorizedpages-description'
		 * communitypage-wantedpages-description'
		 * communitypage-deadendpages-description'
		 */
		$insightPages['type'] = $type;
		$insightPages['title'] = wfMessage( 'communitypage-' . $type . '-title' )->text();
		$insightPages['description'] =  wfMessage( 'communitypage-' . $type . '-description' )->text();

		if ( $insightPages['count'] > self::INSIGHTS_MODULE_ITEMS ) {
			$insightPages['fulllistlink'] = SpecialPage::getTitleFor( 'Insights', $type )
				->getLocalURL( $this->getSortingParam( $config['sortingType'] ) );
		}

		$insightPages = $this->addLastRevision( $insightPages, $config['displayPageviews'] );

		return $insightPages;
	}

	/**
	 * @param array $insightsPages
	 * @param boolean $displayPageviews should display information about pageviews
	 * @return array Prepare message about who and when last edited given article
	 * @throws MWException
	 */
	private function addLastRevision( $insightsPages, $displayPageviews ) {
		global $wgLang;

		foreach ( $insightsPages['pages'] as $key => $insight ) {
			$insightsPages['pages'][$key]['metadataDetails'] = $this->getArticleMetadataDetails( $insight['metadata'] );
			$insightsPages['pages'][$key]['editlink'] = $this->getEditUrl( $insight['link']['articleurl'] );
			$insightsPages['pages'][$key]['edittext'] = $this->getArticleContributeText( $insight['metadata'] );

			if ( $displayPageviews ) {
				$insightsPages['pages'][$key]['pageviews'] = wfMessage(
					'communitypage-noofviews',
					$wgLang->formatNum( $insight['metadata']['pv7'] )
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

		return [];
	}

	private function getArticleContributeText( $metadata ) {
		if ( !empty( $metadata['wantedBy'] ) ) {
			return wfMessage( 'communitypage-page-list-create' )->text();
		}

		return wfMessage( 'communitypage-page-list-edit' )->text();
	}

	/**
	 * Get message with article metadata details
	 *
	 * @param array $metadata
	 * @return string
	 */
	private function getArticleMetadataDetails( $metadata ) {
		global $wgUser, $wgLang;

		if ( !empty( $metadata['wantedBy'] ) ) {
			return wfMessage( $metadata['wantedBy']['message'] )->rawParams(
				Html::element(
					'a',
					[
						'href' => $metadata['wantedBy']['url'],
						'data-tracking' => 'wanted-by-link',
					],
					$metadata['wantedBy']['value']
				)
			)->escaped();
		}

		$timestamp = wfTimestamp( TS_UNIX, $metadata['lastRevision']['timestamp'] );

		return wfMessage( 'communitypage-lastrevision' )->rawParams(
			Html::element(
				'a',
				[
					'href' => $metadata['lastRevision']['userpage'],
					'data-tracking' => 'user-profile-link',
				],
				$metadata['lastRevision']['username']
			),
			$wgLang->userDate( $timestamp, $wgUser )
		)->escaped();
	}
}
