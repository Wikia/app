<?php
/**
 * Part of WikiCitation extension for Mediawiki.
 *
 * @ingroup WikiCitation
 * @file
 */


class WCLiteralSegment extends WCSegment {

	protected $text;

	protected $reset;

	public function __construct( $text ) {
		parent::__construct();
		$this->text = $text;
		$this->exists = True;
	}

	public function render( WCStyle $style, $endSeparator = '' ) {
		if ( $endSeparator ) {
			$chrL = mb_substr( $this->text, -1, 1 );
			$chrR = mb_substr( $endSeparator, 0, 1 );
			if ( $chrL == $chrR ) {
				$endSeparator = ltrim( $endSeparator, $chrR );
			}
			return $this->text . $endSeparator;
		} else {
			return $this->text;
		}
	}

	public function getSortingParts() {
		return array();
	}

	/**
	 * Implements Iterator interface method.
	 * @return string
	 */
	public function key() {
		return '1';
	}


	/**
	 * Implements Iterator interface method.
	 * @return WCSegment
	 */
	public function current() {
		return '';
	}


	/**
	 * Implements Iterator interface method.
	 */
	public function next() {
		$this->reset = False;
	}


	/**
	 * Implements Iterator interface method.
	 * @return boolean
	 */
	public function valid() {
		return $this->exists && $this->reset;
	}


	/**
	 * Implements Iterator interface method.
	 */
	public function rewind() {
		$this->reset = True;;
	}

}
