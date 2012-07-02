<?php

/**
 * MenuButton with facebook styling
 *
 * @author macbre
 */
class FacebookButtonController extends WikiaController {

	public function index() {
		$this->class = $this->request->getVal('class', '');
		$this->text = $this->request->getVal('text', '');
		$this->tooltip = $this->request->getVal('tooltip');

		if ( $this->app->checkSkin( 'wikiamobile' ) ) {
			F::build( 'JSMessages' )->registerPackage( 'fblogin' , array( 'wikiamobile-facebook-connect-fail' ) );
			$this->response->setVal( 'requestType', $this->request->getVal( 'requestType' ) );
			$this->overrideTemplate( 'WikiaMobileIndex' );
		}
	}
}