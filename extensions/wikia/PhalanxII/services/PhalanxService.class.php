<?php

class PhalanxService extends Service {

	private $mModule;
	private $mLang;
	private $mType;


	public function check() {
		$this->sendToPhalanxDaemon( "check", array( "type" => "test", "content" => "fuckąężźćńół") );
	}

	/**
	 * Send prepared request request to phalanx daemon
	 *
	 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
	 * @access private
	 *
	 * @param $action String type of action
	 * @param $parameters Array additional parameters as hash table
	 */
	private function sendToPhalanxDaemon( $action, $parameters ) {
		global $wgPhalanxServiceUrl;

		// but for now we just build test url
		$url = sprintf("%s/%s?%s",
			"http://localhost:8080/",
			$action,
			http_build_query( $parameters )
		);

		return Http::post( $url );
	}

};
