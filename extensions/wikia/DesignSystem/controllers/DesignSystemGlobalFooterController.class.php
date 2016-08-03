<?php

class DesignSystemGlobalFooterController extends WikiaController {
	public function index() {
		$this->setVal( 'model', $this->getData() );
	}

	public function section() {
		$this->setVal( 'model', $this->getVal( 'model' ) );
		$this->setVal( 'name', $this->getVal( 'name' ) );
		$this->setVal( 'parentName', $this->getVal( 'parentName' ) );
	}

	public function imageHeader() {
		$this->setVal( 'model', $this->getVal( 'model' ) );
		$this->setVal( 'section', $this->getVal( 'section' ) );
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

	/**
	 * TODO XW-1804 use the API and the proper language
	 *
	 * @return array
	 */
	private function getData() {
		global $wgCityId, $wgContentLanguage;

		$footerModel = new DesignSystemGlobalFooterModel( $wgCityId, $wgContentLanguage );

		return $footerModel->getData();
	}
}
