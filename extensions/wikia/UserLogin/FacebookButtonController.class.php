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
		$this->tabindex = $this->request->getVal('tabindex', null);

		if ( $this->app->checkSkin( 'wikiamobile' ) ) {
			JSMessages::registerPackage( 'fblogin' , array( 'wikiamobile-facebook-connect-fail' ) );

			if ( F::app()->wg->Title->isSpecial('Userlogin') ) {
				JSMessages::enqueuePackage( 'fblogin', 'inline' );
			}

			$this->response->setVal( 'requestType', $this->request->getVal( 'requestType' ) );
			$this->overrideTemplate( 'WikiaMobileIndex' );
		}
	}
}