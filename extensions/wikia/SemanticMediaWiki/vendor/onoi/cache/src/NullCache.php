<?php

namespace Onoi\Cache;

/**
 * @license GNU GPL v2+
 * @since 1.1
 *
 * @author mwjames
 */
class NullCache implements Cache {

	/**
	 * @since  1.1
	 *
	 * {@inheritDoc}
	 */
	public function fetch( $id ) {
		return false;
	}

	/**
	 * @since  1.1
	 *
	 * {@inheritDoc}
	 */
	public function contains( $id ) {
		return false;
	}

	/**
	 * @since  1.1
	 *
	 * {@inheritDoc}
	 */
	public function save( $id, $data, $ttl = 0 ) {}

	/**
	 * @since  1.1
	 *
	 * {@inheritDoc}
	 */
	public function delete( $id ) {}

	/**
	 * @since  1.1
	 *
	 * {@inheritDoc}
	 */
	public function getStats() {
		return array();
	}

	/**
	 * @since  1.2
	 *
	 * {@inheritDoc}
	 */
	public function getName() {
		return '';
	}

}
