<?php

/**
 * @method setLimit
 */
class PhalanxService extends Service {
	/* limit of blocks */
	private $limit = 1;
	/* @var User */
	private $user = null;

	const RES_OK = 'ok';
	const RES_FAILURE = 'failure';
	const RES_STATUS = 'PHALANX ALIVE';

	public function __call($name, $args) {
		$method = substr($name, 0, 3);
		$key = strtolower( substr( $name, 3 ) );

		$result = null;
		switch($method) {
			case 'get':
				if ( isset( $this->$key ) ) {
					$result = $this->$key;
				}
				break;
			case 'set':
				$this->$key = $args[0];
				$result = $this;
				break;
			default:
				throw new WikiaException('PhalanxService::_call supports getters and setters only');
		}
		return $result;
	}

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
	public function check( $type, $content, $lang = "" ) {
		return $this->sendToPhalanxDaemon( "check", array( "type" => $type, "content" => $content, "lang" => $lang ) );
	}

	/**
	 * service for match function
	 *
	 * @param string $type     one of: content, summary, title, user, question_title, recent_questions, wiki_creation, cookie, email
	 * @param string/Array $content  text to be checked
	 * @param string $lang     language code (eg. en, de, ru, pl). "en" will be assumed if this is missing
	 */
	public function match( $type, $content, $lang = "" ) {
		return $this->sendToPhalanxDaemon( "match", array( "type" => $type, "content" => $content, "lang" => $lang ) );
	}

	/**
	 * Send expected results for comparison
	 */
	public function matchShadow($type, $content, $expected_id, $lang = "" ) {
		wfProfileIn( __METHOD__  );
		$result =  $this->sendToPhalanxDaemon( "match", array( "type" => $type, "content" => $content,
			"expected" => $expected_id, "lang" => $lang ) );
		wfProfileOut( __METHOD__  );
		return $result;
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
	 * service for stats method
	 *
	 * @example curl "http://localhost:8080/stats"
	 *
	 */
	public function stats() {
		return $this->sendToPhalanxDaemon( "stats", array() );
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

		$baseurl = F::app()->wg->PhalanxServiceUrl;
		$options = F::app()->wg->PhalanxServiceOptions;

		$url = sprintf( "%s/%s", $baseurl, $action != "status" ? $action : "" );
		/**
		 * for status we're sending GET
		 */
		if( $action == "status" ) {
			wfDebug( __METHOD__ . ": calling $url\n" );
			$response = Http::get( $url, 'default', $options );
		}
		/**
		 * for any other we're sending POST
		 */
		else {
			if (($action == "match" || $action == "check") && !is_null( $this->user ) ) {
				$parameters[ 'wiki' ] = F::app()->wg->CityId;
				$parameters[ 'user' ][] = $this->user->getName();
			}
			if ($action == "match" && $this->limit != 1) {
				$parameters['limit'] = $this->limit;
			}

			$postData = array();
			if ( !empty( $parameters ) ) {
				foreach ( $parameters as $key => $values ) {
					if ( is_array( $values ) ) {
						foreach ( $values as $val ) {
							$postData[] = urlencode( $key ) . '=' . urlencode( $val );
						}
					} else {
						$postData[] = urlencode( $key ) . '=' . urlencode( $values );
					}
				}
			}

			$options["postData"] = implode( "&", $postData );
			wfDebug( __METHOD__ . ": calling $url with POST data " . $options["postData"] ."\n" );
			wfDebug( __METHOD__ . ": " . json_encode($parameters) ."\n" );
			$response = Http::post( $url, $options);
		}

		if ( $response === false ) {
			/* service doesn't work */
			$res = false;
		} else {
			wfDebug( __METHOD__ . "::response - {$response}\n" );

			switch ( $action ) {
				case "stats":
					$res = ( is_null( $response ) ) ? false : $response;
					break;
				case "status":
					$res = ( stripos( $response, self::RES_STATUS  ) !== false ) ? true : false;
					break;
				case "match" :
					$ret = json_decode( $response );
					if ( !is_array( $ret ) ) {
						$res = false;
					}
					else {
						if (count($ret)>0 && $this->limit != 0) {
							if ( $this->limit == 1 ) {
								$res = $ret[0];
							} else {
								$res = array_slice( $ret, 0, $this->limit );
							}
						} else {
							$res = 0;
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
