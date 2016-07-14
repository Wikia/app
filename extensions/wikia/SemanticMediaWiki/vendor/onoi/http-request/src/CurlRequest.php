<?php

namespace Onoi\HttpRequest;

use InvalidArgumentException;

/**
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class CurlRequest implements HttpRequest {

	/**
	 * @var resource
	 */
	private $handle;

	/**
	 * @var array
	 */
	protected $options = array();

	/**
	 * @since 1.0
	 *
	 * @param resource $handle
	 */
	public function __construct( $handle ) {

		if ( get_resource_type( $handle ) !== 'curl' ) {
			throw new InvalidArgumentException( "Expected a cURL resource type" );
		}

		$this->handle = $handle;
	}

	/**
	 * @since 1.0
	 *
	 * @return boolean
	 */
	public function ping() {

		if ( curl_getinfo( $this->handle, CURLINFO_EFFECTIVE_URL ) === '' ) {
			return false;
		}

		// Copy the handle to avoid diluting the resource
		$handle = curl_copy_handle( $this->handle );

		curl_setopt_array( $handle, array(
			CURLOPT_HEADER => false,
			CURLOPT_RETURNTRANSFER, true,
			CURLOPT_CONNECTTIMEOUT => 5,
			CURLOPT_FRESH_CONNECT => false,
			CURLOPT_FAILONERROR => true
		) );

		curl_exec( $handle );

		return curl_errno( $handle ) == 0;
	}

	/**
	 * @since 1.0
	 *
	 * @param string $name
	 * @param mixed $value
	 */
	public function setOption( $name, $value ) {

		$this->options[$name] = $value;

		// Internal ONOI options are not further relayed
		if ( strpos( $name, 'ONOI_HTTP_REQUEST' ) !== false ) {
			return;
		}

		curl_setopt(
			$this->handle,
			$name,
			$value
		);
	}

	/**
	 * @since 1.0
	 *
	 * @param string $name
	 *
	 * @return mixed|null
	 */
	public function getOption( $name ) {
		return isset( $this->options[$name] ) ? $this->options[$name] : null;
	}

	/**
	 * @since 1.0
	 *
	 * @param string|null $name
	 *
	 * @return mixed
	 */
	public function getLastTransferInfo( $name = null ) {
		return curl_getinfo( $this->handle, $name );
	}

	/**
	 * @since 1.0
	 *
	 * @return string
	 */
	public function getLastError() {
		return curl_error( $this->handle );
	}

	/**
	 * @since 1.0
	 *
	 * @return integer
	 */
	public function getLastErrorCode() {
		return curl_errno( $this->handle );
	}

	/**
	 * @since 1.0
	 *
	 * @return mixed
	 */
	public function execute() {
		$this->options = array();
		return curl_exec( $this->handle );
	}

	/**
	 * Use __invoke to return the handle in order to avoid cluttering the
	 * interface
	 *
	 * @since 1.0
	 */
	public function __invoke() {
		return $this->handle;
	}

	/**
	 * @since 1.0
	 */
	public function __destruct() {
		curl_close( $this->handle );
	}

}
