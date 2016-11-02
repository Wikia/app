<?php

namespace Onoi\HttpRequest;

/**
 * @since 1.1
 *
 * @{
 */
// @codeCoverageIgnoreStart
define( 'ONOI_HTTP_REQUEST_URL', 'ONOI_HTTP_REQUEST_URL' );
define( 'ONOI_HTTP_REQUEST_PROTOCOL_VERSION', 'ONOI_HTTP_REQUEST_PROTOCOL_VERSION' );
define( 'ONOI_HTTP_REQUEST_METHOD', 'ONOI_HTTP_REQUEST_METHOD' ); // POST, GET, HEAD

define( 'ONOI_HTTP_REQUEST_CONNECTION_TIMEOUT', 'ONOI_HTTP_REQUEST_CONNECTION_TIMEOUT' );
define( 'ONOI_HTTP_REQUEST_CONNECTION_FAILURE_REPEAT', 'ONOI_HTTP_REQUEST_CONNECTION_FAILURE_REPEAT' );

define( 'ONOI_HTTP_REQUEST_CONTENT_TYPE', 'ONOI_HTTP_REQUEST_CONTENT_TYPE' ); // "Content-Type: ..."
define( 'ONOI_HTTP_REQUEST_CONTENT', 'ONOI_HTTP_REQUEST_CONTENT' );
define( 'ONOI_HTTP_REQUEST_FOLLOWLOCATION', 'ONOI_HTTP_REQUEST_FOLLOWLOCATION' );

define( 'ONOI_HTTP_REQUEST_SSL_VERIFYPEER', 'ONOI_HTTP_REQUEST_SSL_VERIFYPEER' ); // SSL setting true, false
define( 'ONOI_HTTP_REQUEST_SOCKET_CLIENT_FLAGS', 'ONOI_HTTP_REQUEST_SOCKET_CLIENT_FLAGS' ); // STREAM_CLIENT_ASYNC_CONNECT | STREAM_CLIENT_PERSISTENT

define( 'ONOI_HTTP_REQUEST_ON_COMPLETED_CALLBACK', 'ONOI_HTTP_REQUEST_ON_COMPLETED_CALLBACK' );
define( 'ONOI_HTTP_REQUEST_ON_FAILED_CALLBACK', 'ONOI_HTTP_REQUEST_ON_FAILED_CALLBACK' );

define( 'ONOI_HTTP_REQUEST_RESPONSECACHE_PREFIX', 'ONOI_HTTP_REQUEST_RESPONSECACHE_PREFIX' );
define( 'ONOI_HTTP_REQUEST_RESPONSECACHE_TTL', 'ONOI_HTTP_REQUEST_RESPONSECACHE_TTL' );

// @codeCoverageIgnoreEnd
/**@}
 */

/**
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
interface HttpRequest {

	/**
	 * @since 1.0
	 *
	 * @return boolean
	 */
	public function ping();

	/**
	 * @since 1.0
	 *
	 * @param string $name
	 * @param mixed $value
	 */
	public function setOption( $name, $value );

	/**
	 * @since 1.0
	 *
	 * @param string $name
	 */
	public function getOption( $name );

	/**
	 * @since 1.0
	 *
	 * @param string|null $name
	 */
	public function getLastTransferInfo( $name = null );

	/**
	 * @since 1.0
	 *
	 * @return string
	 */
	public function getLastError();

	/**
	 * @since 1.0
	 *
	 * @return integer
	 */
	public function getLastErrorCode();

	/**
	 * @since 1.0
	 *
	 * @return mixed
	 */
	public function execute();

}
