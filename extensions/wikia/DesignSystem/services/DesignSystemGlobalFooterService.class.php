<?php

class DesignSystemGlobalFooterService extends WikiaService {
	public function index() {
		$this->setVal( 'model', $this->getData() );
	}

	public function section() {
		$this->response->setValues( [
			'model' => $this->getVal( 'model' ),
			'name' => $this->getVal( 'name' ),
			'parentName' => $this->getVal( 'parentName' )
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

	public function licensingAndVertical() {
		$this->setVal( 'model', $this->getVal( 'model' ) );
	}

	private function getData() {
		return $this->sendRequest( 'DesignSystemApi', 'getFooter', [
			'id' => $this->wg->CityId,
			'product' => 'wikis',
			'lang' => $this->wg->Lang->getCode()
		] )->getData();
	}
}
