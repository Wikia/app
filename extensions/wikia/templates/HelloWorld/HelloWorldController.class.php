<?php

/**
 * This is an example use of controller
 * @author Christian
 *
 */
class HelloWorldController extends WikiaController {

	/**
	 * This function simply exists to render the index template
	 */
	public function index() {
		$this->setVal( 'html5logo', $this->wg->ExtensionsPath . '/wikia/templates/HelloWorld/images/html5logo.png');
	}

}