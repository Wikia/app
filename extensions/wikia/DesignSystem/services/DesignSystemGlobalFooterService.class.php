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

	public function imageHeader() {
		$this->response->setValues( [
			'model' => $this->getVal( 'model' ),
			'section' => $this->getVal( 'section' )
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
		// TODO uncomment after API changes from XW-1741 are merged to this branch
		//$model = $this->getVal( 'model' );
		$model = [
			'description' => [
				'type' => 'translatable-text',
				'key' => 'global-footer-licensing-and-vertical-description',
				'params' => [
					'sitename' => [
						'type' => 'text',
						'value' => 'Muppet Wiki'
					],
					'vertical' => [
						'type' => 'translatable-text',
						'key' => 'global-footer-licensing-and-vertical-description-param-vertical-tv'
					],
					'license' => [
						'type' => 'link-text',
						'title' => [
							'type' => 'text',
							'value' => 'CC-BY-SA'
						],
						'href' => 'http://wikia.com/Licensing'
					]
				]
			]
		];

		$this->setVal( 'model', $model );
	}

	private function getData() {
		return $this->sendRequest( 'DesignSystemApi', 'getFooter', [
			'wikiId' => $this->wg->CityId,
			'lang' => $this->wg->Lang->getCode()
		] )->getData();
	}
}
