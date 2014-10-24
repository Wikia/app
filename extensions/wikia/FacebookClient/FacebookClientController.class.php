<?php

class FacebookClientController extends WikiaController {
	const DEFAULT_TEMPLATE_ENGINE = WikiaResponse::TEMPLATE_ENGINE_MUSTACHE;

	/**
	 *
	 */
	public function index() {

	}

	public function preferences() {
		$this->facebookDisconnectLink = wfMessage( 'facebookclient-disconnect-link' )->plain();
		$this->facebookDisconnectDone = wfMessage( 'facebookclient-disconnect-done' );
		$this->blankImgUrl = F::app()->wg->BlankImgUrl;

		if ( F::app()->wg->User->getOption( 'fbFromExist' ) ) {
			$this->facebookDisconnectInfo = wfMessage( 'facebookclient-disconnect-info-existing' );
		} else {
			$this->facebookDisconnectInfo = wfMessage( 'facebookclient-disconnect-info' );
		}
	}
}
