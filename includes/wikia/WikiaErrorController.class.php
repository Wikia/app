<?php

class WikiaErrorController extends WikiaController {

	public function error() {
		$code = $this->getResponse()->getException()->getCode();

		if( empty($code) ) {
			$code = 501;
		}

		$this->getResponse()->setCode( $code );
	}
}