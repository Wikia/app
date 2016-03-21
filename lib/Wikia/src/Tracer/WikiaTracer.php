<?php

namespace Wikia\Tracer;

use Wikia\Logger\ContextSource;

class WikiaTracer {

	const APPLICATION_NAME = 'mediawiki';

	const TRACE_ID_HEADER_NAME = 'X-Trace-Id';
	const CLIENT_IP_HEADER_NAME = 'X-Client-Ip';
	const CLIENT_BEACON_ID_HEADER_NAME = 'X-Client-Beacon-Id';
	const CLIENT_DEVICE_ID_HEADER_NAME = 'X-Client-Device-Id';
	const CLIENT_USER_ID = 'X-User-Id';

	const ORIGIN_HOST_HEADER_NAME = 'X-Request-Origin-Host';
	const INTERNAL_REQUEST_HEADER_NAME = 'X-Wikia-Internal-Request';

	const INTERNAL_REQUEST_HEADER_VALUE = 'mediawiki';

	const LEGACY_TRACE_ID_HEADER_NAME = 'X-Request-Id';
	const LEGACY_BEACON_HEADER_NAME = 'X-Beacon';

	private $traceId;
	private $clientIp;
	private $clientBeaconId;
	private $clientDeviceId;
	private $userId;
	private $appVersion = '';

	/**
	 * @var ContextSource
	 */
	private $contextSource;

	private function __construct() {
		$this->traceId = RequestId::instance()->getRequestId();
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

		if ( isset( $_SERVER[$serverHeaderName] ) && $_SERVER[$serverHeaderName] !== '' ) {
			return $_SERVER[$serverHeaderName];
		}
		else if ( isset( $_ENV[$entryName] ) && $_ENV[$entryName] !== '' ) {
			return $_ENV[$entryName];
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
		global $wgDBname, $wgCityId, $maintClass;

		$context = [
			'app_name' => self::APPLICATION_NAME,
			'app_version' => $this->getAppVersion(), // please note that this field won't always be filled (if logging is called pretty early)
		];

		if ( !empty( $wgDBname ) ) {
			$context['wiki_dbname'] = $wgDBname;
		}

		if ( !empty( $wgCityId ) ) {
			$context['wiki_id'] = $wgCityId;
		}

		if ( isset( $_SERVER['REQUEST_URI'] ) ) {
			$context['http_url_path'] = $_SERVER['REQUEST_URI'];

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

	public function getTraceId() {
		return $this->traceId;
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
	 * Pass request context to maintenance scripts run via wfShellExec
	 *
	 * @param string $cmd
	 * @param array $environ
	 * @return bool true - it's a hook
	 */
	public static function onWfShellExecBeforeEnviron( &$cmd, array &$environ ) {
		$traceEnviron = [];
		$traceHeaders = array_merge(
			self::instance()->getInternalHeaders(),
			self::instance()->getPublicHeaders()
		);

		foreach ( $traceHeaders as $key => $val ) {
			$key = str_replace( '-', '_', $key );
			$key = strtoupper( $key );

			$traceEnviron[ $key ] = $val;
		}

		$environ = array_merge(
			$environ,
			$traceEnviron
		);

		return true;
	}
}
