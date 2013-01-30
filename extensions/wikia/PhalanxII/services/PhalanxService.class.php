<?php


#$wgPhalanxServiceUrl = "http://dev-$wgDevelEnvironmentName:8080";

class PhalanxService extends Service {
	private $response = null;

	const RES_OK = 'ok';
	const RES_FAILURE = 'failure';
	const RES_STATUS = 'PHALANX ALIVE';


	/**
	 * check service status
	 */
	public function status() {
		return $this->sendToPhalanxDaemon( "status", array() );
	}

	/**
	 * service for check function
	 *
	 * @param string $type     one of: content, summary, title, user, question_title, recent_questions, wiki_creation, cookie, email
	 * @param string $content  text to be checked
	 * @param string $lang     language code (eg. en, de, ru, pl). "en" will be assumed if this is missing
	 */
	public function check( $type, $content, $lang = "en" ) {
		return $this->sendToPhalanxDaemon( "check", array( "type" => $type, "content" => $content, "lang" => $lang ) );
	}

	/**
	 * service for match function
	 *
	 * @param string $type     one of: content, summary, title, user, question_title, recent_questions, wiki_creation, cookie, email
	 * @param string $content  text to be checked
	 * @param string $lang     language code (eg. en, de, ru, pl). "en" will be assumed if this is missing
	 */
	public function match( $type, $content, $lang = "en" ) {
		return $this->sendToPhalanxDaemon( "match", array( "type" => $type, "content" => $content, "lang" => $lang ) );
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
		return $this->sendToPhalanxDaemon( "reload", is_array( $changed ) && sizeof( $changed ) ? array( "changed" => implode( ",", $changed ) ) : array() );
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
		return $this->sendToPhalanxDaemon( "validate", array( "regex" => $regex ) );
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


		/**
		 * for status we're sending GET
		 */
		if( $action == "status" ) {
			wfDebug( __METHOD__ . ": calling $url\n" );
			$response = Http::get( $url, 'default', array( "noProxy" => true ) );
		}
		/**
		 * for any other we're sending POST
		 */
		else {
			wfDebug( __METHOD__ . ": calling $url with POST data " . wfArrayToCGI( $parameters ) ."\n" );
			$response = Http::post( $url, array( "noProxy" => true, "postData" => wfArrayToCGI( $parameters ) ) );
		}

		if ( $response === false ) {
			/* service doesn't work */
			$res = false;
		} else {
			switch ( $action ) {
				case "status":
					$res = ( stripos( $response, self::RES_STATUS  ) !== false ) ? true : false; break;
				case "match" :
					$ret = json_decode( $response );
					if ( is_null( $ret ) ) {
						/* don't match any blocks */
						$res = 0;
					} else {
						if ( is_array( $ret ) ) {
							/* first block ID ? */
							reset( $ret ); $res = current( $ret );
						} else {
							$res = $ret;
						}
					}
					break;
				default:
					if ( stripos( $response, self::RES_OK  ) !== false ) {
						$res = 1;
					} elseif ( stripos( $response, self::RES_FAILURE ) !== false ) {
						$res = 0;
					} else {
						/* invalid response */
						$res = false;
					}
					break;
			}
		}

		wfProfileOut( __METHOD__  );

		return $res;
	}
};
