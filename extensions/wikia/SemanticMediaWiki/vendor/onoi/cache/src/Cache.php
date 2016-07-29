<?php

namespace Onoi\Cache;

/**
 * Specifying a common interface to access a cache instance and is modelled after
 * the Doctrine\Common\Cache interface
 *
 * @note Moved from SMW\Cache\Cache@2.1
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
interface Cache {

	/**
	 * Returns a cache item or false if no entry was found
	 *
	 * @since 1.0
	 *
	 * @param string $id
	 *
	 * @return mixed|false
	 */
	public function fetch( $id );

	/**
	 * Whether an entry is available for the given id
	 *
	 * @since 1.0
	 *
	 * @param string $id
	 *
	 * @return boolean
	 */
	public function contains( $id );

	/**
	 * @since 1.0
	 *
	 * @param string $id
	 * @param mixed $data
	 * @param integer $ttl
	 *
	 * @return mixed
	 */
	public function save( $id, $data, $ttl = 0 );

	/**
	 * @since 1.0
	 *
	 * @param string $id
	 *
	 * @return boolean
	 */
	public function delete( $id );

	/**
	 * @since 1.0
	 *
	 * @return array|null
	 */
	public function getStats();

	/**
	 * @since 1.2
	 *
	 * @return string
	 */
	public function getName();

}
