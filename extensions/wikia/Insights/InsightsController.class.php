<?php

class InsightsController extends WikiaSpecialPageController {
	private $model;

	public function __construct() {
		parent::__construct( 'Insights', 'insights', true );
	}

	public function index() {
		wfProfileIn( __METHOD__ );
		$this->wg->Out->setPageTitle( wfMessage( 'insights' )->escaped() );
		$this->addAssets();

		$this->subpage = $this->getPar();
		if ( !empty( $this->subpage ) ) {
			$this->renderSubpage();
		}

		wfProfileOut( __METHOD__ );
	}

	private function addAssets() {
		$this->response->addAsset( '/extensions/wikia/Insights/styles/insights.scss' );
	}

	public function renderSubpage() {
		switch ( $this->subpage ) {
			case 'uncategorized':
				$this->model = new InsightsUncategorizedModel();
				break;
			case 'wantedpages':
				$this->model = new InsightsWantedpagesModel();
				break;
			default:
				$this->response->redirect( $this->specialPage->getTitle()->getFullURL() );
		}

		$this->content = $this->model->getContent();
		$this->data = $this->model->getData();
		$this->overrideTemplate( $this->model->getTemplate() );
	}
} 
