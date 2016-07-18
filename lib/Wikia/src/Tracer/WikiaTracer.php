<?php

namespace Wikia\Tracer;

use Wikia\Logger\ContextSource;

class WikiaTracer {

	const APPLICATION_NAME = 'mediawiki';

	const TRACE_ID_HEADER_NAME = 'X-Trace-Id';
	const PARENT_SPAN_ID_HEADER_NAME = 'X-Parent-Span-Id';
	const CLIENT_IP_HEADER_NAME = 'X-Client-Ip';
	const CLIENT_BEACON_ID_HEADER_NAME = 'X-Client-Beacon-Id';
	const CLIENT_DEVICE_ID_HEADER_NAME = 'X-Client-Device-Id';
	const CLIENT_USER_ID = 'X-User-Id';

	const ORIGIN_HOST_HEADER_NAME = 'X-Request-Origin-Host';
	const INTERNAL_REQUEST_HEADER_NAME = 'X-Wikia-Internal-Request';

	const INTERNAL_REQUEST_HEADER_VALUE = 'mediawiki';

	const LEGACY_TRACE_ID_HEADER_NAME = 'X-Request-Id';
	const LEGACY_BEACON_HEADER_NAME = 'X-Beacon';

	const REQUEST_PATH_HEADER_NAME = 'X-Request-Path';

	const ENV_VARIABLES_PREFIX = 'WIKIA_TRACER_';

	private $traceId;
	private $parentSpanId;
	private $clientIp;
	private $clientBeaconId;
	private $clientDeviceId;
	private $userId;
	private $appVersion = '';

	private $requestPath = [];

	/**
	 * @var ContextSource
	 */
	private $contextSource;

	private function __construct() {
		$this->spanId = RequestId::generateId();
		$this->traceId = RequestId::instance()->getRequestId();

		$this->parentSpanId = $this->getTraceEntry( self::PARENT_SPAN_ID_HEADER_NAME );
		$this->clientIp = $this->getTraceEntry( self::CLIENT_IP_HEADER_NAME );
		$this->clientBeaconId = $this->getTraceEntry( self::CLIENT_BEACON_ID_HEADER_NAME );
		$this->clientDeviceId = $this->getTraceEntry( self::CLIENT_DEVICE_ID_HEADER_NAME );
		$this->userId = $this->getTraceEntry( self::CLIENT_USER_ID );

		$this->contextSource = new ContextSource( [ ] );
		$this->updateContext();
	}

	/**
	 * Get trace entry from either HTTP request header or env variable. Returns null if none of these are set.
	 *
	 * @param string $entryName
	 * @return string|null
	 */
	private function getTraceEntry( $entryName ) {
		$entryName = str_replace( '-', '_', $entryName );
		$entryName = strtoupper( $entryName );

		$serverHeaderName = 'HTTP_' . $entryName;
		$envName = self::ENV_VARIABLES_PREFIX . $entryName;

		if ( isset( $_SERVER[$serverHeaderName] ) && $_SERVER[$serverHeaderName] !== '' ) {
			return $_SERVER[$serverHeaderName];
		}
		else if ( isset( $_ENV[$envName] ) && $_ENV[$envName] !== '' ) {
			return $_ENV[$envName];
		}
		else {
			return null;
		}
	}

	private function updateContext() {
		$newContext = array_merge(
			$this->getApplicationContext(),
			$this->removeNullEntries( [
				'client_ip' => $this->clientIp,
				'client_beacon_id' => $this->clientBeaconId,
				'client_device_id' => $this->clientDeviceId,
				'user_id' => $this->userId,
				'span_id' => $this->spanId,
				'parent_span_id' => $this->parentSpanId,
				'trace_id' => $this->traceId,
			] )
		);
		if ( $this->contextSource->getContext() !== $newContext ) {
			$this->contextSource->setContext( $newContext ); // this will notify listeners
		}
	}

	/**
	 * @return string
	 */
	private function getAppVersion() {
		if ( !$this->appVersion && class_exists( 'WikiaSpecialVersion' ) ) {
			$this->appVersion = trim( \WikiaSpecialVersion::getWikiaCodeVersion() );
		}

		return $this->appVersion;
	}

	private function getApplicationContext() {
		global $wgDBname, $wgCityId, $wgWikiaDatacenter, $wgWikiaEnvironment, $maintClass;

		$context = [
			'app_name' => self::APPLICATION_NAME,
			'app_version' => $this->getAppVersion(), // please note that this field won't always be filled (if logging is called pretty early)
			'datacenter' => $wgWikiaDatacenter, # sjc / res / poz
			'environment' => $wgWikiaEnvironment, # dev / prod
		];

		if ( !empty( $wgDBname ) ) {
			$context['wiki_dbname'] = $wgDBname;
		}

		if ( !empty( $wgCityId ) ) {
			$context['wiki_id'] = $wgCityId;
		}

		if ( isset( $_SERVER['REQUEST_URI'] ) ) {
			$context['http_url_path'] = $this->stripDomainFromUrl($_SERVER['REQUEST_URI']);

			if ( isset( $_SERVER['REQUEST_METHOD'] ) ) {
				$context['http_method'] = $_SERVER['REQUEST_METHOD'];
			}

			if ( isset( $_SERVER['SERVER_NAME'] ) ) {
				$context['http_url_domain'] = $_SERVER['SERVER_NAME'];

				$context['http_url'] = sprintf( "%s://%s%s",
					( empty( $_SERVER['HTTPS'] ) ? 'http' : 'https' ),
					$_SERVER['SERVER_NAME'],
					$_SERVER['REQUEST_URI'] );
			}

			if ( isset( $_SERVER['HTTP_REFERER'] ) ) {
				$context['http_referrer'] = $_SERVER['HTTP_REFERER'];
			}
		}

		// add some context for maintenance scripts
		if ( defined( 'RUN_MAINTENANCE_IF_MAIN' ) ) {
			if ( isset( $_SERVER['SCRIPT_FILENAME'] ) ) {
				$context['maintenance_file'] = realpath( $_SERVER['SCRIPT_FILENAME'] );
			}

			if ( !empty( $maintClass ) ) {
				$context['maintenance_class'] = $maintClass;
			}
		}

		return $this->removeNullEntries( $context );
	}

	private function stripDomainFromUrl( $url ) {
		$matches = null;
		if (preg_match('#^https?://[^/]+(/.*)?$#',$url,$matches)) {
			if (isset($matches[1])) {
				$url = $matches[1];
			} else {
				$url = '/';
			}
		}

		return $url;
	}

	private function removeNullEntries( $array ) {
		foreach ( $array as $k => $v ) {
			if ( is_null( $v ) ) {
				unset( $array[$k] );
			}
		}

		return $array;
	}

	/**
	 * Update internal state from Mediawiki
	 *
	 * @return true so it can be used as hook handler
	 * @throws \MWException
	 */
	public static function updateInstanceFromMediawiki() {
		self::instance()->updateFromMediawiki();

		return true;
	}

	public function updateFromMediawiki() {
		global $wgRequest, $wgUser;
		if ( is_null( $this->clientIp ) && $wgRequest && $wgRequest->getIP() ) {
			$this->clientIp = $wgRequest->getIP();
		}
		if ( is_null( $this->clientBeaconId ) && $this->getTraceEntry( self::LEGACY_BEACON_HEADER_NAME ) ) {
			$this->clientBeaconId = $this->getTraceEntry( self::LEGACY_BEACON_HEADER_NAME );
		}
		if ( is_null( $this->userId ) && $wgUser && $wgUser->isLoggedIn() ) {
			$this->userId = (string)$wgUser->getId();
		}

		$this->updateContext();
	}

	/**
	 * @return WikiaTracer
	 */
	public static function instance() {
		static $instance = null;

		if ( !isset( $instance ) ) {
			$instance = new self();
			self::updateInstanceFromMediawiki(); // mainly to trigger the hook
		}

		return $instance;
	}

	/**
	 * @return string
	 */
	public function getTraceId() {
		return $this->traceId;
	}

	/**
	 * @return string
	 */
	public function getSpanId() {
		return $this->spanId;
	}

	/**
	 * @return null|string
	 */
	public function getParentSpanId() {
		return $this->parentSpanId;
	}

	public function getInternalHeaders() {
		return array_merge(
			$this->getPublicHeaders(),
			$this->removeNullEntries( [
				self::CLIENT_IP_HEADER_NAME => $this->clientIp,
				self::CLIENT_BEACON_ID_HEADER_NAME => $this->clientBeaconId,
				self::CLIENT_DEVICE_ID_HEADER_NAME => $this->clientDeviceId,
				self::CLIENT_USER_ID => $this->userId,
				self::ORIGIN_HOST_HEADER_NAME => wfHostname(),
				self::INTERNAL_REQUEST_HEADER_NAME => self::INTERNAL_REQUEST_HEADER_VALUE,
			] )
		);
	}

	public function getPublicHeaders() {
		return $this->removeNullEntries( [
			self::TRACE_ID_HEADER_NAME => $this->traceId,
			self::LEGACY_TRACE_ID_HEADER_NAME => $this->traceId, // duplicated until we move to X-Trace-Id everywhere
			self::PARENT_SPAN_ID_HEADER_NAME => $this->spanId, // pass the current span ID to the subrequest, it will be logged as parent_span_id there
		] );
	}

	public function getContextSource() {
		return $this->contextSource;
	}

	public function getContext() {
		return $this->contextSource->getContext();
	}

	public function getHeaders( $forInternalRequest ) {
		if ( !is_bool($forInternalRequest) ) {
			throw new \InvalidArgumentException("Argument #1 must be a bool");
		}

		return $forInternalRequest ? $this->getInternalHeaders() : $this->getPublicHeaders();
	}

	public function setRequestHeaders( &$requestHeaders, $forInternalRequest ) {
		$requestHeaders = array_merge( $requestHeaders, $this->getHeaders($forInternalRequest) );
	}

	/**
	 * Get the array of env variables with client data
	 *
	 * @return array
	 */
	public function getEnvVariables() {
		$traceEnviron = [];
		$traceHeaders = array_merge(
			self::instance()->getInternalHeaders(),
			self::instance()->getPublicHeaders()
		);

		foreach ( $traceHeaders as $key => $val ) {
			$key = str_replace( '-', '_', $key );
			$key = strtoupper( $key );

			$traceEnviron[ self::ENV_VARIABLES_PREFIX . $key ] = $val;
		}

		return $traceEnviron;
	}

	/**
	 * Pass request context to maintenance scripts run via wfShellExec
	 *
	 * @param string $cmd
	 * @param array $environ
	 * @return bool true - it's a hook
	 */
	public static function onBeforeWfShellExec( &$cmd, array &$environ ) {
		$environ = array_merge(
			$environ,
			self::instance()->getEnvVariables()
		);

		return true;
	}

	/**
	 * Record HTTP sub-requests to form X-Request-Path response header
	 *
	 * @see PLATFORM-2079
	 *
	 * @param string $method HTTP method
	 * @param string $url
	 * @param string $caller
	 * @param float $requestTime UNIX timestamp (with microseconds precision when the request was sent
	 * @param \MWHttpRequest|null $req request object to take HTTP response headers from
	 * @return bool
	 */
	public static function onAfterHttpRequest( $method, $url, $caller, $requestTime, $req ) {
		// check if we received X-Request-Path header in a response and simply use it
		$headerValue = null;
		if ( $req instanceof \MWHttpRequest ) {
			$headerValue = $req->getResponseHeader(self::REQUEST_PATH_HEADER_NAME);
		}

		if ( $headerValue !== null ) {
			self::instance()->requestPath[] = $headerValue;
			return true;
		}

		$took = microtime( true ) - $requestTime;

		$appName = self::getAppNameFromCaller( $caller );
		$hostName = parse_url( $url, PHP_URL_HOST );
		$timestamp = (int) $requestTime;

		self::instance()->pushRequestPath( $appName, $hostName, $timestamp, $took );

		return true;
	}

	/**
	 * Get the app / service name using the name of the PHP method that performed the HTTP request
	 *
	 * For instance: "Wikia\Service\Helios\HeliosClientImpl:Wikia\Service\Helios\{closure}" will give "Helios"
	 * For instance: "Wikia\Service\Gateway\ConsulUrlProvider:getUrl" will give "ConsulUrlProvider:getUrl"
	 *
	 * @param string $caller
	 * @return string
	 */
	public static function getAppNameFromCaller( $caller ) {
		$caller = str_replace( '{closure}', '', $caller );
		$caller = trim( $caller, '\\:' );

		$parts = explode('\\', $caller );
		return end( $parts );
	}

	/**
	 * Add an entry to X-Request-Path response header
	 *
	 * E.g. (mediawiki ap-s52 1459866775 0.012345)
	 *
	 * @param string $appName e.g. mediawiki
	 * @param string $hostName e.g. ap-s52
	 * @param int $timestamp UNIX timestamp of when the sub-requests started
	 * @param float $took how long it took to perform the sub-request (in seconds)
	 */
	private function pushRequestPath( $appName, $hostName, $timestamp, $took ) {
		$this->requestPath[] = sprintf( "(%s %s %d %.6f)", $appName, $hostName, $timestamp, $took );
	}

	/**
	 * Get properly formatted X-Request-Path header
	 *
	 * @see PLATFORM-2079
	 * @return string
	 */
	public function getRequestPath() {
		global $wgRequestTime;

		$path = $this->requestPath;
		array_unshift( $path, sprintf( "%s %s %d %.6f", 'mediawiki', wfHostname(), (int) $wgRequestTime, microtime( true ) - $wgRequestTime ) );

		return sprintf( "(%s)", join( ' ', $path ) );
	}
}
