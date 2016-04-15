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
		$this->response->setVal( 'thLabelCommunity', 'Community' );
		$this->response->setVal( 'thLabelPortability', 'Portability' );
		$this->response->setVal( 'thLabelInfoboxPortability', 'Infobox Portability' );
		$this->response->setVal( 'thLabelTraffic', 'Traffic' );
		$this->response->setVal( 'thLabelCustomInfoboxesCount', 'Non-portable Infoboxes' );
		$this->response->setVal( 'thLabelTyplessTemplatesCount', 'Unorganized Templates' );
		$this->response->setVal( 'thLabelMigrationImpact', 'Migration Impact' );

		$this->response->setTemplateEngine( WikiaResponse::TEMPLATE_ENGINE_MUSTACHE );
	}
}
