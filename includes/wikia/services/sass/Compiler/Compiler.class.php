<?php

namespace Wikia\Sass\Compiler;
use Wikia\Sass\Source\Source;

/**
 * SassCompiler is a base class that defines the public interface
 * of Sass compiler subclasses.
 *
 * @author Władysław Bodzek <wladek@wikia-inc.com>
 */
abstract class Compiler {

	/**
	 * Create a new instance and configure it with provided options
	 *
	 * @param $options array
	 */
	public function __construct( $options = array() ) {
		$this->setOptions($options);
	}

	/**
	 * Set options (the list of options depends on a subclass)
	 *
	 * @param $key string|array Option name or array with options
	 * @param $value mixed|null Option value
	 * @return Compiler fluent interface
	 */
	public function setOptions( $key, $value = null ) {
		if ( !is_array( $key ) ) {
			$key = array( $key => $value );
		}
		foreach ( $key as $k => $v ) {
			if ( property_exists($this,$k) ) {
				$this->$k = $v;
			}
		}
		return $this;
	}

	/**
	 * Returns a cloned instance and overrides given settings there.
	 *
	 * @param $key string|array Option name or array with options
	 * @param $value mixed|null Option value
	 * @return Compiler Cloned instance
	 */
	public function withOptions( $key, $value = null ) {
		$res = clone $this;
		$res->setOptions($key,$value);
		return $res;
	}

	/**
	 * Compile the given SASS source
	 *
	 * @param Source $source Sass source
	 * @throws \Wikia\Sass\Exception
	 * @return string Css stylesheet
	 */
	abstract public function compile( Source $source );

}