<?php

class RWEPageHeaderController extends WikiaController {

	public function index() {
		$this->searchModel = $this->getSearchData();
//		ddd($this->searchModel);
	}

	private function getSearchData() {
		return $this->sendRequest( 'DesignSystemApi', 'getNavigation', [
			'id' => $this->wg->CityId,
			'product' => 'wikis',
			'lang' => $this->wg->Lang->getCode()
		] )->getData()['search'];
	}
}
