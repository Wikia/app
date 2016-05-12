<?php

class CommunityPageSpecialInsightsModel {
	const INSIGHTS_MODULE_ITEMS = 5;
	const INSIGHTS_MODULE_SORT_TYPE = 'pvDiff';
	const INSIGHTS_MODULES = [
		'popularpages' => 'pvDiff'
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
			'edittext' => wfMessage( 'communitypage-page-list-edit' )->text(),
			'fulllist' => wfMessage( 'communitypage-full-list' )->text()
		];

		foreach ( self::INSIGHTS_MODULES as $insight => $sortingType ) {
			$module = $this->getInsightModule( $insight, $sortingType );
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
	private function getInsightModule( $type, $sortingType = self::INSIGHTS_MODULE_SORT_TYPE ) {
		$insightPages['pages'] = $this->insightsService->getInsightPages(
			$type,
			self::INSIGHTS_MODULE_ITEMS,
			$sortingType
		);

		if ( empty( $insightPages['pages'] ) ) {
			return [];
		}

		/**
		 * Covers messages:
		 *
		 * communitypage-popularpages-title'
		 * communitypage-popularpages-description'
		 */
		$insightPages['title'] = wfMessage( 'communitypage-' . $type. '-title' )->text();
		$insightPages['description'] =  wfMessage( 'communitypage-' . $type. '-description' )->text();

		$insightPages['fulllistlink'] = SpecialPage::getTitleFor( 'Insights', $type )->getLocalURL();

		$insightPages = $this->addLastRevision( $insightPages );

		return $insightPages;
	}

	/**
	 * @param array $insightsPages
	 * @return array Prepare message about who and when last edited given article
	 * @throws MWException
	 */
	private function addLastRevision( $insightsPages ) {
		foreach ( $insightsPages['pages'] as $key => $insight ) {
			$insightsPages['pages'][$key]['metadataDetails'] = $this->getArticleMetadataDetails( $insight['metadata'] );
			$insightsPages['pages'][$key]['editlink'] = $this->getEditUrl( $insight['link']['url'] );

			if ( !empty( $insightsPages['pages'][$key]['pageviews'] ) ) {
				$insightsPages['pages'][$key]['pageviews'] = wfMessage(
					'communitypage-noofviews',
					$insight['metadata']['pv7']
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
					['href' => $metadata['wantedBy']['url']],
					$metadata['wantedBy']['value']
				)
			)->escaped();
		}

		$timestamp = wfTimestamp( TS_UNIX, $metadata['lastRevision']['timestamp'] );

		return wfMessage( 'communitypage-lastrevision' )->rawParams(
			Html::element(
				'a',
				['href' => $metadata['lastRevision']['userpage']],
				$metadata['lastRevision']['username']
			),
			$wgLang->userDate( $timestamp, $wgUser )
		)->escaped();
	}
}
