<?php

namespace SMW\SQLStore\Lookup;

/**
 * A simple interface for fetching a list from either a DB or use a decorator
 * to cache results
 *
 * @license GNU GPL v2+
 * @since 2.2
 *
 * @author mwjames
 */
interface ListLookup {

	/**
	 * @since 2.2
	 *
	 * @return array
	 */
	public function fetchList();

	/**
	 * @since 2.2
	 *
	 * @return boolean
	 */
	public function isCached();

	/**
	 * A unique identifier that can describe a specific lookup instance to
	 * distinguish it from other lookup's of the same list
	 *
	 * @since 2.2
	 *
	 * @return string
	 */
	public function getLookupIdentifier();

	/**
	 * @since 2.2
	 *
	 * @return integer
	 */
	public function getTimestamp();

}
