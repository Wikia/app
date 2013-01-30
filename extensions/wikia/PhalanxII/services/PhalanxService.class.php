<?php


#$wgPhalanxServiceUrl = "http://dev-$wgDevelEnvironmentName:8080";

class PhalanxService extends Service {

	const RES_OK = 'ok';
	const RES_FAILURE = 'failure';
	const RES_STATUS = 'PHALANX ALIVE';


	/**
	 * check service status
	 */
	public function status() {
		$response = $this->sendToPhalanxDaemon( "status", array() );
		return ( stripos( $response, self::RES_STATUS  ) !== false ) ? true : false;
	}

	/**
	 * service for check function
	 *
	 * @param string $type     one of: content, summary, title, user, question_title, recent_questions, wiki_creation, cookie, email
	 * @param string $content  text to be checked
	 * @param string $lang     language code (eg. en, de, ru, pl). "en" will be assumed if this is missing
	 */
	public function check( $type, $content, $lang = "en" ) {
		$response = $this->sendToPhalanxDaemon( "check", array( "type" => $type, "content" => $content, "lang" => $lang ) );
		if ( $response !== false ) {
			if ( stripos( $response, self::RES_OK  ) !== false ) {
				$ret = 1;
			} elseif ( stripos( $response, self::RES_FAILURE ) !== false ) {
				$ret = 0;
			} else {
				/* invalid response */
				$ret = false;
			}
		} else {
			/* service doesn't work */
			$ret = false;
		}

		return $ret;
	}

	/**
	 * service for match function
	 *
	 * @param string $type     one of: content, summary, title, user, question_title, recent_questions, wiki_creation, cookie, email
	 * @param string $content  text to be checked
	 * @param string $lang     language code (eg. en, de, ru, pl). "en" will be assumed if this is missing
	 */
	public function match( $type, $content, $lang = "en" ) {
		$response = $this->sendToPhalanxDaemon( "match", array( "type" => $type, "content" => $content, "lang" => $lang ) );
		if ( $response !== false ) {
			$res = json_decode( $response );
			if ( is_null( $res ) ) {
				/* don't match any blocks */
				$ret = 0;
			} else {
				if ( is_array( $res ) ) {
					/* first block ID ? */
					reset( $res ); $ret = current( $res );
				} else {
					$ret = $res;
				}
			}
		} else {
			/* service doesn't work */
			$ret = false;
		}

		return $ret;
	}

	/**
	 * service for reload function
	 *
	 * @example curl "http://localhost:8080/reload?changed=1,2,3"
	 *
	 * @param array $changed -- list of rules to reload, default empty array so reload all
	 *
	 */
	public function reload( $changed = array() ) {
		$response = $this->sendToPhalanxDaemon( "reload",
			is_array( $changed ) && sizeof( $changed )
				? array( "changed" => implode( ",", $changed ) )
				: array()
		);

		if ( $response !== false ) {
			if ( stripos( $response, self::RES_OK  ) !== false ) {
				$ret = 1;
			} elseif ( stripos( $response, self::RES_FAILURE ) !== false ) {
				$ret = 0;
			} else {
				/* invalid response */
				$ret = false;
			}
		} else {
			/* service doesn't work */
			$ret = false;
		}

		return $ret;
	}

	/**
	 * service for validate regex in service
	 *
	 * @example curl "http://localhost:8080/validate?regex=^alamakota$"
	 *
	 * @param $regex String
	 *
	 */
	public function validate( $regex ) {
		$response = $this->sendToPhalanxDaemon( "validate", array( "regex" => $regex ) );

		if ( $response !== false ) {
			if ( stripos( $response, self::RES_OK  ) !== false ) {
				$ret = 1;
			} elseif ( stripos( $response, self::RES_FAILURE ) !== false ) {
				$ret = 0;
			} else {
				/* invalid response */
				$ret = false;
			}
		} else {
			/* service doesn't work */
			$ret = false;
		}

		return $ret;
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

		wfProfileIn( __METHOD__  );

		$url = sprintf( "%s/%s", F::app()->wg->PhalanxServiceUrl, $action != "status" ? $action : "" );

		if( sizeof( $parameters ) ) {
			$url .= "?" . http_build_query( $parameters );
		}
		wfDebug( __METHOD__ . ": calling $url\n" );

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
			$response = Http::post( $url, array( "noProxy" => true ) );
		}


		wfProfileOut( __METHOD__  );

		return $response;
	}
};
