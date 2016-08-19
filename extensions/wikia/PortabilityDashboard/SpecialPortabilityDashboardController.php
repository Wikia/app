<?php

class SpecialPortabilityDashboardController extends WikiaSpecialPageController {
	const SPECIAL_INSIGHTS_PATH = '/wiki/Special:Insights/';
	const SPECIAL_INSIGHTS_TYPELESS_TEMPLATE_PAGE = 'templateswithouttype';
	const SPECIAL_CUSTOM_INFOBOXES_PAGE = 'nonportableinfoboxes';
	const LANGUAGE_FILTER_QS_PARAM = 'lang';
	const WIKI_URL_QS_PARAM = 'url';
	const SUPPORTED_LANGUAGE_FILTERS = [ 'de', 'en', 'es', 'fr', 'id', 'it', 'ja', 'ko', 'nl', 'pl', 'pt', 'pt-br',
		'ru', 'vi', 'zh', 'zh-hk' ];


	public function __construct() {
		parent::__construct( 'PortabilityDashboard', 'pidash', true );
	}

	public function index() {
		$langFilter = $this->getVal( static::LANGUAGE_FILTER_QS_PARAM, '' );
		$wikiUrlParam = $this->getVal( static::WIKI_URL_QS_PARAM, '' );
		$isLangFilterSet = !empty( $langFilter );
		$list = $this->getResultsList( $langFilter, $wikiUrlParam );
		$noResultsInfoMessage = wfMessage(
			$isLangFilterSet ? 'portability-dashboard-no-results-for-lang-info' : 'portability-dashboard-no-results-for-url-info',
			PortabilityDashboardModel::WIKIS_LIMIT
		)->text();

		// template model
		$this->response->setVal( 'list', $list );

		// template helpers
		$this->response->setVal(
			'typelessTemplatesInsightsPath', self::SPECIAL_INSIGHTS_PATH . self::SPECIAL_INSIGHTS_TYPELESS_TEMPLATE_PAGE
		);
		$this->response->setVal(
			'customInfoboxesInsightsPath', self::SPECIAL_INSIGHTS_PATH . self::SPECIAL_CUSTOM_INFOBOXES_PAGE
		);
		$this->response->setVal(
			'langList',
			$this->extendLanguagesListWithActiveLanguage(
				self::SUPPORTED_LANGUAGE_FILTERS,
				$langFilter
			)
		);
		$this->response->setVal( 'isLangFilterSet', $isLangFilterSet );
		$this->response->setVal( 'langQSParam', self::LANGUAGE_FILTER_QS_PARAM );

		// i18n template strings
		$this->response->setVal( 'langFilterLabel', wfMessage( 'portability-dashboard-language-filter-label' )->text() );
		$this->response->setVal( 'dashboardLegend', wfMessage( 'portability-dashboard-hover-info' )->text() );
		$this->response->setVal( 'allLangFilter', wfMessage( 'portability-dashboard-language-filter-all' )->text() );
		$this->response->setVal( 'dashboardLabels', $this->getDashboardLabels() );
		$this->response->setVal(
			'templatesWithoutTypeUrlTitle', wfMessage( 'portability-dashboard-special-insights-template-without-title'
		)->text() );
		$this->response->setVal(
			'customInfoboxesInsightsUrlTitle', wfMessage( 'portability-dashboard-special-insights-custom-infobox-title'
		)->text() );
		$this->response->setVal( 'refreshFreqInfo', wfMessage( 'portability-dashboard-refresh-frequency-info' )->text() );
		$this->response->setVal( 'noResultsInfo', $noResultsInfoMessage );
		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );

		Wikia::addAssetsToOutput( 'special_portability_dashboard_scss' );
	}

	private function getResultsList( $langFilter, $wikiUrlParam ) {
		$model = new PortabilityDashboardModel();

		if ( empty( $wikiUrlParam ) ) {
			$modelList = $model->getList();
			$list = empty( $langFilter ) ? $modelList : $this->filterListByLang( $modelList, $langFilter );
		} else {
			$list = $model->getWikiByUrl( Sanitizer::encodeAttribute( $wikiUrlParam ) );
		}

		return $list;
	}

	/**
	 * extends languages list with active language filter
	 * @param array $list - languages list
	 * @param string $activeLangFilter - language code for active language filter
	 * @return array - extended languages list
	 */
	private function extendLanguagesListWithActiveLanguage( $list, $activeLangFilter ) {
		return array_map( function ( $item ) use ( $activeLangFilter ) {
			return [
				'lang' => $item,
				'active' => $item === $activeLangFilter
			];
		}, $list );
	}

	/**
	 * filters model by language
	 * @param array $list - model
	 * @param string $langFilter - language code
	 * @return array - filtered model
	 */
	private function filterListByLang( $list, $langFilter ) {
		return array_filter( $list, function ( $item ) use ( $langFilter ) {
			return $item[ 'wikiLang' ] === $langFilter;
		} );
	}

	/**
	 * gets dashboard labels with descriptions
	 * @return array - dashboard labels data
	 */
	private function getDashboardLabels() {
		return [
			[
				'header' => $this->renderTooltip(
					wfMessage( 'portability-dashboard-community-header' )->text(),
					wfMessage( 'portability-dashboard-community-desc' )->text()
				)
			],
			[
				'header' => $this->renderTooltip(
					wfMessage( 'portability-dashboard-lang-header' )->text(),
					wfMessage( 'portability-dashboard-lang-desc' )->text()
				)
			],
			[
				'header' => $this->renderTooltip(
					wfMessage( 'portability-dashboard-portability-header' )->text(),
					wfMessage( 'portability-dashboard-portability-desc' )->text()
				)
			],
			[
				'header' => $this->renderTooltip(
					wfMessage( 'portability-dashboard-infobox-portability-header' )->text(),
					wfMessage( 'portability-dashboard-infobox-portability-desc' )->text()
				)
			],
			[
				'header' => $this->renderTooltip(
					wfMessage( 'portability-dashboard-traffic-header' )->text(),
					wfMessage( 'portability-dashboard-traffic-desc' )->text()
				)
			],
			[
				'header' => $this->renderTooltip(
					wfMessage( 'portability-dashboard-templates-header' )->text(),
					wfMessage( 'portability-dashboard-templates-desc' )->text()
				)
			],
			[
				'header' => $this->renderTooltip(
					wfMessage( 'portability-dashboard-infoboxes-header' )->text(),
					wfMessage( 'portability-dashboard-infoboxes-desc' )->text()
				)
			],
			[
				'header' => $this->renderTooltip(
					wfMessage( 'portability-dashboard-impact-header' )->text(),
					wfMessage( 'portability-dashboard-impact-desc' )->text()
				)
			],
		];
	}

	private function renderTooltip( $text, $tooltip ) {
		return $this->app->renderView( 'WikiaStyleGuideTooltipIconController', 'index', [
			'text' => $text,
			'tooltipIconTitle' => $tooltip
		] );
	}
}
