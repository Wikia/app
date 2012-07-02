<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */


abstract class WCDataSegment extends WCSegment implements Countable {

	protected $citation;

	protected $sortingParts;

	public function __construct( WCCitation $citation, $prefix = '', $suffix = '' ) {
		$this->citation = $citation;
		$this->prefix = $prefix;
		$this->suffix = $suffix;
	}

	abstract public function getLabel( WCStyle $style, WCLabelFormEnum $form, WCPluralEnum $plural );

	public function count() {
		return (int) $this->exists;
	}


	/**
	 * Implements Iterator interface method.
	 * @return string
	 */
	public function key() {
		return key( $this->sortingParts );
	}


	/**
	 * Implements Iterator interface method.
	 * @return WCSegment
	 */
	public function current() {
		return current( $this->sortingParts );
	}


	/**
	 * Implements Iterator interface method.
	 */
	public function next() {
		next( $this->sortingParts );
	}


	/**
	 * Implements Iterator interface method.
	 * @return boolean
	 */
	public function valid() {
		return (boolean) current( $this->sortingParts );
	}


	/**
	 * Implements Iterator interface method.
	 */
	public function rewind() {
		$this->sortingParts = $this->getSortingParts();
		reset( $this->sortingParts );
	}

}

