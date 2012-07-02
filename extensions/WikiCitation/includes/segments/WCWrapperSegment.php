<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */


class WCWrapperSegment extends WCSegment {

	protected $segment;

	public function __construct( $segment, $prefix = '', $suffix = '' ) {
		parent::__construct( $prefix, $suffix );
		$this->segment = $segment;
	}


	public function exists() {
		if ( $this->exists ) {
			if ( $this->segment->exists() ) {
				return True;
			} else {
				$this->exists = False;
			}
		}
		$this->exists = False;
		return False;
	}


	public function render( WCStyle $style, $endSeparator = '' ) {
		return $this->prefix . $this->segment->render( $style, $this->extendSuffix( $endSeparator ) );
	}


	public function getSortingParts() {
		if ( $this->exists ) {
			return $this->segment->getSortingParts();
		}
	}


	/**
	 * Implements Iterator interface method.
	 * @return string
	 */
	public function key() {
		return $this->segment->key();
	}


	/**
	 * Implements Iterator interface method.
	 * @return WCSegment
	 */
	public function current() {
		return $this->segment->current();
	}


	/**
	 * Implements Iterator interface method.
	 */
	public function next() {
		$this->segment->next();
	}


	/**
	 * Implements Iterator interface method.
	 * @return boolean
	 */
	public function valid() {
		return $this->exists && $this->segment->valid();
	}


	/**
	 * Implements Iterator interface method.
	 */
	public function rewind() {
		$this->segment->rewind();
	}

}
