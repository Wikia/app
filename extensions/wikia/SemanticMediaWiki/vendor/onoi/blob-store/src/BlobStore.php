<?php

namespace Onoi\BlobStore;

use Onoi\Cache\Cache;
use Onoi\Cache\CacheFactory;
use InvalidArgumentException;

/**
 * Pervasive value blob store that can be used to store and retrieve key values
 * from a schema free "fast" data store such as redis. The connection to a back-end
 * is handled by the Onoi\Cache interface to support different provider solutions.
 *
 * @license GNU GPL v2+
 * @since 1.0
 *
 * @author mwjames
 */
class BlobStore {

	/**
	 * @var string
	 */
	private $namespace;

	/**
	 * @var string
	 */
	private $namespacePrefix = 'blobstore';

	/**
	 * @var Cache
	 */
	private $cache;

	/**
	 * @var Cache
	 */
	private $internalCache;

	/**
	 * @var boolean
	 */
	private $usageState = true;

	/**
	 * 0 = stored indefinitely until it is removed or dropped
	 *
	 * @var integer
	 */
	private $expiry = 0;

	/**
	 * @since 1.0
	 *
	 * @param string $namespace
	 * @param Cache $cache
	 */
	public function __construct( $namespace, Cache $cache ) {

		if ( !is_string( $namespace ) ) {
			throw new InvalidArgumentException( "Expected the namespace to be a string" );
		}

		$this->namespace = $namespace;
		$this->cache = $cache;

		// It is only used internally therefore no injection required as it improves
		// performance on long lists as seen in #1
		$this->internalCache = CacheFactory::getInstance()->newFixedInMemoryLruCache( 500 );
	}

	/**
	 * @since 1.0
	 *
	 * @return boolean
	 */
	public function canUse() {
		return $this->usageState;
	}

	/**
	 * Specifies whether the instance can be generally used or not
	 *
	 * @since 1.0
	 *
	 * @param boolean $usageState
	 */
	public function setUsageState( $usageState ) {
		$this->usageState = (bool)$usageState;
	}

	/**
	 * Specifies the expiry / time to live for stored containers in seconds
	 *
	 * @since 1.0
	 *
	 * @param integer $expiry
	 */
	public function setExpiryInSeconds( $expiry ) {
		$this->expiry = $expiry;
	}

	/**
	 * @since 1.0
	 *
	 * @param string $prefix
	 */
	public function setNamespacePrefix( $prefix ) {
		$this->namespacePrefix = $prefix;
	}

	/**
	 * @since 1.0
	 *
	 * @param string $id
	 *
	 * @return boolean
	 */
	public function exists( $id ) {
		return $this->cache->contains( $this->getKey( $id ) );
	}

	/**
	 * @since 1.0
	 *
	 * @return array
	 */
	public function getStats() {
		return $this->cache->getStats() + array(
			'internalCache' => $this->internalCache->getStats()
		);
	}

	/**
	 * @since 1.0
	 *
	 * @param string $id
	 *
	 * @return Container
	 */
	public function read( $id ) {

		$id = $this->getKey( $id );

		// If possible use the raw data from the internal cache
		// without unserialization
		if ( $this->internalCache->contains( $id ) ) {
			$data = $this->internalCache->fetch( $id );
		} elseif ( $this->cache->contains( $id ) ) {
			$data = unserialize( $this->cache->fetch( $id ) );
			$this->internalCache->save( $id, $data );
		} else {
			$data = array();
		}

		$container = new Container( $id, (array)$data );
		$container->setExpiryInSeconds( $this->expiry );

		return $container;
	}

	/**
	 * @since 1.0
	 *
	 * @param Container $container
	 */
	public function save( Container $container ) {

		$this->internalCache->save(
			$container->getId(),
			$container->getData(),
			$container->getExpiry()
		);

		$this->cache->save(
			$container->getId(),
			serialize( $container->getData() ),
			$container->getExpiry()
		);

		unset( $container );
	}

	/**
	 * @since 1.0
	 *
	 * @param string $id
	 */
	public function delete( $id ) {
		$this->cache->delete( $this->getKey( $id ) );
		$this->internalCache->delete( $this->getKey( $id ) );
	}

	/**
	 * @since 1.0
	 */
	public function drop() {
		// After using the internal list for several production runs it seems
		// difficult to keep track of ids especially when using long lists and
		// not to increase overhead which can easily produced by 50K+ entries
		// which would require to split the internal list
		//
		// Using an appropriate expiry seems more efficient
	}

	private function getKey( $id ) {

		if ( !is_string( $id ) ) {
			throw new InvalidArgumentException( "Expected the id to be a string" );
		}

		return  $this->namespacePrefix . ':' . $this->namespace . ':' . $id;
	}

}
