<?php
/**
 * Memcached-like cache client for PathFinder
 * @author Federico "Lox" Lucignano <federico(at)wikia-inc.com>
 * 
 * For now it's using Redis, it has been written to be able to change cache backend without touching PathFinder's code directly
 */
class PathFinderCache extends WikiaObject {
	const PHP_PREFIX = 'php://';
	
	private $predisClient;
	
	function __construct(){
		$this->predisClient = (new Predis\Client);
	}
	
	public function set( $key, $value = null, $exp = 0 ) {
		if ( !is_scalar( $value ) ) {
			$value = self::PHP_PREFIX . serialize( $value );
		}
		
		if ( $exp > 0 ) {
			$pipe = $this->predisClient->pipeline();
			$pipe->set( $key, $value );
			$pipe->expire( $key, $exp );
			
			return $pipe->execute();
		} else {
			return $this->predisClient->set( $key, $value );
		}
	}
	
	public function get( $key ) {
		$value = $this->predisClient->get( $key );
		
		if ( is_string( $value ) && strpos( $value, self::PHP_PREFIX ) === 0 ) {
			$value = unserialize( substr( $value, strlen( self::PHP_PREFIX ) ) );
		}
		
		return $value;
	}
	
	public function delete( $key, $time = 0 ) {
		if ( $time > 0) {
			return $this->predisClient->expire( $key, $time );
		} else {
			return $this->predisClient->del( $key );
		}
	}
	
	public function makeKey( /* ... */ ){
		$key = wfWikiID() . ':' . implode( ':', func_get_args() );
		return str_replace( ' ', '_', $key );
	}
	
	//catch all
	public function __call( $funcName, $funcArgs ){
		return false;
	}
}
