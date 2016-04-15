<?php

class SpecialPortabilityDashboardController extends WikiaSpecialPageController {
	const SPECIAL_INSIGHTS_PATH = '/wiki/Special:Insights/';
	const SPECIAL_INSIGHTS_TYPELESS_TEMPLATE_PAGE = 'templateswithouttype';
	const SPECIAL_CUSTOM_INFOBOXES_PAGE = 'nonportableinfoboxes';


	public function __construct() {
		parent::__construct( 'PortabilityDashboard', 'pidash', true );
	}

	public function index() {
		$model = new PortabilityDashboardModel();

		Wikia::addAssetsToOutput( 'special_portability_dashboard_scss' );

		// template model 
		$this->response->setVal( 'list', $model->getList() );

		// template helpers
		$this->response->setVal(
			'typelessTemplatesInsightsPath', self::SPECIAL_INSIGHTS_PATH . self::SPECIAL_INSIGHTS_TYPELESS_TEMPLATE_PAGE
		);
		$this->response->setVal(
			'customInfoboxesInsightsPath', self::SPECIAL_INSIGHTS_PATH . self::SPECIAL_CUSTOM_INFOBOXES_PAGE
		);

		// i18n template strings
		$this->response->setVal( 'dashboardLegend', wfMessage( 'portability-dashboard-hover-info' )->text() );
		$this->response->setVal( 'dashboardLabels', [
			[
				'name' => wfMessage( 'portability-dashboard-community-header' )->text(),
				'description' => wfMessage( 'portability-dashboard-community-desc' )->text()
			],
			[
				'name' => wfMessage( 'portability-dashboard-lang-header' )->text(),
				'description' => wfMessage( 'portability-dashboard-lang-desc' )->text()
			],
			[
				'name' => wfMessage( 'portability-dashboard-portability-header' )->text(),
				'description' => wfMessage( 'portability-dashboard-portability-desc' )->text()
			],
			[
				'name' => wfMessage( 'portability-dashboard-infobox-portability-header' )->text(),
				'description' => wfMessage( 'portability-dashboard-infobox-portability-desc' )->text()
			],
			[
				'name' => wfMessage( 'portability-dashboard-traffic-header' )->text(),
				'description' => wfMessage( 'portability-dashboard-traffic-desc' )->text()
			],
			[
				'name' => wfMessage( 'portability-dashboard-templates-header' )->text(),
				'description' => wfMessage( 'portability-dashboard-templates-desc' )->text()
			],
			[
				'name' => wfMessage( 'portability-dashboard-infoboxes-header' )->text(),
				'description' => wfMessage( 'portability-dashboard-infoboxes-desc' )->text()
			],
			[
				'name' => wfMessage( 'portability-dashboard-impact-header' )->text(),
				'description' => wfMessage( 'portability-dashboard-impact-desc' )->text()
			],
		] );

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}
}
