<?php
/**
 * Class definition for Wikia\Search\Traits\Cachable
 * @author relwell
 */
namespace Wikia\Search\Traits;
use WikiaGlobalRegistry as Registry;
use WikiaFunctionWrapper as Wrapper;
/**
 * This trait lets us expose optional caching for methods using a magic method.
 * In order to implement this class, you must register the following logic in __call( $name, $args ):
 * <code>
 * if ( $this->isMethodWithCaching( $name ) ) {
 *     return $this->getCachedMethodCall( $name, $args );
 * }
 * </code>
 * All caching logic is stored in the traits, and all
 * business logic is stored in the classes that use this trait.
 * In order to invoke a method with caching, simply add _withCaching to the method string.
 * 
 * @author relwell
 */
trait Cachable {
	
	/**
	 * By default we cache for a day.
	 * This can be changed via mutator.
	 * @var int
	 */
	protected $cacheTtl = 86400;
	
	/**
	 * Allows us to lazy-load WikiaGlobalRegistry
	 * @var WikiaGlobalRegistry
	 */
	protected $wg;
	
	/**
	 * Allows us to lazy-load WikiaFunctionWrapper
	 * @var WikiaFunctionWrapper
	 */
	protected $wf;
	
	/**
	 * Sets the cached result time to live.
	 * @param int $ttl
	 * @return Cachable
	 */
	public function setCacheTtl( $ttl ) {
		$this->cacheTtl = $ttl;
		return $this;
	}
	
	/**
	 * Gives us the current registered TTL in seconds.
	 * @return int
	 */
	public function getCacheTtl() {
		return $this->cacheTtl;
	}
	
	/**
	 * Returns the memcache key for the given string
	 * 
	 * @param string $key
	 * @return string
	 */
	public function getCacheKey( $key ) {
		return $this->getWf()->SharedMemcKey( $key, $this->getWikiId () );
	}
	
	/**
	 * Returns what's set in memcache through the app
	 * 
	 * @param string $key
	 * @return array
	 */
	public function getCacheResult( $key ) {
		return $this->getWg()->Memc->get( $key );
	}
	
	/**
	 * Returns the cached result without the intermediate cache query in
	 * consumer logic
	 * 
	 * @param string $key
	 * @return multitype
	 */
	public function getCacheResultFromString( $key ) {
		return $this->getCacheResult ( $this->getCacheKey ( $key ) );
	}
	
	/**
	 * Allows us to set values in global memcache without knowing the memcache
	 * key
	 * 
	 * @param string $key
	 * @param mixed $value
	 * @param int $ttl
	 * @return \Wikia\Search\MediaWikiService
	 */
	public function setCacheFromStringKey( $key, $value, $ttl = null ) {
		$this->getWg()->Memc->set( $this->getCacheKey( $key ), $value, $ttl ?  : $this->cacheTttl );
		return $this;
	}
	

	/**
	 * Determines if a method that is not found is an existing method with 
	 * '_withCaching' at the end, which indicates we should push it through 
	 * this caching component.
	 * 
	 * @param string $name
	 * @return bool
	 */
	protected function isMethodWithCaching( $name ) {
		return method_exists( $this, preg_replace( '/_withCaching$/', '', $name ) );
	}
	
	/**
	 * Allows us to cache method calls. 
	 * This should be invoked in __call by any method that uses this trait.
	 * 
	 * @param string $method
	 * @param array $args
	 * @return mixed
	 */
	protected function getCachedMethodCall( $method, array $args = array() ) {
		$method = preg_replace( '/_withCaching$/', '', $method ); // remove caching suffix
		$sig = sha1 ( $method . serialize( $args ) );
		$result = $this->getCacheResultFromString( $sig );
		if ( empty( $result ) ) {
			$result = call_user_func_array( [ $this, $method ], $args );
			$this->setCacheFromStringKey( $sig, $result, $this->cacheTtl );
		}
		return $result;
	}
	
	/**
	 * Lazy-loading for WikiaGlobalRegistry
	 * @todo probably move to separate trait
	 * @return WikiaGlobalRegistry
	 */
	protected function getWg() {
		if ( $this->wg === null ) {
			$this->wg = new Registry;
		}
		return $this->wg;
	}
	
	/**
	 * Lazy-loading for WikiaFunctionWrapper
	 * @todo probably move to separate trait
	 * @return WikiaFunctionWrapper
	 */
	protected function getWf() {
		if ( $this->wf === null ) {
			$this->wf = new Wrapper;
		}
		return $this->wf;
	}
}