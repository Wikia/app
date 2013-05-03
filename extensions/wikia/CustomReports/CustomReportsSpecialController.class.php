<?php

class CustomReportsSpecialController extends WikiaSpecialPageController {
	
	public function __construct() {
		parent::__construct( 'CustomReports', '', false );
	}

	public function init() {
		$this->reports = array(
			'new_wikis' => array(
				'new_wikis',
			),
			'new_users' => array(
				'total_users',
				'confirmed_users',
				'temp_users',
				'facebook_users',
			),
			'founderemails' => array(
				'founderemails_sent',
				'founderemails_opens',
				'founderemails_clicks',
				'founderemails_clicks_per_sent',
				'founderemails_opens_per_sent',
			),
//			'allemails' => array(
//				'allemails_sent',
//				'allemails_opens',
//				'allemails_clicks',
//				'allemails_clicks_per_sent',
//				'allemails_opens_per_sent',
//			),
		);
		$this->height = 410;
		$this->width = 700;
		$this->opt_days = array(3,7,14,30,60);
	}
	
	public function index() {
		if (!$this->wg->User->isAllowed( 'customreports' )) {
			$this->displayRestrictionError();
			return false;  // skip rendering
		}
		
		$this->response->addAsset('extensions/wikia/CustomReports/css/CustomReports.scss');
		
		$code = $this->getVal('report', null);
		$days = $this->getVal('days', null);
		
		$this->charts = '';
		$this->report = $code;
		$this->days = $days;
		$this->action = $this->getTitle()->escapeLocalUrl();
		
		if (!is_null($code)) {
			$report = new Report($code, $days);
			$data = $report->get_data();
			foreach($data as $key => $data_xml) {
				$this->charts .= (string) $this->app->sendRequest('CustomReportsSpecial', 'getChart', array('data_xml'=>$data_xml, 'num_chart' => $key));
			}

			if (empty($this->charts)) {
				$this->charts = wfMsg( 'report-no-data' );
			}
		}
	}
	
	public function getChart() {
		$this->data_xml = $this->getVal('data_xml', null);
		$this->num_chart = $this->getVal('num_chart', 1);
		$this->swf = $this->wg->ExtensionsPath."/wikia/CustomReports/charts/FCF_MSLine.swf?chartWidth=".$this->width."&chartHeight=".$this->height."&".$this->wg->StyleVersion;
	}

}
