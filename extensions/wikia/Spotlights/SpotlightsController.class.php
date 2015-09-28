<?php
class SpotlightsController extends WikiaController {
	public function index() {
		if ( $this->wg->EnableSeoTestingExt ) {
			$this->setVal( 'seoTestOneH1', SeoTesting::getGroup('One_H1') === 2 );
		}
	}
}
