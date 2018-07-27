<?php

class DesignSystemGlobalNavigationService extends WikiaService {

	public function index() {
		$this->setVal( 'model', $this->getData() );
	}

	public function partnerSlot() {
		$this->setVal( 'model', $this->getVal( 'model' ) );
	}

	public function search() {
		$this->setVal( 'model', $this->getVal( 'model' ) );
	}

	private function getData() {
		return $this->sendRequest( 'DesignSystemApi', 'getNavigation', [
			'id' => $this->wg->CityId,
			'product' => 'wikis',
			'lang' => $this->wg->Lang->getCode(),
			'version' => '2',
		] )->getData();
	}
}
