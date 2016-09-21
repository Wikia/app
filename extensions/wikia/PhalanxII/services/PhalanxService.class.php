<?php

/**
 * @method setLimit
 * @method setUser
 */
class PhalanxService extends Service {

	use \Wikia\Logger\Loggable;

	/* limit of blocks */
	private $limit = 1;
	/* @var User */
	private $user = null;

	const RES_OK = 'ok';
	const RES_FAILURE = 'failure';
	const RES_STATUS = 'PHALANX ALIVE';
	const PHALANX_LOG_PARAM_LENGTH_LIMIT = 64;

	const PHALANX_SERVICE_TRIES_LIMIT = 3; // number of retries for phalanx POST requests
	const PHALANX_SERVICE_TRY_USLEEP = 20000; // delay between retries - 0.2s

	/**
	 * @var int PHALANX_SERVICE_RELOAD_TIMEOUT
	 * SUS-964: Give Phalanx /reload requests more time to succeed (25 seconds, the old default for $wgHttpTimeout)
	 * This does not affect site performance - /reload requests are sent only upon saving/modifying a block.
	 */
	const PHALANX_SERVICE_RELOAD_TIMEOUT = 25;

	protected function getLoggerContext() {
		return [
			'class' => __CLASS__
		];
	}

	/**
	 * @param $name
	 * @param $args
	 * @return null|PhalanxService
	 */
	public function __call($name, $args) {
		$method = substr($name, 0, 3);
		$key = lcfirst( substr( $name, 3 ) );

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
		wfProfileIn( __METHOD__  );
		$result =  $this->sendToPhalanxDaemon( "check", array( "type" => $type, "content" => $content, "lang" => $lang ) );
		wfProfileOut( __METHOD__  );
		return $result;
	}

	/**
	 * service for match function
	 *
	 * @param string $type     one of: content, summary, title, user, question_title, recent_questions, wiki_creation, cookie, email
	 * @param string/Array $content  text to be checked
	 * @param string $lang     language code (eg. en, de, ru, pl). "en" will be assumed if this is missing
	 */
	public function match( $type, $content, $lang = "" ) {
		wfProfileIn( __METHOD__  );
		if (is_array($content)) {
			$content = array_unique($content);
		}
		$result =  $this->sendToPhalanxDaemon( "match", array( "type" => $type, "content" => $content, "lang" => $lang ) );
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
		wfProfileIn( __METHOD__  );
		$result = $this->sendToPhalanxDaemon( "reload", is_array( $changed ) && sizeof( $changed ) ? array( "changed" => implode( ",", $changed ) ) : array() );
		wfProfileOut( __METHOD__  );
		return $result;
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
		wfProfileIn( __METHOD__  );
		$result =  $this->sendToPhalanxDaemon( "validate", array( "regex" => $regex ) );
		wfProfileOut( __METHOD__  );
		return $result;
	}

	/**
	 * service for stats method
	 *
	 * @example curl "http://localhost:8080/stats"
	 *
	 */
	public function stats() {
		wfProfileIn( __METHOD__  );
		$result = $this->sendToPhalanxDaemon( "stats", array() );
		wfProfileOut( __METHOD__  );
		return $result;
	}

	/**
	 * Send prepared request request to phalanx daemon
	 *
	 * @author Krzysztof Krzyżaniak (eloy) <eloy@wikia-inc.com>
	 * @access private
	 *
	 * @param $action String type of action
	 * @param $parameters Array additional parameters as hash table
	 * @return integer|mixed data of blocks applied or numeric value (0 - block applied, 1 - no block applied)
	 */
	private function sendToPhalanxDaemon( $action, $parameters ) {
		$baseurl = F::app()->wg->PhalanxServiceUrl;
		$options = F::app()->wg->PhalanxServiceOptions;

		$url = sprintf( "%s/%s", $baseurl, $action != "status" ? $action : "" );
		$requestTime = 0;
		$loggerPostParams = [];
		$tries = 1;
		/**
		 * for status we're sending GET
		 */
		if( $action == "status" ) {
			wfDebug( __METHOD__ . ": calling $url\n" );
			$requestTime = microtime( true );
			$response = Http::get( $url, 'default', $options );
			$requestTime = (int)( ( microtime( true ) - $requestTime ) * 10000.0 );
		}
		/**
		 * for any other we're sending POST
		 */
		else {
			/**
			 * city_id should be always known
			 */
			$parameters[ 'wiki' ] = F::app()->wg->CityId;

			if( ( $action == "match" || $action == "check") ) {
				if( !is_null( $this->user ) ) {
					$parameters[ 'user' ][] = $this->user->getName();
				} else {
					if ( ( new \Wikia\Util\Statistics\BernoulliTrial( 0.001 ) )->shouldSample() ) {
						$this->error(
							'PLATFORM-1387',
							[
								'exception'    => new Exception(),
								'block_params' => $parameters,
								'user_name'    => F::app()->wg->User->getName()
							]
						);
					}
				}
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
					$loggerPostParams[ $key ] = substr( json_encode( $values ), 0, self::PHALANX_LOG_PARAM_LENGTH_LIMIT );
				}
			}

			// SUS-964: Give reload requests more time to succeed
			// Reload requests are only sent upon saving/modifying a block,
			// so using a higher value here won't affect site performance
			if ( $action === 'reload' ) {
				$options['timeout'] = static::PHALANX_SERVICE_RELOAD_TIMEOUT;
			}

			$options["postData"] = implode( "&", $postData );
			wfDebug( __METHOD__ . ": calling $url with POST data " . $options["postData"] ."\n" );
			wfDebug( __METHOD__ . ": " . json_encode($parameters) ."\n" );
			$requestTime = microtime( true );

			// BAC-1332 - some of the phalanx service calls are breaking and we're not sure why
			// it's better to do the retry than maintain the PHP fallback for that
			while ( $tries <= self::PHALANX_SERVICE_TRIES_LIMIT ) {
				$response = Http::post( $url, $options );
				if ( false !== $response) {
					break;
				}
				if ( $tries <  self::PHALANX_SERVICE_TRIES_LIMIT ) { // don't wait after the last try
					// wait for 0.02 second
					usleep( self::PHALANX_SERVICE_TRY_USLEEP );
				}
				$tries++;

				$this->error( "Phalanx service error - retrying...", [
					"phalanxUrl" => $url,
					'postParams' => json_encode( $loggerPostParams ),
					'tries' => $tries,
					'exception' => new Exception( $action ),
				] );
			}
			$requestTime = (int)( ( microtime( true ) - $requestTime ) * 10000.0 );
		}

		if ( $response === false ) {
			/* service doesn't work */
			$res = false;

			$this->error( "Phalanx service error", [
				"phalanxUrl" => $url,
				'requestTime' => $requestTime,
				'postParams' => json_encode( $loggerPostParams ),
				'tries' => $tries,
				'exception' => new Exception( $action ),
			] );

			wfDebug( __METHOD__ . " - response failed!\n" );
		} else {
			wfDebug( __METHOD__ . " - received '{$response}'\n" );

			$this->debug( "Phalanx service success", [
				"phalanxUrl" => $url,
				'requestTime' => $requestTime,
				'tries' => $tries
			] );

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
		return $res;
	}
};
