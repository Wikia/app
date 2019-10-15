<?php

class DesignSystemGlobalFooterService extends WikiaService {
	public function index() {
		$model = $this->getData();

		$this->setVal( 'model', $model );

		if ($model['is-wikia-org']) {
			$this->overrideTemplate('WikiaOrg_index');
		}
	}

	public function section() {
		$this->response->setValues( [
			'model' => $this->getVal( 'model' ),
			'name' => $this->getVal( 'name' ),
		] );
	}

	public function linkBranded() {
		$this->setVal( 'model', $this->getVal( 'model' ) );
	}

	public function linkImage() {
		$this->setVal( 'model', $this->getVal( 'model' ) );
	}

	public function linkText() {
		$this->setVal( 'model', $this->getVal( 'model' ) );
	}

	private function getData() {
		return $this->sendRequest( 'DesignSystemApi', 'getFooter', [
			'id' => $this->wg->CityId,
			'product' => 'wikis',
			'lang' => $this->wg->Lang->getCode(),
			'footer_version' => '2',
		] )->getData();
	}
}
