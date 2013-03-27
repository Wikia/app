<?php
/**
 * Class definition for Wikia\Search\Traits\Cachable
 * @author relwell
 */
namespace Wikia\Search\Traits;
use WikiaGlobalRegistry as Registry;
use WikiaFunctionWrapper as Wrapper;
/**
 * This trait lets us expose protected methods preceded by an underscore
 * as cached methods.
 * All caching logic is stored in the traits, and all
 * business logic is stored in the classes that use this trait.
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
	 * Magic method that allows us to cache any public method
	 * by turning it into a protected method with an underscore preceding it.
	 * 
	 * @param string $name
	 * @param array $args
	 * @throws \BadMethodCallException
	 * @return Ambigous <\Wikia\Search\mixed, mixed>
	 */
	public function __call($name, array $args = array()) {
		if (method_exists ( $this, '_' . $name )) {
			return $this->getCachedMethodCall ( '_' . $name, $args );
		}
		throw new \BadMethodCallException ( "Method by name of {$name} does not exist (and not cached)." );
	}
	
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
	public function getCacheKey($key) {
		return $this->getWf()->SharedMemcKey( $key, $this->getWikiId () );
	}
	
	/**
	 * Returns what's set in memcache through the app
	 * 
	 * @param string $key
	 * @return array
	 */
	public function getCacheResult($key) {
		return $this->getWg()->Memc->get( $key );
	}
	
	/**
	 * Returns the cached result without the intermediate cache query in
	 * consumer logic
	 * 
	 * @param string $key
	 * @return multitype
	 */
	public function getCacheResultFromString($key) {
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
	public function setCacheFromStringKey($key, $value, $ttl = null) {
		$this->getWg()->Memc->set ( $this->getCacheKey ( $key ), $value, $ttl ?  : $this->cacheTttl );
		return $this;
	}
	
	/**
	 * Allows us to cache method calls.
	 * Suggested practice is to write a protected method with core logic,
	 * and then a public method that invokes this method. Prefix
	 * cached methods with an underscore.
	 * 
	 * @param string $method
	 * @param array $args
	 * @return mixed
	 */
	protected function getCachedMethodCall($method, array $args = array()) {
		$sig = sha1 ( $method . serialize ( $args ) );
		$result = $this->getCacheResultFromString ( $sig );
		if ( empty( $result ) ) {
			$result = call_user_func_array ( array (
					$this,
					$method 
			), $args );
			$this->setCacheFromStringKey ( $sig, $result, $this->cacheTtl );
		}
		return $result;
	}
	
	/**
	 * Lazy-loading for WikiaGlobalRegistry
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
	 * @return WikiaFunctionWrapper
	 */
	protected function getWf() {
		if ( $this->wf === null ) {
			$this->wf = new Wrapper;
		}
		return $this->wf;
	}
}