<?php

namespace Wikia\Sass\Filter;

/**
 * Filter is a base class that defines the public interface
 * of Sass filter subclasses
 *
 * @author Władysław Bodzek <wladek@wikia-inc.com>
 */
abstract class Filter {

	/**
	 * Apply filter rules to given string
	 *
	 * @param $contents string Input contents
	 * @return string Processed string
	 */
	abstract public function process( $contents );

}