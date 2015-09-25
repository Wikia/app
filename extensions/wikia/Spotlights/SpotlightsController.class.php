<?php
class SpotlightsController extends WikiaController {
	public function index() {
		if ( class_exists( 'SeoTesting' ) ) {
			$this->setVal( 'seoTestOneH1', SeoTesting::getGroup('One_H1') === 2 );
		}
	}
}
