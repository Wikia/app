<?php
/**
 * User: artur
 * Date: 07.06.13
 * Time: 15:31
 */

class Iterators {
	/**
	 * @param \Iterator $iterator
	 * @param int $groupSize
	 * @return \Iterator
	 */
	public static function group( Iterator $iterator, $groupSize = 50 ) {
		if ( $groupSize < 0 ) {
			throw new InvalidArgumentException( "groupSize" );
		}
		return new GroupingIterator( $iterator, $groupSize );
	}
}


