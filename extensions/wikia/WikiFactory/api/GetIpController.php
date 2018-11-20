<?php

use Wikia\Logger\Loggable;

class GetIpController extends WikiaController {
	use Loggable;
	const PARAMETER_ID = 'id';


	public function init() {
		$this->assertCanAccessController();
	}

	public function getIp() {
		$context = $this->getContext();
		$request = $context->getRequest();

		$id = $request->getVal( self::PARAMETER_ID);
		if ( empty( $id ) || !is_numeric($id) ) {
			$this->response->setCode( 400 );
			return;
		}

		$wiki = WikiFactory::getWikiByID( $id );
		if ( empty( $wiki ) ) {
			$this->response->setCode( 404 );
			return;
		}

		$this->response->setFormat( WikiaResponse::FORMAT_JSON );
		$ip = inet_ntop($wiki->city_founding_ip_bin);

		$this->response->setBody($ip);
		return $ip;
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