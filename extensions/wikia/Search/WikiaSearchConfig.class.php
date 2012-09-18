<?php 

/**
 * A config class intended to handle variable flags for search
 * Intended to be a dependency-injected receptacle for different search requirements
 * @author relwell
 *
 */

class WikiaSearchConfig implements ArrayAccess
{
	private $params = array(
			'page'			=>	1,
			'length'		=>	WikiaSearch::RESULTS_PER_PAGE,
			'cityId'		=>	0,
			'groupResults'	=>	false,
			'rank'			=>	'default',
			'hub'			=>	false,
			'videoSearch'	=>	false,
			'start'			=>	0,
			);
	
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
			$this->offsetSet( strtolower($method[3]).strtolower(substr($method, 4)) );
			return $this; // fluent
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