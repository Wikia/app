<?php
/**
 * Class definition for \Wikia\Search\Traits\AttributeIterableTrait
 */
namespace Wikia\Search\Traits;
/**
 * Here come a bunch of wrapper methods for ArrayIterator.
 * These allow us to use array iterator methods on an existing property.
 * This is a really nifty pattern for classes that encapsulate something iterable, but may require additional logic further down the road.
 * This way, you can test once, and focus on the logic in the specific class implementations.
 * A class that uses this can implement ArrayAccess and Iterator.
 * @package Search
 * @subpackage Traits
 */
trait AttributeIterableTrait {
	
	/**
	 * Return the attribute that is iterable.
	 * @return \ArrayIterator
	 */
	abstract function getIterable();
	
	/**
	 * Check if offset exists
	 * @link http://www.php.net/manual/en/arrayiterator.offsetexists.php
	 * @param index string <p>
	 * The offset being checked.
	 * </p>
	 * @return void true if the offset exists, otherwise false
	 */
	public function offsetExists( $index ) {
	    return $this->getIterable()->offsetExists( $index );
	}

	/**
	 * Get value for an offset
	 * @link http://www.php.net/manual/en/arrayiterator.offsetget.php
	 * @param index string <p>
	 * The offset to get the value from.
	 * </p>
	 * @return mixed The value at offset index.
	 */
	public function offsetGet( $index ) {
	    return $this->getIterable()->offsetGet( $index );
	}

	/**
	 * Set value for an offset
	 * @link http://www.php.net/manual/en/arrayiterator.offsetset.php
	 * @param index string <p>
	 * The index to set for.
	 * </p>
	 * @param newval string <p>
	 * The new value to store at the index.
	 * </p>
	 * @return void 
	 */
	public function offsetSet( $index, $newval ) {
	    return $this->getIterable()->offsetSet( $index, $newval );
	}

	/**
	 * Unset value for an offset
	 * @link http://www.php.net/manual/en/arrayiterator.offsetunset.php
	 * @param index string <p>
	 * The offset to unset.
	 * </p>
	 * @return void 
	 */
	public function offsetUnset( $index ) {
	    return $this->getIterable()->offsetUnset( $index );
	}

	/**
	 * Append an element
	 * @link http://www.php.net/manual/en/arrayiterator.append.php
	 * @param value mixed <p>
	 * The value to append.
	 * </p>
	 * @return void 
	 */
	public function append( $value ) {
	    return $this->getIterable()->append( $value );
	}

	/**
	 * Rewind array back to the start
	 * @link http://www.php.net/manual/en/arrayiterator.rewind.php
	 * @return void 
	 */
	public function rewind(){
	    return $this->getIterable()->rewind();
	}

	/**
	 * Return current array entry
	 * @link http://www.php.net/manual/en/arrayiterator.current.php
	 * @return mixed The current array entry.
	 */
	public function current() {
	    return $this->getIterable()->current();
	}

	/**
	 * Return current array key
	 * @link http://www.php.net/manual/en/arrayiterator.key.php
	 * @return mixed The current array key.
	 */
	public function key() {
	    return $this->getIterable()->key();
	}

	/**
	 * Move to next entry
	 * @link http://www.php.net/manual/en/arrayiterator.next.php
	 * @return void 
	 */
	public function next() {
	    return $this->getIterable()->next();
	}

	/**
	 * Check whether array contains more entries
	 * @link http://www.php.net/manual/en/arrayiterator.valid.php
	 * @return bool 
	 */
	public function valid() {
	    return $this->getIterable()->valid();
	}

	/**
	 * Seek to position
	 * @link http://www.php.net/manual/en/arrayiterator.seek.php
	 * @param position int <p>
	 * The position to seek to.
	 * </p>
	 * @return void 
	 */
	public function seek( $position ) {
	    return $this->getIterable()->seek( $position );
	}
	
}