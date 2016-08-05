<?php

class DesignSystemGlobalFooterController extends WikiaController {
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
		$model = $this->getVal( 'model' );

		$messageKey = $model['description']['key'];
		$params = $model['description']['params'];


		$this->setVal( 'model', $model );
	}

	private function getData() {
		global $wgCityId, $wgLang;

		return $this->sendRequest( 'DesignSystemApi', 'getFooter', [
			'wikiId' => $wgCityId,
			'lang' => $wgLang->getCode()
		] )->getData();
	}
}
