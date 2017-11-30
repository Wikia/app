<?php

use Wikia\Rabbit\ConnectionBase;
use Wikia\Service\Gateway\KubernetesUrlProvider;
use Wikia\Service\Gateway\UrlProvider;

/**
 * @method PhalanxService setLimit( int $limit )
 * @method PhalanxService setUser( User $user )
 */
class PhalanxService {

	use \Wikia\Logger\Loggable;

	// limit of blocks
	private $limit = 1;
	/** @var User */
	private $user = null;

	/** @var UrlProvider $urlProvider */
	private $urlProvider;

	const RES_OK = 'ok';
	const RES_FAILURE = 'failure';
	const RES_STATUS = 'PHALANX ALIVE';
	const PHALANX_LOG_PARAM_LENGTH_LIMIT = 64;
	const ROUTING_KEY = 'onUpdate';

	// number of retries for phalanx POST requests
	const PHALANX_SERVICE_TRIES_LIMIT = 3;

	// delay between retries - 0.2s
	const PHALANX_SERVICE_TRY_USLEEP = 20000;

	/**
	 * @Inject
	 * @param KubernetesUrlProvider $urlProvider
	 */
	public function __construct( KubernetesUrlProvider $urlProvider ) {
		$this->urlProvider = $urlProvider;
	}

	protected function getLoggerContext() {
		return [
			'class' => __CLASS__
		];
	}

	/**
	 * @param $name
	 * @param $args
	 * @return null|PhalanxService
	 * @throws WikiaException
	 */
	public function __call( $name, $args ) {
		$method = substr( $name, 0, 3 );
		$key = lcfirst( substr( $name, 3 ) );

		$result = null;
		switch ( $method ) {
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
				throw new WikiaException( 'PhalanxService::_call supports getters and setters only' );
		}
		return $result;
	}

	/**
	 * check service status
	 */
	public function status() {
		return $this->sendToPhalanxDaemon( "status", [] );
	}

	/**
	 * service for check function
	 *
	 * @param string $type one of: content, summary, title, user, question_title, recent_questions,
	 *                     wiki_creation, cookie, email
	 * @param string $content text to be checked
	 * @return mixed
	 */
	public function check( string $type, string $content ) {
		wfProfileIn( __METHOD__ );

		$result = $this->sendToPhalanxDaemon( 'check', [ 'type' => $type, 'content' => $content ] );

		wfProfileOut( __METHOD__ );
		return $result;
	}

	/**
	 * service for match function
	 *
	 * @param string $type one of: content, summary, title, user, question_title, recent_questions,
	 *                     wiki_creation, cookie, email
	 * @param string|array $content text to be checked
	 * @return mixed
	 */
	public function match( string $type, $content ) {
		wfProfileIn( __METHOD__ );
		if ( is_array( $content ) ) {
			$content = array_unique( $content );
		}

		$result = $this->sendToPhalanxDaemon( 'match', [ 'type' => $type, 'content' => $content ] );

		wfProfileOut( __METHOD__ );
		return $result;
	}

	/**
	 * Instruct Phalanx nodes to load a set of rules (identified by ID) from the database
	 * @param int[] $changed -- list of rules to reload
	 */
	public function reload( $changed = [] ) {
		global $wgPhalanxQueue;

		$rabbitConnection = new ConnectionBase( $wgPhalanxQueue );
		$rabbitConnection->publish( self::ROUTING_KEY, implode( ",", $changed ) );
	}

	/**
	 * service for validate regex in service
	 *
	 * @example curl "http://localhost:8080/validate?regex=^alamakota$"
	 *
	 * @param $regex String
	 *
	 * @return int|mixed
	 */
	public function validate( $regex ) {
		wfProfileIn( __METHOD__ );
		$result = $this->sendToPhalanxDaemon( "validate", [ "regex" => $regex ] );
		wfProfileOut( __METHOD__ );
		return $result;
	}

	/**
	 * Send prepared request request to phalanx daemon
	 *
	 * @param string $action String type of action
	 * @param array $parameters additional parameters as hash table
	 * @return integer|mixed data of blocks applied or numeric value
	 *         (0 - block applied, 1 - no block applied)
	 */
	private function sendToPhalanxDaemon( $action, $parameters ) {
		$options = F::app()->wg->PhalanxServiceOptions;

		$url = $this->getPhalanxUrl( $action );
		$loggerPostParams = [];
		$tries = 1;
		/**
		 * for status we're sending GET
		 */
		if ( $action == "status" ) {
			wfDebug( __METHOD__ . ": calling $url\n" );
			$requestTime = microtime( true );
			$response = Http::get( $url, 'default', $options );
			$requestTime = (int)( ( microtime( true ) - $requestTime ) * 10000.0 );
		} /**
		 * for any other we're sending POST
		 */
		else {
			global $wgCityId, $wgLanguageCode;

			// Specify wiki ID parameter, for Phalanx Stats logging
			$parameters['wiki'] = $wgCityId;

			// SUS-2759: pass on content language code to the service
			$parameters['lang'] = $wgLanguageCode;

			if ( ( $action == "match" || $action == "check" ) && !empty( $this->user ) ) {
				$parameters['user'][] = $this->user->getName();
			}

			if ( $action == "match" && $this->limit != 1 ) {
				$parameters['limit'] = $this->limit;
			}

			$postData = [];
			if ( !empty( $parameters ) ) {
				foreach ( $parameters as $key => $values ) {
					if ( is_array( $values ) ) {
						foreach ( $values as $val ) {
							$postData[] = urlencode( $key ) . '=' . urlencode( $val );
						}
					} else {
						$postData[] = urlencode( $key ) . '=' . urlencode( $values );
					}
					$loggerPostParams[$key] = substr(
						json_encode( $values ),
						0,
						self::PHALANX_LOG_PARAM_LENGTH_LIMIT
					);
				}
			}

			$options["postData"] = implode( "&", $postData );

			$requestTime = microtime( true );

			// BAC-1332 - some of the phalanx service calls are breaking and we're not sure why
			// it's better to do the retry than maintain the PHP fallback for that
			$url = $this->getPhalanxUrl( $action );
			while ( $tries <= self::PHALANX_SERVICE_TRIES_LIMIT ) {
				$response = Http::post( $url, $options );
				if ( false !== $response ) {
					break;
				}
				// don't wait after the last try
				if ( $tries < self::PHALANX_SERVICE_TRIES_LIMIT ) {
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

			$this->error( "Phalanx service failed", [
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
					$res = ( stripos( $response, self::RES_STATUS ) !== false ) ? true : false;
					break;
				case "match" :
					$ret = json_decode( $response );
					if ( !is_array( $ret ) ) {
						$res = false;
					} else {
						if ( count( $ret ) > 0 && $this->limit != 0 ) {
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
					if ( stripos( $response, self::RES_OK ) !== false ) {
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

	private function getPhalanxUrl( $action ) {
		global $wgPhalanxServiceUrl;

		if ( !empty( $wgPhalanxServiceUrl ) ) {
			// e.g. "localhost:4666"
			$baseurl = $wgPhalanxServiceUrl;
		} else {
			$baseurl = $this->urlProvider->getUrl( 'phalanx' );
		}

		return sprintf( "http://%s/%s", $baseurl, $action != "status" ? $action : "" );
	}
}
