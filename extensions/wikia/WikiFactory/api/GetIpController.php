<?php

class GetIpController extends WikiaController {
	use Loggable;

	public function init() {
		$this->assertCanAccessController();
	}

	public function annotateNotSpam($wikiId) {
		$ip = WikiFactory::getIp( $wikiId );
		$this->info("This is IP of the " + $wikiId + " wiki: " + $ip);
	}

	/**
	 * Make sure to only allow authorized methods.
	 * @throws WikiaHttpException
	 */
	public function assertCanAccessController() {
		if ( !$this->getContext()->getRequest()->isWikiaInternalRequest() ) {
			throw new ForbiddenException( 'Access to this controller is restricted' );
		}
	}
}