<?php

class DesignSystemGlobalNavigationService extends WikiaService {
	public function index() {
		$this->setVal( 'model', $this->getData() );
	}

	public function linkBranded() {
		$this->setVal( 'model', $this->getVal( 'model' ) );
	}

	public function dropdown() {
		$this->response->setValues( [
			'model' => $this->getVal( 'model' ),
			'type' => $this->getVal( 'type', 'link' ),
			'rightAligned' => $this->request->getBool( 'rightAligned' ),
		] );
	}

	public function accountNavigation() {
		$this->setVal( 'model', $this->getVal( 'model' ) );
	}

	public function dropdownLink() {
		$this->setVal( 'model', $this->getVal( 'model' ) );
	}

	public function linkAuthentication() {
		$this->setVal( 'model', $this->getVal( 'model' ) );
	}

	private function getData() {
		return $this->sendRequest( 'DesignSystemApi', 'getNavigation', [
			'wikiId' => $this->wg->CityId,
			'lang' => $this->wg->Lang->getCode()
		] )->getData();
	}
}
