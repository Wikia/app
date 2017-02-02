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
		global $wgBlankImgUrl;

		$model = new PortabilityDashboardModel();
		$langFilter = $this->getVal( static::LANGUAGE_FILTER_QS_PARAM, '' );
		$wikiUrlParam = $this->getVal( static::WIKI_URL_QS_PARAM, '' );
		$isLangFilterSet = !empty( $langFilter );
		$isWikiUrlParamSet = !empty( $wikiUrlParam );
		$noResultsInfoMessageKey = 'portability-dashboard-no-results-info';

		if ( $isWikiUrlParamSet ) {
			$list = $model->getWikiDataByUrl( Sanitizer::encodeAttribute( $wikiUrlParam ) );
		} else {
			$list = $model->getRowList();
		}

		// add data needed for portability dashboard: wiki url, title and lang
		$list = $model->extendList( $list );

		if ( $isLangFilterSet ) {
			$list = $this->filterListByLang( $list, $langFilter );
			$noResultsInfoMessageKey = 'portability-dashboard-no-results-for-lang-info';
		}

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
		$this->response->setValues( [
			// template model
			'list' => $list,
			// template helpers
			'typelessTemplatesInsightsPath' =>  static::SPECIAL_INSIGHTS_PATH . static::SPECIAL_INSIGHTS_TYPELESS_TEMPLATE_PAGE,
			'customInfoboxesInsightsPath' => static::SPECIAL_INSIGHTS_PATH . static::SPECIAL_CUSTOM_INFOBOXES_PAGE,
			'langList' => $this->extendLanguagesListWithActiveLanguage( static::SUPPORTED_LANGUAGE_FILTERS, $langFilter ),
			'isLangFilterSet'=> $isLangFilterSet,
			'langQSParam' => static::LANGUAGE_FILTER_QS_PARAM,
			'blankImgUrl' => $wgBlankImgUrl,
			// i18n template strings
			'langFilterLabel' => wfMessage( 'portability-dashboard-language-filter-label' )->text(),
			'dashboardLegend' => wfMessage( 'portability-dashboard-hover-info' )->text(),
			'allLangFilter'=> wfMessage( 'portability-dashboard-language-filter-all' )->text(),
			'searchHeadline' => wfMessage( 'portability-dashboard-search-headline' )->text(),
			'searchPlaceholder' => wfMessage( 'portability-dashboard-search-placeholder' )->text(),
			'dashboardLabels'=> $this->getDashboardLabels(),
			'templatesWithoutTypeUrlTitle' => wfMessage( 'portability-dashboard-special-insights-template-without-title' )->text(),
			'customInfoboxesInsightsUrlTitle' => wfMessage( 'portability-dashboard-special-insights-custom-infobox-title' )->text(),
			'refreshFreqInfo' => wfMessage( 'portability-dashboard-refresh-frequency-info' )->text(),
			'noResultsInfo' => wfMessage( $noResultsInfoMessageKey, PortabilityDashboardModel::WIKIS_LIMIT )->text()
		] );

		Wikia::addAssetsToOutput( 'special_portability_dashboard_scss' );
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
