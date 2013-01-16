<?php

class PhalanxService extends Service {

	/**
	 * check service status
	 */
	public function status() {
		$response = $this->sendToPhalanxDaemon( "status", array() );
	}

	/**
	 * service for check function
	 *
	 * @param string $type     one of: content, summary, title, user, question_title, recent_questions, wiki_creation, cookie, email
	 * @param string $content  text to be checked
	 * @param string $lang     language code (eg. en, de, ru, pl). "en" will be assumed if this is missing
	 */
	public function check( $type, $content, $lang = "en" ) {
		$this->sendToPhalanxDaemon( "check", array( "type" => $test, "content" => $content, "lang" => $lang ) );
	}

	/**
	 * service for match function
	 *
	 * @param string $type     one of: content, summary, title, user, question_title, recent_questions, wiki_creation, cookie, email
	 * @param string $content  text to be checked
	 * @param string $lang     language code (eg. en, de, ru, pl). "en" will be assumed if this is missing
	 */
	public function match( $type, $content, $lang = "en" ) {
		$this->sendToPhalanxDaemon( "match", array( "type" => $test, "content" => $content, "lang" => $lang ) );
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

		wfProfileIn( __METHOD__  );

		// but for now we just build test url
		$url = sprintf("%s/%s",
			"http://localhost:8080/",
			$action
		);
		if( sizeof( $parameters ) ) {
			$url .= "?" . http_build_query( $parameters );
		}

		/**
		 * for status we're sending GET
		 */
		if( $action == "status" ) {
			$response = Http::get( $url, 'default', array( "noProxy" => true ) );
		}
		/**
		 * for any other we're sending POST
		 */
		else {
			$response = Http::post( $url, 'default', array( "noProxy" => true ) );
		}
		wfProfileOut( __METHOD__  );
	}

};
