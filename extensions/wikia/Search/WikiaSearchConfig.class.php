<?php 

/**
 * A config class intended to handle variable flags for search
 * Intended to be a dependency-injected receptacle for different search requirements
 * @author relwell
 *
 */

class WikiaSearchConfig implements ArrayAccess
{
	private $params = array();
	
	public function __construct( array $params = array() )
	{
		$this->params = array_merge( $this->params, $params );
	}

	// getter and setter shortcuts
	public function __call($method, $params)
	{
		if ( substr($method, 0, 3) == 'get' ) {
			return $this->offsetGet( strtolower($method[3]).strtolower(substr($method, 4)) );
		} else if ( substr($method, 0, 3) == 'set' ) {
			return $this->offsetSet( strtolower($method[3]).strtolower(substr($method, 4)) );
		}
	}
	
	public function offsetExists ($offset)
	{
		return isset($this->params[$offset]);
	}

	public function offsetGet ($offset)
	{
		return isset($this->params[$offset]) ? $this->params[$offset] : null;
	}

	public function offsetSet ($offset, $value)
	{
		$this->params[$offset] = $value;
	}

	public function offsetUnset ($offset)
	{
		unset($this->params[$offset]);
	}
	
}