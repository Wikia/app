<?php

class InsightsController extends WikiaSpecialPageController {

	public function __construct() {
		parent::__construct('Insights', 'insights', true);
	}

	public function index() {
		wfProfileIn(__METHOD__);

		$model = new QueryPagesModel( 'UncategorizedPagesPage' );

		$this->wg->Out->setPageTitle( wfMessage( 'insights' )->escaped() );

		$this->list = $model->getList();
		$this->offset = 0;

		wfProfileOut(__METHOD__);
	}
} 
