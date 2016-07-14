<?php

namespace Onoi\HttpRequest;

/**
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class NullRequest implements HttpRequest {

	/**
	 * @since 1.0
	 *
	 * {@inheritDoc}
	 */
	public function ping() {
		return false;
	}

	/**
	 * @since 1.0
	 *
	 * {@inheritDoc}
	 */
	public function setOption( $name, $value ) {}

	/**
	 * @since 1.0
	 *
	 * {@inheritDoc}
	 */
	public function getOption( $name ) {}

	/**
	 * @since 1.0
	 *
	 * {@inheritDoc}
	 */
	public function getLastTransferInfo( $name = null ) {
		return null;
	}

	/**
	 * @since 1.0
	 *
	 * {@inheritDoc}
	 */
	public function getLastError() {
		return '';
	}

	/**
	 * @since 1.0
	 *
	 * {@inheritDoc}
	 */
	public function getLastErrorCode() {
		return 0;
	}

	/**
	 * @since 1.0
	 *
	 * {@inheritDoc}
	 */
	public function execute() {}

}
