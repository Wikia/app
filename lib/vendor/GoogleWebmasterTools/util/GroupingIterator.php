<?php
/**
 * User: artur
 * Date: 07.06.13
 * Time: 16:01
 */

/**
 * Class GroupingIterator
 * Wraps inner iterator and returns arrays of size $groupSize.
 * @example $groupsSize = 2 and original iterator returns 1,2,3,4,5.
 * @example new iterator would return [1,2], [3,4], [5]
 */
class GroupingIterator implements Iterator {
	/**
	 * @var Iterator
	 */
	private $innerIterator;
	/**
	 * @var integer
	 */
	private $groupSize;
	/**
	 * @var array
	 */
	private $currentGroup;
	/**
	 * @var int
	 */
	private $index = 0;

	public function __construct( $innerIterator, $groupSize ) {
		$this->innerIterator = $innerIterator;
		$this->groupSize = $groupSize;
	}


	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Return the current element
	 * @link http://php.net/manual/en/iterator.current.php
	 * @return array Can return any type.
	 */
	public function current() {
		if( $this->currentGroup == null ) {
			$left = $this->groupSize;
			$this->currentGroup = array();
			while( $this->innerIterator->valid() ) {
				if( $left -- <= 0 ) { break; }
				$this->currentGroup[] = $this->innerIterator->current();
				$this->innerIterator->next();
			}
		}
		return $this->currentGroup;
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Move forward to next element
	 * @link http://php.net/manual/en/iterator.next.php
	 * @return void Any returned value is ignored.
	 */
	public function next() {
		$this->current();
		$this->currentGroup = null;
		$this->index++;
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Return the key of the current element
	 * @link http://php.net/manual/en/iterator.key.php
	 * @return mixed scalar on success, or null on failure.
	 */
	public function key() {
		return $this->index;
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Checks if current position is valid
	 * @link http://php.net/manual/en/iterator.valid.php
	 * @return boolean The return value will be casted to boolean and then evaluated.
	 * Returns true on success or false on failure.
	 */
	public function valid() {
		return sizeof($this->current()) > 0;
	}

	/**
	 * (PHP 5 &gt;= 5.0.0)<br/>
	 * Rewind the Iterator to the first element
	 * @link http://php.net/manual/en/iterator.rewind.php
	 * @return void Any returned value is ignored.
	 */
	public function rewind() {
		$this->index = 0;
		$this->innerIterator->rewind();
	}
}
